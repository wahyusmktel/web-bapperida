<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    FileText,
    Download,
    Eye,
    Search,
    Calendar,
    Filter,
    Layers,
    Sparkles,
    ChevronRight,
    TrendingUp,
    ShieldCheck,
    CheckCircle2,
    X,
    ExternalLink,
    Clock
} from 'lucide-vue-next';

export interface ReportItem {
    id: string;
    title: string;
    slug: string;
    year: number;
    document_number: string;
    description: string;
    file_name: string;
    file_size: string;
    downloads_count: number;
    published_at: string;
}

export interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

export interface IndexMetric {
    name: string;
    code: string;
    year: number;
    score: string;
    predicate: string;
    evaluator: string;
    description?: string;
}

export interface Props {
    reports: {
        data: ReportItem[];
        links: PaginationLink[];
        total: number;
        current_page: number;
        last_page: number;
    };
    years: number[];
    indexMetric?: IndexMetric | null;
    meta: {
        title: string;
        subtitle: string;
        description: string;
        badge: string;
        category_slug: string;
    };
    filters: {
        search?: string;
        year?: number;
    };
    baseUrl: string;
}

const props = defineProps<Props>();

const search = ref(props.filters.search || '');
const selectedYear = ref(props.filters.year ? String(props.filters.year) : '');

const selectedReportPreview = ref<ReportItem | null>(null);

