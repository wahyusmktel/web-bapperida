<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import SppgGuideModal from '@/components/SppgGuideModal.vue';
import { SPPG_GUIDELINES, SPPG_CATEGORIES } from '@/data/sppgGuidelines';
import { confirmAction } from '@/lib/swal';
import { notify } from '@/lib/toast';
import {
    ClipboardCheck,
    ShieldCheck,
    CheckCircle2,
    AlertCircle,
    Info,
    BookOpen,
    Upload,
    Calendar,
    User,
    Building2,
    Users,
    Utensils,
    Droplets,
    Flame,
    ThermometerSnowflake,
    Trash2,
    Sparkles,
    FileText,
    Camera,
    Eye,
    Save,
    RotateCcw,
    ChevronRight,
    ArrowRight,
    Activity,
    Layers,
    PenTool,
} from 'lucide-vue-next';

interface Props {
    suggestedNumber: string;
    currentDate: string;
}

const props = defineProps<Props>();

// State Modal Panduan
const activeGuideId = ref<number | null>(null);
const isGuideModalOpen = ref(false);

const openGuide = (id: number) => {
    activeGuideId.value = id;
    isGuideModalOpen.value = true;
};

// Form State
const form = ref({
    // Header
    inspection_number: props.suggestedNumber || 'ST-SATGAS/PSW/2026/001',
    inspection_date: props.currentDate || new Date().toISOString().split('T')[0],
    sppg_id_code: '',
    sppg_name: '',
    sppg_type: 'BGN',
    regency_city: 'Kabupaten Pringsewu',
    inspector_name: '',
    beneficiary_count: 2000,

    // 01. Legalitas
    has_slhs: false,
    slhs_expiry_date: '',
    has_halal: false,
    halal_expiry_date: '',

    // 02. Staff
    head_present: false,
    head_name: '',
    head_nik: '',
    head_phone: '',
    nutritionist_status: 'tidak_ada', // ada_gizi, ada_tekpang, tidak_ada
    nutritionist_name: '',
    nutritionist_nik: '',
    nutritionist_phone: '',
    nutritionist_education: '',
    finance_present: false,
    finance_name: '',
    finance_nik: '',
    finance_phone: '',

    // 03. Chef
    chef_present: false,
    chef_name: '',
    chef_nik: '',
    chef_phone: '',
    chef_has_experience: false,
    chef_paklaring_number: '',

    // 04. Air Minum
    drinking_water_source: 'galon', // ro, galon, pdam, sumur

    // 05. Air Masak
    cooking_water_source: 'galon', // ro, galon, pdam, sumur

    // 06. Rantai Dingin
    chiller_unit_count: 1,
    chiller_temp_celsius: 4.0,
    chiller_status: 'optimal_le_5', // optimal_le_5, above_5, not_working
    freezer_unit_count: 1,
    freezer_temp_celsius: -18.5,
    freezer_capacity_liters: 800,
    freezer_status: 'optimal_le_minus18', // optimal_le_minus18, above_minus18, not_working

    // 07. Kompor
    stove_high_pressure_count: 3,
    stove_low_pressure_count: 2,
    stove_all_working: true,

    // 08. Sanitasi Dasar
    sink_persiapan: true,
    sink_pemorsian: true,
    sink_pengolahan: true,
    sink_kamar_mandi: true,
    sink_jalan_masuk: true,
    ipal_functioning: true,
    grease_trap_functioning: true,

    // 09. APAR
    apar_available: true,
    apar_expiry_date: '',
    apar_is_valid: true,

    // 10. Label Kemasan
    label_has_time_limit: true,
    label_has_no_takeaway: true,

    // 11. Luasan SPPG
    land_area_sqm: 350,
    building_area_sqm: 220,
    area_compliance: 'sesuai', // sesuai, di_bawah_standar, tidak_dapat_dinilai

    // 12. Gudang
    rack_dry_material: 'stainless', // stainless, besi_plastik, kayu, tidak_ada
    pallet_dry_material: 'stainless',
    rack_wet_material: 'stainless',
    pallet_wet_material: 'stainless',

    // 13. Video Alur
    production_flow_status: 'sesuai_tanpa_catatan', // sesuai_tanpa_catatan, sesuai_dengan_catatan, tidak_sesuai
    production_flow_video_url: '',
    production_flow_notes: '',

    // 14. CCTV & Internet
    cctv_all_critical_points: true,
    cctv_unit_count: 10,
    cctv_type: 'IP Cam PoE',
    internet_speed_test_available: true,
    internet_download_mbps: 50.0,
    internet_upload_mbps: 20.0,
    internet_provider: 'IndiHome 50 Mbps',

    // Rekomendasi
    recommendation_reason: '',
    satgas_leader_name: 'Ketua Satgas MBG Kabupaten Pringsewu',
    satgas_leader_signature: '',
});

// Auto-evaluate Luasan SPPG based on PM & Building Area
watch(
    [() => form.value.beneficiary_count, () => form.value.building_area_sqm],
    ([pm, area]) => {
        const p = Number(pm) || 0;
        const a = Number(area) || 0;
        let requiredArea = 160;
        if (p <= 500) requiredArea = 160;
        else if (p <= 1500) requiredArea = 161;
        else if (p <= 2500) requiredArea = 241;
        else requiredArea = 321;

        if (a >= requiredArea) {
            form.value.area_compliance = 'sesuai';
        } else if (a > 0) {
            form.value.area_compliance = 'di_bawah_standar';
        }
    }
);

