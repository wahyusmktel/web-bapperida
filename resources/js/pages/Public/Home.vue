<script setup lang="ts">
import { ref, computed } from 'vue';
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
    TrendingUp,
    Award,
    Building2,
    Compass,
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
</script>

<template>
    <Head title="Portal Resmi BAPPERIDA Kabupaten Pringsewu" />

    <PublicLayout>
        <!-- Hero Section Asimetris Modern -->
        <section class="relative overflow-hidden bg-white border-b border-slate-100 py-16 sm:py-24">
            <!-- Subtle Radial Gradient Backgrounds -->
            <div class="absolute top-0 right-0 w-1/2 h-full bg-radial from-teal-50/70 via-transparent to-transparent pointer-events-none" />
            <div class="absolute -bottom-24 left-1/4 w-96 h-96 bg-amber-50/50 rounded-full blur-3xl pointer-events-none" />

            <div class="max-w-7xl mx-auto px-4 sm:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <!-- Hero Text Content (7 cols) -->
                    <div class="lg:col-span-7 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-50 border border-teal-200/80 text-xs font-bold text-teal-800 tracking-wide">
                            <Sparkles class="w-3.5 h-3.5 text-teal-700" />
                            <span>Pemerintah Kabupaten Pringsewu • BAPPERIDA</span>
                        </div>

                        <h1 class="text-3xl sm:text-5xl lg:text-[54px] font-black text-slate-900 tracking-tight leading-[1.12]">
                            Merencanakan Pembangunan, <span class="text-teal-800">Menggerakkan Riset</span> & Inovasi Daerah.
                        </h1>

                        <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl font-normal">
                            Portal resmi Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah (BAPPERIDA) Kabupaten Pringsewu. Akses dokumen perencanaan (RPJMD/RKPD), riset strategis, warta 6 bidang, dan pantau indeks capaian daerah secara transparan.
                        </p>

                        <!-- Integrated Search Bar -->
                        <form @submit.prevent="handleHeroSearch" class="max-w-xl">
                            <div class="relative flex items-center bg-slate-50 border-2 border-slate-200/80 hover:border-teal-700/60 focus-within:border-teal-700 focus-within:bg-white rounded-2xl p-1.5 transition-all shadow-xs">
                                <Search class="w-5 h-5 text-slate-400 ml-3 shrink-0" />
                                <input
                                    v-model="heroSearchQuery"
                                    type="text"
                                    placeholder="Cari dokumen RKPD, RPJMD, atau topik berita..."
                                    class="w-full bg-transparent px-3 py-2 text-xs sm:text-sm text-slate-800 outline-none"
                                />
                                <button
                                    type="submit"
                                    class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-teal-800 hover:bg-teal-900 active:scale-[0.98] transition-all shrink-0 cursor-pointer shadow-xs"
                                >
                                    Cari Data
                                </button>
                            </div>
                        </form>

                        <!-- Quick Badges -->
                        <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 pt-2">
                            <span class="font-semibold text-slate-400">Pencarian Populer:</span>
                            <Link href="/dokumen?search=RKPD" class="hover:text-teal-800 underline decoration-slate-300">RKPD 2026</Link>
                            <Link href="/dokumen?search=RPJMD" class="hover:text-teal-800 underline decoration-slate-300">RPJMD 2025-2029</Link>
                            <Link href="/dokumen?search=Stunting" class="hover:text-teal-800 underline decoration-slate-300">Kajian Stunting</Link>
                            <Link href="/layanan" class="hover:text-teal-800 underline decoration-slate-300">Permohonan Data</Link>
                        </div>
                    </div>

                    <!-- Hero Visual Card (5 cols) -->
                    <div class="lg:col-span-5 space-y-4">
                        <!-- Card 1: Prestasi Utama IID -->
                        <div class="bg-linear-to-br from-teal-900 to-slate-900 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden">
                            <div class="absolute -top-12 -right-12 w-40 h-40 bg-teal-500/20 rounded-full blur-2xl" />
                            <div class="space-y-4 relative z-10">
                                <div class="flex items-center justify-between">
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-teal-300">
                                        Capaian Prestasi Daerah
                                    </span>
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-teal-800 text-teal-200 border border-teal-600/30">
                                        Tahun 2025
                                    </span>
                                </div>
                                <div>
                                    <span class="text-xs text-slate-300">Indeks Inovasi Daerah (IID)</span>
                                    <div class="flex items-baseline gap-3 mt-1">
                                        <span class="text-4xl sm:text-5xl font-black text-white tracking-tight">
                                            62.45
                                        </span>
                                        <span class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                            <Award class="w-3.5 h-3.5" /> Sangat Inovatif
                                        </span>
                                    </div>
                                </div>
                                <p class="text-xs text-teal-100/70 pt-2 border-t border-teal-800/80">
                                    Dianugerahi oleh Kementerian Dalam Negeri Republik Indonesia atas komitmen penguatan ekosistem riset dan kemudahan pelayanan warga Pringsewu.
                                </p>
                            </div>
                        </div>

                        <!-- Card 2: Quick Fact Pringsewu -->
                        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs flex items-center justify-between">
                            <div class="space-y-1">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">
                                    Dokumen Perencanaan
                                </span>
                                <h3 class="text-base font-bold text-slate-900">
                                    Transparansi Publik 100%
                                </h3>
                                <p class="text-xs text-slate-500">
                                    Seluruh regulasi pembangunan daerah dapat diakses dan diunduh cuma-cuma.
                                </p>
                            </div>
                            <Link
                                href="/dokumen"
                                class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-800 flex items-center justify-center hover:bg-teal-800 hover:text-white transition-all shrink-0 ml-3"
                            >
                                <ArrowRight class="w-5 h-5" />
                            </Link>
                        </div>
                    </div>
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
        <section class="py-16 bg-white border-b border-slate-100">
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
