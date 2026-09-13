<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    Search,
    Calendar,
    Eye,
    Clock,
    User,
    ArrowRight,
    Sparkles,
    Bookmark,
    Layers,
    Building2,
    Activity,
    Users,
    TrendingUp,
    Lightbulb,
    Share2,
    Compass,
    ChevronRight
} from 'lucide-vue-next';

export interface ArticleItem {
    id: string;
    title: string;
    slug: string;
    excerpt: string;
    category_name: string;
    category_code: string;
    category_slug: string;
    category_color: string;
    author_name: string;
    featured_image: string | null;
    published_at: string;
    published_date_full: string;
    views_count: number;
    reading_time: string;
}

export interface CategoryItem {
    id: string;
    name: string;
    code: string;
    slug: string;
    color: string;
    description?: string;
}

export interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

export interface Props {
    articles: {
        data: ArticleItem[];
        links: PaginationLink[];
        current_page: number;
        last_page: number;
        total: number;
    };
    featuredArticle?: ArticleItem | null;
    popularArticles?: ArticleItem[];
    category?: CategoryItem | null;
    categories: CategoryItem[];
    meta: {
        title: string;
        description: string;
        badge: string;
        category_slug: string;
    };
    filters: {
        search?: string;
        bidang?: string;
    };
    baseUrl: string;
}

const props = defineProps<Props>();

const search = ref(props.filters.search || '');

// Interactive mouse reaction for hero ambient light
const mouseX = ref(0);
const mouseY = ref(0);

const handleMouseMove = (e: MouseEvent) => {
    const { clientX, clientY } = e;
    const { innerWidth, innerHeight } = window;
    mouseX.value = Math.round((clientX / innerWidth) * 20 - 10);
    mouseY.value = Math.round((clientY / innerHeight) * 20 - 10);
};

