<script setup lang="ts">
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    FileText,
    Download,
    Search,
    Calendar,
    ChevronRight,
    ArrowRight,
    Sparkles,
    Filter,
    Layers,
    BookOpen,
    BarChart3,
    CheckCircle2,
    ShieldCheck
} from 'lucide-vue-next';

interface DocumentItem {
    id: string;
    title: string;
    slug: string;
    category_name: string;
    category_slug: string;
    year: number;
    document_number: string;
    description: string;
    file_name: string;
    file_size: string;
    downloads_count: number;
    published_at: string;
}

interface PaginationLinks {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginatedDocuments {
    data: DocumentItem[];
    links: PaginationLinks[];
    current_page: number;
    last_page: number;
    total: number;
}

interface Props {
    documents: PaginatedDocuments;
    years: number[];
    meta: {
        title: string;
        description: string;
        badge: string;
        category_slug: string;
    };
    filters: {
        search?: string;
        year?: number;
    };
}

const props = defineProps<Props>();

const search = ref(props.filters.search || '');
const selectedYear = ref(props.filters.year || '');

// Interactive mouse position for abstract mesh background reaction
const mouseX = ref(0);
const mouseY = ref(0);

const handleMouseMove = (e: MouseEvent) => {
    const { clientX, clientY } = e;
    const { innerWidth, innerHeight } = window;
    mouseX.value = Math.round((clientX / innerWidth) * 30 - 15);
    mouseY.value = Math.round((clientY / innerHeight) * 30 - 15);
};

const applyFilters = () => {
    router.get(
        '/dokumen/kajian',
        {
            search: search.value || undefined,
            year: selectedYear.value || undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
};

const resetFilters = () => {
    search.value = '';
    selectedYear.value = '';
    applyFilters();
};

watch([selectedYear], () => {
    applyFilters();
});
</script>

<template>
    <Head :title="meta.title + ' - BAPPERIDA Kabupaten Pringsewu'" />

    <PublicLayout>
        <!-- Breadcrumb Bar -->
        <div class="bg-slate-100/80 border-b border-slate-200/80 py-2.5 px-4 sm:px-8 relative z-20">
            <div class="max-w-7xl mx-auto flex items-center gap-2 text-xs text-slate-600">
                <Link href="/" class="hover:text-teal-800 transition-colors">Beranda</Link>
                <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                <span class="text-slate-400">Dokumen</span>
                <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                <span class="font-semibold text-teal-800">{{ meta.title }}</span>
            </div>
        </div>

        <!-- HERO BANNER DENGAN BACKGROUND ABSTRAK KHAS PRINGSEWU -->
        <section
            @mousemove="handleMouseMove"
            class="relative bg-gradient-to-r from-teal-950 via-teal-900 to-slate-950 text-white py-16 sm:py-24 px-4 sm:px-8 overflow-hidden min-h-[360px] flex items-center"
        >
            <!-- ORNAMEN ABSTRAK KHAS PRINGSEWU & LAMPUNG (SERIBU BAMBU & MOTIF TAPIS SIGER) -->
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <!-- 1. Siluet Geometris Batang Bambu Abstrak Khas Pringsewu -->
                <svg
                    class="absolute -right-16 -bottom-24 w-[500px] h-[500px] opacity-15 text-emerald-400 transition-transform duration-700 ease-out"
                    :style="{ transform: `translate(${mouseX * -1.5}px, ${mouseY * -1.5}px)` }"
                    viewBox="0 0 400 400"
                    fill="none"
                    stroke="currentColor"
                >
                    <!-- Batang Bambu Pringsewu Geometris -->
                    <rect x="40" y="20" width="24" height="360" rx="6" stroke-width="2" />
                    <line x1="40" y1="120" x2="64" y2="120" stroke-width="3" />
                    <line x1="40" y1="220" x2="64" y2="220" stroke-width="3" />
                    <line x1="40" y1="310" x2="64" y2="310" stroke-width="3" />

                    <rect x="90" y="60" width="30" height="340" rx="8" stroke-width="2.5" />
                    <line x1="90" y1="150" x2="120" y2="150" stroke-width="4" />
                    <line x1="90" y1="260" x2="120" y2="260" stroke-width="4" />

                    <rect x="150" y="10" width="20" height="380" rx="6" stroke-width="2" />
                    <line x1="150" y1="110" x2="170" y2="110" stroke-width="3" />
                    <line x1="150" y1="210" x2="170" y2="210" stroke-width="3" />
                    <line x1="150" y1="300" x2="170" y2="300" stroke-width="3" />

                    <rect x="200" y="40" width="36" height="360" rx="9" stroke-width="3" />
                    <line x1="200" y1="140" x2="236" y2="140" stroke-width="5" />
                    <line x1="200" y1="250" x2="236" y2="250" stroke-width="5" />

                    <!-- Daun Bambu Abstrak Melengkung -->
                    <path d="M64 120 C90 100 130 110 160 90" stroke-width="2" />
                    <path d="M120 150 C160 130 200 140 240 110" stroke-width="2.5" />
                    <path d="M170 210 C210 190 250 200 290 170" stroke-width="2" />
                </svg>

                <!-- 2. Ornamen Geometris Pucuk Rebung Tapis Lampung Abstrak -->
                <svg
                    class="absolute -left-12 -top-12 w-80 h-80 opacity-20 text-amber-400 transition-transform duration-500 ease-out"
                    :style="{ transform: `translate(${mouseX * 1.2}px, ${mouseY * 1.2}px)` }"
                    viewBox="0 0 200 200"
                    fill="currentColor"
                >
                    <polygon points="100,10 120,50 80,50" />
                    <polygon points="100,45 135,95 65,95" opacity="0.8" />
                    <polygon points="100,90 150,150 50,150" opacity="0.6" />
                    <polygon points="100,140 170,210 30,210" opacity="0.4" />
                </svg>

                <!-- 3. Mesh Glow Bulatan Gradasi Dinamis -->
                <div
                    class="absolute top-1/4 left-1/3 w-96 h-96 bg-teal-500/15 rounded-full blur-3xl transition-transform duration-1000 ease-out"
                    :style="{ transform: `translate(${mouseX * 2}px, ${mouseY * 2}px)` }"
                ></div>
                <div
                    class="absolute bottom-10 right-1/4 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl transition-transform duration-700 ease-out"
                    :style="{ transform: `translate(${mouseX * -1}px, ${mouseY * -1}px)` }"
                ></div>

                <!-- Pattern Titik-Titik Halus -->
                <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#00C096_1px,transparent_1px)] [background-size:24px_24px]"></div>
            </div>

            <!-- Content Header -->
            <div class="relative z-10 max-w-7xl mx-auto w-full space-y-4">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-500/20 border border-teal-400/30 text-xs font-semibold text-teal-200 backdrop-blur-md">
                    <component :is="Sparkles" class="w-3.5 h-3.5 text-teal-300" />
                    <span>{{ meta.badge }}</span>
                </div>
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white max-w-4xl leading-tight">
                    {{ meta.title }}
                </h1>
                <p class="text-sm sm:text-base text-teal-100/90 max-w-3xl leading-relaxed">
                    {{ meta.description }}
                </p>

                <!-- Quick Link Pills untuk Kemudahan Navigasi -->
                <div class="pt-4 flex flex-wrap items-center gap-2">
                    <Link
                        href="/dokumen/perencanaan"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all"
                        :class="meta.category_slug === 'dokumen-perencanaan'
                            ? 'bg-amber-400 text-slate-950 shadow-md shadow-amber-400/20'
                            : 'bg-white/10 text-white hover:bg-white/20 border border-white/10'"
                    >
                        Dokumen Perencanaan
                    </Link>
                    <Link
                        href="/dokumen/kajian"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all"
                        :class="meta.category_slug === 'dokumen-kajian'
                            ? 'bg-amber-400 text-slate-950 shadow-md shadow-amber-400/20'
                            : 'bg-white/10 text-white hover:bg-white/20 border border-white/10'"
                    >
                        Dokumen Kajian
                    </Link>
                    <Link
                        href="/dokumen/analisis"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all"
                        :class="meta.category_slug === 'dokumen-analisis'
                            ? 'bg-amber-400 text-slate-950 shadow-md shadow-amber-400/20'
                            : 'bg-white/10 text-white hover:bg-white/20 border border-white/10'"
                    >
                        Dokumen Analisis
                    </Link>
                </div>
            </div>
        </section>

        <!-- Main Content Area -->
        <main class="py-12 sm:py-16 bg-slate-50/60 relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-10">

                <!-- Filter & Search Toolbar -->
                <div class="p-6 rounded-3xl bg-white border border-slate-200/90 shadow-md flex flex-col md:flex-row items-center justify-between gap-4">
                    <!-- Search Box -->
                    <form @submit.prevent="applyFilters" class="relative w-full md:w-96">
                        <Search class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" />
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Cari judul, nomor SK, atau kata kunci..."
                            class="w-full pl-10 pr-4 py-2.5 text-xs rounded-2xl border border-slate-200 focus:outline-hidden focus:border-teal-500 focus:ring-1 focus:ring-teal-500 bg-slate-50/80"
                        />
                    </form>

                    <!-- Filter Year & Reset -->
                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <div class="flex items-center gap-2">
                            <Filter class="w-3.5 h-3.5 text-slate-400" />
                            <select
                                v-model="selectedYear"
                                class="text-xs py-2 px-3 rounded-xl border border-slate-200 bg-slate-50 focus:outline-hidden focus:border-teal-500 text-slate-700 font-medium"
                            >
                                <option value="">Semua Tahun</option>
                                <option v-for="y in years" :key="y" :value="y">{{ y }}</option>
                            </select>
                        </div>

                        <button
                            v-if="search || selectedYear"
                            @click="resetFilters"
                            class="text-xs text-rose-600 hover:text-rose-700 font-semibold px-2 py-1 cursor-pointer"
                        >
                            Reset
                        </button>

                        <div class="text-xs text-slate-400 font-mono hidden sm:block">
                            Total: <strong>{{ documents.total }}</strong> dokumen
                        </div>
                    </div>
                </div>

                <!-- Document Cards Grid -->
                <div v-if="documents.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="doc in documents.data"
                        :key="doc.id"
                        class="rounded-3xl bg-white border border-slate-200/90 shadow-xs hover:shadow-xl hover:border-teal-400 transition-all duration-300 p-6 flex flex-col justify-between group"
                    >
                        <div class="space-y-4">
                            <!-- Category Badge & Year -->
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full bg-teal-50 text-teal-800 uppercase tracking-wider">
                                    {{ doc.category_name }}
                                </span>
                                <span class="flex items-center gap-1 text-xs font-mono font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-lg">
                                    <Calendar class="w-3 h-3 text-slate-400" />
                                    {{ doc.year }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="text-sm font-black text-slate-900 group-hover:text-teal-800 transition-colors leading-snug">
                                {{ doc.title }}
                            </h3>

                            <!-- Description -->
                            <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                {{ doc.description }}
                            </p>

                            <!-- Document Number / Meta -->
                            <div class="pt-2 border-t border-slate-100 text-[11px] text-slate-500 space-y-1">
                                <div class="flex justify-between">
                                    <span>Nomor Regulasi:</span>
                                    <span class="font-semibold text-slate-800">{{ doc.document_number }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Ukuran Berkas:</span>
                                    <span class="font-mono">{{ doc.file_size }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Download Action Button -->
                        <div class="pt-5 mt-4 border-t border-slate-100 flex items-center justify-between">
                            <div class="text-[10px] text-slate-400">
                                <span>Diunduh {{ doc.downloads_count }}x</span>
                            </div>

                            <a
                                :href="`/dokumen/${doc.slug}/unduh`"
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-teal-800 hover:bg-teal-700 text-white text-xs font-bold shadow-xs shadow-teal-900/10 transition-transform active:scale-95 group-hover:bg-teal-900"
                            >
                                <Download class="w-3.5 h-3.5" />
                                <span>Unduh PDF</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="p-12 text-center bg-white rounded-3xl border border-slate-200 space-y-3">
                    <FileText class="w-12 h-12 text-slate-300 mx-auto" />
                    <h3 class="text-sm font-bold text-slate-800">Tidak ada dokumen yang sesuai</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto">
                        Coba gunakan kata kunci pencarian lain atau pilih tahun rilis yang berbeda.
                    </p>
                    <button
                        @click="resetFilters"
                        class="px-4 py-2 rounded-xl bg-teal-800 text-white text-xs font-bold hover:bg-teal-700 transition-colors cursor-pointer"
                    >
                        Tampilkan Semua Dokumen
                    </button>
                </div>

                <!-- Pagination Links -->
                <div v-if="documents.links.length > 3" class="flex justify-center items-center gap-1 pt-6">
                    <template v-for="(link, i) in documents.links" :key="i">
                        <Link
                            v-if="link.url"
                            :href="link.url"
                            class="px-3.5 py-2 rounded-xl text-xs font-semibold transition-all"
                            :class="link.active ? 'bg-teal-800 text-white' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'"
                            v-html="link.label"
                        />
                        <span
                            v-else
                            class="px-3 py-2 text-xs text-slate-400"
                            v-html="link.label"
                        />
                    </template>
                </div>

            </div>
        </main>
    </PublicLayout>
</template>