// Realtime Score Calculations
const scores = computed(() => {
    // 01. Legalitas
    const slhs = form.value.has_slhs ? 6.0 : 0.0;
    const halal = form.value.has_halal ? 6.0 : 0.0;
    const s01 = slhs + halal;

    // 02. Staff
    const head = form.value.head_present ? 2.0 : 0.0;
    const nut = form.value.nutritionist_status === 'ada_gizi' ? 2.0 : (form.value.nutritionist_status === 'ada_tekpang' ? 1.0 : 0.0);
    const fin = form.value.finance_present ? 1.0 : 0.0;
    const s02 = head + nut + fin;

    // 03. Chef
    const chefP = form.value.chef_present ? 3.0 : 0.0;
    const chefE = form.value.chef_has_experience ? 3.0 : 0.0;
    const s03 = chefP + chefE;

    // 04. Air Minum
    const s04 = form.value.drinking_water_source === 'ro' ? 7.0 : (form.value.drinking_water_source === 'galon' ? 6.0 : (form.value.drinking_water_source === 'pdam' ? 4.0 : 0.0));

    // 05. Air Masak
    const s05 = form.value.cooking_water_source === 'ro' ? 9.0 : (form.value.cooking_water_source === 'galon' ? 8.0 : (form.value.cooking_water_source === 'pdam' ? 6.0 : 2.0));

    // 06. Rantai Dingin
    const chiller = form.value.chiller_status === 'optimal_le_5' ? 5.0 : (form.value.chiller_status === 'above_5' ? 3.0 : 0.0);
    const freezer = form.value.freezer_status === 'optimal_le_minus18' ? 6.0 : (form.value.freezer_status === 'above_minus18' ? 3.0 : 0.0);
    const s06 = chiller + freezer;

    // 07. Kompor
    const workingStoves = (Number(form.value.stove_high_pressure_count) || 0) + (Number(form.value.stove_low_pressure_count) || 0);
    const pm = Math.max(1, Number(form.value.beneficiary_count) || 1);
    const ratio = (workingStoves * 450) / pm;
    const hasHigh = (Number(form.value.stove_high_pressure_count) || 0) > 0;
    let s07 = 0.0;
    if (ratio >= 1.0) {
        if (form.value.stove_all_working && hasHigh) s07 = 4.0;
        else if (!form.value.stove_all_working && hasHigh) s07 = 2.0;
        else if (form.value.stove_all_working && !hasHigh) s07 = 1.0;
        else s07 = 0.0;
    }

    // 08. Sanitasi
    let sinkCount = 0;
    if (form.value.sink_persiapan) sinkCount++;
    if (form.value.sink_pemorsian) sinkCount++;
    if (form.value.sink_pengolahan) sinkCount++;
    if (form.value.sink_kamar_mandi) sinkCount++;
    if (form.value.sink_jalan_masuk) sinkCount++;
    const sinkScore = Number((sinkCount * 1.2).toFixed(2));
    const ipal = form.value.ipal_functioning ? 4.0 : 0.0;
    const grease = form.value.grease_trap_functioning ? 2.0 : 0.0;
    const s08 = Number((sinkScore + ipal + grease).toFixed(2));

    // 09. APAR
    const s09 = (form.value.apar_available && form.value.apar_is_valid) ? 5.0 : 0.0;

    // 10. Label Ompreng
    let s10 = 0.0;
    if (form.value.label_has_time_limit) s10 += 1.5;
    if (form.value.label_has_no_takeaway) s10 += 1.5;

    // 11. Luasan
    const s11 = form.value.area_compliance === 'sesuai' ? 7.0 : (form.value.area_compliance === 'di_bawah_standar' ? 3.0 : 0.0);

    // 12. Gudang
    const getMatScore = (mat: string) => mat === 'stainless' ? 2.0 : (mat === 'besi_plastik' ? 1.75 : 0.0);
    const s12 = getMatScore(form.value.rack_dry_material) +
                getMatScore(form.value.pallet_dry_material) +
                getMatScore(form.value.rack_wet_material) +
                getMatScore(form.value.pallet_wet_material);

    // 13. Alur
    const s13 = form.value.production_flow_status === 'sesuai_tanpa_catatan' ? 8.0 : (form.value.production_flow_status === 'sesuai_dengan_catatan' ? 6.0 : 4.0);

    // 14. CCTV & Net
    const cctv = form.value.cctv_all_critical_points ? 1.5 : 0.0;
    const net = form.value.internet_speed_test_available ? 1.5 : 0.0;
    const s14 = cctv + net;

    // Pilar
    const pilarLegalitas = Number((s01 + s02 + s03).toFixed(2));
    const pilarPangan = Number((s04 + s05 + s06 + s07 + s08 + s10 + s12 + s13 + s14).toFixed(2));
    const pilarKeselamatan = Number((s09 + s11).toFixed(2));
    const total = Number(Math.min(100.0, pilarLegalitas + pilarPangan + pilarKeselamatan).toFixed(2));

    let grade = 'Grade D';
    let recommendation = 'tidak_layak';
    let recommendationLabel = 'Tidak Layak Dilanjutkan';
    let gradeBadge = 'bg-rose-100 text-rose-800 border-rose-300';

    if (total >= 85.0) {
        grade = 'Grade A';
        recommendation = 'layak_dilanjutkan';
        recommendationLabel = 'Layak Dilanjutkan';
        gradeBadge = 'bg-emerald-100 text-emerald-800 border-emerald-300';
    } else if (total >= 70.0) {
        grade = 'Grade B';
        recommendation = 'layak_dengan_perbaikan';
        recommendationLabel = 'Layak Dilanjutkan dengan Perbaikan';
        gradeBadge = 'bg-amber-100 text-amber-800 border-amber-300';
    }

    return {
        s01, s02, s03, s04, s05, s06, s07, s08, s09, s10, s11, s12, s13, s14,
        pilarLegalitas,
        pilarPangan,
        pilarKeselamatan,
        total,
        grade,
        recommendation,
        recommendationLabel,
        gradeBadge,
        stoveRatio: Number(ratio.toFixed(2)),
    };
});

// Canvas Signature
const signatureCanvas = ref<HTMLCanvasElement | null>(null);
const isDrawing = ref(false);
let ctx: CanvasRenderingContext2D | null = null;

const initCanvas = () => {
    if (signatureCanvas.value) {
        ctx = signatureCanvas.value.getContext('2d');
        if (ctx) {
            ctx.strokeStyle = '#0f172a';
            ctx.lineWidth = 2.5;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';
        }
    }
};

const startDrawing = (e: MouseEvent | TouchEvent) => {
    isDrawing.value = true;
    if (!ctx || !signatureCanvas.value) return;
    const rect = signatureCanvas.value.getBoundingClientRect();
    const x = 'touches' in e ? e.touches[0].clientX - rect.left : e.clientX - rect.left;
    const y = 'touches' in e ? e.touches[0].clientY - rect.top : e.clientY - rect.top;
    ctx.beginPath();
    ctx.moveTo(x, y);
};

const draw = (e: MouseEvent | TouchEvent) => {
    if (!isDrawing.value || !ctx || !signatureCanvas.value) return;
    e.preventDefault();
    const rect = signatureCanvas.value.getBoundingClientRect();
    const x = 'touches' in e ? e.touches[0].clientX - rect.left : e.clientX - rect.left;
    const y = 'touches' in e ? e.touches[0].clientY - rect.top : e.clientY - rect.top;
    ctx.lineTo(x, y);
    ctx.stroke();
};

const stopDrawing = () => {
    if (isDrawing.value && signatureCanvas.value) {
        isDrawing.value = false;
        form.value.satgas_leader_signature = signatureCanvas.value.toDataURL('image/png');
    }
};

const clearSignature = () => {
    if (ctx && signatureCanvas.value) {
        ctx.clearRect(0, 0, signatureCanvas.value.width, signatureCanvas.value.height);
        form.value.satgas_leader_signature = '';
    }
};

onMounted(() => {
    initCanvas();
});

// Form Submission
const isSubmitting = ref(false);

const submitAudit = async () => {
    if (!form.value.sppg_name.trim()) {
        notify.error('Mohon isi Nama SPPG terlebih dahulu.');
        return;
    }
    if (!form.value.sppg_id_code.trim() || form.value.sppg_id_code.length !== 8) {
        notify.error('ID SPPG wajib berupa 8 digit angka.');
        return;
    }
    if (!form.value.inspector_name.trim()) {
        notify.error('Mohon isi Nama Petugas Satgas Inspeksi.');
        return;
    }

    const confirmed = await confirmAction({
        title: 'Kirim Hasil Audit SPPG?',
        text: `Skor Total Terhitung: ${scores.value.total}% (${scores.value.grade} - ${scores.value.recommendationLabel}). Laporan akan diarsipkan resmi ke sistem BAPPERIDA.`,
        confirmButtonText: 'Ya, Kirim Laporan Audit',
        cancelButtonText: 'Cek Ulang',
    });

    if (confirmed) {
        isSubmitting.value = true;
        notify.info('Mengirim data audit...');
        router.post('/audit-sppg/form', form.value, {
            onFinish: () => {
                isSubmitting.value = false;
            },
            onError: (err) => {
                notify.error('Gagal menyimpan audit. Silakan cek kolom yang belum lengkap.');
                console.error(err);
            },
        });
    }
};
</script>

