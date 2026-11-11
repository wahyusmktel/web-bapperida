<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SppgAudit extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'sppg_audits';

    protected $guarded = ['id'];

    protected $casts = [
        'inspection_date' => 'date',
        'slhs_expiry_date' => 'date',
        'halal_expiry_date' => 'date',
        'apar_expiry_date' => 'date',
        'has_slhs' => 'boolean',
        'has_halal' => 'boolean',
        'head_present' => 'boolean',
        'finance_present' => 'boolean',
        'chef_present' => 'boolean',
        'chef_has_experience' => 'boolean',
        'stove_all_working' => 'boolean',
        'sink_persiapan' => 'boolean',
        'sink_pemorsian' => 'boolean',
        'sink_pengolahan' => 'boolean',
        'sink_kamar_mandi' => 'boolean',
        'sink_jalan_masuk' => 'boolean',
        'ipal_functioning' => 'boolean',
        'grease_trap_functioning' => 'boolean',
        'apar_available' => 'boolean',
        'apar_is_valid' => 'boolean',
        'label_has_time_limit' => 'boolean',
        'label_has_no_takeaway' => 'boolean',
        'cctv_all_critical_points' => 'boolean',
        'internet_speed_test_available' => 'boolean',
        'total_score' => 'float',
        'score_keamanan_pangan' => 'float',
        'score_legalitas_sdm' => 'float',
        'score_lahan_keselamatan' => 'float',
    ];

    /**
     * Hitung ulang seluruh skor berdasarkan kriteria resmi paparan BGN.
     */
    public function calculateScores(): void
    {
        // 01. Legalitas Dokumen (12%)
        $this->score_slhs = $this->has_slhs ? 6.00 : 0.00;
        $this->score_halal = $this->has_halal ? 6.00 : 0.00;
        $this->score_legalitas_dokumen = $this->score_slhs + $this->score_halal;

        // 02. Staff di SPPG (5%)
        $this->score_head = $this->head_present ? 2.00 : 0.00;
        if ($this->nutritionist_status === 'ada_gizi') {
            $this->score_nutritionist = 2.00;
        } elseif ($this->nutritionist_status === 'ada_tekpang') {
            $this->score_nutritionist = 1.00;
        } else {
            $this->score_nutritionist = 0.00;
        }
        $this->score_finance = $this->finance_present ? 1.00 : 0.00;
        $this->score_staff_sppg = $this->score_head + $this->score_nutritionist + $this->score_finance;

        // 03. Chef (6%)
        $this->score_chef_presence = $this->chef_present ? 3.00 : 0.00;
        $this->score_chef_experience = $this->chef_has_experience ? 3.00 : 0.00;
        $this->score_chef = $this->score_chef_presence + $this->score_chef_experience;

        // 04. Air Minum (7%)
        $this->score_air_minum = match ($this->drinking_water_source) {
            'ro' => 7.00,
            'galon' => 6.00,
            'pdam' => 4.00,
            default => 0.00,
        };

        // 05. Air Masak (9%)
        $this->score_air_masak = match ($this->cooking_water_source) {
            'ro' => 9.00,
            'galon' => 8.00,
            'pdam' => 6.00,
            default => 2.00,
        };

        // 06. Rantai Dingin (11%)
        $this->score_chiller = match ($this->chiller_status) {
            'optimal_le_5' => 5.00,
            'above_5' => 3.00,
            default => 0.00,
        };
        $this->score_freezer = match ($this->freezer_status) {
            'optimal_le_minus18' => 6.00,
            'above_minus18' => 3.00,
            default => 0.00,
        };
        $this->score_rantai_dingin = $this->score_chiller + $this->score_freezer;

        // 07. Kompor (4%)
        $workingStoves = ($this->stove_high_pressure_count + $this->stove_low_pressure_count);
        $pm = max(1, (int) $this->beneficiary_count);
        $ratio = ($workingStoves * 450) / $pm;
        $this->stove_ratio = round($ratio, 2);

        $hasHighPressure = $this->stove_high_pressure_count > 0;
        if ($ratio >= 1.0) {
            if ($this->stove_all_working && $hasHighPressure) {
                $this->score_kompor = 4.00;
                $this->stove_condition = 'Seluruh kompor berfungsi baik & ada kompor high pressure (rasio >= 1)';
            } elseif (!$this->stove_all_working && $hasHighPressure) {
                $this->score_kompor = 2.00;
                $this->stove_condition = 'Ada kompor tidak berfungsi tapi ada kompor high pressure (rasio >= 1)';
            } elseif ($this->stove_all_working && !$hasHighPressure) {
                $this->score_kompor = 1.00;
                $this->stove_condition = 'Seluruh kompor berfungsi baik tapi tidak ada kompor high pressure (rasio >= 1)';
            } else {
                $this->score_kompor = 0.00;
                $this->stove_condition = 'Kondisi tidak memenuhi standar minimal';
            }
        } else {
            $this->score_kompor = 0.00;
            $this->stove_condition = 'Rasio kompor di bawah kapasitas PM (< 1)';
        }

        // 08. Sanitasi Dasar (12%)
        $sinkCount = 0;
        if ($this->sink_persiapan) $sinkCount++;
        if ($this->sink_pemorsian) $sinkCount++;
        if ($this->sink_pengolahan) $sinkCount++;
        if ($this->sink_kamar_mandi) $sinkCount++;
        if ($this->sink_jalan_masuk) $sinkCount++;
        $this->score_sink = round($sinkCount * 1.20, 2);

        $this->score_ipal = $this->ipal_functioning ? 4.00 : 0.00;
        $this->score_grease_trap = $this->grease_trap_functioning ? 2.00 : 0.00;
        $this->score_sanitasi_dasar = $this->score_sink + $this->score_ipal + $this->score_grease_trap;

        // 09. APAR (5%)
        $this->score_apar = ($this->apar_available && $this->apar_is_valid) ? 5.00 : 0.00;

        // 10. Label Ompreng (3%)
        $labelScore = 0.00;
        if ($this->label_has_time_limit) $labelScore += 1.50;
        if ($this->label_has_no_takeaway) $labelScore += 1.50;
        $this->score_label_ompreng = $labelScore;

        // 11. Luasan SPPG (7%)
        $this->score_luasan = match ($this->area_compliance) {
            'sesuai' => 7.00,
            'di_bawah_standar' => 3.00,
            default => 0.00,
        };

        // 12. Gudang Kering & Basah (8%)
        $rackDryScore = match ($this->rack_dry_material) {
            'stainless' => 2.00,
            'besi_plastik' => 1.75,
            default => 0.00,
        };
        $palletDryScore = match ($this->pallet_dry_material) {
            'stainless' => 2.00,
            'besi_plastik' => 1.75,
            default => 0.00,
        };
        $rackWetScore = match ($this->rack_wet_material) {
            'stainless' => 2.00,
            'besi_plastik' => 1.75,
            default => 0.00,
        };
        $palletWetScore = match ($this->pallet_wet_material) {
            'stainless' => 2.00,
            'besi_plastik' => 1.75,
            default => 0.00,
        };
        $this->score_gudang = $rackDryScore + $palletDryScore + $rackWetScore + $palletWetScore;

        // 13. Video Alur Produksi (8%)
        $this->score_alur_produksi = match ($this->production_flow_status) {
            'sesuai_tanpa_catatan' => 8.00,
            'sesuai_dengan_catatan' => 6.00,
            'tidak_sesuai' => 4.00,
            default => 0.00,
        };

        // 14. CCTV & Internet (3%)
        $this->score_cctv = $this->cctv_all_critical_points ? 1.50 : 0.00;
        $this->score_internet = $this->internet_speed_test_available ? 1.50 : 0.00;
        $this->score_cctv_internet = $this->score_cctv + $this->score_internet;

        // Akumulasi 3 Pilar
        $this->score_legalitas_sdm = $this->score_legalitas_dokumen + $this->score_staff_sppg + $this->score_chef;
        $this->score_keamanan_pangan = $this->score_air_minum + $this->score_air_masak + $this->score_rantai_dingin +
            $this->score_kompor + $this->score_sanitasi_dasar + $this->score_label_ompreng +
            $this->score_gudang + $this->score_alur_produksi + $this->score_cctv_internet;
        $this->score_lahan_keselamatan = $this->score_apar + $this->score_luasan;

        $total = $this->score_legalitas_sdm + $this->score_keamanan_pangan + $this->score_lahan_keselamatan;
        $this->total_score = min(100.00, round($total, 2));

        // Penentuan Rekomendasi & Grade
        if ($this->total_score >= 85.00) {
            $this->grade = 'Grade A';
            $this->recommendation = 'layak_dilanjutkan';
        } elseif ($this->total_score >= 70.00) {
            $this->grade = 'Grade B';
            $this->recommendation = 'layak_dengan_perbaikan';
        } else {
            $this->grade = 'Grade D';
            $this->recommendation = 'tidak_layak';
        }
    }
}
