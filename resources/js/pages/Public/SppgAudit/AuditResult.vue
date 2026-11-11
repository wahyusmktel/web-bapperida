<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    Printer,
    Download,
    Share2,
    CheckCircle2,
    AlertCircle,
    XCircle,
    ShieldCheck,
    Building2,
    Calendar,
    User,
    ArrowLeft,
    FileText,
    Award,
    Activity,
    QrCode,
} from 'lucide-vue-next';
import { notify } from '@/lib/toast';

interface AuditItem {
    id: string;
    inspection_number: string;
    inspection_date: string;
    sppg_id_code: string;
    sppg_name: string;
    sppg_type: string;
    regency_city: string;
    inspector_name: string;
    beneficiary_count: number;

    has_slhs: boolean;
    slhs_expiry_date: string | null;
    has_halal: boolean;
    halal_expiry_date: string | null;

    head_present: boolean;
    head_name: string | null;
    head_nik: string | null;
    head_phone: string | null;

    nutritionist_status: string;
    nutritionist_name: string | null;
    nutritionist_nik: string | null;
    nutritionist_phone: string | null;
    nutritionist_education: string | null;

    finance_present: boolean;
    finance_name: string | null;
    finance_nik: string | null;
    finance_phone: string | null;

    chef_present: boolean;
    chef_name: string | null;
    chef_nik: string | null;
    chef_phone: string | null;
    chef_has_experience: boolean;
    chef_paklaring_number: string | null;

    drinking_water_source: string;
    cooking_water_source: string;

    chiller_unit_count: number;
    chiller_temp_celsius: number | null;
    chiller_status: string;
    freezer_unit_count: number;
    freezer_temp_celsius: number | null;
    freezer_capacity_liters: number | null;
    freezer_status: string;

    stove_high_pressure_count: number;
    stove_low_pressure_count: number;
    stove_all_working: boolean;
    stove_ratio: number;
    stove_condition: string;

    sink_persiapan: boolean;
    sink_pemorsian: boolean;
    sink_pengolahan: boolean;
    sink_kamar_mandi: boolean;
    sink_jalan_masuk: boolean;
    ipal_functioning: boolean;
    grease_trap_functioning: boolean;

    apar_available: boolean;
    apar_expiry_date: string | null;
    apar_is_valid: boolean;

    label_has_time_limit: boolean;
    label_has_no_takeaway: boolean;

    land_area_sqm: number;
    building_area_sqm: number;
    area_compliance: string;

    rack_dry_material: string;
    pallet_dry_material: string;
    rack_wet_material: string;
    pallet_wet_material: string;

    production_flow_status: string;
    production_flow_video_url: string | null;
    production_flow_notes: string | null;

    cctv_all_critical_points: boolean;
    cctv_unit_count: number | null;
    cctv_type: string | null;
    internet_speed_test_available: boolean;
    internet_download_mbps: number | null;
    internet_upload_mbps: number | null;
    internet_provider: string | null;

    score_keamanan_pangan: number;
    score_legalitas_sdm: number;
    score_lahan_keselamatan: number;
    total_score: number;
    grade: string;
    recommendation: string;
    recommendation_reason: string | null;

    satgas_leader_name: string;
    satgas_leader_signature: string | null;
    status: string;
    created_at: string;
}

interface Props {
    audit: AuditItem;
}

const props = defineProps<Props>();

const printDocument = () => {
    window.print();
};

const copyShareLink = () => {
    navigator.clipboard.writeText(window.location.href);
    notify.success('Tautan lembar audit berhasil disalin ke clipboard.');
};

const gradeColor = computed(() => {
    if (props.audit.grade === 'Grade A') return 'text-emerald-700 bg-emerald-50 border-emerald-300';
    if (props.audit.grade === 'Grade B') return 'text-amber-700 bg-amber-50 border-amber-300';
    return 'text-rose-700 bg-rose-50 border-rose-300';
});

const recommendationText = computed(() => {
    if (props.audit.recommendation === 'layak_dilanjutkan') return 'Layak Dilanjutkan';
    if (props.audit.recommendation === 'layak_dengan_perbaikan') return 'Layak Dilanjutkan dengan Perbaikan';
    return 'Tidak Layak Dilanjutkan';
});
</script>

