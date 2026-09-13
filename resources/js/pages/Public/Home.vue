<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    Search,
    FileText,
    Newspaper,
    Inbox,
    BarChart3,
    ArrowRight,
    Download,
    Calendar,
    Eye,
    ShieldCheck,
    Sparkles,
    CheckCircle2,
    ExternalLink,
    ChevronRight,
    ChevronLeft,
    TrendingUp,
    Award,
    Building2,
    Compass,
    MapPin,
} from 'lucide-vue-next';

interface DocumentItem {
    id: string;
    title: string;
    slug: string;
    category_name: string;
    year: number;
    document_number: string;
    file_size: string;
    downloads_count: number;
}

interface CategoryItem {
    id: string;
    name: string;
    code: string;
    slug: string;
    color: string;
}

interface NewsItem {
    id: string;
    title: string;
    slug: string;
    excerpt: string;
    category_name: string;
    category_code: string;
    category_slug: string;
    featured_image: string | null;
    published_at: string;
    views_count: number;
}

interface IndexItem {
    id: string;
    name: string;
    code: string;
    score: string;
    predicate: string;
    evaluator: string;
    year: number;
}

interface Props {
    featuredDocuments: DocumentItem[];
    categories: CategoryItem[];
    latestNews: NewsItem[];
    indexes: IndexItem[];
    headOfficial: {
        name: string;
        position: string;
        nip: string;
    } | null;
}

const props = defineProps<Props>();

const heroSearchQuery = ref('');
const activeBidang = ref('semua');

const handleHeroSearch = () => {
    if (heroSearchQuery.value.trim()) {
        router.get('/dokumen', { search: heroSearchQuery.value.trim() });
    }
};

const filteredNews = computed(() => {
    if (activeBidang.value === 'semua') {
        return props.latestNews;
    }
    return props.latestNews.filter((n) => n.category_slug === activeBidang.value);
});

const externalServices = [
    {
        name: 'Permohonan Data & Informasi',
        desc: 'Pengajuan data perencanaan & riset publik secara resmi.',
        href: '/layanan',
        icon: Inbox,
        color: 'teal',
        isInternal: true,
    },
    {
        name: 'Pengaduan SPAN-LAPOR!',
        desc: 'Saluran aspirasi dan pengaduan masyarakat nasional terintegrasi.',
        href: 'https://lapor.go.id/',
        icon: ShieldCheck,
        color: 'rose',
        isInternal: false,
    },
    {
        name: 'PPID Pringsewu',
        desc: 'Pejabat Pengelola Informasi dan Dokumentasi Kabupaten.',
        href: 'https://ppid.pringsewukab.go.id/',
        icon: FileText,
        color: 'blue',
        isInternal: false,
    },
    {
        name: 'Survei Kepuasan (IKM)',
        desc: 'Bantu kami meningkatkan kualitas layanan publik daerah.',
        href: '/layanan',
        icon: Sparkles,
        color: 'amber',
        isInternal: true,
    },
];

const integratedPortals = [
    { name: 'Satu Data Pringsewu', desc: 'Portal data statistik & geospasial terpadu', href: 'https://satudata.pringsewukab.go.id/' },
    { name: 'LPSE Pengadaan Barang/Jasa', desc: 'Layanan Pengadaan Secara Elektronik', href: 'https://lpse.pringsewukab.go.id/' },
    { name: 'e-Pajak Daerah', desc: 'Sistem informasi pengelolaan pendapatan daerah', href: 'https://epajak.pringsewukab.go.id/' },
    { name: 'CCTV Pantau Pringsewu', desc: 'Pemantauan titik lalu lintas & ruang publik', href: 'https://cctv.pringsewukab.go.id/' },
];

interface HeroSlide {
    id: number;
    tag: string;
    title: string;
    highlight: string;
    description: string;
    landmark: string;
    landmarkSubtitle: string;
    landmarkBadge: string;
    image: string;
    primaryCta: { label: string; href: string };
    secondaryCta: { label: string; href: string };
    quickStat: { label: string; value: string; desc: string };
}

