<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    Network,
    Building2,
    ChevronRight,
    Users,
    Layers,
    FileCheck,
    GraduationCap,
    Lightbulb,
    Scale,
    Shield,
    Sparkles
} from 'lucide-vue-next';

interface OfficialItem {
    id?: string;
    name: string;
    nip: string;
    position: string;
    category_code?: string;
}

interface Props {
    officials?: OfficialItem[];
}

defineProps<Props>();

// Data Pejabat Resmi Sesuai Perbup No. 38 Tahun 2025
const kaban = {
    title: 'KABAN BAPPERIDA',
    name: 'Dr. IMAM FATKUROJI, S.STP., M.IP',
    nip: '19841110 200312 1 001',
    role: 'Kepala Badan Perencanaan Pembangunan Riset dan Inovasi Daerah'
};

const sekretaris = {
    title: 'SEKRETARIS',
    name: 'SITI RAHMAH, S.I.Kom., MM',
    nip: '19850609 201001 2 014',
    role: 'Sekretaris Badan'
};

const sekretariatUnits = [
    {
        title: 'KASUBBAG UMPEG',
        name: 'FITRI FAULA, S.I.Kom',
        nip: '19880429 201001 2 006',
        type: 'structural',
        typeLabel: 'Struktural'
    },
    {
        title: 'JF PERENCANA AHLI MUDA',
        name: 'EVY SURYANI SIMATUPANG, MM',
        nip: '19830331 201101 2 006',
        type: 'functional',
        typeLabel: 'Fungsional'
    },
    {
        title: 'JF ANALIS KEUANGAN PUSAT DAN DAERAH AHLI MUDA',
        name: 'FEBBY SABEL SUPRIYATNA, SE, MM',
        nip: '19860204 201001 2 021',
        type: 'functional',
        typeLabel: 'Fungsional'
    }
];

const bidangList = [
    {
        code: 'PPE',
        title: 'KABID PPE',
        fullTitle: 'Bidang Perencanaan, Pengendalian dan Evaluasi',
        name: 'RARA SUKMA, ST., M.P.W.K',
        nip: '19850724 201001 2 016',
        hasFunctional: true
    },
    {
        code: 'IPW',
        title: 'KABID IPW',
        fullTitle: 'Bidang Infrastruktur dan Pengembangan Wilayah',
        name: 'Ir. A. ADAM ALTHUSIUS, ST., MURP.',
        nip: '19800422 201001 1 009',
        hasFunctional: true
    },
    {
        code: 'PPM',
        title: 'KABID PPM',
        fullTitle: 'Bidang Pemerintahan dan Pembangunan Manusia',
        name: 'DEBIT ZULIANSYAH, ST',
        nip: '19801012 201001 1 023',
        hasFunctional: true
    },
    {
        code: 'PSDA',
        title: 'KABID PSDA',
        fullTitle: 'Bidang Perekonomian dan Sumber Daya Alam',
        name: 'Ir. ERWIN SONI, ST., MM',
        nip: '19801208 201001 1 011',
        hasFunctional: true
    },
    {
        code: 'RIDA',
        title: 'KABID RIDA',
        fullTitle: 'Bidang Riset dan Inovasi Daerah',
        name: 'FENNY APRILIA, S.Sos',
        nip: '19840405 201001 2 032',
        hasFunctional: true
    }
];
</script>

