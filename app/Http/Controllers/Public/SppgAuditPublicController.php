<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SppgAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class SppgAuditPublicController extends Controller
{
    /**
     * Halaman landing & direktori hasil audit SPPG Makan Bergizi Gratis.
     */
    public function index(Request $request): Response
    {
        $query = SppgAudit::query()->latest('inspection_date');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('sppg_name', 'like', "%{$search}%")
                  ->orWhere('sppg_id_code', 'like', "%{$search}%")
                  ->orWhere('inspector_name', 'like', "%{$search}%")
                  ->orWhere('inspection_number', 'like', "%{$search}%");
            });
        }

        if ($grade = $request->input('grade')) {
            $query->where('grade', $grade);
        }

        if ($recommendation = $request->input('recommendation')) {
            $query->where('recommendation', $recommendation);
        }

        $audits = $query->paginate(9)->withQueryString();

        // Statistik agregat
        $stats = [
            'total_audits' => SppgAudit::count(),
            'total_pm' => SppgAudit::sum('beneficiary_count'),
            'grade_a_count' => SppgAudit::where('grade', 'Grade A')->count(),
            'grade_b_count' => SppgAudit::where('grade', 'Grade B')->count(),
            'grade_d_count' => SppgAudit::where('grade', 'Grade D')->count(),
            'avg_score' => round(SppgAudit::avg('total_score') ?? 0, 1),
            'avg_food_safety' => round(SppgAudit::avg('score_keamanan_pangan') ?? 0, 1),
            'avg_legality_hr' => round(SppgAudit::avg('score_legalitas_sdm') ?? 0, 1),
            'avg_safety_land' => round(SppgAudit::avg('score_lahan_keselamatan') ?? 0, 1),
        ];

        return Inertia::render('Public/SppgAudit/Index', [
            'audits' => $audits,
            'stats' => $stats,
            'filters' => $request->only(['search', 'grade', 'recommendation']),
        ]);
    }

    /**
     * Halaman form pengisian audit kelayakan operasional SPPG.
     */
    public function create(): Response
    {
        // Generate nomor inspeksi baru
        $countThisMonth = SppgAudit::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count() + 1;
        $suggestedNumber = sprintf('ST-SATGAS/PSW/%d/%03d', now()->year, $countThisMonth);

        return Inertia::render('Public/SppgAudit/AuditForm', [
            'suggestedNumber' => $suggestedNumber,
            'currentDate' => now()->toDateString(),
        ]);
    }

    /**
     * Simpan hasil pengisian form audit SPPG.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // Header
            'inspection_number' => 'nullable|string|max:50',
            'inspection_date' => 'required|date',
            'sppg_id_code' => 'required|string|size:8',
            'sppg_name' => 'required|string|max:255',
            'sppg_type' => 'required|string|in:BGN,Mandiri,Khusus,Terpencil,Sekolah Rakyat',
            'regency_city' => 'required|string|max:100',
            'inspector_name' => 'required|string|max:255',
            'beneficiary_count' => 'required|integer|min:1',

            // 01. Legalitas
            'has_slhs' => 'boolean',
            'slhs_expiry_date' => 'nullable|date',
            'has_halal' => 'boolean',
            'halal_expiry_date' => 'nullable|date',

            // 02. Staff
            'head_present' => 'boolean',
            'head_name' => 'nullable|string|max:255',
            'head_nik' => 'nullable|string|max:20',
            'head_phone' => 'nullable|string|max:25',
            'nutritionist_status' => 'required|string|in:ada_gizi,ada_tekpang,tidak_ada',
            'nutritionist_name' => 'nullable|string|max:255',
            'nutritionist_nik' => 'nullable|string|max:20',
            'nutritionist_phone' => 'nullable|string|max:25',
            'nutritionist_education' => 'nullable|string|max:255',
            'finance_present' => 'boolean',
            'finance_name' => 'nullable|string|max:255',
            'finance_nik' => 'nullable|string|max:20',
            'finance_phone' => 'nullable|string|max:25',

            // 03. Chef
            'chef_present' => 'boolean',
            'chef_name' => 'nullable|string|max:255',
            'chef_nik' => 'nullable|string|max:20',
            'chef_phone' => 'nullable|string|max:25',
            'chef_has_experience' => 'boolean',
            'chef_paklaring_number' => 'nullable|string|max:100',

            // 04. Air Minum
            'drinking_water_source' => 'required|string|in:ro,galon,pdam,sumur',

            // 05. Air Masak
            'cooking_water_source' => 'required|string|in:ro,galon,pdam,sumur',

            // 06. Rantai Dingin
            'chiller_unit_count' => 'required|integer|min:0',
            'chiller_temp_celsius' => 'nullable|numeric',
            'chiller_status' => 'required|string|in:optimal_le_5,above_5,not_working',
            'freezer_unit_count' => 'required|integer|min:0',
            'freezer_temp_celsius' => 'nullable|numeric',
            'freezer_capacity_liters' => 'nullable|integer|min:0',
            'freezer_status' => 'required|string|in:optimal_le_minus18,above_minus18,not_working',

            // 07. Kompor
            'stove_high_pressure_count' => 'required|integer|min:0',
            'stove_low_pressure_count' => 'required|integer|min:0',
            'stove_all_working' => 'boolean',

            // 08. Sanitasi Dasar
            'sink_persiapan' => 'boolean',
            'sink_pemorsian' => 'boolean',
            'sink_pengolahan' => 'boolean',
            'sink_kamar_mandi' => 'boolean',
            'sink_jalan_masuk' => 'boolean',
            'ipal_functioning' => 'boolean',
            'grease_trap_functioning' => 'boolean',

            // 09. APAR
            'apar_available' => 'boolean',
            'apar_expiry_date' => 'nullable|date',
            'apar_is_valid' => 'boolean',

            // 10. Label Kemasan
            'label_has_time_limit' => 'boolean',
            'label_has_no_takeaway' => 'boolean',

            // 11. Luasan SPPG
            'land_area_sqm' => 'required|numeric|min:0',
            'building_area_sqm' => 'required|numeric|min:0',
            'area_compliance' => 'required|string|in:sesuai,di_bawah_standar,tidak_dapat_dinilai',

            // 12. Gudang
            'rack_dry_material' => 'required|string|in:stainless,besi_plastik,kayu,tidak_ada',
            'pallet_dry_material' => 'required|string|in:stainless,besi_plastik,kayu,tidak_ada',
            'rack_wet_material' => 'required|string|in:stainless,besi_plastik,kayu,tidak_ada',
            'pallet_wet_material' => 'required|string|in:stainless,besi_plastik,kayu,tidak_ada',

            // 13. Video Alur
            'production_flow_status' => 'required|string|in:sesuai_tanpa_catatan,sesuai_dengan_catatan,tidak_sesuai',
            'production_flow_video_url' => 'nullable|string|max:500',
            'production_flow_notes' => 'nullable|string',

            // 14. CCTV & Internet
            'cctv_all_critical_points' => 'boolean',
            'cctv_unit_count' => 'nullable|integer|min:0',
            'cctv_type' => 'nullable|string|max:50',
            'internet_speed_test_available' => 'boolean',
            'internet_download_mbps' => 'nullable|numeric|min:0',
            'internet_upload_mbps' => 'nullable|numeric|min:0',
            'internet_provider' => 'nullable|string|max:100',

            // Rekomendasi & TTD
            'recommendation_reason' => 'nullable|string|max:300',
            'satgas_leader_name' => 'required|string|max:255',
            'satgas_leader_signature' => 'nullable|string',
        ]);

        $audit = new SppgAudit($validated);
        $audit->created_by_ip = $request->ip();
        $audit->status = 'submitted';
        $audit->calculateScores();
        $audit->save();

        return redirect()->route('public.audit-sppg.show', $audit->id)
            ->with('success', 'Formulir Audit Kelayakan Operasional SPPG berhasil dikirim dan dihitung secara resmi.');
    }

    /**
     * Tampilkan detail & lembar cetak hasil audit SPPG resmi.
     */
    public function show(string $id): Response
    {
        $audit = SppgAudit::findOrFail($id);

        return Inertia::render('Public/SppgAudit/AuditResult', [
            'audit' => $audit,
        ]);
    }
}
