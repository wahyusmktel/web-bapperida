<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    FileCheck,
    ShieldCheck,
    CheckCircle2,
    ChevronRight,
    ChevronUp,
    ChevronDown,
    Building2,
    Layers,
    Sparkles,
    Target,
    Scale,
    Compass,
    TrendingUp,
    Sprout,
    Cpu,
    ArrowDown,
    ArrowUp
} from 'lucide-vue-next';

// Slide Index untuk Vertical Slider
const currentSlide = ref(0);

const slides = [
    {
        id: 'tugas',
        tag: 'MANDAT UTAMA',
        title: 'TUGAS BAPPERIDA',
        subtitle: 'Bupati & Pemerintah Kabupaten Pringsewu',
        description: 'BAPPERIDA Pringsewu mempunyai tugas membantu Bupati dalam penyusunan kebijakan dan pengkoordinasian terhadap pelaksanaan tugas di bidang perencanaan pembangunan, riset dan inovasi daerah.',
        theme: 'from-amber-500 to-amber-600',
        badge: 'Tugas Pokok',
        icon: Target
    },
    {
        id: 'fungsi',
        tag: 'EMPAT PILAR FUNGSI',
        title: '4 FUNGSI UTAMA',
        subtitle: 'Penyelenggaraan Urusan Penunjang Pemerintahan',
        description: 'Dalam menjalankan tugas pokok kedinasan, BAPPERIDA Kabupaten Pringsewu menyelenggarakan 4 fungsi strategis pemerintahan daerah.',
        theme: 'from-teal-600 to-teal-700',
        badge: 'Fungsi Badan',
        icon: ShieldCheck
    },
    {
        id: 'sekretariat',
        tag: 'KOORDINASI ADMINISTRASI',
        title: 'TUPOKSI SEKRETARIAT',
        subtitle: 'Pembinaan Administrasi, Umum & Keuangan',
        description: 'Pengoordinasian pelaksanaan tugas operasional, pembinaan administrasi kepegawaian, tata usaha, perlengkapan, serta pengelolaan perencanaan dan keuangan dinas.',
        theme: 'from-emerald-600 to-emerald-700',
        badge: 'Sekretariat',
        icon: Building2
    },
    {
        id: 'bidang-teknis',
        tag: '5 BIDANG OPERASIONAL',
        title: 'TUPOKSI 5 BIDANG',
        subtitle: 'PPE, IPW, PPM, PSDA & RIDA',
        description: 'Pelaksanaan perumusan kebijakan makro, tata ruang infrastruktur, pembangunan manusia, kemandirian pangan agribisnis, serta ekosistem riset inovasi daerah.',
        theme: 'from-indigo-600 to-indigo-700',
        badge: 'Bidang Teknis',
        icon: Layers
    }
];

const totalSlides = slides.length;

const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % totalSlides;
};

const prevSlide = () => {
    currentSlide.value = (currentSlide.value - 1 + totalSlides) % totalSlides;
};

const goToSlide = (idx: number) => {
    currentSlide.value = idx;
};

// 4 Fungsi Utama Persis Berdasarkan Dokumen Resmi
const officialFunctions = [
    {
        number: '01',
        text: 'Penyelenggaraan perumusan kebijakan teknis fungsi penunjang urusan pemerintah bidang perencanaan pembangunan, riset dan inovasi daerah'
    },
    {
        number: '02',
        text: 'Pembinaan dan pelaksanaan tugas pada BAPPERIDA'
    },
    {
        number: '03',
        text: 'Pelaksanaan tugas lain yang diberikan oleh Bupati pada BAPPERIDA'
    },
    {
        number: '04',
        text: 'Pelaksanaan fungsi lain sesuai tugas pokok dan fungsi yang diberikan oleh Bupati'
    }
];

