<script setup lang="ts">
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { notify } from '@/lib/toast';
import {
    FileText,
    Search,
    Download,
    Calendar,
    ChevronRight,
    Sparkles,
    Tag,
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
    file_name: string | null;
    file_size: string;
    downloads_count: number;
    published_at: string;
}

interface CategoryItem {
    id: string;
    name: string;
    slug: string;
}

interface Props {
    documents: {
        data: DocumentItem[];
        links: any[];
        total: number;
    };
    categories: CategoryItem[];
    years: number[];
    filters: {
        search?: string;
        category?: string;
        year?: string;
    };
}

const props = defineProps<Props>();

const search = ref(props.filters.search || '');
const selectedCategory = ref(props.filters.category || '');
const selectedYear = ref(props.filters.year || '');

watch([search, selectedCategory, selectedYear], () => {
    router.get(
        '/dokumen',
        {
            search: search.value || undefined,
            category: selectedCategory.value || undefined,
            year: selectedYear.value || undefined,
        },
        { preserveState: true, replace: true }
    );
});

const onDownloadClick = (doc: DocumentItem) => {
    notify.info('Mengunduh Berkas', `Sedang mengunduh dokumen ${doc.title}...`);
};
</script>

<template>
    <Head title="Dokumen Perencanaan & Riset Publik - BAPPERIDA Pringsewu" />

    <PublicLayout>
        <!-- Page Header -->
        <section class="bg-linear-to-b from-teal-900 via-teal-800 to-slate-900 text-white py-14 px-4 sm:px-8 relative overflow-hidden">
            <div class="max-w-7xl mx-auto space-y-3 relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-xs text-teal-200">
                    <Sparkles class="w-3.5 h-3.5" />
                    <span>Transparansi Kebijakan Daerah</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                    Repositori Dokumen Perencanaan & Riset
                </h1>
                <p class="text-xs sm:text-sm text-teal-100/80 max-w-2xl leading-relaxed">
                    Unduh dokumen induk perencanaan pembangunan (RPJPD, RPJMD, RKPD, Renstra, Renja), dokumen kajian akademis, dan analisis strategis Kabupaten Pringsewu secara terbuka.
                </p>
            </div>
        </section>

        <!-- Search & Filter Controls -->
        <section class="py-8 bg-white border-b border-slate-200/60 sticky top-16 z-30 shadow-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 flex flex-col md:flex-row gap-4 items-center justify-between">
                <!-- Search -->
                <div class="relative w-full md:w-96">
                    <Search class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Cari judul dokumen, regulasi..."
                        class="w-full pl-9 pr-4 py-2.5 rounded-2xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none transition-all"
                    />
                </div>

                <!-- Filters -->
                <div class="flex items-center gap-2.5 w-full md:w-auto">
                    <select
                        v-model="selectedCategory"
                        class="px-3.5 py-2.5 rounded-2xl text-xs bg-slate-50 border border-slate-200 text-slate-700 outline-none focus:border-teal-700 font-medium"
                    >
                        <option value="">Semua Kategori Dokumen</option>
                        <option v-for="cat in categories" :key="cat.id" :value="cat.slug">
                            {{ cat.name }}
                        </option>
                    </select>

                    <select
                        v-model="selectedYear"
                        class="px-3.5 py-2.5 rounded-2xl text-xs bg-slate-50 border border-slate-200 text-slate-700 outline-none focus:border-teal-700 font-medium"
                    >
                        <option value="">Semua Tahun</option>
                        <option v-for="yr in years" :key="yr" :value="yr">
                            {{ yr }}
                        </option>
                    </select>
                </div>
            </div>
        </section>

        <!-- Documents List -->
        <section class="py-12 bg-slate-50 min-h-[500px]">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-6">
                <div class="text-xs text-slate-500 flex items-center justify-between">
                    <span>Menampilkan <strong>{{ documents.data.length }}</strong> dari <strong>{{ documents.total }}</strong> dokumen resmi</span>
                </div>

                <div v-if="documents.data.length === 0" class="bg-white rounded-3xl p-16 text-center text-slate-400 border border-slate-200/80">
                    Tidak ada dokumen perencanaan yang sesuai dengan filter pencarian Anda.
                </div>

                <!-- Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="doc in documents.data"
                        :key="doc.id"
                        class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md hover:border-teal-600/40 transition-all flex flex-col justify-between"
                    >
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-bold px-2.5 py-1 rounded-md bg-teal-50 text-teal-800 border border-teal-200/60">
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

                            <p v-if="doc.description" class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                {{ doc.description }}
                            </p>
                        </div>

                        <div class="pt-4 mt-6 border-t border-slate-100 flex items-center justify-between">
                            <div class="text-[11px] text-slate-400">
                                <span>{{ doc.file_size }}</span> • <span>{{ doc.downloads_count }}x diunduh</span>
                            </div>

                            <a
                                :href="`/dokumen/${doc.slug}/unduh`"
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-teal-800 bg-teal-50 hover:bg-teal-800 hover:text-white border border-teal-200/80 transition-all"
                                @click="onDownloadClick(doc)"
                            >
                                <Download class="w-3.5 h-3.5" />
                                Unduh
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
