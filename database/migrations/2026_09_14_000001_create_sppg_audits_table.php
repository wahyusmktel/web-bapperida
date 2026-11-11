<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sppg_audits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Header Identitas SPPG & Inspeksi
            $table->string('inspection_number', 50)->nullable();
            $table->date('inspection_date');
            $table->string('sppg_id_code', 8)->index(); // 8 digit
            $table->string('sppg_name');
            $table->string('sppg_type', 30)->default('BGN'); // BGN, Mandiri, Khusus, Terpencil, Sekolah Rakyat
            $table->string('regency_city')->default('Kabupaten Pringsewu');
            $table->string('inspector_name');
            $table->integer('beneficiary_count')->default(0); // PM (porsi/hari)

            // 01. Legalitas Dokumen (12%)
            $table->boolean('has_slhs')->default(false);
            $table->date('slhs_expiry_date')->nullable();
            $table->string('slhs_doc_path')->nullable();
            $table->decimal('score_slhs', 5, 2)->default(0);

            $table->boolean('has_halal')->default(false);
            $table->date('halal_expiry_date')->nullable();
            $table->string('halal_doc_path')->nullable();
            $table->decimal('score_halal', 5, 2)->default(0);
            $table->decimal('score_legalitas_dokumen', 5, 2)->default(0);

            // 02. Staff di SPPG (5%)
            $table->boolean('head_present')->default(false);
            $table->string('head_name')->nullable();
            $table->string('head_nik', 20)->nullable();
            $table->string('head_phone', 25)->nullable();
            $table->string('head_photo_path')->nullable();
            $table->string('head_ktp_path')->nullable();
            $table->decimal('score_head', 5, 2)->default(0);

            $table->string('nutritionist_status', 30)->default('tidak_ada'); // ada_gizi, ada_tekpang, tidak_ada
            $table->string('nutritionist_name')->nullable();
            $table->string('nutritionist_nik', 20)->nullable();
            $table->string('nutritionist_phone', 25)->nullable();
            $table->string('nutritionist_education')->nullable();
            $table->decimal('score_nutritionist', 5, 2)->default(0);

            $table->boolean('finance_present')->default(false);
            $table->string('finance_name')->nullable();
            $table->string('finance_nik', 20)->nullable();
            $table->string('finance_phone', 25)->nullable();
            $table->decimal('score_finance', 5, 2)->default(0);
            $table->decimal('score_staff_sppg', 5, 2)->default(0);

            // 03. Chef (6%)
            $table->boolean('chef_present')->default(false);
            $table->string('chef_name')->nullable();
            $table->string('chef_nik', 20)->nullable();
            $table->string('chef_phone', 25)->nullable();
            $table->string('chef_photo_path')->nullable();
            $table->string('chef_ktp_path')->nullable();
            $table->decimal('score_chef_presence', 5, 2)->default(0);

            $table->boolean('chef_has_experience')->default(false);
            $table->string('chef_paklaring_number')->nullable();
            $table->string('chef_paklaring_doc_path')->nullable();
            $table->decimal('score_chef_experience', 5, 2)->default(0);
            $table->decimal('score_chef', 5, 2)->default(0);

            // 04. Sumber Air Minum (7%)
            $table->string('drinking_water_source', 30)->default('sumur'); // ro, galon, pdam, sumur
            $table->string('drinking_water_photo_path')->nullable();
            $table->decimal('score_air_minum', 5, 2)->default(0);

            // 05. Sumber Air Masak (9%)
            $table->string('cooking_water_source', 30)->default('sumur'); // ro, galon, pdam, sumur
            $table->string('cooking_water_photo_path')->nullable();
            $table->decimal('score_air_masak', 5, 2)->default(0);

            // 06. Rantai Dingin (Chiller & Freezer) (11%)
            $table->integer('chiller_unit_count')->default(0);
            $table->decimal('chiller_temp_celsius', 4, 1)->nullable();
            $table->string('chiller_status', 30)->default('not_working'); // optimal_le_5, above_5, not_working
            $table->string('chiller_photo_path')->nullable();
            $table->decimal('score_chiller', 5, 2)->default(0);

            $table->integer('freezer_unit_count')->default(0);
            $table->decimal('freezer_temp_celsius', 4, 1)->nullable();
            $table->integer('freezer_capacity_liters')->nullable();
            $table->string('freezer_status', 30)->default('not_working'); // optimal_le_minus18, above_minus18, not_working
            $table->string('freezer_photo_path')->nullable();
            $table->decimal('score_freezer', 5, 2)->default(0);
            $table->decimal('score_rantai_dingin', 5, 2)->default(0);

            // 07. Kompor (4%)
            $table->integer('stove_high_pressure_count')->default(0);
            $table->integer('stove_low_pressure_count')->default(0);
            $table->boolean('stove_all_working')->default(false);
            $table->decimal('stove_ratio', 5, 2)->default(0);
            $table->string('stove_condition', 255)->default('none');
            $table->string('stove_photo_path')->nullable();
            $table->decimal('score_kompor', 5, 2)->default(0);

            // 08. Sanitasi Dasar (12%)
            // Wastafel (6%) - 1.2% per lokasi
            $table->boolean('sink_persiapan')->default(false);
            $table->boolean('sink_pemorsian')->default(false);
            $table->boolean('sink_pengolahan')->default(false);
            $table->boolean('sink_kamar_mandi')->default(false);
            $table->boolean('sink_jalan_masuk')->default(false);
            $table->string('sink_photo_path')->nullable();
            $table->decimal('score_sink', 5, 2)->default(0);

            // IPAL & Grease Trap (6%)
            $table->boolean('ipal_functioning')->default(false);
            $table->string('ipal_photo_path')->nullable();
            $table->decimal('score_ipal', 5, 2)->default(0);

            $table->boolean('grease_trap_functioning')->default(false);
            $table->string('grease_trap_photo_path')->nullable();
            $table->decimal('score_grease_trap', 5, 2)->default(0);
            $table->decimal('score_sanitasi_dasar', 5, 2)->default(0);

            // 09. APAR (5%)
            $table->boolean('apar_available')->default(false);
            $table->date('apar_expiry_date')->nullable();
            $table->boolean('apar_is_valid')->default(false);
            $table->string('apar_photo_path')->nullable();
            $table->decimal('score_apar', 5, 2)->default(0);

            // 10. Label Kemasan Ompreng (3%)
            $table->boolean('label_has_time_limit')->default(false);
            $table->boolean('label_has_no_takeaway')->default(false);
            $table->string('label_photo_path')->nullable();
            $table->decimal('score_label_ompreng', 5, 2)->default(0);

            // 11. Jenis & Luasan SPPG (7%)
            $table->decimal('land_area_sqm', 8, 2)->default(0);
            $table->decimal('building_area_sqm', 8, 2)->default(0);
            $table->string('area_compliance', 30)->default('sesuai'); // sesuai, di_bawah_standar, tidak_dapat_dinilai
            $table->string('area_front_photo_path')->nullable();
            $table->string('building_front_photo_path')->nullable();
            $table->decimal('score_luasan', 5, 2)->default(0);

            // 12. Gudang Kering & Basah (8%)
            $table->string('rack_dry_material', 30)->default('tidak_ada'); // stainless, besi_plastik, kayu, tidak_ada
            $table->string('pallet_dry_material', 30)->default('tidak_ada');
            $table->string('rack_wet_material', 30)->default('tidak_ada');
            $table->string('pallet_wet_material', 30)->default('tidak_ada');
            $table->string('warehouse_dry_photo_path')->nullable();
            $table->string('warehouse_wet_photo_path')->nullable();
            $table->decimal('score_gudang', 5, 2)->default(0);

            // 13. Video Alur Produksi (8%)
            $table->string('production_flow_status', 50)->default('sesuai_tanpa_catatan'); // sesuai_tanpa_catatan, sesuai_dengan_catatan, tidak_sesuai
            $table->string('production_flow_video_url')->nullable();
            $table->text('production_flow_notes')->nullable();
            $table->decimal('score_alur_produksi', 5, 2)->default(0);

            // 14. CCTV Pengawasan Dapur (3%)
            $table->boolean('cctv_all_critical_points')->default(false);
            $table->integer('cctv_unit_count')->default(0);
            $table->string('cctv_type', 30)->nullable(); // DVR / IP Cam
            $table->string('cctv_photo_path')->nullable();
            $table->decimal('score_cctv', 5, 2)->default(0);

            $table->boolean('internet_speed_test_available')->default(false);
            $table->decimal('internet_download_mbps', 6, 2)->nullable();
            $table->decimal('internet_upload_mbps', 6, 2)->nullable();
            $table->string('internet_provider')->nullable();
            $table->string('internet_speed_test_photo_path')->nullable();
            $table->decimal('score_internet', 5, 2)->default(0);
            $table->decimal('score_cctv_internet', 5, 2)->default(0);

            // Ringkasan Akumulasi Skor & Rekomendasi Kelayakan
            $table->decimal('score_keamanan_pangan', 5, 2)->default(0); // 65%
            $table->decimal('score_legalitas_sdm', 5, 2)->default(0);   // 23%
            $table->decimal('score_lahan_keselamatan', 5, 2)->default(0); // 12%
            $table->decimal('total_score', 5, 2)->default(0);            // 100%
            
            $table->string('grade', 10)->default('Grade D'); // Grade A, Grade B, Grade D
            $table->string('recommendation', 50)->default('tidak_layak'); // layak_dilanjutkan, layak_dengan_perbaikan, tidak_layak
            $table->text('recommendation_reason')->nullable(); // Maks 2 baris
            
            // Pengesahan
            $table->string('satgas_leader_name')->default('Ketua Satgas MBG Pringsewu');
            $table->text('satgas_leader_signature')->nullable(); // Data URL / path
            
            // Status & Audit Trail
            $table->string('status', 30)->default('submitted'); // draft, submitted, verified
            $table->string('created_by_ip', 45)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sppg_audits');
    }
};