// Rincian Tupoksi Unit Kerja
const unitDuties = [
    {
        code: 'SEKRETARIAT',
        unit: 'Sekretariat Badan',
        head: 'Membantu Kepala Badan dalam pengoordinasian penyusunan rencana program, pembinaan administrasi, umum, dan keuangan.',
        duties: [
            'Pengoordinasian penyusunan program kerja tahunan dan laporan akuntabilitas kinerja (SAKIP).',
            'Pengelolaan urusan kepegawaian, surat-menyurat, kehumasan, dan perlengkapan rumah tangga dinas.',
            'Pengelolaan administrasi keuangan, verifikasi perbendaharaan, dan akuntansi belanja daerah.',
            'Pengoordinasian tugas Jabatan Fungsional Perencana dan Analis Keuangan Pusat & Daerah.'
        ]
    },
    {
        code: 'PPE',
        unit: 'Bidang Perencanaan, Pengendalian dan Evaluasi (PPE)',
        head: 'Melaksanakan perumusan kebijakan perencanaan makro, penyelarasan program, serta evaluasi pembangunan daerah.',
        duties: [
            'Penyusunan dokumen RPJPD, RPJMD, dan RKPD Kabupaten Pringsewu.',
            'Pengendalian konsistensi perencanaan dan penganggaran lintas sektor.',
            'Evaluasi berkala capaian indikator kinerja pembangunan daerah.',
            'Pengelolaan satu data perencanaan dan sistem informasi pembangunan daerah.'
        ]
    },
    {
        code: 'IPW',
        unit: 'Bidang Infrastruktur dan Pengembangan Wilayah (IPW)',
        head: 'Melaksanakan perencanaan bidang infrastruktur konektivitas, tata ruang wilayah, dan kawasan permukiman.',
        duties: [
            'Penyelarasan Rencana Tata Ruang Wilayah (RTRW) dan RDTR kabupaten.',
            'Perencanaan pembangunan jaringan jalan jembatan dan konektivitas antardaerah.',
            'Penyusunan program penyediaan air minum, sanitasi, dan perumahan rakyat.',
            'Pengoordinasian mitigasi tata kelola kawasan rawan bencana.'
        ]
    },
    {
        code: 'PPM',
        unit: 'Bidang Pemerintahan dan Pembangunan Manusia (PPM)',
        head: 'Melaksanakan pengoordinasian perencanaan bidang pendidikan, kesehatan prima, dan kesejahteraan masyarakat.',
        duties: [
            'Penyelarasan program pendidikan tuntas dan peningkatan derajat kesehatan masyarakat.',
            'Pengoordinasian terpadu percepatan penurunan stunting dan penanggulangan kemiskinan.',
            'Sinkronisasi perencanaan urusan pemerintahan pekon/desa dan ketertiban umum.',
            'Monitoring dan evaluasi program perlindungan perempuan dan anak.'
        ]
    },
    {
        code: 'PSDA',
        unit: 'Bidang Perekonomian dan Sumber Daya Alam (PSDA)',
        head: 'Melaksanakan perencanaan pembangunan sektor agribisnis, industri UMKM, dan ketahanan pangan.',
        duties: [
            'Penyusunan strategi penguatan rantai pasok komoditas pertanian dan perkebunan.',
            'Fasilitasi pengembangan iklim investasi, perdagangan, dan UMKM naik kelas.',
            'Perencanaan pengelolaan sumber daya alam dan ketahanan pangan berkelanjutan.',
            'Penguatan koordinasi pembiayaan pembangunan daerah non-APBD.'
        ]
    },
    {
        code: 'RIDA',
        unit: 'Bidang Riset dan Inovasi Daerah (RIDA)',
        head: 'Melaksanakan penyelenggaraan riset terapan, fasilitasi inovasi daerah, dan kemitraan iptek.',
        duties: [
            'Penyelenggaraan riset ilmiah kebijakan berbasis bukti (evidence-based policy).',
            'Pengelolaan penjaringan inovasi daerah (Indeks Inovasi Daerah / IID).',
            'Fasilitasi perlindungan kekayaan intelektual (HAKI) bagi para inovator daerah.',
            'Penyebarluasan dan pemanfaatan teknologi tepat guna bagi masyarakat.'
        ]
    }
];

