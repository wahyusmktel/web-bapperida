<script setup lang="ts">
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    Newspaper,
    Search,
    Calendar,
    Eye,
    ArrowRight,
    Sparkles,
} from 'lucide-vue-next';

interface ArticleItem {
    id: string;
    title: string;
    slug: string;
    excerpt: string;
    category_name: string;
    category_code: string;
    category_slug: string;
    category_color: string;
    featured_image: string | null;
    published_at: string;
    views_count: number;
}

interface CategoryItem {
    id: string;
    name: string;
    code: string;
    slug: string;
    color: string;
}

interface Props {
    articles: {
        data: ArticleItem[];
        links: any[];
        total: number;
    };
    categories: CategoryItem[];
    filters: {
        search?: string;
        bidang?: string;
    };
}

const props = defineProps<Props>();

const search = ref(props.filters.search || '');
const selectedBidang = ref(props.filters.bidang || '');

watch([search, selectedBidang], () => {
    router.get(
        '/berita',
        {
            search: search.value || undefined,
            bidang: selectedBidang.value || undefined,
        },
        { preserveState: true, replace: true }
    );
});
</script>

<template>
    <Head title="Warta & Publikasi 6 Bidang - BAPPERIDA Pringsewu" />

    <PublicLayout>
        <!-- Page Header -->
        <section class="bg-linear-to-b from-teal-900 via-teal-800 to-slate-900 text-white py-14 px-4 sm:px-8">
            <div class="max-w-7xl mx-auto space-y-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-xs text-teal-200">
                    <Sparkles class="w-3.5 h-3.5" />
                    <span>Warta Resmi Pembangunan Daerah</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                    Publikasi & Berita 6 Bidang BAPPERIDA
                </h1>
                <p class="text-xs sm:text-sm text-teal-100/80 max-w-2xl leading-relaxed">
                    Informasi terpercaya seputar kegiatan perencanaan pembangunan, riset daerah, ekosistem inovasi, dan kemitraan strategis Kabupaten Pringsewu.
                </p>
            </div>
        </section>

        <!-- Bidang Filter Tabs & Search -->
        <section class="py-6 bg-white border-b border-slate-200/60 sticky top-16 z-30 shadow-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-4">
                <!-- Bidang Tabs -->
                <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs">
                    <button
                        type="button"
                        class="px-4 py-2 rounded-xl font-bold transition-all whitespace-nowrap cursor-pointer"
                        :class="selectedBidang === '' ? 'bg-teal-800 text-white shadow-xs' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200'"
                        @click="selectedBidang = ''"
                    >
                        Semua Bidang
                    </button>
                    <button
                        v-for="cat in categories"
                        :key="cat.id"
                        type="button"
                        class="px-4 py-2 rounded-xl font-bold transition-all whitespace-nowrap cursor-pointer"
                        :class="selectedBidang === cat.slug ? 'bg-teal-800 text-white shadow-xs' : 'bg-slate-50 text-slate-600 hover:bg-slate-100 border border-slate-200'"
                        @click="selectedBidang = cat.slug"
                    >
                        {{ cat.code }} • {{ cat.name }}
                    </button>
                </div>

                <!-- Search -->
                <div class="relative max-w-md">
                    <Search class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Cari artikel berita..."
                        class="w-full pl-9 pr-4 py-2 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none transition-all"
                    />
                </div>
            </div>
        </section>

        <!-- Articles Grid -->
        <section class="py-12 bg-slate-50 min-h-[500px]">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-6">
                <div v-if="articles.data.length === 0" class="bg-white rounded-3xl p-16 text-center text-slate-400 border border-slate-200/80">
                    Tidak ada artikel berita yang cocok dengan kriteria pencarian Anda.
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <article
                        v-for="art in articles.data"
                        :key="art.id"
                        class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group"
                    >
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold uppercase bg-teal-50 text-teal-800 border border-teal-200/60">
                                    {{ art.category_code }} • {{ art.category_name }}
                                </span>
                                <span class="text-[11px] text-slate-400 flex items-center gap-1">
                                    <Calendar class="w-3 h-3" /> {{ art.published_at }}
                                </span>
                            </div>

                            <h2 class="text-base font-bold text-slate-900 leading-snug group-hover:text-teal-800 transition-colors">
                                <Link :href="`/berita/${art.slug}`">
                                    {{ art.title }}
                                </Link>
                            </h2>

                            <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed">
                                {{ art.excerpt }}
                            </p>
                        </div>

                        <div class="pt-4 mt-6 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-[11px] text-slate-400 flex items-center gap-1">
                                <Eye class="w-3 h-3" /> {{ art.views_count }} pembaca
                            </span>

                            <Link
                                :href="`/berita/${art.slug}`"
                                class="inline-flex items-center gap-1 font-bold text-teal-800 hover:text-teal-900"
                            >
                                <span>Baca Rilis</span>
                                <ArrowRight class="w-3.5 h-3.5" />
                            </Link>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