<template>
    <Head title="Formulir Checklist Kelayakan Operasional SPPG (Satgas MBG) - BAPPERIDA Pringsewu" />

    <PublicLayout>
        <!-- Header Banner -->
        <section class="bg-gradient-to-b from-teal-950 via-teal-900 to-slate-900 text-white pt-10 pb-16 relative overflow-hidden border-b border-teal-800/40">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#5eead4_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none" />

            <div class="max-w-7xl mx-auto px-4 sm:px-8 relative space-y-4">
                <div class="flex flex-wrap items-center gap-2 text-xs font-bold text-teal-300">
                    <Link href="/audit-sppg" class="hover:text-white transition-colors">Audit SPPG</Link>
                    <ChevronRight class="w-3.5 h-3.5 text-teal-500" />
                    <span class="text-white">Formulir Kelayakan Operasional (Lampiran 1 BGN)</span>
                </div>

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="space-y-2 max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-800/60 border border-teal-500/40 text-[11px] font-bold text-teal-200">
                            <ShieldCheck class="w-3.5 h-3.5 text-teal-300" />
                            <span>Satuan Tugas Percepatan Program Makan Bergizi Gratis (MBG)</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight">
                            Form Checklist Kelayakan Operasional SPPG
                        </h1>
                        <p class="text-xs sm:text-sm text-teal-100/80 leading-relaxed">
                            Standar penilaian resmi Badan Gizi Nasional (BGN) RI mencakup 14 indikator teknis, kalkulasi skor real-time, dan verifikasi kelayakan operasional dapur MBG.
                        </p>
                    </div>

                    <div class="flex items-center gap-3 shrink-0">
                        <Link
                            href="/audit-sppg"
                            class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-xs font-bold text-white transition-all"
                        >
                            Daftar Hasil Audit
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Form & Live Scoring Container -->
        <div class="max-w-7xl mx-auto px-4 sm:px-8 py-8 relative">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Kolom Kiri: Form Input Interaktif (8 cols) -->
                <div class="lg:col-span-8 space-y-8">
                    
                    <!-- 1. IDENTITAS SPPG & INSPEKSI -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-6">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-800 flex items-center justify-center font-bold">
                                    <Building2 class="w-5 h-5" />
                                </div>
                                <div>
                                    <h2 class="text-base sm:text-lg font-black text-slate-900">
                                        Identitas SPPG & Data Inspeksi
                                    </h2>
                                    <p class="text-xs text-slate-500">
                                        Data umum sentra dapur dan petugas satgas pemeriksa
                                    </p>
                                </div>
                            </div>
                            <span class="text-[11px] font-mono px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 font-bold">
                                Lampiran 1
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Nomor Surat Tugas / Lampiran</label>
                                <input
                                    v-model="form.inspection_number"
                                    type="text"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:border-teal-600 focus:ring-1 focus:ring-teal-600 font-mono text-xs"
                                    placeholder="ST-SATGAS/PSW/2026/001"
                                />
                            </div>

                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Tanggal Inspeksi</label>
                                <input
                                    v-model="form.inspection_date"
                                    type="date"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:border-teal-600 focus:ring-1 focus:ring-teal-600 text-xs"
                                />
                            </div>

                            <div>
                                <label class="block font-bold text-slate-700 mb-1">
                                    ID SPPG (8 digit) <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    v-model="form.sppg_id_code"
                                    type="text"
                                    maxlength="8"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:border-teal-600 focus:ring-1 focus:ring-teal-600 font-mono text-xs tracking-wider"
                                    placeholder="Contoh: 18020101"
                                />
                            </div>

                            <div>
                                <label class="block font-bold text-slate-700 mb-1">
                                    Jenis SPPG <span class="text-rose-500">*</span>
                                </label>
                                <select
                                    v-model="form.sppg_type"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:border-teal-600 focus:ring-1 focus:ring-teal-600 text-xs bg-white"
                                >
                                    <option value="BGN">BGN (Badan Gizi Nasional)</option>
                                    <option value="Mandiri">Mandiri</option>
                                    <option value="Khusus">Khusus</option>
                                    <option value="Terpencil">Terpencil</option>
                                    <option value="Sekolah Rakyat">Sekolah Rakyat</option>
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block font-bold text-slate-700 mb-1">
                                    Nama SPPG (Sentra Dapur) <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    v-model="form.sppg_name"
                                    type="text"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:border-teal-600 focus:ring-1 focus:ring-teal-600 text-xs"
                                    placeholder="Contoh: SPPG Sentra Dapur Mandiri Pringsewu Kota"
                                />
                            </div>

                            <div>
                                <label class="block font-bold text-slate-700 mb-1">
                                    Jumlah PM (Penerima Manfaat - porsi/hari) <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    v-model.number="form.beneficiary_count"
                                    type="number"
                                    min="1"
                                    step="50"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:border-teal-600 focus:ring-1 focus:ring-teal-600 text-xs font-mono font-bold"
                                    placeholder="2000"
                                />
                            </div>

                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Kabupaten / Kota</label>
                                <input
                                    v-model="form.regency_city"
                                    type="text"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-600 text-xs"
                                />
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block font-bold text-slate-700 mb-1">
                                    Nama Petugas Satgas Pemeriksa <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    v-model="form.inspector_name"
                                    type="text"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:border-teal-600 focus:ring-1 focus:ring-teal-600 text-xs"
                                    placeholder="Contoh: Ahmad Fadillah, S.Tr.Gz & Tim Satgas MBG"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- 2. PILAR 1: LEGALITAS & SDM (Bobot 23%) -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-blue-200/80 shadow-xs space-y-6">
                        <div class="flex items-center justify-between border-b border-blue-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-800 flex items-center justify-center font-bold">
                                    <Users class="w-5 h-5" />
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md bg-blue-100 text-blue-900">
                                            Pilar 1
                                        </span>
                                        <span class="text-xs font-bold text-blue-700">Bobot 23%</span>
                                    </div>
                                    <h3 class="text-base sm:text-lg font-black text-slate-900">
                                        Legalitas & Sumber Daya Manusia (SDM)
                                    </h3>
                                </div>
                            </div>
                            <span class="text-xs font-mono font-bold px-3 py-1 rounded-full bg-blue-50 text-blue-800 border border-blue-200">
                                Skor: {{ scores.pilarLegalitas }}% / 23%
                            </span>
                        </div>

                        <!-- 01. Legalitas Dokumen (12%) -->
                        <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/80 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-blue-100 text-blue-800">01</span>
                                    <h4 class="text-sm font-bold text-slate-900">Legalitas Dokumen (Bobot 12%)</h4>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        class="text-xs font-bold text-blue-700 hover:text-blue-900 flex items-center gap-1 cursor-pointer bg-white px-2.5 py-1 rounded-lg border border-slate-200 shadow-2xs"
                                        @click="openGuide(1)"
                                    >
                                        <BookOpen class="w-3.5 h-3.5" /> Panduan BGN
                                    </button>
                                    <span class="text-xs font-mono font-bold text-blue-800">{{ scores.s01 }}%</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                <!-- SLHS -->
                                <div class="p-4 rounded-xl bg-white border border-slate-200 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <label class="font-bold text-slate-800">SLHS (Sertifikat Laik Higiene Sanitasi)</label>
                                        <span class="text-[11px] font-mono font-bold text-teal-700">6%</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" :value="true" v-model="form.has_slhs" class="text-teal-700" />
                                            <span>Ada Dokumen Asli</span>
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" :value="false" v-model="form.has_slhs" class="text-teal-700" />
                                            <span>Tidak Ada</span>
                                        </label>
                                    </div>
                                    <div v-if="form.has_slhs">
                                        <label class="text-[11px] text-slate-500 block mb-0.5">Berlaku sampai dengan:</label>
                                        <input v-model="form.slhs_expiry_date" type="date" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs" />
                                    </div>
                                </div>

                                <!-- Sertifikat Halal -->
                                <div class="p-4 rounded-xl bg-white border border-slate-200 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <label class="font-bold text-slate-800">Sertifikat Halal (BPJPH / MUI)</label>
                                        <span class="text-[11px] font-mono font-bold text-teal-700">6%</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" :value="true" v-model="form.has_halal" class="text-teal-700" />
                                            <span>Ada Dokumen Asli</span>
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" :value="false" v-model="form.has_halal" class="text-teal-700" />
                                            <span>Tidak Ada</span>
                                        </label>
                                    </div>
                                    <div v-if="form.has_halal">
                                        <label class="text-[11px] text-slate-500 block mb-0.5">Berlaku sampai dengan:</label>
                                        <input v-model="form.halal_expiry_date" type="date" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 02. Staff di SPPG (5%) -->
                        <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/80 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-blue-100 text-blue-800">02</span>
                                    <h4 class="text-sm font-bold text-slate-900">Staff di SPPG (Bobot 5%)</h4>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        class="text-xs font-bold text-blue-700 hover:text-blue-900 flex items-center gap-1 cursor-pointer bg-white px-2.5 py-1 rounded-lg border border-slate-200 shadow-2xs"
                                        @click="openGuide(2)"
                                    >
                                        <BookOpen class="w-3.5 h-3.5" /> Panduan BGN
                                    </button>
                                    <span class="text-xs font-mono font-bold text-blue-800">{{ scores.s02 }}%</span>
                                </div>
                            </div>

                            <div class="space-y-3 text-xs">
                                <!-- Kepala SPPG -->
                                <div class="p-3.5 rounded-xl bg-white border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-slate-900">Kepala SPPG (Bobot 2%)</span>
                                            <span class="text-[10px] text-slate-400">Jam kerja: 02.00-08.00 & 17.00-19.30</span>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <label class="flex items-center gap-1.5 cursor-pointer">
                                                <input type="radio" :value="true" v-model="form.head_present" class="text-teal-700" />
                                                <span>Ada di Lokasi (2%)</span>
                                            </label>
                                            <label class="flex items-center gap-1.5 cursor-pointer">
                                                <input type="radio" :value="false" v-model="form.head_present" class="text-teal-700" />
                                                <span>Tidak Ada (0%)</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div v-if="form.head_present" class="grid grid-cols-2 gap-2 sm:w-72">
                                        <input v-model="form.head_name" type="text" placeholder="Nama Kepala SPPG" class="px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs" />
                                        <input v-model="form.head_phone" type="text" placeholder="No HP" class="px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs" />
                                    </div>
                                </div>

                                <!-- Pengawas Gizi -->
                                <div class="p-3.5 rounded-xl bg-white border border-slate-200 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-slate-900">Pengawas Gizi (Bobot 2%)</span>
                                        <span class="text-[10px] text-slate-400">Jam kerja: 02.00-08.00 & 17.00-19.30</span>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" value="ada_gizi" v-model="form.nutritionist_status" class="text-teal-700" />
                                            <span>Ada, Jurusan Ahli Gizi (2%)</span>
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" value="ada_tekpang" v-model="form.nutritionist_status" class="text-teal-700" />
                                            <span>Ada, Non-Ahli Gizi misal Tekpang (1%)</span>
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" value="tidak_ada" v-model="form.nutritionist_status" class="text-teal-700" />
                                            <span>Tidak Ada (0%)</span>
                                        </label>
                                    </div>
                                    <div v-if="form.nutritionist_status !== 'tidak_ada'" class="grid grid-cols-1 sm:grid-cols-3 gap-2 pt-1">
                                        <input v-model="form.nutritionist_name" type="text" placeholder="Nama Pengawas Gizi" class="px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs" />
                                        <input v-model="form.nutritionist_education" type="text" placeholder="Pendidikan / Jurusan" class="px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs" />
                                        <input v-model="form.nutritionist_phone" type="text" placeholder="No HP" class="px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs" />
                                    </div>
                                </div>

                                <!-- Pengawas Keuangan -->
                                <div class="p-3.5 rounded-xl bg-white border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-slate-900">Pengawas Keuangan (Bobot 1%)</span>
                                            <span class="text-[10px] text-slate-400">Jam kerja: 09.00-15.00 & 17.00-19.30</span>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <label class="flex items-center gap-1.5 cursor-pointer">
                                                <input type="radio" :value="true" v-model="form.finance_present" class="text-teal-700" />
                                                <span>Ada di Lokasi (1%)</span>
                                            </label>
                                            <label class="flex items-center gap-1.5 cursor-pointer">
                                                <input type="radio" :value="false" v-model="form.finance_present" class="text-teal-700" />
                                                <span>Tidak Ada (0%)</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div v-if="form.finance_present" class="grid grid-cols-2 gap-2 sm:w-72">
                                        <input v-model="form.finance_name" type="text" placeholder="Nama Pengawas Keuangan" class="px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs" />
                                        <input v-model="form.finance_phone" type="text" placeholder="No HP" class="px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 03. Chef (6%) -->
                        <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/80 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-blue-100 text-blue-800">03</span>
                                    <h4 class="text-sm font-bold text-slate-900">Chef / Koki Dapur (Bobot 6%)</h4>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        class="text-xs font-bold text-blue-700 hover:text-blue-900 flex items-center gap-1 cursor-pointer bg-white px-2.5 py-1 rounded-lg border border-slate-200 shadow-2xs"
                                        @click="openGuide(3)"
                                    >
                                        <BookOpen class="w-3.5 h-3.5" /> Panduan BGN
                                    </button>
                                    <span class="text-xs font-mono font-bold text-blue-800">{{ scores.s03 }}%</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                <div class="p-4 rounded-xl bg-white border border-slate-200 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <label class="font-bold text-slate-800">Kehadiran Chef</label>
                                        <span class="text-[11px] font-mono font-bold text-teal-700">3%</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" :value="true" v-model="form.chef_present" class="text-teal-700" />
                                            <span>Ada di Lokasi (3%)</span>
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" :value="false" v-model="form.chef_present" class="text-teal-700" />
                                            <span>Tidak Ada (0%)</span>
                                        </label>
                                    </div>
                                    <div v-if="form.chef_present" class="space-y-1 pt-1">
                                        <input v-model="form.chef_name" type="text" placeholder="Nama Chef" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs" />
                                    </div>
                                </div>

                                <div class="p-4 rounded-xl bg-white border border-slate-200 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <label class="font-bold text-slate-800">Paklaring / Masa Kerja 1 Tahun</label>
                                        <span class="text-[11px] font-mono font-bold text-teal-700">3%</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" :value="true" v-model="form.chef_has_experience" class="text-teal-700" />
                                            <span>Ada Bukti (3%)</span>
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" :value="false" v-model="form.chef_has_experience" class="text-teal-700" />
                                            <span>Tidak Ada (0%)</span>
                                        </label>
                                    </div>
                                    <div v-if="form.chef_has_experience" class="space-y-1 pt-1">
                                        <input v-model="form.chef_paklaring_number" type="text" placeholder="Nomor Surat Paklaring / Instansi" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. PILAR 2: KEAMANAN PANGAN (Bobot 65%) -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-emerald-200/80 shadow-xs space-y-6">
                        <div class="flex items-center justify-between border-b border-emerald-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-800 flex items-center justify-center font-bold">
                                    <Utensils class="w-5 h-5" />
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-900">
                                            Pilar 2
                                        </span>
                                        <span class="text-xs font-bold text-emerald-700">Bobot 65% (Kritis)</span>
                                    </div>
                                    <h3 class="text-base sm:text-lg font-black text-slate-900">
                                        Keamanan Pangan & Higiene Sanitasi
                                    </h3>
                                </div>
                            </div>
                            <span class="text-xs font-mono font-bold px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200">
                                Skor: {{ scores.pilarPangan }}% / 65%
                            </span>
                        </div>

                        <!-- 04 & 05 Air Minum & Masak -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- 04. Air Minum (7%) -->
                            <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/80 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">04</span>
                                        <h4 class="text-xs font-bold text-slate-900">Sumber Air Minum (7%)</h4>
                                    </div>
                                    <button type="button" @click="openGuide(4)" class="text-[11px] font-bold text-emerald-700 hover:text-emerald-900">Panduan</button>
                                </div>
                                <div class="space-y-1.5 text-xs">
                                    <label class="flex items-center justify-between p-2 rounded-lg bg-white border border-slate-200 cursor-pointer">
                                        <span class="flex items-center gap-2">
                                            <input type="radio" value="ro" v-model="form.drinking_water_source" class="text-emerald-600" />
                                            <span>RO (Reverse Osmosis)</span>
                                        </span>
                                        <span class="font-mono font-bold text-emerald-700">7%</span>
                                    </label>
                                    <label class="flex items-center justify-between p-2 rounded-lg bg-white border border-slate-200 cursor-pointer">
                                        <span class="flex items-center gap-2">
                                            <input type="radio" value="galon" v-model="form.drinking_water_source" class="text-emerald-600" />
                                            <span>Galon Berizin (AMDK/AMIU)</span>
                                        </span>
                                        <span class="font-mono font-bold text-emerald-700">6%</span>
                                    </label>
                                    <label class="flex items-center justify-between p-2 rounded-lg bg-white border border-slate-200 cursor-pointer">
                                        <span class="flex items-center gap-2">
                                            <input type="radio" value="pdam" v-model="form.drinking_water_source" class="text-emerald-600" />
                                            <span>PDAM</span>
                                        </span>
                                        <span class="font-mono font-bold text-emerald-700">4%</span>
                                    </label>
                                    <label class="flex items-center justify-between p-2 rounded-lg bg-white border border-slate-200 cursor-pointer">
                                        <span class="flex items-center gap-2">
                                            <input type="radio" value="sumur" v-model="form.drinking_water_source" class="text-emerald-600" />
                                            <span>Sumur Gali / Bor</span>
                                        </span>
                                        <span class="font-mono font-bold text-rose-600">0%</span>
                                    </label>
                                </div>
                            </div>

                            <!-- 05. Air Masak (9%) -->
                            <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/80 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-1.5">
                                        <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">05</span>
                                        <h4 class="text-xs font-bold text-slate-900">Sumber Air Masak (9%)</h4>
                                    </div>
                                    <button type="button" @click="openGuide(5)" class="text-[11px] font-bold text-emerald-700 hover:text-emerald-900">Panduan</button>
                                </div>
                                <div class="space-y-1.5 text-xs">
                                    <label class="flex items-center justify-between p-2 rounded-lg bg-white border border-slate-200 cursor-pointer">
                                        <span class="flex items-center gap-2">
                                            <input type="radio" value="ro" v-model="form.cooking_water_source" class="text-emerald-600" />
                                            <span>RO (Reverse Osmosis)</span>
                                        </span>
                                        <span class="font-mono font-bold text-emerald-700">9%</span>
                                    </label>
                                    <label class="flex items-center justify-between p-2 rounded-lg bg-white border border-slate-200 cursor-pointer">
                                        <span class="flex items-center gap-2">
                                            <input type="radio" value="galon" v-model="form.cooking_water_source" class="text-emerald-600" />
                                            <span>Galon Berizin (AMDK/AMIU)</span>
                                        </span>
                                        <span class="font-mono font-bold text-emerald-700">8%</span>
                                    </label>
                                    <label class="flex items-center justify-between p-2 rounded-lg bg-white border border-slate-200 cursor-pointer">
                                        <span class="flex items-center gap-2">
                                            <input type="radio" value="pdam" v-model="form.cooking_water_source" class="text-emerald-600" />
                                            <span>PDAM</span>
                                        </span>
                                        <span class="font-mono font-bold text-emerald-700">6%</span>
                                    </label>
                                    <label class="flex items-center justify-between p-2 rounded-lg bg-white border border-slate-200 cursor-pointer">
                                        <span class="flex items-center gap-2">
                                            <input type="radio" value="sumur" v-model="form.cooking_water_source" class="text-emerald-600" />
                                            <span>Sumur Gali / Bor</span>
                                        </span>
                                        <span class="font-mono font-bold text-amber-600">2%</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- 06. Rantai Dingin (Chiller & Freezer) (11%) -->
                        <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/80 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">06</span>
                                    <h4 class="text-sm font-bold text-slate-900">Rantai Dingin (Chiller & Freezer - Bobot 11%)</h4>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="openGuide(6)" class="text-xs font-bold text-emerald-700 hover:text-emerald-900 flex items-center gap-1 bg-white px-2.5 py-1 rounded-lg border border-slate-200">
                                        <BookOpen class="w-3.5 h-3.5" /> Panduan BGN
                                    </button>
                                    <span class="text-xs font-mono font-bold text-emerald-800">{{ scores.s06 }}%</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                <!-- Chiller (5%) -->
                                <div class="p-4 rounded-xl bg-white border border-slate-200 space-y-2.5">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-slate-800">Chiller (Maks 5%)</span>
                                        <span class="text-[11px] font-mono text-emerald-700">Suhu display digital</span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <label class="text-[10px] text-slate-500">Jumlah Unit</label>
                                            <input v-model.number="form.chiller_unit_count" type="number" min="0" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs" />
                                        </div>
                                        <div>
                                            <label class="text-[10px] text-slate-500">Suhu Terbaca (°C)</label>
                                            <input v-model.number="form.chiller_temp_celsius" type="number" step="0.1" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs font-mono" />
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" value="optimal_le_5" v-model="form.chiller_status" class="text-emerald-600" />
                                            <span>Suhu ≤ 5°C & berfungsi baik (5%)</span>
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" value="above_5" v-model="form.chiller_status" class="text-emerald-600" />
                                            <span>Suhu > 5°C (3%)</span>
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" value="not_working" v-model="form.chiller_status" class="text-emerald-600" />
                                            <span>Tidak berfungsi / suhu tidak tampak (0%)</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Freezer (6%) -->
                                <div class="p-4 rounded-xl bg-white border border-slate-200 space-y-2.5">
                                    <div class="flex items-center justify-between">
                                        <span class="font-bold text-slate-800">Freezer (Maks 6%)</span>
                                        <span class="text-[11px] font-mono text-emerald-700">Suhu display digital</span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2">
                                        <div>
                                            <label class="text-[10px] text-slate-500">Jumlah Unit</label>
                                            <input v-model.number="form.freezer_unit_count" type="number" min="0" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 text-xs" />
                                        </div>
                                        <div>
                                            <label class="text-[10px] text-slate-500">Suhu (°C)</label>
                                            <input v-model.number="form.freezer_temp_celsius" type="number" step="0.1" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 text-xs font-mono" />
                                        </div>
                                        <div>
                                            <label class="text-[10px] text-slate-500">Kapasitas (L)</label>
                                            <input v-model.number="form.freezer_capacity_liters" type="number" min="0" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 text-xs" />
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" value="optimal_le_minus18" v-model="form.freezer_status" class="text-emerald-600" />
                                            <span>Suhu ≤ −18°C & berfungsi baik (6%)</span>
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" value="above_minus18" v-model="form.freezer_status" class="text-emerald-600" />
                                            <span>Suhu > −18°C (3%)</span>
                                        </label>
                                        <label class="flex items-center gap-1.5 cursor-pointer">
                                            <input type="radio" value="not_working" v-model="form.freezer_status" class="text-emerald-600" />
                                            <span>Tidak berfungsi / suhu tidak tampak (0%)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 07. Kompor (4%) -->
                        <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/80 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">07</span>
                                    <h4 class="text-sm font-bold text-slate-900">Kompor High & Low Pressure (Bobot 4%)</h4>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="openGuide(7)" class="text-xs font-bold text-emerald-700 hover:text-emerald-900 flex items-center gap-1 bg-white px-2.5 py-1 rounded-lg border border-slate-200">
                                        <BookOpen class="w-3.5 h-3.5" /> Panduan BGN
                                    </button>
                                    <span class="text-xs font-mono font-bold text-emerald-800">{{ scores.s07 }}%</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                                <div>
                                    <label class="font-bold text-slate-700 block mb-1">Tungku Kompor High Pressure</label>
                                    <input v-model.number="form.stove_high_pressure_count" type="number" min="0" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-mono font-bold" />
                                </div>
                                <div>
                                    <label class="font-bold text-slate-700 block mb-1">Tungku Kompor Low Pressure</label>
                                    <input v-model.number="form.stove_low_pressure_count" type="number" min="0" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-mono font-bold" />
                                </div>
                                <div>
                                    <label class="font-bold text-slate-700 block mb-1">Kondisi Seluruh Kompor</label>
                                    <label class="flex items-center gap-2 p-2 rounded-xl bg-white border border-slate-200 cursor-pointer mt-1">
                                        <input type="checkbox" v-model="form.stove_all_working" class="rounded text-emerald-600" />
                                        <span>Seluruhnya Berfungsi Baik</span>
                                    </label>
                                </div>
                            </div>

                            <div class="p-3 rounded-xl bg-emerald-50/70 border border-emerald-200/60 flex items-center justify-between text-xs text-emerald-950">
                                <div>
                                    <span class="font-bold">Kalkulasi Rasio Kapasitas: </span>
                                    <span class="font-mono">{{ scores.stoveRatio }} (Standar BGN: 1 kompor = 450 PM)</span>
                                </div>
                                <span class="font-bold" :class="scores.stoveRatio >= 1.0 ? 'text-emerald-700' : 'text-rose-600'">
                                    {{ scores.stoveRatio >= 1.0 ? '✓ Rasio Memenuhi Standar' : '✗ Rasio di bawah kapasitas PM' }}
                                </span>
                            </div>
                        </div>

                        <!-- 08. Sanitasi Dasar (12%) -->
                        <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/80 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">08</span>
                                    <h4 class="text-sm font-bold text-slate-900">Sanitasi Dasar: Wastafel 5 Titik, IPAL & Grease Trap (Bobot 12%)</h4>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="openGuide(8)" class="text-xs font-bold text-emerald-700 hover:text-emerald-900 flex items-center gap-1 bg-white px-2.5 py-1 rounded-lg border border-slate-200">
                                        <BookOpen class="w-3.5 h-3.5" /> Panduan BGN
                                    </button>
                                    <span class="text-xs font-mono font-bold text-emerald-800">{{ scores.s08 }}%</span>
                                </div>
                            </div>

                            <div class="space-y-3 text-xs">
                                <div>
                                    <label class="font-bold text-slate-800 block mb-1.5">
                                        Wastafel Cuci Tangan & Sabun Cair Tersedia (1.2% per lokasi • maks 6%):
                                    </label>
                                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-2">
                                        <label class="p-2.5 rounded-xl border cursor-pointer transition-colors flex items-center gap-2" :class="form.sink_persiapan ? 'bg-emerald-50 border-emerald-300 text-emerald-900' : 'bg-white border-slate-200 text-slate-600'">
                                            <input type="checkbox" v-model="form.sink_persiapan" class="rounded text-emerald-600" />
                                            <span class="text-[11px] font-medium">Ruang Persiapan</span>
                                        </label>
                                        <label class="p-2.5 rounded-xl border cursor-pointer transition-colors flex items-center gap-2" :class="form.sink_pemorsian ? 'bg-emerald-50 border-emerald-300 text-emerald-900' : 'bg-white border-slate-200 text-slate-600'">
                                            <input type="checkbox" v-model="form.sink_pemorsian" class="rounded text-emerald-600" />
                                            <span class="text-[11px] font-medium">Ruang Pemorsian</span>
                                        </label>
                                        <label class="p-2.5 rounded-xl border cursor-pointer transition-colors flex items-center gap-2" :class="form.sink_pengolahan ? 'bg-emerald-50 border-emerald-300 text-emerald-900' : 'bg-white border-slate-200 text-slate-600'">
                                            <input type="checkbox" v-model="form.sink_pengolahan" class="rounded text-emerald-600" />
                                            <span class="text-[11px] font-medium">Ruang Pengolahan</span>
                                        </label>
                                        <label class="p-2.5 rounded-xl border cursor-pointer transition-colors flex items-center gap-2" :class="form.sink_kamar_mandi ? 'bg-emerald-50 border-emerald-300 text-emerald-900' : 'bg-white border-slate-200 text-slate-600'">
                                            <input type="checkbox" v-model="form.sink_kamar_mandi" class="rounded text-emerald-600" />
                                            <span class="text-[11px] font-medium">Kamar Mandi</span>
                                        </label>
                                        <label class="p-2.5 rounded-xl border cursor-pointer transition-colors flex items-center gap-2" :class="form.sink_jalan_masuk ? 'bg-emerald-50 border-emerald-300 text-emerald-900' : 'bg-white border-slate-200 text-slate-600'">
                                            <input type="checkbox" v-model="form.sink_jalan_masuk" class="rounded text-emerald-600" />
                                            <span class="text-[11px] font-medium">Jalan Masuk Utama</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                    <label class="p-3 rounded-xl border flex items-center justify-between cursor-pointer" :class="form.ipal_functioning ? 'bg-emerald-50 border-emerald-300 text-emerald-900' : 'bg-white border-slate-200 text-slate-600'">
                                        <span class="flex items-center gap-2">
                                            <input type="checkbox" v-model="form.ipal_functioning" class="rounded text-emerald-600" />
                                            <span class="font-bold">Saluran Limbah IPAL Berfungsi Baik</span>
                                        </span>
                                        <span class="font-mono font-bold text-emerald-700">4%</span>
                                    </label>

                                    <label class="p-3 rounded-xl border flex items-center justify-between cursor-pointer" :class="form.grease_trap_functioning ? 'bg-emerald-50 border-emerald-300 text-emerald-900' : 'bg-white border-slate-200 text-slate-600'">
                                        <span class="flex items-center gap-2">
                                            <input type="checkbox" v-model="form.grease_trap_functioning" class="rounded text-emerald-600" />
                                            <span class="font-bold">Saluran Grease Trap Penangkap Lemak</span>
                                        </span>
                                        <span class="font-mono font-bold text-emerald-700">2%</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- 10. Label Kemasan Ompreng (3%) -->
                        <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/80 space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">10</span>
                                    <h4 class="text-sm font-bold text-slate-900">Label Kemasan Ompreng Makanan (Bobot 3%)</h4>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="openGuide(10)" class="text-xs font-bold text-emerald-700 hover:text-emerald-900">Panduan</button>
                                    <span class="text-xs font-mono font-bold text-emerald-800">{{ scores.s10 }}%</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                <label class="p-3 rounded-xl border flex items-center justify-between cursor-pointer" :class="form.label_has_time_limit ? 'bg-emerald-50 border-emerald-300 text-emerald-900' : 'bg-white border-slate-200 text-slate-600'">
                                    <span class="flex items-center gap-2">
                                        <input type="checkbox" v-model="form.label_has_time_limit" class="rounded text-emerald-600" />
                                        <span>Info "Konsumsi sebelum jam..." / Batas Waktu</span>
                                    </span>
                                    <span class="font-mono font-bold text-emerald-700">1.5%</span>
                                </label>
                                <label class="p-3 rounded-xl border flex items-center justify-between cursor-pointer" :class="form.label_has_no_takeaway ? 'bg-emerald-50 border-emerald-300 text-emerald-900' : 'bg-white border-slate-200 text-slate-600'">
                                    <span class="flex items-center gap-2">
                                        <input type="checkbox" v-model="form.label_has_no_takeaway" class="rounded text-emerald-600" />
                                        <span>Info "Tidak boleh dibawa pulang"</span>
                                    </span>
                                    <span class="font-mono font-bold text-emerald-700">1.5%</span>
                                </label>
                            </div>
                        </div>

                        <!-- 12. Gudang Kering & Basah (8%) -->
                        <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/80 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">12</span>
                                    <h4 class="text-sm font-bold text-slate-900">Gudang Kering & Basah (Rak & Palet - Bobot 8%)</h4>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="openGuide(12)" class="text-xs font-bold text-emerald-700 hover:text-emerald-900 flex items-center gap-1 bg-white px-2.5 py-1 rounded-lg border border-slate-200">
                                        <BookOpen class="w-3.5 h-3.5" /> Panduan BGN
                                    </button>
                                    <span class="text-xs font-mono font-bold text-emerald-800">{{ scores.s12 }}%</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                <!-- Gudang Kering -->
                                <div class="p-3.5 rounded-xl bg-white border border-slate-200 space-y-2">
                                    <span class="font-bold text-slate-900 block">Gudang Kering</span>
                                    <div>
                                        <label class="text-[10px] text-slate-500 block mb-0.5">Bahan Rak:</label>
                                        <select v-model="form.rack_dry_material" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 text-xs bg-white">
                                            <option value="stainless">Stainless Steel (2%)</option>
                                            <option value="besi_plastik">Besi / Plastik / Baja Ringan (1.75%)</option>
                                            <option value="kayu">Kayu (0%)</option>
                                            <option value="tidak_ada">Tidak Ada (0%)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-[10px] text-slate-500 block mb-0.5">Bahan Palet (Palet kayu dilarang):</label>
                                        <select v-model="form.pallet_dry_material" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 text-xs bg-white">
                                            <option value="stainless">Stainless Steel (2%)</option>
                                            <option value="besi_plastik">Besi / Plastik / Baja Ringan (1.75%)</option>
                                            <option value="kayu">Kayu [DILARANG KERAS] (0%)</option>
                                            <option value="tidak_ada">Tidak Ada (0%)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Gudang Basah -->
                                <div class="p-3.5 rounded-xl bg-white border border-slate-200 space-y-2">
                                    <span class="font-bold text-slate-900 block">Gudang Basah</span>
                                    <div>
                                        <label class="text-[10px] text-slate-500 block mb-0.5">Bahan Rak:</label>
                                        <select v-model="form.rack_wet_material" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 text-xs bg-white">
                                            <option value="stainless">Stainless Steel (2%)</option>
                                            <option value="besi_plastik">Besi / Plastik / Baja Ringan (1.75%)</option>
                                            <option value="kayu">Kayu (0%)</option>
                                            <option value="tidak_ada">Tidak Ada (0%)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-[10px] text-slate-500 block mb-0.5">Bahan Palet (Palet kayu dilarang):</label>
                                        <select v-model="form.pallet_wet_material" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 text-xs bg-white">
                                            <option value="stainless">Stainless Steel (2%)</option>
                                            <option value="besi_plastik">Besi / Plastik / Baja Ringan (1.75%)</option>
                                            <option value="kayu">Kayu [DILARANG KERAS] (0%)</option>
                                            <option value="tidak_ada">Tidak Ada (0%)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 13. Video Alur Produksi (8%) -->
                        <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/80 space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">13</span>
                                    <h4 class="text-sm font-bold text-slate-900">Video Alur Proses Produksi (Bobot 8%)</h4>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="openGuide(13)" class="text-xs font-bold text-emerald-700 hover:text-emerald-900">Panduan</button>
                                    <span class="text-xs font-mono font-bold text-emerald-800">{{ scores.s13 }}%</span>
                                </div>
                            </div>
                            <div class="space-y-2 text-xs">
                                <div class="space-y-1.5">
                                    <label class="flex items-center justify-between p-2.5 rounded-xl bg-white border border-slate-200 cursor-pointer">
                                        <span class="flex items-center gap-2">
                                            <input type="radio" value="sesuai_tanpa_catatan" v-model="form.production_flow_status" class="text-emerald-600" />
                                            <span>Sesuai ketentuan alur proses produksi tanpa catatan (ADA sekat partisi penuh)</span>
                                        </span>
                                        <span class="font-mono font-bold text-emerald-700">8%</span>
                                    </label>
                                    <label class="flex items-center justify-between p-2.5 rounded-xl bg-white border border-slate-200 cursor-pointer">
                                        <span class="flex items-center gap-2">
                                            <input type="radio" value="sesuai_dengan_catatan" v-model="form.production_flow_status" class="text-emerald-600" />
                                            <span>Sesuai ketentuan alur DENGAN catatan (tidak ada sekat partisi penuh)</span>
                                        </span>
                                        <span class="font-mono font-bold text-amber-600">6%</span>
                                    </label>
                                    <label class="flex items-center justify-between p-2.5 rounded-xl bg-white border border-slate-200 cursor-pointer">
                                        <span class="flex items-center gap-2">
                                            <input type="radio" value="tidak_sesuai" v-model="form.production_flow_status" class="text-emerald-600" />
                                            <span>Tidak sesuai ketentuan alur proses produksi DENGAN catatan</span>
                                        </span>
                                        <span class="font-mono font-bold text-rose-600">4%</span>
                                    </label>
                                </div>
                                <input
                                    v-model="form.production_flow_video_url"
                                    type="url"
                                    placeholder="Tautan Video Alur (Google Drive / Cloud Storage)"
                                    class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs"
                                />
                            </div>
                        </div>

                        <!-- 14. CCTV Pengawasan Dapur & Internet (3%) -->
                        <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/80 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">14</span>
                                    <h4 class="text-sm font-bold text-slate-900">CCTV 10 Titik Kritis & Bandwidth Internet (Bobot 3%)</h4>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="openGuide(14)" class="text-xs font-bold text-emerald-700 hover:text-emerald-900 flex items-center gap-1 bg-white px-2.5 py-1 rounded-lg border border-slate-200">
                                        <BookOpen class="w-3.5 h-3.5" /> Panduan BGN
                                    </button>
                                    <span class="text-xs font-mono font-bold text-emerald-800">{{ scores.s14 }}%</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                <div class="p-3.5 rounded-xl bg-white border border-slate-200 space-y-2">
                                    <span class="font-bold text-slate-900 block">CCTV Pengawasan Dapur (1.5%)</span>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" v-model="form.cctv_all_critical_points" class="rounded text-emerald-600" />
                                        <span>Terpasang di SELURUH 10 titik kritis operasional</span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-2 pt-1">
                                        <input v-model.number="form.cctv_unit_count" type="number" placeholder="Jumlah Kamera" class="px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs" />
                                        <input v-model="form.cctv_type" type="text" placeholder="Tipe (IP Cam / DVR)" class="px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs" />
                                    </div>
                                </div>

                                <div class="p-3.5 rounded-xl bg-white border border-slate-200 space-y-2">
                                    <span class="font-bold text-slate-900 block">Bandwidth Internet (Speed Test) (1.5%)</span>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" v-model="form.internet_speed_test_available" class="rounded text-emerald-600" />
                                        <span>Hasil Speed Test Ada & Tercatat</span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-2 pt-1">
                                        <input v-model.number="form.internet_download_mbps" type="number" step="0.1" placeholder="Download (Mbps)" class="px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs font-mono" />
                                        <input v-model.number="form.internet_upload_mbps" type="number" step="0.1" placeholder="Upload (Mbps)" class="px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs font-mono" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. PILAR 3: LAHAN & KESELAMATAN KERJA (Bobot 12%) -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-amber-200/80 shadow-xs space-y-6">
                        <div class="flex items-center justify-between border-b border-amber-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-800 flex items-center justify-center font-bold">
                                    <ShieldCheck class="w-5 h-5" />
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md bg-amber-100 text-amber-900">
                                            Pilar 3
                                        </span>
                                        <span class="text-xs font-bold text-amber-700">Bobot 12%</span>
                                    </div>
                                    <h3 class="text-base sm:text-lg font-black text-slate-900">
                                        Lahan, Bangunan & Keselamatan Kerja
                                    </h3>
                                </div>
                            </div>
                            <span class="text-xs font-mono font-bold px-3 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200">
                                Skor: {{ scores.pilarKeselamatan }}% / 12%
                            </span>
                        </div>

                        <!-- 09. APAR (5%) -->
                        <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/80 space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-amber-100 text-amber-800">09</span>
                                    <h4 class="text-sm font-bold text-slate-900">APAR (Alat Pemadam Api Ringan - Bobot 5%)</h4>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="openGuide(9)" class="text-xs font-bold text-amber-700 hover:text-amber-900">Panduan</button>
                                    <span class="text-xs font-mono font-bold text-amber-800">{{ scores.s09 }}%</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                <div class="space-y-1.5">
                                    <label class="flex items-center gap-2 p-2.5 rounded-xl bg-white border border-slate-200 cursor-pointer">
                                        <input type="checkbox" v-model="form.apar_available" class="rounded text-amber-600" />
                                        <span class="font-bold">APAR Powder 3kg Tersedia di Area Masak</span>
                                    </label>
                                    <label class="flex items-center gap-2 p-2.5 rounded-xl bg-white border border-slate-200 cursor-pointer">
                                        <input type="checkbox" v-model="form.apar_is_valid" class="rounded text-amber-600" />
                                        <span>Label Tanggal Kedaluwarsa Ada & Masih Berlaku</span>
                                    </label>
                                </div>
                                <div class="p-3 rounded-xl bg-white border border-slate-200 space-y-1">
                                    <label class="text-[11px] text-slate-500 block">Tanggal Kedaluwarsa APAR:</label>
                                    <input v-model="form.apar_expiry_date" type="date" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-200 text-xs" />
                                </div>
                            </div>
                        </div>

                        <!-- 11. Jenis & Luasan SPPG (7%) -->
                        <div class="p-5 rounded-2xl bg-slate-50/80 border border-slate-200/80 space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-mono font-bold px-2 py-0.5 rounded bg-amber-100 text-amber-800">11</span>
                                    <h4 class="text-sm font-bold text-slate-900">Jenis & Luasan SPPG (Bobot 7%)</h4>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="openGuide(11)" class="text-xs font-bold text-amber-700 hover:text-amber-900 flex items-center gap-1 bg-white px-2.5 py-1 rounded-lg border border-slate-200">
                                        <BookOpen class="w-3.5 h-3.5" /> Panduan BGN
                                    </button>
                                    <span class="text-xs font-mono font-bold text-amber-800">{{ scores.s11 }}%</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                                <div>
                                    <label class="font-bold text-slate-700 block mb-1">Luas Tanah (m²)</label>
                                    <input v-model.number="form.land_area_sqm" type="number" min="0" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-mono" />
                                </div>
                                <div>
                                    <label class="font-bold text-slate-700 block mb-1">Luas Bangunan Produksi (m²)</label>
                                    <input v-model.number="form.building_area_sqm" type="number" min="0" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-mono font-bold" />
                                </div>
                                <div>
                                    <label class="font-bold text-slate-700 block mb-1">Kesesuaian Standar PM</label>
                                    <select v-model="form.area_compliance" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white font-bold" :class="form.area_compliance === 'sesuai' ? 'text-emerald-700' : 'text-amber-700'">
                                        <option value="sesuai">Sesuai Standar PM (7%)</option>
                                        <option value="di_bawah_standar">Di Bawah Standar (3%)</option>
                                        <option value="tidak_dapat_dinilai">Tidak Dapat Dinilai (0%)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 5. REKOMENDASI KELAYAKAN & PENGESAHAN -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-xs space-y-6">
                        <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                            <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-800 flex items-center justify-center font-bold">
                                <PenTool class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="text-base sm:text-lg font-black text-slate-900">
                                    Rekomendasi Kelayakan Operasional & Pengesahan
                                </h3>
                                <p class="text-xs text-slate-500">
                                    Penetapan rekomendasi akhir oleh Satuan Tugas MBG Kabupaten/Kota
                                </p>
                            </div>
                        </div>

                        <!-- Badge Hasil Otomatis -->
                        <div class="p-4 rounded-2xl border flex flex-col sm:flex-row sm:items-center justify-between gap-4" :class="scores.gradeBadge">
                            <div class="space-y-1">
                                <span class="text-[11px] font-bold uppercase tracking-wider block">Status Kelayakan Rekomendasi:</span>
                                <h4 class="text-lg sm:text-xl font-black">
                                    {{ scores.recommendationLabel }} ({{ scores.grade }})
                                </h4>
                            </div>
                            <div class="text-right font-mono font-black text-2xl sm:text-3xl">
                                {{ scores.total }}%
                            </div>
                        </div>

                        <!-- Alasan Singkat -->
                        <div class="space-y-1 text-xs">
                            <label class="block font-bold text-slate-800">
                                Alasan Singkat Rekomendasi (Maksimal 2 baris):
                            </label>
                            <textarea
                                v-model="form.recommendation_reason"
                                rows="2"
                                maxlength="250"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:border-teal-600 focus:ring-1 focus:ring-teal-600 text-xs"
                                placeholder="Contoh: Seluruh indikator rantai dingin dan keamanan pangan terpenuhi, sarana IPAL berfungsi dengan baik dan dokumen perizinan lengkap."
                            />
                        </div>

                        <!-- Tanda Tangan Canvas -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2 text-xs">
                            <div>
                                <label class="block font-bold text-slate-800 mb-1">Nama Ketua Satgas MBG Kab/Kota</label>
                                <input
                                    v-model="form.satgas_leader_name"
                                    type="text"
                                    class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-xs"
                                    placeholder="Drs. Akhmad Pratama, M.Si."
                                />
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label class="font-bold text-slate-800">Tanda Tangan Digital Petugas</label>
                                    <button
                                        type="button"
                                        class="text-[11px] text-rose-600 hover:text-rose-800 font-bold flex items-center gap-1 cursor-pointer"
                                        @click="clearSignature"
                                    >
                                        <RotateCcw class="w-3 h-3" /> Hapus Goresan
                                    </button>
                                </div>
                                <div class="border-2 border-dashed border-slate-300 rounded-2xl bg-slate-50 overflow-hidden relative touch-none">
                                    <canvas
                                        ref="signatureCanvas"
                                        width="400"
                                        height="140"
                                        class="w-full h-28 cursor-crosshair"
                                        @mousedown="startDrawing"
                                        @mousemove="draw"
                                        @mouseup="stopDrawing"
                                        @mouseleave="stopDrawing"
                                        @touchstart="startDrawing"
                                        @touchmove="draw"
                                        @touchend="stopDrawing"
                                    />
                                    <div v-if="!form.satgas_leader_signature" class="absolute inset-0 pointer-events-none flex items-center justify-center text-slate-400 text-[11px]">
                                        Tanda tangan di sini menggunakan mouse atau layar sentuh
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                            <Link
                                href="/audit-sppg"
                                class="px-5 py-3 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold transition-all"
                            >
                                Batal
                            </Link>
                            <button
                                type="button"
                                :disabled="isSubmitting"
                                class="px-6 py-3 rounded-xl bg-teal-800 hover:bg-teal-900 text-white text-xs font-bold transition-all shadow-md hover:shadow-lg flex items-center gap-2 cursor-pointer disabled:opacity-50"
                                @click="submitAudit"
                            >
                                <Save class="w-4 h-4" />
                                <span>{{ isSubmitting ? 'Menyimpan Audit...' : 'Kirim & Simpan Hasil Audit' }}</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Real-Time Scorecard & Navigasi Panduan (4 cols) -->
                <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">
                    
                    <!-- Floating Live Score Card -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-md space-y-5">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-500">
                                Akumulasi Skor Real-Time
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-teal-50 text-teal-800 border border-teal-200">
                                <Activity class="w-3 h-3 text-teal-600 animate-pulse" />
                                Live Calc
                            </span>
                        </div>

                        <!-- Total Score Display -->
                        <div class="text-center py-2 space-y-2">
                            <div class="text-5xl font-black text-slate-900 tracking-tight font-mono">
                                {{ scores.total }}<span class="text-2xl text-slate-400 font-sans">%</span>
                            </div>
                            <div>
                                <span class="px-3.5 py-1.5 rounded-full text-xs font-black inline-block border" :class="scores.gradeBadge">
                                    {{ scores.grade }} • {{ scores.recommendationLabel }}
                                </span>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="space-y-1">
                            <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div
                                    class="h-full transition-all duration-300 rounded-full"
                                    :class="scores.total >= 85 ? 'bg-teal-600' : (scores.total >= 70 ? 'bg-amber-500' : 'bg-rose-500')"
                                    :style="{ width: `${scores.total}%` }"
                                />
                            </div>
                            <div class="flex justify-between text-[10px] text-slate-400 font-mono">
                                <span>0% (D)</span>
                                <span>70% (B)</span>
                                <span>85% (A)</span>
                                <span>100%</span>
                            </div>
                        </div>

                        <!-- Breakdown 3 Pilar -->
                        <div class="space-y-2.5 pt-2 border-t border-slate-100 text-xs">
                            <div class="flex items-center justify-between p-2.5 rounded-xl bg-blue-50/70 border border-blue-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-blue-600" />
                                    <span class="font-bold text-slate-800">Legalitas & SDM</span>
                                </div>
                                <span class="font-mono font-bold text-blue-900">{{ scores.pilarLegalitas }}% / 23%</span>
                            </div>

                            <div class="flex items-center justify-between p-2.5 rounded-xl bg-emerald-50/70 border border-emerald-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-600" />
                                    <span class="font-bold text-slate-800">Keamanan Pangan</span>
                                </div>
                                <span class="font-mono font-bold text-emerald-900">{{ scores.pilarPangan }}% / 65%</span>
                            </div>

                            <div class="flex items-center justify-between p-2.5 rounded-xl bg-amber-50/70 border border-amber-100">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-amber-600" />
                                    <span class="font-bold text-slate-800">Lahan & Keselamatan</span>
                                </div>
                                <span class="font-mono font-bold text-amber-900">{{ scores.pilarKeselamatan }}% / 12%</span>
                            </div>
                        </div>

                        <!-- Quick Submit from Sidebar on Mobile/Desktop -->
                        <button
                            type="button"
                            :disabled="isSubmitting"
                            class="w-full py-3 rounded-xl bg-teal-800 hover:bg-teal-900 text-white text-xs font-bold transition-all shadow-sm hover:shadow flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50"
                            @click="submitAudit"
                        >
                            <Save class="w-4 h-4" />
                            <span>{{ isSubmitting ? 'Menyimpan...' : 'Kirim Audit SPPG' }}</span>
                        </button>
                    </div>

                    <!-- Quick Guide Card -->
                    <div class="bg-gradient-to-br from-slate-900 to-teal-950 text-white rounded-3xl p-6 shadow-md space-y-4">
                        <div class="flex items-center gap-2 text-teal-300 text-xs font-bold">
                            <BookOpen class="w-4 h-4" />
                            <span>Panduan Resmi Satgas BGN</span>
                        </div>
                        <h4 class="text-sm font-black text-white">
                            Pedoman Penilaian 14 Indikator
                        </h4>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Setiap indikator memiliki bobot dan kriteria dokumentasi wajib. Klik tombol "Panduan" pada masing-masing indikator untuk membuka rincian resmi.
                        </p>
                        <div class="space-y-1.5 pt-1 text-xs">
                            <button
                                v-for="(guide, id) in SPPG_GUIDELINES"
                                :key="id"
                                type="button"
                                class="w-full text-left px-3 py-2 rounded-xl bg-white/5 hover:bg-white/10 transition-colors flex items-center justify-between group cursor-pointer"
                                @click="openGuide(Number(id))"
                            >
                                <span class="text-slate-300 group-hover:text-white font-medium truncate">
                                    {{ guide.code }}. {{ guide.title }}
                                </span>
                                <span class="text-[10px] font-mono text-teal-300 font-bold ml-2 shrink-0">
                                    {{ guide.weight }}
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sppg Guide Modal -->
        <SppgGuideModal
            :is-open="isGuideModalOpen"
            :indicator-id="activeGuideId"
            @close="isGuideModalOpen = false"
        />
    </PublicLayout>
</template>