const slides: HeroSlide[] = [
    {
        id: 1,
        tag: 'Pemerintah Kabupaten Pringsewu • BAPPERIDA',
        title: 'Merencanakan Pembangunan,',
        highlight: 'Menggerakkan Riset & Inovasi',
        description:
            'Portal resmi Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah Kabupaten Pringsewu. Akses dokumen kebijakan daerah (RPJMD/RKPD), riset tematik, publikasi 6 bidang, dan pantau indeks capaian daerah.',
        landmark: 'Tugu Selamat Datang Pringsewu',
        landmarkSubtitle: 'Gerbang Ikonik Bambu Bermahkota Siger Emas Lampung',
        landmarkBadge: 'Ikon Selamat Datang',
        image: '/images/hero/hero_welcome_arch.jpg',
        primaryCta: { label: 'Unduh Dokumen RKPD', href: '/dokumen' },
        secondaryCta: { label: 'Layanan & Aspirasi', href: '/layanan' },
        quickStat: { label: 'Indeks Inovasi Daerah', value: '62.45', desc: 'Sangat Inovatif' },
    },
    {
        id: 2,
        tag: 'Ketangguhan & Semangat Gotong Royong',
        title: 'Harmoni Pembangunan Tangguh,',
        highlight: 'Pringsewu Berprestasi Dunia',
        description:
            'Menumbuhkan pembangunan manusia unggul, penguatan ekonomi kerakyatan, serta ketangguhan daerah yang berdaya saing global terinspirasi kejayaan atlet angkat besi kebanggaan Pringsewu.',
        landmark: 'Tugu Gajah Angkat Besi',
        landmarkSubtitle: 'Monumen Simbol Kejayaan Atlet & Gotong Royong Pringsewu',
        landmarkBadge: 'Ikon Prestasi Daerah',
        image: '/images/hero/hero_tugu_gajah.jpg',
        primaryCta: { label: 'Lihat Indeks Capaian', href: '#indeks-section' },
        secondaryCta: { label: 'Publikasi Riset & Berita', href: '/berita' },
        quickStat: { label: 'Daya Saing Daerah', value: '3.42', desc: 'Kategori Tinggi' },
    },
    {
        id: 3,
        tag: 'Infrastruktur Strategis & Lingkungan Lestari',
        title: 'Pengelolaan Ruang & Ketahanan Pangan,',
        highlight: 'Masa Depan Berkelanjutan',
        description:
            'Optimalisasi tata ruang terpadu, konservasi sumber daya air, dan kedaulatan pangan berkelanjutan melalui Bendungan Way Sekampung untuk kemakmuran generasi kini dan masa depan.',
        landmark: 'Bendungan Way Sekampung',
        landmarkSubtitle: 'Kedaulatan Irigasi Pertanian & Daya Air Kabupaten Pringsewu',
        landmarkBadge: 'Proyek Strategis Nasional',
        image: '/images/hero/hero_way_sekampung.jpg',
        primaryCta: { label: 'Kajian Perencanaan', href: '/dokumen' },
        secondaryCta: { label: 'Survei Kepuasan (IKM)', href: '/layanan' },
        quickStat: { label: 'Pengelolaan Keuangan (IPKD)', value: '84.10', desc: 'Sangat Baik' },
    },
];

const currentSlideIndex = ref(0);
const isPaused = ref(false);
let timer: ReturnType<typeof setInterval> | null = null;

const currentSlide = computed(() => slides[currentSlideIndex.value]);

const nextSlide = () => {
    currentSlideIndex.value = (currentSlideIndex.value + 1) % slides.length;
};

const prevSlide = () => {
    currentSlideIndex.value = (currentSlideIndex.value - 1 + slides.length) % slides.length;
};

const setSlide = (idx: number) => {
    currentSlideIndex.value = idx;
};

const startTimer = () => {
    stopTimer();
    timer = setInterval(() => {
        if (!isPaused.value) {
            nextSlide();
        }
    }, 6500);
};

const stopTimer = () => {
    if (timer) {
        clearInterval(timer);
        timer = null;
    }
};

onMounted(() => {
    startTimer();
});

onUnmounted(() => {
    stopTimer();
});
</script>

