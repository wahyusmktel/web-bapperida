<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    Target,
    Compass,
    CheckCircle2,
    ChevronRight,
    Sparkles,
    Shield,
    Users,
    TrendingUp,
    Briefcase,
    Sprout,
    Building2,
    HeartHandshake,
    Lightbulb,
    Lock,
    Sun,
    Award
} from 'lucide-vue-next';

// 6 Pilar Akronim "PRINGSEWU MAKMUR"
const visionPillars = [
    {
        number: '01',
        title: 'MANDIRI',
        desc: 'Mampu menggali, mengelola, dan memanfaatkan berbagai potensi sumber daya alam (SDA) dan sumber daya manusia (SDM) yang ada di wilayah Kabupaten Pringsewu secara berdikari dan berkesinambungan.',
        badgeColor: 'bg-emerald-50 text-emerald-800 border-emerald-200',
        accentColor: 'text-emerald-700',
        icon: Sprout
    },
    {
        number: '02',
        title: 'AMAN',
        desc: 'Terciptanya ketenangan, kenyamanan, dan kedamaian dalam segala aspek kehidupan masyarakat Pringsewu yang dilindungi oleh kepastian hukum dan rasa aman bermasyarakat.',
        badgeColor: 'bg-teal-50 text-teal-800 border-teal-200',
        accentColor: 'text-teal-700',
        icon: Lock
    },
    {
        number: '03',
        title: 'KONDUSIF',
        desc: 'Situasi atau kondisi kehidupan masyarakat yang senantiasa tertib, stabil, tenteram, dan harmonis dalam mendukung dinamika sosial, ekonomi, serta pembangunan daerah.',
        badgeColor: 'bg-sky-50 text-sky-800 border-sky-200',
        accentColor: 'text-sky-700',
        icon: HeartHandshake
    },
    {
        number: '04',
        title: 'MAJU',
        desc: 'Bergerak ke depan menuju perkembangan yang lebih baik pada aspek kualitas pembangunan sumber daya manusia, pertumbuhan ekonomi daerah, serta kelayakan prasarana dan sarana.',
        badgeColor: 'bg-indigo-50 text-indigo-800 border-indigo-200',
        accentColor: 'text-indigo-700',
        icon: TrendingUp
    },
    {
        number: '05',
        title: 'UNGGUL',
        desc: 'Memiliki kemampuan yang lebih baik, kompetitif, tinggi, tangguh, optimis, dan berdaya cipta kreatif dalam menghasilkan karya nyata dan prestasi daerah yang membanggakan.',
        badgeColor: 'bg-amber-50 text-amber-800 border-amber-200',
        accentColor: 'text-amber-700',
        icon: Award
    },
    {
        number: '06',
        title: 'RELIGIUS',
        desc: 'Tatanan kehidupan masyarakat Pringsewu senantiasa menjunjung tinggi nilai, norma kesopanan, toleransi kerukunan, serta kaidah ajaran agama yang dianut sebagai pondasi moral daerah.',
        badgeColor: 'bg-emerald-50 text-emerald-800 border-emerald-200',
        accentColor: 'text-emerald-700',
        icon: Sun
    }
];

// 5 Butir Misi Bupati dan Wakil Bupati Periode 2025-2029
const missions = [
    {
        number: '01',
        title: 'Optimalisasi Kualitas dan Pemanfaatan Sumber Daya Manusia',
        desc: 'Meningkatkan kompetensi, taraf kesehatan prima, akses pendidikan bermutu, dan perluasan kesempatan berkarya bagi seluruh masyarakat demi melahirkan generasi Pringsewu yang unggul dan berkarakter.',
        icon: Users
    },
    {
        number: '02',
        title: 'Meningkatkan Pertumbuhan Ekonomi Berbasis Keunggulan Daerah',
        desc: 'Mendorong akselerasi ekonomi daerah yang inklusif melalui penguatan komoditas unggulan agribisnis, pemberdayaan koperasi dan UMKM, inovasi industri kreatif, serta perluasan peluang investasi.',
        icon: TrendingUp
    },
    {
        number: '03',
        title: 'Penyelenggaraan Tata Kelola yang Profesional, Modern, dan Inovatif',
        desc: 'Mewujudkan birokrasi pemerintahan yang bersih, transparan, akuntabel, dan adaptif berbasis pemanfaatan teknologi informasi (SPBE), riset ilmiah terapan, serta budaya pelayanan prima.',
        icon: Briefcase
    },
    {
        number: '04',
        title: 'Mempertahankan Swasembada Pangan yang Berwawasan Lingkungan',
        desc: 'Menjaga kemandirian dan lumbung pangan daerah melalui perlindungan lahan pertanian berkelanjutan, modernisasi sarana irigasi, serta konservasi lingkungan hidup yang ramah alam.',
        icon: Sprout
    },
    {
        number: '05',
        title: 'Peningkatan Prasarana dan Sarana Pelayanan Dasar yang Berkelanjutan',
        desc: 'Mempercepat pemerataan konektivitas infrastruktur jalan dan jembatan, penyediaan air minum bersih, sanitasi layak, fasilitas publik ramah warga, dan penataan permukiman yang tangguh.',
        icon: Building2
    }
];
</script>