<template>
    <Head :title="`Hasil Audit SPPG - ${audit.sppg_name}`" />

    <PublicLayout>
        <!-- Print Header & Controls (Hidden when printing) -->
        <section class="print:hidden bg-gradient-to-b from-teal-950 to-slate-900 text-white py-8 border-b border-teal-800/40">
            <div class="max-w-5xl mx-auto px-4 sm:px-8 space-y-4">
                <div class="flex items-center justify-between">
                    <Link
                        href="/audit-sppg"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-teal-300 hover:text-white transition-colors"
                    >
                        <ArrowLeft class="w-3.5 h-3.5" />
                        <span>Kembali ke Modul Audit SPPG</span>
                    </Link>

                    <div class="flex items-center gap-2">
                        <button
                            type="button"
                            class="px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-bold text-white transition-all flex items-center gap-1.5 cursor-pointer"
                            @click="copyShareLink"
                        >
                            <Share2 class="w-3.5 h-3.5" />
                            <span>Bagikan</span>
                        </button>
                        <button
                            type="button"
                            class="px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-xs font-bold text-white transition-all shadow-md flex items-center gap-1.5 cursor-pointer"
                            @click="printDocument"
                        >
                            <Printer class="w-3.5 h-3.5" />
                            <span>Cetak Formulir Resmi (Lampiran 1)</span>
                        </button>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2">
                    <div>
                        <span class="text-[11px] font-mono text-teal-300 uppercase tracking-wider block">
                            {{ audit.inspection_number }} • ID: {{ audit.sppg_id_code }}
                        </span>
                        <h1 class="text-xl sm:text-2xl font-black text-white">
                            {{ audit.sppg_name }}
                        </h1>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="px-4 py-2 rounded-2xl border text-center" :class="gradeColor">
                            <span class="text-[10px] font-bold uppercase tracking-wider block">Hasil Evaluasi</span>
                            <span class="text-lg font-black font-mono">{{ audit.total_score }}% • {{ audit.grade }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- OFFICIAL FORM CONTAINER (Formatted for Screen & Print) -->
        <div class="max-w-5xl mx-auto px-4 sm:px-8 py-8 print:p-0 print:max-w-none">
            
            <!-- Dokumen Kertas Resmi Lampiran 1 -->
            <div class="bg-white rounded-3xl print:rounded-none p-6 sm:p-10 border border-slate-200/90 print:border-none shadow-lg print:shadow-none space-y-6 text-slate-900 font-sans">
                
                <!-- Kop Form Resmi -->
                <div class="text-center space-y-1 border-b-2 border-slate-900 pb-4">
                    <h2 class="text-lg sm:text-xl font-black uppercase tracking-wide">
                        FORM CHECKLIST KELAYAKAN OPERASIONAL SPPG
                    </h2>
                    <p class="text-xs sm:text-sm font-bold text-slate-700">
                        Oleh Satuan Tugas Percepatan Program Makan Bergizi Gratis Kabupaten/Kota
                    </p>
                    <div class="flex justify-between items-center text-[11px] text-slate-600 pt-2 font-mono">
                        <span>Lampiran 1 | Nomor: <strong>{{ audit.inspection_number || '-' }}</strong></span>
                        <span>Tanggal: <strong>{{ audit.inspection_date }}</strong></span>
                    </div>
                </div>

                <!-- Petunjuk Resmi -->
                <div class="text-[11px] text-slate-600 space-y-0.5 border-b border-slate-200 pb-3">
                    <p class="font-bold text-slate-700">Petunjuk:</p>
                    <p>1. Isi seluruh kolom dan lampirkan foto sesuai kolom Dokumentasi Wajib. Kirim hasil melalui kanal resmi Satgas MBG.</p>
                    <p>2. Seluruh bukti dokumentasi (foto dan video) wajib menggunakan timestamp.</p>
                </div>

                <!-- Identitas SPPG Box -->
                <div class="grid grid-cols-2 sm:grid-cols-4 border border-slate-900 text-xs divide-x divide-y divide-slate-900">
                    <div class="p-2.5 bg-slate-50 font-bold">ID SPPG (8 digit)</div>
                    <div class="p-2.5 font-mono font-bold">{{ audit.sppg_id_code }}</div>
                    <div class="p-2.5 bg-slate-50 font-bold">Kab / Kota</div>
                    <div class="p-2.5">{{ audit.regency_city }}</div>

                    <div class="p-2.5 bg-slate-50 font-bold">Nama SPPG</div>
                    <div class="p-2.5 font-bold">{{ audit.sppg_name }}</div>
                    <div class="p-2.5 bg-slate-50 font-bold">Nama Petugas Satgas</div>
                    <div class="p-2.5">{{ audit.inspector_name }}</div>

                    <div class="p-2.5 bg-slate-50 font-bold">Jumlah PM (porsi/hari)</div>
                    <div class="p-2.5 font-mono font-bold">{{ audit.beneficiary_count }} porsi/hari</div>
                    <div class="p-2.5 bg-slate-50 font-bold">Tanggal Inspeksi</div>
                    <div class="p-2.5 font-mono">{{ audit.inspection_date }}</div>
                </div>

                <!-- TABEL 14 INDIKATOR PEMERIKSAAN -->
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-slate-900 text-[11px] sm:text-xs">
                        <thead>
                            <tr class="bg-slate-100 text-slate-900 border-b border-slate-900">
                                <th class="border border-slate-900 p-2 text-center w-10">No</th>
                                <th class="border border-slate-900 p-2 text-left w-48 sm:w-56">Item Pemeriksaan</th>
                                <th class="border border-slate-900 p-2 text-left">Nilai / Data Temuan</th>
                                <th class="border border-slate-900 p-2 text-left w-52 sm:w-64">Dokumentasi Wajib</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-900">
                            <!-- 1. Legalitas Dokumen -->
                            <tr>
                                <td class="border border-slate-900 p-2 text-center font-bold">1</td>
                                <td class="border border-slate-900 p-2 font-bold">
                                    Legalitas Dokumen
                                    <span class="block text-[10px] text-slate-500 font-normal">Bobot 12%</span>
                                </td>
                                <td class="border border-slate-900 p-2 space-y-1">
                                    <div>SLHS: <strong>{{ audit.has_slhs ? 'Ada [✓]' : 'Tidak [✗]' }}</strong> (Berlaku s.d: {{ audit.slhs_expiry_date || '-' }})</div>
                                    <div>Sertifikat Halal: <strong>{{ audit.has_halal ? 'Ada [✓]' : 'Tidak [✗]' }}</strong> (Berlaku s.d: {{ audit.halal_expiry_date || '-' }})</div>
                                </td>
                                <td class="border border-slate-900 p-2 text-[10px] text-slate-600">
                                    • Foto dokumen asli SLHS<br />
                                    • Foto dokumen asli Sertifikat Halal
                                </td>
                            </tr>

                            <!-- 2. Kepala SPPG & Staff -->
                            <tr>
                                <td class="border border-slate-900 p-2 text-center font-bold">2</td>
                                <td class="border border-slate-900 p-2 font-bold">
                                    Staff di SPPG
                                    <span class="block text-[10px] text-slate-500 font-normal">Bobot 5%</span>
                                </td>
                                <td class="border border-slate-900 p-2 space-y-1">
                                    <div>Kepala SPPG: <strong>{{ audit.head_present ? 'Ada [✓]' : 'Tidak [✗]' }}</strong> - {{ audit.head_name || '-' }} (HP: {{ audit.head_phone || '-' }})</div>
                                    <div>Pengawas Gizi: <strong>{{ audit.nutritionist_status }}</strong> - {{ audit.nutritionist_name || '-' }} ({{ audit.nutritionist_education || '-' }})</div>
                                    <div>Pengawas Keuangan: <strong>{{ audit.finance_present ? 'Ada [✓]' : 'Tidak [✗]' }}</strong> - {{ audit.finance_name || '-' }}</div>
                                </td>
                                <td class="border border-slate-900 p-2 text-[10px] text-slate-600">
                                    • Foto Kepala SPPG memegang KTP latar papan nama dapur<br />
                                    • Foto KTP Kepala SPPG & Pengawas
                                </td>
                            </tr>

                            <!-- 3. Chef -->
                            <tr>
                                <td class="border border-slate-900 p-2 text-center font-bold">3</td>
                                <td class="border border-slate-900 p-2 font-bold">
                                    Chef (Koki Profesional)
                                    <span class="block text-[10px] text-slate-500 font-normal">Bobot 6%</span>
                                </td>
                                <td class="border border-slate-900 p-2 space-y-1">
                                    <div>Kehadiran: <strong>{{ audit.chef_present ? 'Ada di lokasi [✓]' : 'Tidak [✗]' }}</strong> - {{ audit.chef_name || '-' }}</div>
                                    <div>Paklaring / Masa Kerja: <strong>{{ audit.chef_has_experience ? 'Ada Bukti (1 Tahun) [✓]' : 'Tidak [✗]' }}</strong> (No: {{ audit.chef_paklaring_number || '-' }})</div>
                                </td>
                                <td class="border border-slate-900 p-2 text-[10px] text-slate-600">
                                    • Foto Chef memegang KTP latar papan dapur<br />
                                    • Foto KTP Chef & Surat Paklaring
                                </td>
                            </tr>

                            <!-- 4. Sumber Air Minum -->
                            <tr>
                                <td class="border border-slate-900 p-2 text-center font-bold">4</td>
                                <td class="border border-slate-900 p-2 font-bold">Sumber Air Minum (7%)</td>
                                <td class="border border-slate-900 p-2">
                                    Jenis: <strong class="uppercase">{{ audit.drinking_water_source }}</strong>
                                </td>
                                <td class="border border-slate-900 p-2 text-[10px] text-slate-600">Foto sumber air minum</td>
                            </tr>

                            <!-- 5. Sumber Air Masak -->
                            <tr>
                                <td class="border border-slate-900 p-2 text-center font-bold">5</td>
                                <td class="border border-slate-900 p-2 font-bold">Sumber Air Masak (9%)</td>
                                <td class="border border-slate-900 p-2">
                                    Jenis: <strong class="uppercase">{{ audit.cooking_water_source }}</strong>
                                </td>
                                <td class="border border-slate-900 p-2 text-[10px] text-slate-600">Foto sumber air masak</td>
                            </tr>

                            <!-- 6. Rantai Dingin -->
                            <tr>
                                <td class="border border-slate-900 p-2 text-center font-bold">6</td>
                                <td class="border border-slate-900 p-2 font-bold">Rantai Dingin (Chiller & Freezer) (11%)</td>
                                <td class="border border-slate-900 p-2 space-y-1">
                                    <div>Chiller: {{ audit.chiller_unit_count }} unit • Suhu display: <strong>{{ audit.chiller_temp_celsius }}°C</strong> ({{ audit.chiller_status }})</div>
                                    <div>Freezer: {{ audit.freezer_unit_count }} unit • Suhu display: <strong>{{ audit.freezer_temp_celsius }}°C</strong> • Kapasitas: {{ audit.freezer_capacity_liters || '-' }} L</div>
                                </td>
                                <td class="border border-slate-900 p-2 text-[10px] text-slate-600">
                                    • Foto chiller display suhu<br />
                                    • Foto freezer display suhu
                                </td>
                            </tr>

                            <!-- 7. Kompor -->
                            <tr>
                                <td class="border border-slate-900 p-2 text-center font-bold">7</td>
                                <td class="border border-slate-900 p-2 font-bold">Kompor (4%)</td>
                                <td class="border border-slate-900 p-2 space-y-1">
                                    <div>High Pressure: {{ audit.stove_high_pressure_count }} tungku • Low Pressure: {{ audit.stove_low_pressure_count }} tungku</div>
                                    <div>Rasio Kapasitas: <strong>{{ audit.stove_ratio }}</strong> • {{ audit.stove_condition }}</div>
                                </td>
                                <td class="border border-slate-900 p-2 text-[10px] text-slate-600">Foto keseluruhan area kompor</td>
                            </tr>

                            <!-- 8. Sanitasi Dasar -->
                            <tr>
                                <td class="border border-slate-900 p-2 text-center font-bold">8</td>
                                <td class="border border-slate-900 p-2 font-bold">Sanitasi Dasar (12%)</td>
                                <td class="border border-slate-900 p-2 space-y-1">
                                    <div>Wastafel Cuci Tangan:
                                        Persiapan [{{ audit.sink_persiapan ? '✓' : '-' }}],
                                        Pemorsian [{{ audit.sink_pemorsian ? '✓' : '-' }}],
                                        Pengolahan [{{ audit.sink_pengolahan ? '✓' : '-' }}],
                                        KM [{{ audit.sink_kamar_mandi ? '✓' : '-' }}],
                                        Pintu Masuk [{{ audit.sink_jalan_masuk ? '✓' : '-' }}]
                                    </div>
                                    <div>Saluran IPAL: <strong>{{ audit.ipal_functioning ? 'Berfungsi [✓]' : 'Tidak [✗]' }}</strong> • Grease Trap: <strong>{{ audit.grease_trap_functioning ? 'Berfungsi [✓]' : 'Tidak [✗]' }}</strong></div>
                                </td>
                                <td class="border border-slate-900 p-2 text-[10px] text-slate-600">
                                    • Foto wastafel 5 ruang<br />
                                    • Foto IPAL terbuka & Grease trap
                                </td>
                            </tr>

                            <!-- 9. APAR -->
                            <tr>
                                <td class="border border-slate-900 p-2 text-center font-bold">9</td>
                                <td class="border border-slate-900 p-2 font-bold">APAR (5%)</td>
                                <td class="border border-slate-900 p-2">
                                    Ketersediaan: <strong>{{ audit.apar_available ? 'Tersedia [✓]' : 'Tidak [✗]' }}</strong> • Kedaluwarsa: {{ audit.apar_expiry_date || '-' }} (Valid: {{ audit.apar_is_valid ? 'Ya' : 'Tidak' }})
                                </td>
                                <td class="border border-slate-900 p-2 text-[10px] text-slate-600">
                                    • Foto APAR<br />
                                    • Foto label tanggal kedaluwarsa
                                </td>
                            </tr>

                            <!-- 10. Label Ompreng -->
                            <tr>
                                <td class="border border-slate-900 p-2 text-center font-bold">10</td>
                                <td class="border border-slate-900 p-2 font-bold">Label Kemasan Ompreng (3%)</td>
                                <td class="border border-slate-900 p-2">
                                    Info Batas Waktu: <strong>{{ audit.label_has_time_limit ? 'Ada [✓]' : 'Tidak [✗]' }}</strong> • Info Dilarang Bawa Pulang: <strong>{{ audit.label_has_no_takeaway ? 'Ada [✓]' : 'Tidak [✗]' }}</strong>
                                </td>
                                <td class="border border-slate-900 p-2 text-[10px] text-slate-600">Foto label tertempel di ompreng</td>
                            </tr>

                            <!-- 11. Jenis & Luasan -->
                            <tr>
                                <td class="border border-slate-900 p-2 text-center font-bold">11</td>
                                <td class="border border-slate-900 p-2 font-bold">Jenis & Luasan SPPG (7%)</td>
                                <td class="border border-slate-900 p-2 space-y-1">
                                    <div>Jenis: {{ audit.sppg_type }} • Luas Tanah: {{ audit.land_area_sqm }} m² • Luas Bangunan: {{ audit.building_area_sqm }} m²</div>
                                    <div>Kesesuaian Standar PM: <strong class="uppercase">{{ audit.area_compliance }}</strong></div>
                                </td>
                                <td class="border border-slate-900 p-2 text-[10px] text-slate-600">Foto Lahan & Bangunan tampak depan</td>
                            </tr>

                            <!-- 12. Gudang Kering & Basah -->
                            <tr>
                                <td class="border border-slate-900 p-2 text-center font-bold">12</td>
                                <td class="border border-slate-900 p-2 font-bold">Gudang Kering & Basah (8%)</td>
                                <td class="border border-slate-900 p-2 space-y-1">
                                    <div>Gudang Kering: Rak ({{ audit.rack_dry_material }}), Palet ({{ audit.pallet_dry_material }})</div>
                                    <div>Gudang Basah: Rak ({{ audit.rack_wet_material }}), Palet ({{ audit.pallet_wet_material }})</div>
                                </td>
                                <td class="border border-slate-900 p-2 text-[10px] text-slate-600">Foto gudang & palet (palet kayu dilarang)</td>
                            </tr>

                            <!-- 13. Video Alur Produksi -->
                            <tr>
                                <td class="border border-slate-900 p-2 text-center font-bold">13</td>
                                <td class="border border-slate-900 p-2 font-bold">Video Alur Produksi (8%)</td>
                                <td class="border border-slate-900 p-2 space-y-1">
                                    <div>Status Alur: <strong class="uppercase">{{ audit.production_flow_status }}</strong></div>
                                    <div v-if="audit.production_flow_notes" class="text-slate-500 italic">Catatan: {{ audit.production_flow_notes }}</div>
                                </td>
                                <td class="border border-slate-900 p-2 text-[10px] text-slate-600">Video alur alur proses produksi</td>
                            </tr>

                            <!-- 14. CCTV & Internet -->
                            <tr>
                                <td class="border border-slate-900 p-2 text-center font-bold">14</td>
                                <td class="border border-slate-900 p-2 font-bold">CCTV & Internet (3%)</td>
                                <td class="border border-slate-900 p-2 space-y-1">
                                    <div>CCTV: {{ audit.cctv_all_critical_points ? 'Terpasang di 10 titik kritis [✓]' : 'Belum seluruh titik [✗]' }} ({{ audit.cctv_unit_count || '-' }} unit {{ audit.cctv_type || '' }})</div>
                                    <div>Speed Test: Download {{ audit.internet_download_mbps || '-' }} Mbps • Upload {{ audit.internet_upload_mbps || '-' }} Mbps ({{ audit.internet_provider || '-' }})</div>
                                </td>
                                <td class="border border-slate-900 p-2 text-[10px] text-slate-600">
                                    • Foto unit CCTV terpasang<br />
                                    • Screenshot speed test ber-timestamp
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Bagian 12: Rekomendasi Kelayakan Operasional Resmi -->
                <div class="border border-slate-900 p-4 space-y-3">
                    <h3 class="font-black text-xs uppercase tracking-wider">
                        12. REKOMENDASI KELAYAKAN OPERASIONAL (TOTAL SKOR: {{ audit.total_score }}% • {{ audit.grade }})
                    </h3>
                    <div class="flex flex-wrap items-center gap-6 text-xs">
                        <label class="flex items-center gap-2 font-bold">
                            <input type="checkbox" :checked="audit.recommendation === 'layak_dilanjutkan'" disabled class="rounded" />
                            <span>[ ] Layak Dilanjutkan</span>
                        </label>
                        <label class="flex items-center gap-2 font-bold">
                            <input type="checkbox" :checked="audit.recommendation === 'layak_dengan_perbaikan'" disabled class="rounded" />
                            <span>[ ] Layak Dilanjutkan dengan Perbaikan</span>
                        </label>
                        <label class="flex items-center gap-2 font-bold">
                            <input type="checkbox" :checked="audit.recommendation === 'tidak_layak'" disabled class="rounded" />
                            <span>[ ] Tidak Layak Dilanjutkan</span>
                        </label>
                    </div>

                    <div class="text-xs pt-1">
                        <span class="font-bold">Alasan singkat (maks. 2 baris): </span>
                        <span class="italic text-slate-800">{{ audit.recommendation_reason || '-' }}</span>
                    </div>
                </div>

                <!-- Bagian Tanda Tangan Resmi -->
                <div class="pt-6 flex justify-between items-end">
                    <div class="text-[10px] text-slate-400 space-y-1">
                        <div class="flex items-center gap-1.5 text-slate-600 font-bold">
                            <QrCode class="w-8 h-8 text-teal-800" />
                            <div>
                                <span>Verifikasi Digital BAPPERIDA</span>
                                <span class="block text-[9px] font-mono text-slate-400">ID: {{ audit.id }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-center space-y-2 min-w-48 text-xs">
                        <p class="font-medium">Ketua Satgas MBG Kabupaten/Kota,</p>
                        <div class="h-20 flex items-center justify-center">
                            <img
                                v-if="audit.satgas_leader_signature"
                                :src="audit.satgas_leader_signature"
                                alt="Tanda Tangan"
                                class="max-h-16 object-contain"
                            />
                            <div v-else class="text-[10px] text-slate-400 italic">
                                [ Tanda Tangan Terlampir ]
                            </div>
                        </div>
                        <p class="font-black underline uppercase">
                            ( {{ audit.satgas_leader_name }} )
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </PublicLayout>
</template>

<style>
@media print {
    body {
        background-color: white !important;
        color: black !important;
    }
    nav, footer, .top-gov-bar {
        display: none !important;
    }
}
</style>