// Handle keyboard navigation for vertical slider
const handleKeyDown = (e: KeyboardEvent) => {
    if (e.key === 'ArrowDown') {
        nextSlide();
    } else if (e.key === 'ArrowUp') {
        prevSlide();
    }
};

onMounted(() => {
    window.addEventListener('keydown', handleKeyDown);
});

onUnmounted(() => {
    window.removeEventListener('keydown', handleKeyDown);
});
</script>

<template>
    <Head title="Tugas Pokok & Fungsi (TUPOKSI) - BAPPERIDA Kabupaten Pringsewu" />

    <PublicLayout>
        <!-- Breadcrumb Bar -->
        <div class="bg-slate-100/80 border-b border-slate-200/80 py-2.5 px-4 sm:px-8">
            <div class="max-w-7xl mx-auto flex items-center gap-2 text-xs text-slate-600">
                <Link href="/" class="hover:text-teal-800 transition-colors">Beranda</Link>
                <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                <span class="text-slate-400">Profil</span>
                <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                <span class="font-semibold text-teal-800">Tugas Pokok & Fungsi</span>
            </div>
        </div>

        <!-- Header Banner -->
        <section class="relative bg-gradient-to-r from-teal-950 via-teal-900 to-slate-900 text-white py-14 sm:py-20 px-4 sm:px-8 overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#00C096_1px,transparent_1px)] [background-size:20px_20px] pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative max-w-7xl mx-auto space-y-4">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-500/20 border border-teal-400/30 text-xs font-semibold text-teal-200">
                    <FileCheck class="w-3.5 h-3.5" />
                    <span>Mandat Resmi Kedinasan</span>
                </div>
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white max-w-4xl leading-tight">
                    Tugas Pokok & Fungsi (TUPOKSI)
                </h1>
                <p class="text-sm sm:text-base text-teal-100/90 max-w-3xl leading-relaxed">
                    Pedoman kewenangan kedinasan BAPPERIDA Kabupaten Pringsewu dalam penyusunan kebijakan, koordinasi pelaksanaan, riset terpadu, dan inovasi daerah.
                </p>
            </div>
        </section>

        <!-- Main Content -->
        <main class="py-12 sm:py-16 bg-slate-50/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-16">

                <!-- SECTION: INTERACTIVE VERTICAL SLIDER SHOWCASE -->
                <div class="space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                        <div class="space-y-1">
                            <span class="text-xs font-bold text-teal-700 uppercase tracking-widest block">Eksplorasi Interaktif</span>
                            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                                Ringkasan Tugas & Fungsi BAPPERIDA
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-600">
                                Gunakan tombol navigasi atas / bawah atau klik indikator untuk menelusuri pilar tupoksi.
                            </p>
                        </div>

                        <!-- Slider Counter & Controller Buttons -->
                        <div class="flex items-center gap-3">
                            <div class="text-xs font-mono font-bold text-slate-600 bg-white px-3 py-1.5 rounded-xl border border-slate-200 shadow-2xs">
                                <span class="text-teal-700 text-sm">0{{ currentSlide + 1 }}</span>
                                <span class="text-slate-400 mx-1">/</span>
                                <span>0{{ totalSlides }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <button
                                    @click="prevSlide"
                                    class="w-10 h-10 rounded-xl bg-white hover:bg-teal-50 border border-slate-200 hover:border-teal-300 text-slate-700 hover:text-teal-800 flex items-center justify-center transition-all shadow-2xs cursor-pointer active:scale-95"
                                    title="Slide Sebelumnya (Atas)"
                                >
                                    <ChevronUp class="w-5 h-5" />
                                </button>
                                <button
                                    @click="nextSlide"
                                    class="w-10 h-10 rounded-xl bg-teal-800 hover:bg-teal-700 text-white flex items-center justify-center transition-all shadow-sm shadow-teal-800/20 cursor-pointer active:scale-95"
                                    title="Slide Berikutnya (Bawah)"
                                >
                                    <ChevronDown class="w-5 h-5" />
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Main Interactive Vertical Slider Box -->
                    <div class="relative rounded-3xl bg-white border border-slate-200/90 shadow-xl overflow-hidden min-h-[500px] flex flex-col lg:flex-row">
                        
                        <!-- Side Left: Visual Indicator & Landmark Banner -->
                        <div class="lg:w-5/12 bg-gradient-to-br from-slate-900 via-teal-950 to-slate-950 text-white p-8 sm:p-10 flex flex-col justify-between relative overflow-hidden">
                            <!-- Background Motif & Landmark Aesthetic -->
                            <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#00C096_1px,transparent_1px)] [background-size:16px_16px] pointer-events-none"></div>
                            
                            <!-- Header Info -->
                            <div class="relative z-10 space-y-3">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-teal-300 text-[11px] font-bold tracking-wider uppercase">
                                    <Sparkles class="w-3.5 h-3.5" />
                                    <span>{{ slides[currentSlide].tag }}</span>
                                </div>
                                <h3 class="text-2xl sm:text-3xl font-black text-white leading-tight">
                                    {{ slides[currentSlide].title }}
                                </h3>
                                <p class="text-xs sm:text-sm text-teal-100/80">
                                    {{ slides[currentSlide].subtitle }}
                                </p>
                            </div>

                            <!-- Vertical Slider Steps / Stepper -->
                            <div class="relative z-10 my-8 py-4 border-y border-white/10 space-y-3">
                                <div
                                    v-for="(s, idx) in slides"
                                    :key="s.id"
                                    @click="goToSlide(idx)"
                                    class="flex items-center gap-3 p-2.5 rounded-xl cursor-pointer transition-all duration-200 group"
                                    :class="currentSlide === idx ? 'bg-white/15 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5'"
                                >
                                    <div
                                        class="w-7 h-7 rounded-lg flex items-center justify-center font-mono text-xs font-bold transition-colors"
                                        :class="currentSlide === idx ? 'bg-amber-400 text-slate-950 font-black' : 'bg-white/10 text-slate-300 group-hover:bg-white/20'"
                                    >
                                        0{{ idx + 1 }}
                                    </div>
                                    <div class="text-xs font-bold leading-tight">
                                        {{ s.title }}
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Indicator Note -->
                            <div class="relative z-10 text-[11px] text-teal-200/70 flex items-center justify-between">
                                <span>Pemerintah Kab. Pringsewu</span>
                                <span class="font-mono">BAPPERIDA 2026</span>
                            </div>

                            <div class="absolute -bottom-16 -left-16 w-56 h-56 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>
                        </div>

                        <!-- Side Right: Dynamic Slide Content (Vertical Transitioning) -->
                        <div class="lg:w-7/12 p-8 sm:p-12 flex flex-col justify-center relative bg-slate-50/40">
                            
                            <!-- SLIDE 1: TUGAS POKOK BAPPERIDA -->
                            <div v-if="currentSlide === 0" class="space-y-6 animate-fadeIn">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold">
                                    <Target class="w-4 h-4 text-amber-700" />
                                    <span>Amanat Tugas Pokok</span>
                                </div>

                                <blockquote class="text-lg sm:text-2xl font-black text-slate-900 leading-snug">
                                    "BAPPERIDA Pringsewu mempunyai tugas membantu Bupati dalam penyusunan kebijakan dan pengkoordinasian terhadap pelaksanaan tugas di bidang perencanaan pembangunan, riset dan inovasi daerah."
                                </blockquote>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-4">
                                    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-2xs space-y-1">
                                        <div class="text-[10px] font-bold text-teal-700 uppercase">Pilar 01</div>
                                        <div class="text-xs font-black text-slate-900">Perencanaan Pembangunan</div>
                                        <p class="text-[11px] text-slate-500">Penyusunan haluan jangka panjang, menengah, dan tahunan.</p>
                                    </div>
                                    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-2xs space-y-1">
                                        <div class="text-[10px] font-bold text-teal-700 uppercase">Pilar 02</div>
                                        <div class="text-xs font-black text-slate-900">Riset Daerah</div>
                                        <p class="text-[11px] text-slate-500">Pengkajian ilmiah dan evidence-based policymaking.</p>
                                    </div>
                                    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-2xs space-y-1">
                                        <div class="text-[10px] font-bold text-teal-700 uppercase">Pilar 03</div>
                                        <div class="text-xs font-black text-slate-900">Inovasi Daerah</div>
                                        <p class="text-[11px] text-slate-500">Penguatan ekosistem daya cipta dan efisiensi publik.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- SLIDE 2: 4 FUNGSI UTAMA BAPPERIDA (PERSIS DOKUMEN GAMBAR) -->
                            <div v-if="currentSlide === 1" class="space-y-6 animate-fadeIn">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 border border-teal-200 text-teal-800 text-xs font-bold">
                                    <ShieldCheck class="w-4 h-4 text-teal-700" />
                                    <span>4 Butir Fungsi Resmi</span>
                                </div>

                                <h3 class="text-lg sm:text-xl font-black text-slate-900 leading-tight">
                                    Penyelenggaraan Fungsi BAPPERIDA
                                </h3>

                                <div class="space-y-3">
                                    <div
                                        v-for="fn in officialFunctions"
                                        :key="fn.number"
                                        class="p-4 rounded-2xl bg-white border border-slate-200/90 shadow-2xs flex items-start gap-4 hover:border-teal-400 transition-colors"
                                    >
                                        <span class="w-8 h-8 rounded-xl bg-amber-400 text-slate-950 font-black text-xs flex items-center justify-center shrink-0 mt-0.5 shadow-xs">
                                            {{ fn.number }}
                                        </span>
                                        <p class="text-xs sm:text-sm text-slate-700 font-medium leading-relaxed">
                                            {{ fn.text }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- SLIDE 3: TUPOKSI SEKRETARIAT -->
                            <div v-if="currentSlide === 2" class="space-y-6 animate-fadeIn">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold">
                                    <Building2 class="w-4 h-4 text-emerald-700" />
                                    <span>Sekretariat Badan</span>
                                </div>

                                <div class="space-y-2">
                                    <h3 class="text-lg sm:text-xl font-black text-slate-900 leading-tight">
                                        Pengoordinasian & Pelayanan Administrasi
                                    </h3>
                                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                        Sekretariat bertugas memberikan pelayanan administratif, pengoordinasian program kerja, dan pengelolaan sumber daya bagi seluruh unit kerja di lingkungan BAPPERIDA.
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                                    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-2xs space-y-1">
                                        <span class="text-[10px] font-bold text-emerald-700 uppercase">Subbag Umpeg</span>
                                        <div class="text-xs font-bold text-slate-900">Umum & Kepegawaian</div>
                                        <p class="text-[11px] text-slate-500">Tata usaha kedinasan, arsip, protokol, dan pembinaan ASN.</p>
                                    </div>
                                    <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-2xs space-y-1">
                                        <span class="text-[10px] font-bold text-emerald-700 uppercase">Fungsional</span>
                                        <div class="text-xs font-bold text-slate-900">Perencanaan & Keuangan</div>
                                        <p class="text-[11px] text-slate-500">Penyusunan anggaran DPA, pelaporan SAKIP, dan pertanggungjawaban APBD.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- SLIDE 4: TUPOKSI 5 BIDANG TEKNIS -->
                            <div v-if="currentSlide === 3" class="space-y-6 animate-fadeIn">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-800 text-xs font-bold">
                                    <Layers class="w-4 h-4 text-indigo-700" />
                                    <span>Unit Pelaksana Teknis</span>
                                </div>

                                <div class="space-y-2">
                                    <h3 class="text-lg sm:text-xl font-black text-slate-900 leading-tight">
                                        5 Bidang Teknis Pembangunan BAPPERIDA
                                    </h3>
                                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                        Meliputi Bidang PPE (Perencanaan & Evaluasi), IPW (Infrastruktur & Wilayah), PPM (Pemerintahan & SDM), PSDA (Ekonomi & SDA), serta RIDA (Riset & Inovasi).
                                    </p>
                                </div>

                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 pt-2 text-center">
                                    <div class="p-3 rounded-2xl bg-white border border-slate-200 shadow-2xs">
                                        <div class="text-xs font-black text-teal-800">BIDANG PPE</div>
                                        <div class="text-[10px] text-slate-500 mt-0.5">RPJMD / RKPD & Evaluasi</div>
                                    </div>
                                    <div class="p-3 rounded-2xl bg-white border border-slate-200 shadow-2xs">
                                        <div class="text-xs font-black text-teal-800">BIDANG IPW</div>
                                        <div class="text-[10px] text-slate-500 mt-0.5">Tata Ruang & Infrastruktur</div>
                                    </div>
                                    <div class="p-3 rounded-2xl bg-white border border-slate-200 shadow-2xs">
                                        <div class="text-xs font-black text-teal-800">BIDANG PPM</div>
                                        <div class="text-[10px] text-slate-500 mt-0.5">Kesehatan, Pendidikan & Sosial</div>
                                    </div>
                                    <div class="p-3 rounded-2xl bg-white border border-slate-200 shadow-2xs">
                                        <div class="text-xs font-black text-teal-800">BIDANG PSDA</div>
                                        <div class="text-[10px] text-slate-500 mt-0.5">Pertanian Agribisnis & UMKM</div>
                                    </div>
                                    <div class="p-3 rounded-2xl bg-white border border-slate-200 shadow-2xs col-span-2 sm:col-span-1">
                                        <div class="text-xs font-black text-teal-800">BIDANG RIDA</div>
                                        <div class="text-[10px] text-slate-500 mt-0.5">Riset Ilmiah & Inovasi IID</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- SECTION: RINCIAN LENGKAP TUGAS OPERASIONAL PER UNIT KERJA -->
                <div class="space-y-8 pt-8 border-t border-slate-200">
                    <div class="text-center max-w-2xl mx-auto space-y-2">
                        <span class="text-xs font-bold text-teal-700 uppercase tracking-widest">Penjabaran Lengkap</span>
                        <h3 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                            Rincian Tugas Sekretariat & 5 Bidang Kerja
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600">
                            Berdasarkan Peraturan Bupati Pringsewu Nomor 38 Tahun 2025 tentang Struktur Organisasi dan Tata Kerja.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div
                            v-for="u in unitDuties"
                            :key="u.code"
                            class="p-6 rounded-3xl bg-white border border-slate-200/90 shadow-xs hover:border-teal-400 hover:shadow-md transition-all flex flex-col justify-between space-y-4"
                        >
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-[11px] font-black px-2.5 py-1 rounded-lg bg-teal-50 text-teal-800 uppercase tracking-wider">
                                        {{ u.code }}
                                    </span>
                                    <div class="w-8 h-8 rounded-xl bg-slate-50 text-teal-700 flex items-center justify-center font-bold">
                                        <Layers class="w-4 h-4" />
                                    </div>
                                </div>
                                <h4 class="text-sm font-black text-slate-900 leading-snug">
                                    {{ u.unit }}
                                </h4>
                                <p class="text-xs text-slate-600 leading-relaxed italic">
                                    {{ u.head }}
                                </p>
                            </div>

                            <div class="pt-4 border-t border-slate-100 space-y-2">
                                <span class="text-[11px] font-bold text-teal-800 uppercase tracking-wider block">
                                    Uraian Fungsi Operasional:
                                </span>
                                <ul class="space-y-2 text-xs text-slate-600">
                                    <li v-for="d in u.duties" :key="d" class="flex items-start gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-teal-600 mt-1.5 shrink-0"></span>
                                        <span>{{ d }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </PublicLayout>
</template>

<style scoped>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(12px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-fadeIn {
    animation: fadeIn 0.35s ease-out forwards;
}
</style>
