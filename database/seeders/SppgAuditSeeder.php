<?php

namespace Database\Seeders;

use App\Models\SppgAudit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SppgAuditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $audits = [
            [
                'inspection_number' => 'ST-SATGAS/PSW/2026/014',
                'inspection_date' => now()->subDays(2),
                'sppg_id_code' => '18020101',
                'sppg_name' => 'SPPG Sentra Dapur Mandiri Pringsewu Kota',
                'sppg_type' => 'Mandiri',
                'regency_city' => 'Kabupaten Pringsewu',
                'inspector_name' => 'Ahmad Fadillah, S.Tr.Gz & Tim Satgas MBG',
                'beneficiary_count' => 2500,
                // Legalitas
                'has_slhs' => true,
                'slhs_expiry_date' => now()->addMonths(18),
                'has_halal' => true,
                'halal_expiry_date' => now()->addMonths(24),
                // Staff
                'head_present' => true,
                'head_name' => 'Bambang Sutejo, S.E.',
                'head_nik' => '1810011504820003',
                'head_phone' => '081273928192',
                'nutritionist_status' => 'ada_gizi',
                'nutritionist_name' => 'Siti Aminah, S.Gz.',
                'nutritionist_nik' => '1810016508930002',
                'nutritionist_phone' => '082188291029',
                'nutritionist_education' => 'S1 Ilmu Gizi (Ahli Gizi Terdaftar)',
                'finance_present' => true,
                'finance_name' => 'Dewi Rahmawati, A.Md.Ak.',
                'finance_nik' => '1810014502950001',
                'finance_phone' => '085278192039',
                // Chef
                'chef_present' => true,
                'chef_name' => 'Chef Hardianto Saputra',
                'chef_nik' => '1810012209880004',
                'chef_phone' => '081399281720',
                'chef_has_experience' => true,
                'chef_paklaring_number' => 'PKL-CHEF/HOTEL-BDL/2024-08',
                // Air
                'drinking_water_source' => 'ro',
                'cooking_water_source' => 'ro',
                // Rantai Dingin
                'chiller_unit_count' => 2,
                'chiller_temp_celsius' => 3.5,
                'chiller_status' => 'optimal_le_5',
                'freezer_unit_count' => 2,
                'freezer_temp_celsius' => -20.0,
                'freezer_capacity_liters' => 1200,
                'freezer_status' => 'optimal_le_minus18',
                // Kompor
                'stove_high_pressure_count' => 4,
                'stove_low_pressure_count' => 3,
                'stove_all_working' => true,
                // Sanitasi
                'sink_persiapan' => true,
                'sink_pemorsian' => true,
                'sink_pengolahan' => true,
                'sink_kamar_mandi' => true,
                'sink_jalan_masuk' => true,
                'ipal_functioning' => true,
                'grease_trap_functioning' => true,
                // APAR
                'apar_available' => true,
                'apar_expiry_date' => now()->addMonths(10),
                'apar_is_valid' => true,
                // Label
                'label_has_time_limit' => true,
                'label_has_no_takeaway' => true,
                // Luasan
                'land_area_sqm' => 450,
                'building_area_sqm' => 280,
                'area_compliance' => 'sesuai',
                // Gudang
                'rack_dry_material' => 'stainless',
                'pallet_dry_material' => 'stainless',
                'rack_wet_material' => 'stainless',
                'pallet_wet_material' => 'stainless',
                // Alur
                'production_flow_status' => 'sesuai_tanpa_catatan',
                'production_flow_video_url' => 'https://drive.google.com/file/d/sppg-pringsewu-flow-sample',
                // CCTV & Net
                'cctv_all_critical_points' => true,
                'cctv_unit_count' => 12,
                'cctv_type' => 'IP Cam NVR 4K',
                'internet_speed_test_available' => true,
                'internet_download_mbps' => 85.50,
                'internet_upload_mbps' => 42.20,
                'internet_provider' => 'IndiHome Fiber 100 Mbps',
                'recommendation_reason' => 'Fasilitas sangat higienis, rantai dingin optimal, seluruh 10 titik kritis CCTV ter-cover dengan baik dan tenaga koki serta ahli gizi terverifikasi.',
                'satgas_leader_name' => 'Drs. Akhmad Pratama, M.Si.',
                'status' => 'verified',
            ],
            [
                'inspection_number' => 'ST-SATGAS/PSW/2026/015',
                'inspection_date' => now()->subDays(4),
                'sppg_id_code' => '18020202',
                'sppg_name' => 'SPPG Sentra Gizi Sejahtera Gadingrejo',
                'sppg_type' => 'BGN',
                'regency_city' => 'Kabupaten Pringsewu',
                'inspector_name' => 'dr. Hendra Kusuma & Tim Satgas MBG',
                'beneficiary_count' => 1800,
                // Legalitas
                'has_slhs' => true,
                'slhs_expiry_date' => now()->addMonths(8),
                'has_halal' => true,
                'halal_expiry_date' => now()->addMonths(14),
                // Staff
                'head_present' => true,
                'head_name' => 'H. Suryadi, S.Sos.',
                'head_nik' => '1810022003750001',
                'head_phone' => '082190827361',
                'nutritionist_status' => 'ada_tekpang',
                'nutritionist_name' => 'Rina Marlina, S.T.P.',
                'nutritionist_nik' => '1810025107960003',
                'nutritionist_phone' => '081298371928',
                'nutritionist_education' => 'S1 Teknologi Pangan (Tekpang)',
                'finance_present' => true,
                'finance_name' => 'Arif Wicaksono, S.E.',
                'finance_nik' => '1810021406900002',
                'finance_phone' => '085718293019',
                // Chef
                'chef_present' => true,
                'chef_name' => 'Chef M. Yusuf Ansori',
                'chef_nik' => '1810020803870005',
                'chef_phone' => '081377281920',
                'chef_has_experience' => true,
                'chef_paklaring_number' => 'PKL-RESTO-PRINGSEWU/2025/11',
                // Air
                'drinking_water_source' => 'galon',
                'cooking_water_source' => 'galon',
                // Rantai Dingin
                'chiller_unit_count' => 1,
                'chiller_temp_celsius' => 4.2,
                'chiller_status' => 'optimal_le_5',
                'freezer_unit_count' => 1,
                'freezer_temp_celsius' => -16.5, // > -18
                'freezer_capacity_liters' => 800,
                'freezer_status' => 'above_minus18',
                // Kompor
                'stove_high_pressure_count' => 2,
                'stove_low_pressure_count' => 3,
                'stove_all_working' => true,
                // Sanitasi
                'sink_persiapan' => true,
                'sink_pemorsian' => true,
                'sink_pengolahan' => true,
                'sink_kamar_mandi' => true,
                'sink_jalan_masuk' => false,
                'ipal_functioning' => true,
                'grease_trap_functioning' => true,
                // APAR
                'apar_available' => true,
                'apar_expiry_date' => now()->addMonths(5),
                'apar_is_valid' => true,
                // Label
                'label_has_time_limit' => true,
                'label_has_no_takeaway' => true,
                // Luasan
                'land_area_sqm' => 350,
                'building_area_sqm' => 210,
                'area_compliance' => 'sesuai',
                // Gudang
                'rack_dry_material' => 'besi_plastik',
                'pallet_dry_material' => 'besi_plastik',
                'rack_wet_material' => 'besi_plastik',
                'pallet_wet_material' => 'besi_plastik',
                // Alur
                'production_flow_status' => 'sesuai_dengan_catatan',
                'production_flow_video_url' => 'https://drive.google.com/file/d/sppg-gadingrejo-flow',
                'production_flow_notes' => 'Terdapat tirai plastik pemisah ruang pengolahan dan pemorsian, disarankan sekat partisi penuh.',
                // CCTV & Net
                'cctv_all_critical_points' => true,
                'cctv_unit_count' => 10,
                'cctv_type' => 'DVR 16 CH 1080P',
                'internet_speed_test_available' => true,
                'internet_download_mbps' => 45.10,
                'internet_upload_mbps' => 18.30,
                'internet_provider' => 'Biznet Home 50 Mbps',
                'recommendation_reason' => 'Perlu kalibrasi suhu freezer agar konsisten di bawah -18°C dan penambahan 1 wastafel di area pintu masuk utama.',
                'satgas_leader_name' => 'Drs. Akhmad Pratama, M.Si.',
                'status' => 'verified',
            ],
            [
                'inspection_number' => 'ST-SATGAS/PSW/2026/016',
                'inspection_date' => now()->subDays(7),
                'sppg_id_code' => '18020303',
                'sppg_name' => 'SPPG Komunitas Tani Berkah Pagelaran',
                'sppg_type' => 'Khusus',
                'regency_city' => 'Kabupaten Pringsewu',
                'inspector_name' => 'Ir. Muhammad Ridwan & Tim Satgas MBG',
                'beneficiary_count' => 1200,
                // Legalitas
                'has_slhs' => false,
                'slhs_expiry_date' => null,
                'has_halal' => true,
                'halal_expiry_date' => now()->addMonths(6),
                // Staff
                'head_present' => true,
                'head_name' => 'Wahyudi, S.Pd.',
                'head_nik' => '1810031105800001',
                'head_phone' => '085269182736',
                'nutritionist_status' => 'tidak_ada',
                'finance_present' => false,
                // Chef
                'chef_present' => true,
                'chef_name' => 'Budi Santoso',
                'chef_nik' => '1810031908850002',
                'chef_phone' => '082281920394',
                'chef_has_experience' => false,
                // Air
                'drinking_water_source' => 'pdam',
                'cooking_water_source' => 'sumur',
                // Rantai Dingin
                'chiller_unit_count' => 1,
                'chiller_temp_celsius' => 7.0,
                'chiller_status' => 'above_5',
                'freezer_unit_count' => 1,
                'freezer_temp_celsius' => -12.0,
                'freezer_capacity_liters' => 500,
                'freezer_status' => 'above_minus18',
                // Kompor
                'stove_high_pressure_count' => 0,
                'stove_low_pressure_count' => 2,
                'stove_all_working' => false,
                // Sanitasi
                'sink_persiapan' => true,
                'sink_pemorsian' => false,
                'sink_pengolahan' => true,
                'sink_kamar_mandi' => true,
                'sink_jalan_masuk' => false,
                'ipal_functioning' => false,
                'grease_trap_functioning' => true,
                // APAR
                'apar_available' => false,
                // Label
                'label_has_time_limit' => false,
                'label_has_no_takeaway' => false,
                // Luasan
                'land_area_sqm' => 200,
                'building_area_sqm' => 130,
                'area_compliance' => 'di_bawah_standar',
                // Gudang
                'rack_dry_material' => 'kayu',
                'pallet_dry_material' => 'kayu', // dilarang
                'rack_wet_material' => 'tidak_ada',
                'pallet_wet_material' => 'tidak_ada',
                // Alur
                'production_flow_status' => 'tidak_sesuai',
                'production_flow_notes' => 'Alur lalu lintas bahan baku bersilangan dengan sisa sampah/limbah.',
                // CCTV & Net
                'cctv_all_critical_points' => false,
                'cctv_unit_count' => 2,
                'cctv_type' => 'Stand Alone WiFi Cam',
                'internet_speed_test_available' => false,
                'recommendation_reason' => 'Belum memiliki dokumen SLHS, palet kayu dilarang digunakan, IPAL belum berfungsi, dan belum ada tenaga ahli gizi tersertifikasi.',
                'satgas_leader_name' => 'Drs. Akhmad Pratama, M.Si.',
                'status' => 'submitted',
            ],
            [
                'inspection_number' => 'ST-SATGAS/PSW/2026/017',
                'inspection_date' => now()->subDays(1),
                'sppg_id_code' => '18020404',
                'sppg_name' => 'SPPG Satgas Gizi Sukoharjo Makmur',
                'sppg_type' => 'BGN',
                'regency_city' => 'Kabupaten Pringsewu',
                'inspector_name' => 'Nurmala Sari, S.KM. & Tim Satgas MBG',
                'beneficiary_count' => 2200,
                // Legalitas
                'has_slhs' => true,
                'slhs_expiry_date' => now()->addMonths(12),
                'has_halal' => true,
                'halal_expiry_date' => now()->addMonths(20),
                // Staff
                'head_present' => true,
                'head_name' => 'Dra. Hj. Nurjanah, M.Pd.',
                'head_nik' => '1810044501780002',
                'head_phone' => '081272819203',
                'nutritionist_status' => 'ada_gizi',
                'nutritionist_name' => 'Fadhil Pratama, S.Gz.',
                'nutritionist_nik' => '1810042104950004',
                'nutritionist_phone' => '082177391029',
                'nutritionist_education' => 'S1 Gizi Kesehatan',
                'finance_present' => true,
                'finance_name' => 'Tri Wulandari, S.Ak.',
                'finance_nik' => '1810045903930001',
                'finance_phone' => '085288192039',
                // Chef
                'chef_present' => true,
                'chef_name' => 'Chef Agus Salim',
                'chef_nik' => '1810041806840003',
                'chef_phone' => '081399182736',
                'chef_has_experience' => true,
                'chef_paklaring_number' => 'SK-CHEF/CATERING-MBG/2025-03',
                // Air
                'drinking_water_source' => 'ro',
                'cooking_water_source' => 'ro',
                // Rantai Dingin
                'chiller_unit_count' => 2,
                'chiller_temp_celsius' => 4.0,
                'chiller_status' => 'optimal_le_5',
                'freezer_unit_count' => 2,
                'freezer_temp_celsius' => -19.0,
                'freezer_capacity_liters' => 1000,
                'freezer_status' => 'optimal_le_minus18',
                // Kompor
                'stove_high_pressure_count' => 4,
                'stove_low_pressure_count' => 2,
                'stove_all_working' => true,
                // Sanitasi
                'sink_persiapan' => true,
                'sink_pemorsian' => true,
                'sink_pengolahan' => true,
                'sink_kamar_mandi' => true,
                'sink_jalan_masuk' => true,
                'ipal_functioning' => true,
                'grease_trap_functioning' => true,
                // APAR
                'apar_available' => true,
                'apar_expiry_date' => now()->addMonths(9),
                'apar_is_valid' => true,
                // Label
                'label_has_time_limit' => true,
                'label_has_no_takeaway' => true,
                // Luasan
                'land_area_sqm' => 400,
                'building_area_sqm' => 260,
                'area_compliance' => 'sesuai',
                // Gudang
                'rack_dry_material' => 'stainless',
                'pallet_dry_material' => 'stainless',
                'rack_wet_material' => 'stainless',
                'pallet_wet_material' => 'stainless',
                // Alur
                'production_flow_status' => 'sesuai_tanpa_catatan',
                'production_flow_video_url' => 'https://drive.google.com/file/d/sppg-sukoharjo-flow',
                // CCTV & Net
                'cctv_all_critical_points' => true,
                'cctv_unit_count' => 11,
                'cctv_type' => 'IP Cam 4MP PoE',
                'internet_speed_test_available' => true,
                'internet_download_mbps' => 78.40,
                'internet_upload_mbps' => 38.60,
                'internet_provider' => 'IndiHome 100 Mbps',
                'recommendation_reason' => 'Standar higienitas dan sanitasi dapur sangat baik, penanganan rantai dingin memuaskan, dokumen legalitas lengkap.',
                'satgas_leader_name' => 'Drs. Akhmad Pratama, M.Si.',
                'status' => 'verified',
            ],
            [
                'inspection_number' => 'ST-SATGAS/PSW/2026/018',
                'inspection_date' => now()->subDays(5),
                'sppg_id_code' => '18020505',
                'sppg_name' => 'SPPG Gotong Royong Adiluwih',
                'sppg_type' => 'Mandiri',
                'regency_city' => 'Kabupaten Pringsewu',
                'inspector_name' => 'Faisal Tanjung, S.T. & Tim Satgas MBG',
                'beneficiary_count' => 1500,
                // Legalitas (SLHS ada, Halal proses/tidak ada -> 6%)
                'has_slhs' => true,
                'slhs_expiry_date' => now()->addMonths(11),
                'has_halal' => false,
                // Staff (Kepala ada, gizi tekpang, finance ada -> 2 + 1 + 1 = 4%)
                'head_present' => true,
                'head_name' => 'Kurniawan, S.E.',
                'head_nik' => '1810052102830002',
                'head_phone' => '081273918201',
                'nutritionist_status' => 'ada_tekpang',
                'nutritionist_name' => 'Dian Permata, S.T.P.',
                'nutritionist_nik' => '1810055208970001',
                'nutritionist_phone' => '082188273619',
                'nutritionist_education' => 'S1 Teknologi Industri Pertanian',
                'finance_present' => true,
                'finance_name' => 'Agus Priyono',
                'finance_nik' => '1810051103890003',
                'finance_phone' => '085277182930',
                // Chef (hadir, paklaring ada -> 6%)
                'chef_present' => true,
                'chef_name' => 'Chef Danu Subroto',
                'chef_nik' => '1810051907860004',
                'chef_phone' => '081399281720',
                'chef_has_experience' => true,
                'chef_paklaring_number' => 'PKL-RESTO-ADILUWIH/2025/09',
                // Air (galon + galon -> 6% + 8% = 14%)
                'drinking_water_source' => 'galon',
                'cooking_water_source' => 'galon',
                // Rantai Dingin (Chiller ok, Freezer above_minus18 -> 5% + 3% = 8%)
                'chiller_unit_count' => 1,
                'chiller_temp_celsius' => 4.5,
                'chiller_status' => 'optimal_le_5',
                'freezer_unit_count' => 1,
                'freezer_temp_celsius' => -15.0,
                'freezer_capacity_liters' => 600,
                'freezer_status' => 'above_minus18',
                // Kompor (ada high pressure, rasio >= 1 tapi 1 tungku servis -> 2%)
                'stove_high_pressure_count' => 2,
                'stove_low_pressure_count' => 2,
                'stove_all_working' => false,
                // Sanitasi (4 wastafel = 4.8%, IPAL ok 4%, Grease ok 2% -> 10.8%)
                'sink_persiapan' => true,
                'sink_pemorsian' => true,
                'sink_pengolahan' => true,
                'sink_kamar_mandi' => true,
                'sink_jalan_masuk' => false,
                'ipal_functioning' => true,
                'grease_trap_functioning' => true,
                // APAR (ada & valid -> 5%)
                'apar_available' => true,
                'apar_expiry_date' => now()->addMonths(6),
                'apar_is_valid' => true,
                // Label (lengkap -> 3%)
                'label_has_time_limit' => true,
                'label_has_no_takeaway' => true,
                // Luasan (sesuai -> 7%)
                'land_area_sqm' => 300,
                'building_area_sqm' => 180,
                'area_compliance' => 'sesuai',
                // Gudang (besi plastik -> 1.75*4 = 7%)
                'rack_dry_material' => 'besi_plastik',
                'pallet_dry_material' => 'besi_plastik',
                'rack_wet_material' => 'besi_plastik',
                'pallet_wet_material' => 'besi_plastik',
                // Alur (sesuai catatan -> 6%)
                'production_flow_status' => 'sesuai_dengan_catatan',
                'production_flow_notes' => 'Tirai sekat ruang pemorsian perlu diganti partisi aluminium permanen.',
                // CCTV & Net (CCTV ok 1.5%, speedtest ok 1.5% -> 3%)
                'cctv_all_critical_points' => true,
                'cctv_unit_count' => 10,
                'cctv_type' => 'DVR 16 CH',
                'internet_speed_test_available' => true,
                'internet_download_mbps' => 35.0,
                'internet_upload_mbps' => 15.0,
                'internet_provider' => 'Iconnet 35 Mbps',
                'recommendation_reason' => 'Percepatan penerbitan Sertifikat Halal, perbaikan 1 unit tungku kompor bertekanan tinggi, dan penyesuaian suhu freezer hingga -18°C.',
                'satgas_leader_name' => 'Drs. Akhmad Pratama, M.Si.',
                'status' => 'verified',
            ],
        ];

        foreach ($audits as $item) {
            $audit = new SppgAudit($item);
            $audit->calculateScores();
            $audit->save();
        }
    }
}