const applyFilters = () => {
    router.get(
        props.baseUrl,
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

const openPreview = (rep: ReportItem) => {
    selectedReportPreview.value = rep;
};

const closePreview = () => {
    selectedReportPreview.value = null;
};
</script>

<template>
    <Head :title="`${meta.title} - BAPPERIDA Pringsewu`" />

    <PublicLayout>
        <!-- Hero Header -->
        <section class="relative overflow-hidden bg-slate-950 text-white py-16 sm:py-20 px-4 sm:px-8 border-b border-teal-900/40">
            <!-- Background AI Image -->
            <div class="absolute inset-0 z-0 opacity-25 mix-blend-luminosity">
                <img
                    src="/images/pringsewu_magazine_bg.jpg"
                    alt="Background Pringsewu"
                    class="w-full h-full object-cover object-center"
                />
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/90 to-teal-950/80" />

            <div class="relative z-10 max-w-7xl mx-auto space-y-6">
                <!-- Breadcrumbs -->
                <div class="flex items-center gap-2 text-xs text-teal-300/80 font-medium">
                    <Link href="/" class="hover:text-white transition-colors">Beranda</Link>
                    <ChevronRight class="w-3.5 h-3.5 text-teal-500" />
                    <span>Laporan Daerah</span>
                    <ChevronRight class="w-3.5 h-3.5 text-teal-500" />
                    <span class="text-white font-semibold">{{ meta.badge }}</span>
                </div>

                <div class="max-w-3xl space-y-3">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-500/20 text-xs font-semibold text-teal-300 border border-teal-400/30 backdrop-blur-md">
                        <Sparkles class="w-3.5 h-3.5 text-amber-300" />
                        <span>{{ meta.badge }}</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-white leading-tight">
                        {{ meta.title }}
                    </h1>

                    <p class="text-sm sm:text-base text-slate-300 leading-relaxed font-normal max-w-2xl">
                        {{ meta.description }}
                    </p>
                </div>

                <!-- Submenu Quick Switcher Tabs -->
                <div class="pt-4 flex flex-wrap items-center gap-2">
                    <Link
                        href="/laporan/iid"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all"
                        :class="meta.category_slug === 'iid'
                            ? 'bg-amber-400 text-slate-950 shadow-md shadow-amber-400/20'
                            : 'bg-white/10 text-white hover:bg-white/20 border border-white/10'"
                    >
                        Indeks Inovasi Daerah (IID)
                    </Link>
                    <Link
                        href="/laporan/idsd"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all"
                        :class="meta.category_slug === 'idsd'
                            ? 'bg-amber-400 text-slate-950 shadow-md shadow-amber-400/20'
                            : 'bg-white/10 text-white hover:bg-white/20 border border-white/10'"
                    >
                        Indeks Daya Saing Daerah (IDSD)
                    </Link>
                    <Link
                        href="/laporan/ipkd"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all"
                        :class="meta.category_slug === 'ipkd'
                            ? 'bg-amber-400 text-slate-950 shadow-md shadow-amber-400/20'
                            : 'bg-white/10 text-white hover:bg-white/20 border border-white/10'"
                    >
                        Pengelolaan Keuangan (IPKD)
                    </Link>
                    <Link
                        href="/laporan/lakip"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all"
                        :class="meta.category_slug === 'lakip'
                            ? 'bg-amber-400 text-slate-950 shadow-md shadow-amber-400/20'
                            : 'bg-white/10 text-white hover:bg-white/20 border border-white/10'"
                    >
                        LAKIP / SAKIP
                    </Link>
                </div>
            </div>
        </section>

        <!-- Main Content Area -->
        <main class="py-12 px-4 sm:px-8 max-w-7xl mx-auto w-full space-y-8">
            <!-- Metric Highlight Card (if exists) -->
            <div
                v-if="indexMetric"
                class="bg-gradient-to-r from-teal-900 to-slate-900 text-white rounded-3xl p-6 sm:p-8 border border-teal-800 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-6"
            >
                <div class="space-y-2 max-w-2xl">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-teal-500/30 text-teal-200 border border-teal-400/30">
                            Capaian Skor Resmi {{ indexMetric.year }}
                        </span>
                        <span class="text-xs text-slate-400">Penilai: {{ indexMetric.evaluator }}</span>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-black tracking-tight text-white">
                        {{ indexMetric.name }}
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-normal">
                        {{ indexMetric.description }}
                    </p>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/15 shrink-0 text-center min-w-[180px]">
                    <span class="text-xs text-teal-300 font-semibold block">Skor Kinerja</span>
                    <span class="text-4xl sm:text-5xl font-black text-amber-300 block py-1 font-mono">
                        {{ indexMetric.score }}
                    </span>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-teal-500/30 text-teal-100 border border-teal-400/40">
                        {{ indexMetric.predicate }}
                    </span>
                </div>
            </div>

            <!-- Search & Year Filter Toolbar -->
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="relative flex-1 w-full">
                    <Search class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Cari judul laporan, nomor dokumen, atau kata kunci ringkasan..."
                        class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all"
                        @keyup.enter="applyFilters"
                    />
                    <button
                        v-if="search"
                        type="button"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 hover:text-slate-600 cursor-pointer"
                        @click="search = ''; applyFilters()"
                    >
                        Reset
                    </button>
                </div>

                <div class="flex items-center gap-3 w-full md:w-auto shrink-0 justify-between md:justify-end">
                    <!-- Year Filter Select -->
                    <select
                        v-model="selectedYear"
                        class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-teal-500 cursor-pointer"
                        @change="applyFilters"
                    >
                        <option value="">Semua Tahun Laporan</option>
                        <option v-for="yr in years" :key="yr" :value="String(yr)">
                            Tahun {{ yr }}
                        </option>
                    </select>

                    <button
                        type="button"
                        class="px-4 py-2.5 rounded-xl bg-teal-800 text-white text-xs font-bold hover:bg-teal-900 transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                        @click="applyFilters"
                    >
                        <Filter class="w-3.5 h-3.5" />
                        <span>Filter</span>
                    </button>

                    <button
                        v-if="search || selectedYear"
                        type="button"
                        class="px-3 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors cursor-pointer"
                        @click="resetFilters"
                    >
                        Reset
                    </button>
                </div>
            </div>

            <!-- REPORT LIST VIEW (Bentuk List Sesuai Permintaan) -->
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-5 bg-teal-700 rounded-full" />
                        <h2 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">
                            Daftar Berkas Laporan Resmi (Format List)
                        </h2>
                    </div>
                    <span class="text-xs text-slate-500 font-medium">
                        Total: <strong class="text-slate-800">{{ reports.total }}</strong> dokumen
                    </span>
                </div>

                <!-- Report Items List -->
                <div v-if="reports.data.length > 0" class="space-y-3">
                    <div
                        v-for="rep in reports.data"
                        :key="rep.id"
                        class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/90 shadow-2xs hover:shadow-md hover:border-teal-700/40 transition-all flex flex-col md:flex-row items-start md:items-center justify-between gap-5 group"
                    >
                        <!-- Left Details -->
                        <div class="flex items-start gap-4 flex-1">
                            <!-- Document Icon with Year Badge -->
                            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-800 border border-teal-200 flex flex-col items-center justify-center shrink-0 group-hover:scale-105 transition-transform mt-0.5">
                                <FileText class="w-5 h-5 text-teal-700" />
                                <span class="text-[9px] font-bold font-mono text-teal-900 leading-none mt-0.5">
                                    {{ rep.year }}
                                </span>
                            </div>

                            <div class="space-y-1.5 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-teal-100 text-teal-900">
                                        Tahun {{ rep.year }}
                                    </span>
                                    <span class="text-xs font-mono text-slate-400">
                                        {{ rep.document_number }}
                                    </span>
                                    <span class="text-slate-300">•</span>
                                    <span class="text-xs text-slate-400 flex items-center gap-1">
                                        <Calendar class="w-3 h-3" /> {{ rep.published_at }}
                                    </span>
                                </div>

                                <h3 class="text-base font-black text-slate-900 group-hover:text-teal-800 transition-colors leading-snug">
                                    {{ rep.title }}
                                </h3>

                                <p class="text-xs text-slate-600 leading-relaxed line-clamp-2 max-w-3xl">
                                    {{ rep.description }}
                                </p>

                                <div class="flex items-center gap-4 text-[11px] text-slate-400 pt-1 font-medium">
                                    <span>Ukuran Berkas: <strong class="text-slate-600">{{ rep.file_size }}</strong></span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1">
                                        <Download class="w-3 h-3 text-slate-400" />
                                        {{ rep.downloads_count }} kali diunduh
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Action Buttons (Lihat & Unduh) -->
                        <div class="flex items-center gap-2.5 shrink-0 self-end md:self-center pt-2 md:pt-0 w-full md:w-auto justify-end border-t md:border-t-0 border-slate-100">
                            <!-- View / Preview Modal Button -->
                            <button
                                type="button"
                                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-teal-50 hover:text-teal-900 hover:border-teal-300 border border-slate-200 transition-all cursor-pointer"
                                @click="openPreview(rep)"
                            >
                                <Eye class="w-3.5 h-3.5 text-slate-500 group-hover:text-teal-800" />
                                <span>Lihat Detail</span>
                            </button>

                            <!-- Download Button -->
                            <a
                                :href="`/dokumen/${rep.slug}/unduh`"
                                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-teal-800 hover:bg-teal-900 active:scale-[0.98] transition-all shadow-xs"
                            >
                                <Download class="w-3.5 h-3.5" />
                                <span>Unduh PDF</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div v-else class="bg-white rounded-3xl p-12 text-center border border-slate-200/80 space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center mx-auto">
                        <FileText class="w-6 h-6" />
                    </div>
                    <h3 class="text-base font-bold text-slate-900">
                        Tidak Ada Laporan Ditemukan
                    </h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto">
                        Dokumen laporan yang Anda cari tidak ditemukan. Silakan gunakan kata kunci lain atau pilih tahun berbeda.
                    </p>
                    <button
                        type="button"
                        class="px-4 py-2 rounded-xl bg-teal-800 text-white text-xs font-bold hover:bg-teal-900 transition-colors cursor-pointer"
                        @click="resetFilters"
                    >
                        Tampilkan Seluruh Laporan
                    </button>
                </div>

                <!-- Pagination -->
                <div v-if="reports.links && reports.links.length > 3" class="pt-6 flex justify-center">
                    <nav class="inline-flex items-center gap-1 bg-white p-1.5 rounded-2xl border border-slate-200 shadow-2xs">
                        <template v-for="(link, i) in reports.links" :key="i">
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
            </div>
        </main>

        <!-- Preview Modal for Report Details -->
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div
                v-if="selectedReportPreview"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-slate-950/80 backdrop-blur-sm"
                @click.self="closePreview"
            >
                <div class="bg-white rounded-3xl max-w-2xl w-full overflow-hidden shadow-2xl border border-slate-200 flex flex-col max-h-[90vh]">
                    <!-- Modal Header -->
                    <div class="p-5 bg-teal-900 text-white flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-teal-800 text-white flex items-center justify-center font-bold">
                                <FileText class="w-4 h-4 text-teal-200" />
                            </div>
                            <div>
                                <span class="text-[11px] text-teal-300 font-bold uppercase tracking-wider block">
                                    Pratinjau Dokumen • Tahun {{ selectedReportPreview.year }}
                                </span>
                                <h4 class="text-sm font-bold text-white line-clamp-1">
                                    {{ selectedReportPreview.title }}
                                </h4>
                            </div>
                        </div>

                        <button
                            type="button"
                            class="p-1.5 rounded-lg text-slate-300 hover:text-white hover:bg-white/10 transition-colors cursor-pointer"
                            @click="closePreview"
                        >
                            <X class="w-5 h-5" />
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 overflow-y-auto space-y-5">
                        <div class="p-4 rounded-2xl bg-teal-50 border border-teal-200/80 space-y-2">
                            <span class="text-[11px] font-bold text-teal-800 uppercase tracking-wider block">
                                Identitas Dokumen
                            </span>
                            <div class="grid grid-cols-2 gap-3 text-xs">
                                <div>
                                    <span class="text-slate-500 block">Nomor Regulasi / Dokumen:</span>
                                    <strong class="text-slate-800 font-mono">{{ selectedReportPreview.document_number }}</strong>
                                </div>
                                <div>
                                    <span class="text-slate-500 block">Tahun Penetapan:</span>
                                    <strong class="text-slate-800">{{ selectedReportPreview.year }}</strong>
                                </div>
                                <div>
                                    <span class="text-slate-500 block">Ukuran Berkas:</span>
                                    <strong class="text-slate-800">{{ selectedReportPreview.file_size }}</strong>
                                </div>
                                <div>
                                    <span class="text-slate-500 block">Tanggal Rilis:</span>
                                    <strong class="text-slate-800">{{ selectedReportPreview.published_at }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <h4 class="text-sm font-bold text-slate-900">
                                Ringkasan Eksekutif & Abstrak Laporan:
                            </h4>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-2xl border border-slate-200">
                                {{ selectedReportPreview.description }}
                            </p>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-500 flex items-center gap-2">
                            <ShieldCheck class="w-4 h-4 text-emerald-600 shrink-0" />
                            <span>Dokumen ini merupakan publikasi data resmi Pemerintah Kabupaten Pringsewu yang telah diverifikasi.</span>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="p-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
                        <button
                            type="button"
                            class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-200/60 transition-colors cursor-pointer"
                            @click="closePreview"
                        >
                            Tutup
                        </button>

                        <a
                            :href="`/dokumen/${selectedReportPreview.slug}/unduh`"
                            class="inline-flex items-center gap-1.5 px-5 py-2 rounded-xl bg-teal-800 text-white text-xs font-bold hover:bg-teal-900 transition-colors shadow-xs"
                        >
                            <Download class="w-3.5 h-3.5" />
                            <span>Unduh Dokumen Lengkap</span>
                        </a>
                    </div>
                </div>
            </div>
        </Transition>
    </PublicLayout>
</template>
