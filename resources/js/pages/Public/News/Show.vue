<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { notify } from '@/lib/toast';
import {
    Calendar,
    Eye,
    User,
    Share2,
    Copy,
    ChevronLeft,
    Sparkles,
    ArrowRight,
    Check,
} from 'lucide-vue-next';

interface Props {
    article: {
        id: string;
        title: string;
        slug: string;
        excerpt: string;
        content: string;
        category_name: string;
        category_code: string;
        author_name: string;
        featured_image: string | null;
        published_at: string;
        views_count: number;
    };
    relatedArticles: Array<{
        id: string;
        title: string;
        slug: string;
        excerpt: string;
        category_name: string;
        category_code: string;
        published_at: string;
    }>;
}

const props = defineProps<Props>();

const copyArticleLink = () => {
    navigator.clipboard.writeText(window.location.href);
    notify.success('Tautan Disalin', 'Tautan rilis berita berhasil disalin ke clipboard.');
};

const shareToWhatsapp = () => {
    const text = encodeURIComponent(`${props.article.title} - Baca selengkapnya di Portal Resmi BAPPERIDA Pringsewu: ${window.location.href}`);
    window.open(`https://api.whatsapp.com/send?text=${text}`, '_blank');
};
</script>

<template>
    <Head :title="`${article.title} - BAPPERIDA Pringsewu`" />

    <PublicLayout>
        <!-- Article Header Breadcrumb -->
        <div class="bg-slate-100/70 border-b border-slate-200/60 py-4 px-4 sm:px-8">
            <div class="max-w-4xl mx-auto flex items-center justify-between text-xs">
                <Link href="/berita" class="inline-flex items-center gap-1.5 text-teal-800 font-bold hover:underline">
                    <ChevronLeft class="w-4 h-4" />
                    <span>Kembali ke Seluruh Berita</span>
                </Link>
                <span class="text-slate-400 font-mono">BAPPERIDA News</span>
            </div>
        </div>

        <article class="py-12 px-4 sm:px-8 max-w-4xl mx-auto space-y-8">
            <!-- Header Meta -->
            <div class="space-y-4">
                <div class="flex flex-wrap items-center gap-2 text-xs">
                    <span class="px-3 py-1 rounded-md font-bold uppercase tracking-wider bg-teal-50 text-teal-800 border border-teal-200/60">
                        {{ article.category_code }} • {{ article.category_name }}
                    </span>
                    <span class="text-slate-400">•</span>
                    <span class="text-slate-500 flex items-center gap-1">
                        <Calendar class="w-3.5 h-3.5 text-slate-400" /> {{ article.published_at }}
                    </span>
                    <span class="text-slate-400">•</span>
                    <span class="text-slate-500 flex items-center gap-1">
                        <User class="w-3.5 h-3.5 text-slate-400" /> {{ article.author_name }}
                    </span>
                </div>

                <h1 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight leading-tight">
                    {{ article.title }}
                </h1>

                <p class="text-sm sm:text-base text-slate-600 font-medium leading-relaxed italic border-l-4 border-teal-700 pl-4 bg-slate-50 py-3 rounded-r-xl">
                    {{ article.excerpt }}
                </p>
            </div>

            <!-- Share Buttons & Views Count -->
            <div class="flex items-center justify-between py-3 border-y border-slate-200/80 text-xs">
                <div class="flex items-center gap-2">
                    <span class="font-bold text-slate-600 mr-2">Bagikan Berita:</span>
                    <button
                        type="button"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-teal-50 hover:text-teal-800 text-slate-700 font-medium transition-all cursor-pointer"
                        @click="copyArticleLink"
                    >
                        <Copy class="w-3.5 h-3.5" />
                        Salin Tautan
                    </button>
                    <button
                        type="button"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-medium transition-all cursor-pointer"
                        @click="shareToWhatsapp"
                    >
                        <Share2 class="w-3.5 h-3.5" />
                        WhatsApp
                    </button>
                </div>

                <span class="text-slate-400 flex items-center gap-1 text-[11px]">
                    <Eye class="w-3.5 h-3.5" /> {{ article.views_count }} Kali Dibaca
                </span>
            </div>

            <!-- Article Body Content -->
            <div
                class="prose prose-slate max-w-none text-slate-700 leading-relaxed text-sm sm:text-base space-y-4"
                v-html="article.content"
            />

            <!-- Related Articles -->
            <div v-if="relatedArticles.length > 0" class="pt-12 mt-12 border-t border-slate-200 space-y-6">
                <h3 class="text-lg font-bold text-slate-900">
                    Warta Terkait dari Bidang yang Sama
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div
                        v-for="rel in relatedArticles"
                        :key="rel.id"
                        class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 hover:bg-white hover:shadow-xs transition-all space-y-2 flex flex-col justify-between"
                    >
                        <div class="space-y-1">
                            <span class="text-[10px] font-bold text-teal-800 uppercase">{{ rel.category_code }}</span>
                            <h4 class="text-xs font-bold text-slate-900 leading-snug line-clamp-2">
                                <Link :href="`/berita/${rel.slug}`" class="hover:text-teal-800">
                                    {{ rel.title }}
                                </Link>
                            </h4>
                        </div>
                        <span class="text-[10px] text-slate-400 block pt-2">{{ rel.published_at }}</span>
                    </div>
                </div>
            </div>
        </article>
    </PublicLayout>
</template>