<template>
    <Head title="Struktur Organisasi - BAPPERIDA Kabupaten Pringsewu" />

    <PublicLayout>
        <!-- Breadcrumb Bar -->
        <div class="bg-slate-100/80 border-b border-slate-200/80 py-2.5 px-4 sm:px-8">
            <div class="max-w-7xl mx-auto flex items-center gap-2 text-xs text-slate-600">
                <Link href="/" class="hover:text-teal-800 transition-colors">Beranda</Link>
                <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                <span class="text-slate-400">Profil</span>
                <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                <span class="font-semibold text-teal-800">Struktur Organisasi</span>
            </div>
        </div>

        <!-- Header Banner -->
        <section class="relative bg-gradient-to-r from-teal-950 via-teal-900 to-slate-900 text-white py-14 sm:py-20 px-4 sm:px-8 overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#00C096_1px,transparent_1px)] [background-size:20px_20px] pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative max-w-7xl mx-auto space-y-4">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-500/20 border border-teal-400/30 text-xs font-semibold text-teal-200">
                    <Network class="w-3.5 h-3.5" />
                    <span>Tata Hubungan Kelembagaan SOTK Resmi</span>
                </div>
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white max-w-4xl leading-tight">
                    Struktur Organisasi BAPPERIDA
                </h1>
                <p class="text-sm sm:text-base text-teal-100/90 max-w-3xl leading-relaxed">
                    Badan Perencanaan Pembangunan Riset dan Inovasi Daerah Kabupaten Pringsewu berdasarkan Perbup No. 38 Tahun 2025.
                </p>
            </div>
        </section>

        <!-- Main Content -->
        <main class="py-12 sm:py-16 bg-slate-50/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-12">

                <!-- Institutional Header Card -->
                <div class="text-center max-w-3xl mx-auto space-y-2">
                    <span class="text-xs font-bold text-teal-700 uppercase tracking-widest block">
                        Bagan Susunan Organisasi & Tata Kerja (SOTK)
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        BADAN PERENCANAAN PEMBANGUNAN RISET DAN INOVASI DAERAH
                    </h2>
                    <p class="text-sm font-bold text-teal-800 uppercase tracking-wider">
                        KABUPATEN PRINGSEWU
                    </p>
                </div>

                <!-- Interactive Visual Tree Container -->
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xl p-6 sm:p-10 overflow-x-auto">
                    <div class="min-w-[900px] space-y-8 flex flex-col items-center">

                        <!-- LEVEL 1: KABAN BAPPERIDA (TOP) -->
                        <div class="relative flex flex-col items-center">
                            <!-- Card Kaban -->
                            <div class="w-80 rounded-2xl overflow-hidden border-2 border-emerald-500 shadow-lg shadow-emerald-900/10 bg-white transition-transform hover:-translate-y-0.5">
                                <div class="bg-emerald-600 text-white text-center py-2 px-3 font-black text-xs uppercase tracking-wider">
                                    {{ kaban.title }}
                                </div>
                                <div class="p-4 text-center space-y-1">
                                    <div class="text-sm font-black text-slate-900">
                                        {{ kaban.name }}
                                    </div>
                                    <div class="text-xs font-mono font-semibold text-emerald-700 bg-emerald-50 py-0.5 px-2 rounded-md inline-block">
                                        NIP. {{ kaban.nip }}
                                    </div>
                                </div>
                            </div>

                            <!-- Garis Vertikal Turun dari Kaban -->
                            <div class="w-0.5 h-10 bg-slate-800"></div>
                        </div>

                        <!-- LEVEL 2: PERCABANGAN KE SEKRETARIS (KANAN) & JALUR BIDANG (BAWAH) -->
                        <div class="w-full relative flex flex-col items-center">
                            <!-- Garis Pusat & Percabangan Horizontal ke Sekretaris -->
                            <div class="relative w-full flex justify-center">
                                <!-- Garis Vertikal Tengah dari Kaban terus ke bawah -->
                                <div class="w-0.5 h-44 bg-slate-800"></div>

                                <!-- Cabang Horizontal ke Sekretariat (Kanan) -->
                                <div class="absolute top-6 left-1/2 w-44 h-0.5 bg-slate-800"></div>

                                <!-- Box Sekretaris (Posisi Kanan) -->
                                <div class="absolute top-0 left-[calc(50%+11rem)] flex flex-col items-start">
                                    <div class="w-72 rounded-2xl overflow-hidden border-2 border-emerald-500 shadow-md bg-white">
                                        <div class="bg-emerald-600 text-white text-center py-1.5 px-3 font-black text-xs uppercase tracking-wider">
                                            {{ sekretaris.title }}
                                        </div>
                                        <div class="p-3.5 text-center space-y-1">
                                            <div class="text-xs font-black text-slate-900 leading-tight">
                                                {{ sekretaris.name }}
                                            </div>
                                            <div class="text-[11px] font-mono font-semibold text-emerald-700 bg-emerald-50 py-0.5 px-2 rounded-md inline-block">
                                                NIP. {{ sekretaris.nip }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Garis Turun dari Sekretaris ke Subbag & Fungsional -->
                                    <div class="w-0.5 h-6 bg-slate-800 ml-36"></div>
                                </div>
                            </div>

                            <!-- Subbag & JF di bawah Sekretaris -->
                            <div class="w-full flex justify-end pr-4 mt-2">
                                <div class="flex items-start gap-3">
                                    <!-- Kasubbag Umpeg (Garis Solid) -->
                                    <div class="w-56 rounded-2xl overflow-hidden border-2 border-emerald-500 shadow-xs bg-white">
                                        <div class="bg-emerald-600 text-white text-center py-1 px-2 font-black text-[10px] uppercase tracking-wider">
                                            {{ sekretariatUnits[0].title }}
                                        </div>
                                        <div class="p-3 text-center space-y-0.5">
                                            <div class="text-[11px] font-black text-slate-900 leading-tight">
                                                {{ sekretariatUnits[0].name }}
                                            </div>
                                            <div class="text-[10px] font-mono font-semibold text-emerald-700">
                                                NIP. {{ sekretariatUnits[0].nip }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- JF Perencana Ahli Muda (Garis Putus-putus) -->
                                    <div class="w-56 rounded-2xl overflow-hidden border-2 border-dashed border-emerald-500 shadow-xs bg-emerald-50/30">
                                        <div class="bg-emerald-600 text-white text-center py-1 px-2 font-black text-[10px] uppercase tracking-wider">
                                            {{ sekretariatUnits[1].title }}
                                        </div>
                                        <div class="p-3 text-center space-y-0.5">
                                            <div class="text-[11px] font-black text-slate-900 leading-tight">
                                                {{ sekretariatUnits[1].name }}
                                            </div>
                                            <div class="text-[10px] font-mono font-semibold text-emerald-700">
                                                NIP. {{ sekretariatUnits[1].nip }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- JF Analis Keuangan (Garis Putus-putus) -->
                                    <div class="w-60 rounded-2xl overflow-hidden border-2 border-dashed border-emerald-500 shadow-xs bg-emerald-50/30">
                                        <div class="bg-emerald-600 text-white text-center py-1 px-2 font-black text-[10px] uppercase tracking-wider">
                                            {{ sekretariatUnits[2].title }}
                                        </div>
                                        <div class="p-3 text-center space-y-0.5">
                                            <div class="text-[11px] font-black text-slate-900 leading-tight">
                                                {{ sekretariatUnits[2].name }}
                                            </div>
                                            <div class="text-[10px] font-mono font-semibold text-emerald-700">
                                                NIP. {{ sekretariatUnits[2].nip }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- LEVEL 3: GARIS HORIZONTAL KE 5 BIDANG TEKNIS -->
                        <div class="w-full relative pt-6">
                            <!-- Garis Horizontal Penghubung 5 Bidang -->
                            <div class="w-full h-0.5 bg-slate-800"></div>

                            <!-- 5 Cabang Bidang -->
                            <div class="grid grid-cols-5 gap-3 pt-4">
                                <div
                                    v-for="b in bidangList"
                                    :key="b.code"
                                    class="flex flex-col items-center space-y-4"
                                >
                                    <!-- Garis Vertikal dari Busbar ke Card Bidang -->
                                    <div class="w-0.5 h-4 bg-slate-800 -mt-4"></div>

                                    <!-- Card Kepala Bidang -->
                                    <div class="w-full rounded-2xl overflow-hidden border-2 border-emerald-500 shadow-md bg-white flex flex-col justify-between h-36">
                                        <div class="bg-emerald-600 text-white text-center py-1.5 px-2 font-black text-[11px] uppercase tracking-wider shrink-0">
                                            {{ b.title }}
                                        </div>
                                        <div class="p-3 text-center space-y-1 flex flex-col justify-center grow">
                                            <div class="text-xs font-black text-slate-900 leading-tight">
                                                {{ b.name }}
                                            </div>
                                            <div class="text-[10px] font-mono font-semibold text-emerald-700 bg-emerald-50/80 py-0.5 px-1.5 rounded-md inline-block">
                                                NIP. {{ b.nip }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Garis Penghubung Putus-putus ke Jabatan Fungsional -->
                                    <div class="w-0.5 h-6 border-l-2 border-dashed border-slate-700"></div>

                                    <!-- Card Jabatan Fungsional di bawah Bidang -->
                                    <div class="w-full rounded-2xl overflow-hidden border-2 border-dashed border-emerald-500 bg-emerald-50/40 p-2.5 text-center shadow-xs">
                                        <div class="bg-emerald-600 text-white rounded-lg py-1 px-2 text-[10px] font-bold uppercase tracking-wider">
                                            JABATAN FUNGSIONAL
                                        </div>
                                        <p class="text-[10px] text-slate-500 mt-1 leading-tight">
                                            Pejabat Fungsional / Tim Kerja Terkait
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Dasar Hukum / Legal Footnote Sesuai Dokumen Gambar -->
                <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-200/90 shadow-xs flex items-start gap-4">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 font-bold">
                        <Scale class="w-5 h-5" />
                    </div>
                    <div class="space-y-1">
                        <h4 class="text-xs font-black uppercase tracking-wider text-slate-900">Landasan Hukum Resmi</h4>
                        <p class="text-xs text-slate-700 leading-relaxed">
                            <strong>Dasar:</strong> Perbup No 38 Tahun 2025 Kabupaten Pringsewu mengatur tentang Perubahan atas Peraturan Bupati Nomor 40 Tahun 2021 mengenai Struktur Organisasi dan Tata Kerja (SOTK) serta Penyesuaian Jabatan PNS di lingkungan Pemkab Pringsewu.
                        </p>
                    </div>
                </div>

                <!-- Keterangan Garis Bagan -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-white border border-slate-200 flex items-center gap-3">
                        <div class="w-8 h-1 bg-slate-800 rounded-full shrink-0"></div>
                        <span class="text-xs text-slate-700 font-medium">
                            <strong>Garis Solid (Komando):</strong> Hubungan hierarki kewenangan komando kedinasan langsung antar-jenjang jabatan.
                        </span>
                    </div>
                    <div class="p-4 rounded-2xl bg-white border border-slate-200 flex items-center gap-3">
                        <div class="w-8 h-1 border-t-2 border-dashed border-slate-700 shrink-0"></div>
                        <span class="text-xs text-slate-700 font-medium">
                            <strong>Garis Putus-putus (Fungsional/Koordinasi):</strong> Hubungan penugasan fungsional keahlian dan koordinasi teknis.
                        </span>
                    </div>
                </div>

            </div>
        </main>
    </PublicLayout>
</template>