const applySearch = () => {
    router.get(
        props.baseUrl,
        {
            search: search.value || undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
};

const resetSearch = () => {
    search.value = '';
    applySearch();
};

const getCategoryColor = (code: string) => {
    switch (code) {
        case 'UMUM':
            return 'bg-slate-100 text-slate-800 border-slate-300';
        case 'PPE':
            return 'bg-teal-100 text-teal-900 border-teal-300';
        case 'PPM':
            return 'bg-blue-100 text-blue-900 border-blue-300';
        case 'PSDA':
            return 'bg-emerald-100 text-emerald-900 border-emerald-300';
        case 'IPW':
            return 'bg-amber-100 text-amber-950 border-amber-300';
        case 'RIDA':
            return 'bg-purple-100 text-purple-900 border-purple-300';
        default:
            return 'bg-teal-100 text-teal-900 border-teal-300';
    }
};

const getCategoryIcon = (code: string) => {
    switch (code) {
        case 'UMUM':
            return Building2;
        case 'PPE':
            return Activity;
        case 'PPM':
            return Users;
        case 'PSDA':
            return TrendingUp;
        case 'IPW':
            return Layers;
        case 'RIDA':
            return Lightbulb;
        default:
            return Compass;
    }
};
</script>

<template>
    <Head :title="`${meta.title} - BAPPERIDA Pringsewu`" />

    <PublicLayout>
        <!-- Magazine Masthead Ticker Bar -->
        <div class="bg-slate-900 text-slate-300 text-[11px] py-2 px-4 sm:px-8 border-b border-slate-800">
            <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 rounded bg-teal-500/20 text-teal-300 font-bold tracking-wider text-[10px] uppercase border border-teal-400/30">
                        Buletin Digital
                    </span>
                    <span class="font-medium text-slate-300 hidden sm:inline">
                        Warta Resmi Perencanaan, Riset & Inovasi Daerah
                    </span>
                    <span class="text-slate-600 hidden sm:inline">•</span>
                    <span class="text-slate-400 text-[10px]">
                        Kabupaten Pringsewu, Lampung
                    </span>
                </div>
                <div class="flex items-center gap-4 text-[10px] text-slate-400">
                    <span>Edisi Tahun 2026</span>
                    <span>•</span>
                    <span class="text-teal-400 font-semibold">Aktif Membangun</span>
                </div>
            </div>
        </div>

        <!-- Magazine Hero Section with AI-Generated Pringsewu Background -->
        <section
            class="relative overflow-hidden bg-slate-950 text-white py-16 sm:py-20 px-4 sm:px-8 border-b border-teal-900/40"
            @mousemove="handleMouseMove"
        >
            <!-- Background Image Generated by AI: Iconic Pringsewu Tugu Bambu & Groves -->
            <div class="absolute inset-0 z-0">
                <img
                    src="/images/pringsewu_magazine_bg.jpg"
                    alt="Background Khas Pringsewu"
                    class="w-full h-full object-cover object-center transform scale-105 transition-transform duration-700 ease-out opacity-45 mix-blend-luminosity"
                    :style="{
                        transform: `translate(${mouseX * 0.4}px, ${mouseY * 0.4}px) scale(1.05)`
                    }"
                />
                <!-- Deep Gradient Vignette Scrim for World-Class Readability -->
                <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/85 to-teal-950/80" />
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-slate-950/70" />
            </div>

            <!-- Tapis Lampung Decorative Geometric SVG Accents -->
            <div class="absolute right-0 top-0 bottom-0 w-1/3 opacity-15 pointer-events-none hidden md:block">
                <svg class="w-full h-full text-amber-300" viewBox="0 0 100 100" preserveAspectRatio="none" fill="currentColor">
                    <polygon points="50,0 100,50 50,100 0,50" />
                    <polygon points="50,15 85,50 50,85 15,50" fill="#0f172a" />
                </svg>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto space-y-6">
                <!-- Breadcrumbs -->
                <div class="flex items-center gap-2 text-xs text-teal-300/80 font-medium">
                    <Link href="/" class="hover:text-white transition-colors">Beranda</Link>
                    <ChevronRight class="w-3.5 h-3.5 text-teal-500" />
                    <Link href="/berita" class="hover:text-white transition-colors">Berita 6 Bidang</Link>
                    <ChevronRight class="w-3.5 h-3.5 text-teal-500" />
                    <span class="text-white font-semibold">{{ meta.badge }}</span>
                </div>

                <div class="max-w-3xl space-y-3">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-500/20 text-xs font-semibold text-teal-300 border border-teal-400/30 backdrop-blur-md">
                        <Sparkles class="w-3.5 h-3.5 text-amber-300" />
                        <span>{{ meta.badge }}</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-white leading-[1.15]">
                        {{ meta.title }}
                    </h1>

                    <p class="text-sm sm:text-base text-slate-300 leading-relaxed max-w-2xl font-normal">
                        {{ meta.description }}
                    </p>
                </div>

                <!-- Rubrik Navigation Tabs (Magazine Switcher) -->
                <div class="pt-4 flex flex-wrap items-center gap-2">
                    <Link
                        href="/berita"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all"
                        :class="meta.category_slug === 'semua'
                            ? 'bg-amber-400 text-slate-950 shadow-md shadow-amber-400/20'
                            : 'bg-white/10 text-white hover:bg-white/20 border border-white/10'"
                    >
                        Semua Warta
                    </Link>
                    <Link
                        href="/berita/umum"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all"
                        :class="meta.category_slug === 'umum'
                            ? 'bg-amber-400 text-slate-950 shadow-md shadow-amber-400/20'
                            : 'bg-white/10 text-white hover:bg-white/20 border border-white/10'"
                    >
                        Umum
                    </Link>
                    <Link
                        href="/berita/ppe"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all"
                        :class="meta.category_slug === 'ppe'
                            ? 'bg-amber-400 text-slate-950 shadow-md shadow-amber-400/20'
                            : 'bg-white/10 text-white hover:bg-white/20 border border-white/10'"
                    >
                        PPE
                    </Link>
                    <Link
                        href="/berita/ppm"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all"
                        :class="meta.category_slug === 'ppm'
                            ? 'bg-amber-400 text-slate-950 shadow-md shadow-amber-400/20'
                            : 'bg-white/10 text-white hover:bg-white/20 border border-white/10'"
                    >
                        PPM
                    </Link>
                    <Link
                        href="/berita/psda"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all"
                        :class="meta.category_slug === 'psda'
                            ? 'bg-amber-400 text-slate-950 shadow-md shadow-amber-400/20'
                            : 'bg-white/10 text-white hover:bg-white/20 border border-white/10'"
                    >
                        PSDA
                    </Link>
                    <Link
                        href="/berita/ipw"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all"
                        :class="meta.category_slug === 'ipw'
                            ? 'bg-amber-400 text-slate-950 shadow-md shadow-amber-400/20'
                            : 'bg-white/10 text-white hover:bg-white/20 border border-white/10'"
                    >
                        IPW
                    </Link>
                    <Link
                        href="/berita/rida"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all"
                        :class="meta.category_slug === 'rida'
                            ? 'bg-amber-400 text-slate-950 shadow-md shadow-amber-400/20'
                            : 'bg-white/10 text-white hover:bg-white/20 border border-white/10'"
                    >
                        RIDA
                    </Link>
                </div>
            </div>
        </section>

        <!-- Main Magazine Content Area -->
        <main class="py-12 px-4 sm:px-8 max-w-7xl mx-auto w-full space-y-12">
            <!-- Magazine Search & Filter Bar -->
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="relative flex-1 w-full">
                    <Search class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Cari liputan, tajuk berita, inovasi, atau kata kunci..."
                        class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all"
                        @keyup.enter="applySearch"
                    />
                    <button
                        v-if="search"
                        type="button"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 hover:text-slate-600 cursor-pointer"
                        @click="resetSearch"
                    >
                        Reset
                    </button>
                </div>

                <div class="flex items-center gap-3 w-full md:w-auto shrink-0 justify-between md:justify-end">
                    <span class="text-xs text-slate-500 font-medium">
                        Total: <strong class="text-slate-800">{{ articles.total }}</strong> artikel
                    </span>
                    <button
                        type="button"
                        class="px-4 py-2.5 rounded-xl bg-teal-800 text-white text-xs font-bold hover:bg-teal-900 transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                        @click="applySearch"
                    >
                        <Search class="w-3.5 h-3.5" />
                        <span>Filter Berita</span>
                    </button>
                </div>
            </div>

            <!-- SECTION 1: COVER FEATURE STORY (MAGAZINE LEAD) -->
            <section v-if="featuredArticle" class="space-y-6">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-5 bg-teal-700 rounded-full" />
                        <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">
                            Sorotan Liputan Utama
                        </h2>
                    </div>
                    <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                        Edisi Terkini
                    </span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    <!-- Left: Large Magazine Lead Card (7 cols) -->
                    <article class="lg:col-span-7 bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden flex flex-col justify-between group hover:shadow-xl transition-all duration-300">
                        <div class="p-6 sm:p-8 space-y-4">
                            <!-- Category Badge & Reading Time -->
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider border"
                                    :class="getCategoryColor(featuredArticle.category_code)"
                                >
                                    {{ featuredArticle.category_name }}
                                </span>
                                <div class="flex items-center gap-3 text-xs text-slate-500">
                                    <span class="flex items-center gap-1">
                                        <Clock class="w-3.5 h-3.5 text-slate-400" />
                                        {{ featuredArticle.reading_time }}
                                    </span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1">
                                        <Eye class="w-3.5 h-3.5 text-slate-400" />
                                        {{ featuredArticle.views_count }} dibaca
                                    </span>
                                </div>
                            </div>

                            <!-- Headline Title -->
                            <Link :href="`/berita/${featuredArticle.slug}`" class="block">
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-900 group-hover:text-teal-800 transition-colors leading-tight">
                                    {{ featuredArticle.title }}
                                </h3>
                            </Link>

                            <!-- Rich Excerpt Paragraph -->
                            <p class="text-sm text-slate-600 leading-relaxed">
                                {{ featuredArticle.excerpt }}
                            </p>
                        </div>

                        <!-- Footer Author & Action -->
                        <div class="p-6 sm:p-8 pt-0 flex items-center justify-between border-t border-slate-100 bg-slate-50/50 mt-4">
                            <div class="flex items-center gap-2.5 pt-4">
                                <div class="w-8 h-8 rounded-full bg-teal-800 text-white flex items-center justify-center font-bold text-xs">
                                    BP
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-slate-900">
                                        {{ featuredArticle.author_name }}
                                    </span>
                                    <span class="text-[11px] text-slate-500">
                                        {{ featuredArticle.published_date_full }}
                                    </span>
                                </div>
                            </div>

                            <Link
                                :href="`/berita/${featuredArticle.slug}`"
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-teal-800 text-white text-xs font-bold hover:bg-teal-900 transition-colors shadow-xs mt-4"
                            >
                                <span>Baca Liputan</span>
                                <ArrowRight class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" />
                            </Link>
                        </div>
                    </article>

                    <!-- Right: Catatan Redaksi / Top Stories (5 cols) -->
                    <div class="lg:col-span-5 flex flex-col justify-between space-y-4">
                        <div class="bg-gradient-to-br from-slate-900 to-teal-950 text-white p-6 rounded-3xl space-y-4 shadow-sm">
                            <div class="flex items-center justify-between border-b border-white/10 pb-3">
                                <div class="flex items-center gap-2">
                                    <Sparkles class="w-4 h-4 text-amber-300" />
                                    <h3 class="text-sm font-black uppercase tracking-wider text-amber-300">
                                        Pilihan Redaksi
                                    </h3>
                                </div>
                                <span class="text-[10px] text-slate-400">Paling Banyak Disorot</span>
                            </div>

                            <div class="space-y-4">
                                <div
                                    v-for="(pop, idx) in popularArticles"
                                    :key="pop.id"
                                    class="group/item flex items-start gap-3.5 pb-3 border-b border-white/10 last:border-0 last:pb-0"
                                >
                                    <span class="text-xl font-black text-teal-400/60 group-hover/item:text-amber-300 transition-colors font-mono">
                                        0{{ idx + 1 }}
                                    </span>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-[10px] font-bold text-teal-300 uppercase tracking-wider">
                                                {{ pop.category_name }}
                                            </span>
                                            <span class="text-[10px] text-slate-400">•</span>
                                            <span class="text-[10px] text-slate-400">{{ pop.published_at }}</span>
                                        </div>
                                        <Link :href="`/berita/${pop.slug}`" class="block">
                                            <h4 class="text-xs sm:text-sm font-bold text-white group-hover/item:text-teal-200 transition-colors leading-snug line-clamp-2">
                                                {{ pop.title }}
                                            </h4>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mini Banner Satu Data & Inovasi Pringsewu -->
                        <div class="bg-amber-50 rounded-2xl p-5 border border-amber-200/80 flex items-center justify-between gap-3">
                            <div class="space-y-1">
                                <span class="text-[10px] font-bold text-amber-900 uppercase tracking-wider block">
                                    Ekosistem Inovasi Pringsewu
                                </span>
                                <p class="text-xs text-amber-800 leading-snug">
                                    Rekomendasikan gagasan inovasi atau pantau transparansi data daerah.
                                </p>
                            </div>
                            <Link
                                href="/layanan"
                                class="shrink-0 px-3 py-1.5 rounded-lg bg-amber-900 text-white text-[11px] font-bold hover:bg-amber-950 transition-colors"
                            >
                                Partisipasi
                            </Link>
                        </div>
                    </div>
                </div>
            </section>

            <!-- SECTION 2: EDITORIAL MAGAZINE GRID -->
            <section class="space-y-6">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-5 bg-teal-700 rounded-full" />
                        <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">
                            Warta & Artikel Publikasi
                        </h2>
                    </div>
                    <span class="text-xs text-slate-500">
                        Menampilkan halaman {{ articles.current_page }} dari {{ articles.last_page }}
                    </span>
                </div>

                <!-- Articles Grid -->
                <div v-if="articles.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <article
                        v-for="art in articles.data"
                        :key="art.id"
                        class="bg-white rounded-2xl border border-slate-200/80 shadow-2xs hover:shadow-lg transition-all duration-200 flex flex-col justify-between overflow-hidden group"
                    >
                        <div class="p-6 space-y-3.5">
                            <!-- Category Badge & Reading Time -->
                            <div class="flex items-center justify-between gap-2">
                                <span
                                    class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border"
                                    :class="getCategoryColor(art.category_code)"
                                >
                                    {{ art.category_name }}
                                </span>
                                <span class="text-[11px] text-slate-400 flex items-center gap-1 font-medium">
                                    <Clock class="w-3 h-3" />
                                    {{ art.reading_time }}
                                </span>
                            </div>

                            <!-- Title -->
                            <Link :href="`/berita/${art.slug}`" class="block">
                                <h3 class="text-base font-black text-slate-900 group-hover:text-teal-800 transition-colors leading-snug line-clamp-2">
                                    {{ art.title }}
                                </h3>
                            </Link>

                            <!-- Excerpt -->
                            <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                                {{ art.excerpt }}
                            </p>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between text-xs text-slate-500">
                            <div class="flex items-center gap-1.5">
                                <Calendar class="w-3.5 h-3.5 text-slate-400" />
                                <span>{{ art.published_at }}</span>
                            </div>
                            <Link
                                :href="`/berita/${art.slug}`"
                                class="font-bold text-teal-800 hover:text-teal-950 flex items-center gap-1 group/btn"
                            >
                                <span>Baca</span>
                                <ArrowRight class="w-3 h-3 group-hover/btn:translate-x-0.5 transition-transform" />
                            </Link>
                        </div>
                    </article>
                </div>

                <!-- Empty State -->
                <div v-else class="bg-white rounded-3xl p-12 text-center border border-slate-200/80 space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center mx-auto">
                        <Search class="w-6 h-6" />
                    </div>
                    <h3 class="text-base font-bold text-slate-900">
                        Tidak Ada Artikel Ditemukan
                    </h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto">
                        Belum ada warta berita yang sesuai dengan kata kunci pencarian. Silakan coba kata kunci lain atau reset filter.
                    </p>
                    <button
                        type="button"
                        class="px-4 py-2 rounded-xl bg-teal-800 text-white text-xs font-bold hover:bg-teal-900 transition-colors"
                        @click="resetSearch"
                    >
                        Tampilkan Semua Berita
                    </button>
                </div>

                <!-- Pagination -->
                <div v-if="articles.links && articles.links.length > 3" class="pt-6 flex justify-center">
                    <nav class="inline-flex items-center gap-1 bg-white p-1.5 rounded-2xl border border-slate-200 shadow-2xs">
                        <template v-for="(link, i) in articles.links" :key="i">
                            <span
                                v-if="!link.url"
                                class="px-3.5 py-1.5 text-xs text-slate-400 rounded-xl cursor-not-allowed select-none"
                                v-html="link.label"
                            />
                            <Link
                                v-else
                                :href="link.url"
                                class="px-3.5 py-1.5 text-xs rounded-xl font-bold transition-all"
                                :class="link.active ? 'bg-teal-800 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100'"
                                v-html="link.label"
                            />
                        </template>
                    </nav>
                </div>
            </section>
        </main>
    </PublicLayout>
</template>