<template>
    <Head title="Visi dan Misi - Kabupaten Pringsewu & BAPPERIDA" />

    <PublicLayout>
        <!-- Breadcrumb Bar -->
        <div class="bg-slate-100/80 border-b border-slate-200/80 py-2.5 px-4 sm:px-8">
            <div class="max-w-7xl mx-auto flex items-center gap-2 text-xs text-slate-600">
                <Link href="/" class="hover:text-teal-800 transition-colors">Beranda</Link>
                <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                <span class="text-slate-400">Profil</span>
                <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                <span class="font-semibold text-teal-800">Visi dan Misi</span>
            </div>
        </div>

        <!-- Header Banner -->
        <section class="relative bg-gradient-to-r from-teal-950 via-teal-900 to-slate-900 text-white py-14 sm:py-20 px-4 sm:px-8 overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#00C096_1px,transparent_1px)] [background-size:20px_20px] pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative max-w-7xl mx-auto space-y-4">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-500/20 border border-teal-400/30 text-xs font-semibold text-teal-200">
                    <Compass class="w-3.5 h-3.5" />
                    <span>Haluan Pembangunan Daerah Periode 2025–2029</span>
                </div>
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white max-w-4xl leading-tight">
                    Visi & Misi Kabupaten Pringsewu
                </h1>
                <p class="text-sm sm:text-base text-teal-100/90 max-w-3xl leading-relaxed">
                    Visi dan misi daerah menunjukkan cita-cita dan tujuan masa depan untuk pembangunan oleh Bupati dan Wakil Bupati Pringsewu, serta mencerminkan aspirasi luhur seluruh masyarakat yang terlibat dalam pembangunan.
                </p>
            </div>
        </section>

        <!-- Main Content -->
        <main class="py-12 sm:py-16 bg-slate-50/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-20">

                <!-- BAGIAN 1: VISI DAERAH -->
                <div class="space-y-10">
                    <!-- Title Pill -->
                    <div class="flex items-center justify-center">
                        <div class="inline-flex items-center gap-2.5 px-6 py-2 rounded-full bg-amber-400 text-slate-950 font-black text-sm sm:text-base tracking-widest shadow-md">
                            <Target class="w-5 h-5 text-slate-900" />
                            <span>VISI DAERAH</span>
                        </div>
                    </div>

                    <!-- Card Utama Visi -->
                    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-teal-900 via-teal-800 to-slate-900 p-8 sm:p-14 text-white shadow-xl shadow-teal-950/10 text-center max-w-4xl mx-auto space-y-4 border border-teal-500/30">
                        <span class="text-xs sm:text-sm font-bold uppercase tracking-widest text-teal-300">
                            Cita-Cita Luhur Masa Depan Pringsewu
                        </span>
                        <blockquote class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight">
                            “PRINGSEWU MAKMUR”
                        </blockquote>
                        <div class="pt-2">
                            <span class="inline-block px-4 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-xs sm:text-base font-semibold text-teal-100">
                                (Mandiri, Aman, Kondusif, Maju, Unggul, Religius)
                            </span>
                        </div>
                        <p class="text-xs sm:text-sm text-teal-100/80 max-w-2xl mx-auto leading-relaxed pt-2">
                            Visi ini menjadi kompas arah kebijakan BAPPERIDA dalam menyusun dokumen perencanaan strategis dan mengoordinasikan seluruh sektor pembangunan di Kabupaten Pringsewu.
                        </p>
                        <div class="absolute -bottom-16 -right-16 w-64 h-64 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>
                    </div>

                    <!-- 6 Pilar Akronim "MAKMUR" -->
                    <div class="space-y-6 pt-4">
                        <div class="text-center max-w-2xl mx-auto space-y-2">
                            <span class="text-xs font-bold text-teal-700 uppercase tracking-widest">Penjabaran Nilai</span>
                            <h3 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                                6 Pilar Pokok "PRINGSEWU MAKMUR"
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600">
                                Makna mendalam dari setiap huruf pembentuk visi pembangunan daerah Kabupaten Pringsewu.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div
                                v-for="pillar in visionPillars"
                                :key="pillar.number"
                                class="p-6 rounded-3xl bg-white border border-slate-200/90 shadow-xs hover:border-teal-400 hover:shadow-md transition-all duration-200 flex flex-col justify-between space-y-4"
                            >
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-9 h-9 rounded-full bg-teal-50 text-teal-800 font-black text-xs flex items-center justify-center border border-teal-200">
                                                {{ pillar.number }}
                                            </span>
                                            <h4 class="text-base font-black tracking-wide text-slate-900">
                                                {{ pillar.title }}
                                            </h4>
                                        </div>
                                        <div class="w-8 h-8 rounded-xl bg-slate-50 flex items-center justify-center" :class="pillar.accentColor">
                                            <component :is="pillar.icon" class="w-4 h-4" />
                                        </div>
                                    </div>
                                    <p class="text-xs text-slate-600 leading-relaxed">
                                        {{ pillar.desc }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 2: MISI DAERAH PERIODE 2025-2029 -->
                <div class="space-y-10 pt-8 border-t border-slate-200">
                    <!-- Title Pill -->
                    <div class="flex items-center justify-center">
                        <div class="inline-flex items-center gap-2.5 px-6 py-2 rounded-full bg-amber-400 text-slate-950 font-black text-sm sm:text-base tracking-widest shadow-md">
                            <Sparkles class="w-5 h-5 text-slate-900" />
                            <span>MISI DAERAH</span>
                        </div>
                    </div>

                    <div class="text-center max-w-3xl mx-auto space-y-3">
                        <h3 class="text-xl sm:text-3xl font-black text-slate-900 leading-tight">
                            Misi Bupati dan Wakil Bupati Kabupaten Pringsewu
                        </h3>
                        <p class="text-xs sm:text-sm font-semibold text-teal-800">
                            Periode Tahun 2025–2029
                        </p>
                        <p class="text-xs sm:text-sm text-slate-600 max-w-2xl mx-auto leading-relaxed">
                            Untuk mencapai Visi <strong>“PRINGSEWU MAKMUR”</strong>, Bupati dan Wakil Bupati Kabupaten Pringsewu Periode Tahun 2025–2029 merumuskan 5 Misi pembangunan strategis sebagai berikut:
                        </p>
                    </div>

                    <!-- 5 Butir Misi Grid / List -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                        <div
                            v-for="(m, idx) in missions"
                            :key="m.number"
                            class="p-7 rounded-3xl bg-white border border-slate-200/90 shadow-xs hover:border-teal-400 hover:shadow-md transition-all flex flex-col justify-between space-y-4"
                            :class="idx === 4 ? 'md:col-span-2 lg:col-span-1' : ''"
                        >
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-800 font-black text-sm flex items-center justify-center border border-teal-200">
                                        {{ m.number }}
                                    </span>
                                    <div class="w-9 h-9 rounded-2xl bg-slate-50 text-teal-700 flex items-center justify-center">
                                        <component :is="m.icon" class="w-5 h-5" />
                                    </div>
                                </div>
                                <h4 class="text-sm sm:text-base font-black text-slate-900 leading-snug">
                                    {{ m.title }}
                                </h4>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    {{ m.desc }}
                                </p>
                            </div>

                            <div class="pt-3 border-t border-slate-100 flex items-center gap-1.5 text-[11px] text-teal-700 font-semibold">
                                <CheckCircle2 class="w-3.5 h-3.5" />
                                <span>Prioritas Pembangunan 2025–2029</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BAGIAN 3: LANDMARK KEBANGGAAN KABUPATEN PRINGSEWU -->
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-teal-950 via-teal-900 to-slate-950 text-white p-8 sm:p-12 shadow-xl border border-teal-400/20">
                    <div class="relative z-10 max-w-3xl space-y-3">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-xs text-teal-200">
                            <Building2 class="w-3.5 h-3.5" />
                            <span>Identitas Daerah Jejama Secancanan</span>
                        </div>
                        <h4 class="text-2xl sm:text-3xl font-black text-white">
                            Bersatu Mewujudkan Pringsewu Makmur & Sejahtera
                        </h4>
                        <p class="text-xs sm:text-sm text-teal-100/80 leading-relaxed">
                            BAPPERIDA Kabupaten Pringsewu mengajak segenap pemangku kepentingan, akademisi, periset, pelaku usaha, dan masyarakat luas untuk berkolaborasi mewujudkan cita-cita daerah yang berdaya saing, lestari, dan bermartabat.
                        </p>
                        <div class="pt-2 flex flex-wrap gap-3">
                            <Link href="/profil/bapperida" class="px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white text-xs font-bold transition-colors inline-flex items-center gap-2">
                                <span>Mengenal Profil BAPPERIDA</span>
                                <ChevronRight class="w-3.5 h-3.5" />
                            </Link>
                            <Link href="/dokumen" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold border border-white/20 transition-colors inline-flex items-center gap-2">
                                <span>Unduh Dokumen RKPD & RPJMD</span>
                            </Link>
                        </div>
                    </div>
                    <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
                </div>

            </div>
        </main>
    </PublicLayout>
</template>