<template>
    <Head title="Portal Resmi BAPPERIDA Kabupaten Pringsewu" />

    <PublicLayout>
        <!-- Full Page Hero Slider Section (Pas Layar Laptop & Desktop Tanpa Perlu Scroll) -->
        <section
            class="relative w-full h-[calc(100vh-100px)] min-h-[500px] max-h-[680px] lg:max-h-[720px] flex items-center overflow-hidden bg-slate-950 text-white select-none border-b border-slate-800"
            @mouseenter="isPaused = true"
            @mouseleave="isPaused = false"
        >
            <!-- Background Slider Images (Prompt Crossfade + Smooth Ken Burns) -->
            <div class="absolute inset-0 w-full h-full overflow-hidden">
                <div
                    v-for="(slide, index) in slides"
                    :key="slide.id"
                    class="absolute inset-0 w-full h-full transition-opacity duration-500 ease-out"
                    :class="index === currentSlideIndex ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none'"
                >
                    <img
                        :src="slide.image"
                        :alt="slide.landmark"
                        class="w-full h-full object-cover object-center transition-transform duration-6000 ease-out"
                        :class="index === currentSlideIndex ? 'scale-105' : 'scale-100'"
                        loading="eager"
                    />
                </div>
            </div>

            <!-- Left Contrast Overlay (Teks terbaca tajam & jelas) -->
            <div class="absolute inset-0 bg-linear-to-r from-slate-950/95 via-slate-950/80 to-transparent z-10 pointer-events-none" />

            <!-- Right Semitransparent Overlay (Overlay terlihat sedikit jelas di sebelah kanan) -->
            <div class="absolute top-0 right-0 bottom-0 w-full md:w-7/12 lg:w-1/2 bg-linear-to-l from-slate-950/80 via-slate-950/35 to-transparent z-10 pointer-events-none" />

            <!-- Top & Bottom Soft Gradient Fades -->
            <div class="absolute inset-x-0 top-0 h-24 bg-linear-to-b from-slate-950/70 to-transparent z-10 pointer-events-none" />
            <div class="absolute inset-x-0 bottom-0 h-24 bg-linear-to-t from-slate-950 via-slate-950/50 to-transparent z-10 pointer-events-none" />

            <!-- Slider Content Container -->
            <div class="max-w-7xl mx-auto px-4 sm:px-8 py-6 sm:py-8 lg:py-10 relative z-20 w-full">
                <div class="max-w-3xl space-y-4 sm:space-y-5">
                    <!-- Main Heading & Deskripsi dengan Animasi Smooth dari Kiri ke Kanan -->
                    <div class="min-h-[110px] sm:min-h-[125px] flex flex-col justify-center overflow-hidden">
                        <Transition name="hero-slide" mode="out-in">
                            <div :key="currentSlide.id" class="space-y-2.5 sm:space-y-3">
                                <h1 class="text-2xl sm:text-3xl lg:text-[36px] xl:text-[42px] font-black text-white tracking-tight leading-[1.16]">
                                    {{ currentSlide.title }}
                                    <span class="block text-teal-400 bg-linear-to-r from-teal-300 via-emerald-300 to-amber-300 bg-clip-text text-transparent">
                                        {{ currentSlide.highlight }}
                                    </span>
                                </h1>

                                <p class="text-xs sm:text-sm text-slate-200/90 leading-relaxed max-w-2xl font-normal drop-shadow-sm line-clamp-2 sm:line-clamp-3">
                                    {{ currentSlide.description }}
                                </p>
                            </div>
                        </Transition>
                    </div>

                    <!-- Integrated Search Bar -->
                    <form @submit.prevent="handleHeroSearch" class="max-w-xl">
                        <div class="relative flex items-center bg-slate-900/60 hover:bg-slate-900/80 focus-within:bg-slate-900 border-2 border-white/20 hover:border-teal-400/80 focus-within:border-teal-400 rounded-2xl p-1 sm:p-1.5 transition-all shadow-xl backdrop-blur-md">
                            <Search class="w-4 h-4 sm:w-5 sm:h-5 text-teal-400 ml-3 shrink-0" />
                            <input
                                v-model="heroSearchQuery"
                                type="text"
                                placeholder="Cari dokumen RKPD, RPJMD, atau topik riset..."
                                class="w-full bg-transparent px-2.5 py-1.5 text-xs sm:text-sm text-white placeholder-slate-300 outline-none"
                            />
                            <button
                                type="submit"
                                class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-teal-600 hover:bg-teal-500 active:scale-[0.98] transition-all shrink-0 cursor-pointer shadow-md flex items-center gap-1.5"
                            >
                                <span>Cari Data</span>
                                <ArrowRight class="w-3.5 h-3.5" />
                            </button>
                        </div>
                    </form>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap items-center gap-3 pt-0.5">
                        <Link
                            :href="currentSlide.primaryCta.href"
                            class="inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm font-bold text-white bg-teal-600 hover:bg-teal-500 active:scale-95 transition-all shadow-lg cursor-pointer"
                        >
                            <span>{{ currentSlide.primaryCta.label }}</span>
                            <ArrowRight class="w-4 h-4" />
                        </Link>
                        <Link
                            :href="currentSlide.secondaryCta.href"
                            class="inline-flex items-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-200 bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-md active:scale-95 transition-all cursor-pointer"
                        >
                            <span>{{ currentSlide.secondaryCta.label }}</span>
                        </Link>
                    </div>

                    <!-- Popular Search Links -->
                    <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 text-[11px] sm:text-xs text-slate-300 pt-0.5">
                        <span class="font-semibold text-slate-400">Pencarian Populer:</span>
                        <Link href="/dokumen?search=RKPD" class="hover:text-teal-300 underline decoration-slate-500">RKPD 2026</Link>
                        <Link href="/dokumen?search=RPJMD" class="hover:text-teal-300 underline decoration-slate-500">RPJMD 2025-2029</Link>
                        <Link href="/dokumen?search=Stunting" class="hover:text-teal-300 underline decoration-slate-500">Kajian Stunting</Link>
                        <Link href="/layanan" class="hover:text-teal-300 underline decoration-slate-500">Permohonan Data</Link>
                    </div>
                </div>
            </div>

            <!-- Compact Corner Widget: Landmark Info & Controls (Pojok Kanan Bawah) -->
            <div class="absolute bottom-4 right-4 sm:bottom-6 sm:right-8 z-30 flex items-center gap-2.5 sm:gap-3 bg-slate-950/75 hover:bg-slate-950/90 backdrop-blur-xl border border-white/20 px-3.5 py-2 sm:px-4 sm:py-2.5 rounded-2xl shadow-2xl transition-all">
                <!-- Landmark Info (Compact) -->
                <div class="flex items-center gap-2.5 pr-3 border-r border-white/15 max-w-[200px] sm:max-w-xs">
                    <div class="w-8 h-8 rounded-xl bg-teal-500/20 border border-teal-400/30 flex items-center justify-center shrink-0">
                        <MapPin class="w-4 h-4 text-teal-300" />
                    </div>
                    <div class="truncate">
                        <Transition name="corner-slide" mode="out-in">
                            <div :key="currentSlide.id" class="truncate">
                                <span class="text-[10px] font-bold text-teal-400 uppercase tracking-wider block leading-none">
                                    {{ currentSlide.landmarkBadge }} • {{ currentSlideIndex + 1 }}/{{ slides.length }}
                                </span>
                                <span class="text-xs sm:text-sm font-bold text-white leading-tight block mt-1 truncate">
                                    {{ currentSlide.landmark }}
                                </span>
                            </div>
                        </Transition>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex items-center gap-1.5">
                    <button
                        type="button"
                        @click="prevSlide"
                        aria-label="Slide Sebelumnya"
                        class="w-8 h-8 rounded-xl bg-white/10 hover:bg-teal-600 text-white flex items-center justify-center transition-all active:scale-90 cursor-pointer"
                    >
                        <ChevronLeft class="w-4 h-4" />
                    </button>
                    <button
                        type="button"
                        @click="nextSlide"
                        aria-label="Slide Berikutnya"
                        class="w-8 h-8 rounded-xl bg-white/10 hover:bg-teal-600 text-white flex items-center justify-center transition-all active:scale-90 cursor-pointer"
                    >
                        <ChevronRight class="w-4 h-4" />
                    </button>
                </div>

                <!-- Slide Indicators -->
                <div class="hidden sm:flex items-center gap-1.5 pl-1">
                    <button
                        v-for="(s, idx) in slides"
                        :key="s.id"
                        type="button"
                        @click="setSlide(idx)"
                        :aria-label="'Pilih Slide ' + (idx + 1)"
                        class="h-1.5 rounded-full transition-all duration-300 cursor-pointer"
                        :class="idx === currentSlideIndex ? 'w-5 bg-teal-400' : 'w-1.5 bg-white/30 hover:bg-white/60'"
                    />
                </div>
            </div>
        </section>

        <!-- Layanan Unggulan Publik (Quick Action Services) -->
        <section class="py-12 bg-slate-50 border-b border-slate-200/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <template v-for="service in externalServices" :key="service.name">
                        <component
                            :is="service.isInternal ? Link : 'a'"
                            :href="service.href"
                            :target="service.isInternal ? undefined : '_blank'"
                            :rel="service.isInternal ? undefined : 'noopener noreferrer'"
                            class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md hover:border-teal-700/40 transition-all flex flex-col justify-between group"
                        >
                            <div class="space-y-3">
                                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-800 flex items-center justify-center group-hover:scale-105 transition-transform">
                                    <component :is="service.icon" class="w-5 h-5" />
                                </div>
                                <h3 class="text-sm font-bold text-slate-900 leading-snug group-hover:text-teal-800 transition-colors">
                                    {{ service.name }}
                                </h3>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    {{ service.desc }}
                                </p>
                            </div>
                            <div class="pt-3 mt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-teal-800">
                                <span>Akses Layanan</span>
                                <component :is="service.isInternal ? ArrowRight : ExternalLink" class="w-3.5 h-3.5 opacity-60" />
                            </div>
                        </component>
                    </template>
                </div>
            </div>
        </section>

        <!-- Sorotan Dokumen Perencanaan Utama -->
        <section class="py-16 bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-10">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                    <div>
                        <span class="text-xs font-bold text-teal-800 uppercase tracking-wider block">
                            Akuntabilitas & Transparansi
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-1">
                            Dokumen Perencanaan Daerah Terkini
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-2xl">
                            Akses langsung produk kebijakan resmi BAPPERIDA Kabupaten Pringsewu dalam format digital berkualitas tinggi.
                        </p>
                    </div>

                    <Link
                        href="/dokumen"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-teal-800 hover:text-teal-900 self-start sm:self-auto"
                    >
                        <span>Lihat Seluruh Dokumen</span>
                        <ChevronRight class="w-4 h-4" />
                    </Link>
                </div>

                <!-- Documents Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div
                        v-for="doc in featuredDocuments"
                        :key="doc.id"
                        class="bg-slate-50/70 rounded-3xl p-6 border border-slate-200/80 hover:bg-white hover:shadow-md hover:border-teal-600/40 transition-all flex flex-col justify-between"
                    >
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-bold px-2.5 py-1 rounded-md bg-teal-100/70 text-teal-800">
                                    {{ doc.category_name }}
                                </span>
                                <span class="text-xs font-bold text-slate-400">
                                    Tahun {{ doc.year }}
                                </span>
                            </div>

                            <h3 class="text-base font-bold text-slate-900 leading-snug">
                                {{ doc.title }}
                            </h3>

                            <p class="text-xs font-mono text-slate-400">
                                {{ doc.document_number }}
                            </p>
                        </div>

                        <div class="pt-4 mt-4 border-t border-slate-200/60 flex items-center justify-between">
                            <span class="text-xs text-slate-400">
                                Ukuran: {{ doc.file_size }}
                            </span>

                            <a
                                :href="`/dokumen/${doc.slug}/unduh`"
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-teal-800 bg-teal-50 hover:bg-teal-800 hover:text-white border border-teal-200/80 transition-all"
                            >
                                <Download class="w-3.5 h-3.5" />
                                Unduh PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Warta Pembangunan 6 Bidang -->
        <section class="py-16 bg-slate-50 border-b border-slate-200/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-10">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                    <div>
                        <span class="text-xs font-bold text-teal-800 uppercase tracking-wider block">
                            Kilas Informasi Publik
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-1">
                            Warta & Publikasi 6 Bidang
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1">
                            Informasi terkini pelaksanaan perencanaan pembangunan, riset terpadu, dan inovasi daerah.
                        </p>
                    </div>

                    <Link
                        href="/berita"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-teal-800 hover:text-teal-900 self-start sm:self-auto"
                    >
                        <span>Arsip Seluruh Berita</span>
                        <ChevronRight class="w-4 h-4" />
                    </Link>
                </div>

                <!-- Bidang Filter Tabs -->
                <div class="flex items-center gap-2 overflow-x-auto pb-2 text-xs">
                    <button
                        type="button"
                        class="px-4 py-2 rounded-xl font-bold transition-all whitespace-nowrap cursor-pointer"
                        :class="activeBidang === 'semua' ? 'bg-teal-800 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/80'"
                        @click="activeBidang = 'semua'"
                    >
                        Semua Bidang
                    </button>
                    <button
                        v-for="cat in categories"
                        :key="cat.id"
                        type="button"
                        class="px-4 py-2 rounded-xl font-bold transition-all whitespace-nowrap cursor-pointer"
                        :class="activeBidang === cat.slug ? 'bg-teal-800 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/80'"
                        @click="activeBidang = cat.slug"
                    >
                        {{ cat.code }} • {{ cat.name }}
                    </button>
                </div>

                <!-- News Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <article
                        v-for="art in filteredNews"
                        :key="art.id"
                        class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group"
                    >
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold uppercase tracking-wider bg-teal-50 text-teal-800 border border-teal-200/60">
                                    {{ art.category_code }}
                                </span>
                                <span class="text-[11px] text-slate-400 flex items-center gap-1">
                                    <Calendar class="w-3 h-3" /> {{ art.published_at }}
                                </span>
                            </div>

                            <h3 class="text-base font-bold text-slate-900 leading-snug group-hover:text-teal-800 transition-colors">
                                <Link :href="`/berita/${art.slug}`">
                                    {{ art.title }}
                                </Link>
                            </h3>

                            <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                {{ art.excerpt }}
                            </p>
                        </div>

                        <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-slate-400 text-[11px] flex items-center gap-1">
                                <Eye class="w-3 h-3" /> {{ art.views_count }} pembaca
                            </span>

                            <Link
                                :href="`/berita/${art.slug}`"
                                class="inline-flex items-center gap-1 font-bold text-teal-800 hover:text-teal-900"
                            >
                                <span>Selengkapnya</span>
                                <ArrowRight class="w-3.5 h-3.5" />
                            </Link>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Indeks Pembangunan Daerah (Metrics Dashboard) -->
        <section id="indeks-section" class="py-16 bg-white border-b border-slate-100 scroll-mt-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-10">
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs font-bold text-teal-800 uppercase tracking-wider">
                        Kinerja & Akuntabilitas Daerah
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Indeks Capaian Kabupaten Pringsewu
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500">
                        Hasil evaluasi objektif lembaga negara terhadap inovasi, daya saing, dan tata kelola keuangan Pringsewu.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div
                        v-for="idx in indexes"
                        :key="idx.id"
                        class="bg-slate-50 rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:bg-white hover:shadow-md transition-all text-center space-y-4"
                    >
                        <span class="text-xs font-mono font-bold px-3 py-1 rounded-full bg-teal-100 text-teal-800 inline-block">
                            {{ idx.code }} • {{ idx.year }}
                        </span>

                        <h3 class="text-sm font-bold text-slate-900 leading-snug min-h-[40px] flex items-center justify-center">
                            {{ idx.name }}
                        </h3>

                        <div class="space-y-1">
                            <span class="text-4xl font-black text-slate-900 tracking-tight block">
                                {{ idx.score }}
                            </span>
                            <span class="inline-block text-xs font-bold px-3 py-1 rounded-full bg-teal-50 text-teal-800 border border-teal-200">
                                {{ idx.predicate }}
                            </span>
                        </div>

                        <p class="text-[11px] text-slate-400 pt-3 border-t border-slate-200/60 leading-tight">
                            Penilai: {{ idx.evaluator }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tautan Portal Daerah Terintegrasi -->
        <section class="py-12 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">
                        Portal Layanan Terintegrasi Pemkab Pringsewu
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a
                        v-for="portal in integratedPortals"
                        :key="portal.name"
                        :href="portal.href"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs hover:border-teal-700 hover:shadow-sm transition-all group"
                    >
                        <div class="flex items-center justify-between text-xs font-bold text-slate-900 group-hover:text-teal-800">
                            <span>{{ portal.name }}</span>
                            <ExternalLink class="w-3.5 h-3.5 text-slate-400 group-hover:text-teal-700" />
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1">
                            {{ portal.desc }}
                        </p>
                    </a>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>

<style scoped>
/* Transisi teks hero dari kiri ke kanan dengan kurva akselerasi halus */
.hero-slide-enter-active {
    transition: transform 0.55s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.45s ease-out;
}
.hero-slide-leave-active {
    transition: transform 0.25s ease-in, opacity 0.2s ease-in;
}
.hero-slide-enter-from {
    opacity: 0;
    transform: translateX(-45px);
}
.hero-slide-leave-to {
    opacity: 0;
    transform: translateX(35px);
}

/* Transisi teks keterangan landmark pojok */
.corner-slide-enter-active {
    transition: transform 0.45s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.35s ease-out;
}
.corner-slide-leave-active {
    transition: opacity 0.2s ease-in;
}
.corner-slide-enter-from {
    opacity: 0;
    transform: translateX(-20px);
}
.corner-slide-leave-to {
    opacity: 0;
}
</style>
