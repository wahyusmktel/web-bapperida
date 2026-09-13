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
    Clock,
    ChevronRight,
    Bookmark
} from 'lucide-vue-next';

interface ArticleData {
    id: string;
    title: string;
    slug: string;
    excerpt: string;
    content: string;
    category_name: string;
    category_code: string;
    category_slug: string;
    category_color: string;
    author_name: string;
    featured_image: string | null;
    published_at: string;
    views_count: number;
    reading_time: string;
}

interface RelatedArticle {
    id: string;
    title: string;
    slug: string;
    excerpt: string;
    category_name: string;
    category_code: string;
    published_at: string;
}

interface PopularArticle {
    id: string;
    title: string;
    slug: string;
    excerpt: string;
    category_name: string;
    category_code: string;
    category_slug: string;
    published_at: string;
    views_count: number;
}

interface Props {
    article: ArticleData;
    relatedArticles: RelatedArticle[];
    popularArticles?: PopularArticle[];
}

const props = defineProps<Props>();

const copyArticleLink = () => {
    navigator.clipboard.writeText(window.location.href);
    notify.success('Tautan Berhasil Disalin', 'Tautan warta resmi telah tersimpan di clipboard.');
};

const shareToWhatsapp = () => {
    const text = encodeURIComponent(`${props.article.title} - Baca selengkapnya di Portal Resmi BAPPERIDA Pringsewu: ${window.location.href}`);
    window.open(`https://api.whatsapp.com/send?text=${text}`, '_blank');
};
</script>

<template>
    <Head :title="`${article.title} - Warta BAPPERIDA Pringsewu`" />

    <PublicLayout>
        <!-- Top Editorial Masthead Bar with AI-generated Pringsewu Background -->
        <section class="relative overflow-hidden bg-slate-950 text-white py-12 sm:py-16 px-4 sm:px-8 border-b border-teal-900/40">
            <div class="absolute inset-0 z-0">
                <img
                    src="/images/pringsewu_magazine_bg.jpg"
                    alt="Pringsewu Background"
                    class="w-full h-full object-cover object-center opacity-30 mix-blend-luminosity"
                />
                <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/90 to-teal-950/85" />
            </div>

            <div class="relative z-10 max-w-4xl mx-auto space-y-4">
                <!-- Breadcrumbs -->
                <div class="flex flex-wrap items-center gap-2 text-xs text-teal-300/80 font-medium">
                    <Link href="/" class="hover:text-white transition-colors">Beranda</Link>
                    <ChevronRight class="w-3.5 h-3.5 text-teal-500" />
                    <Link href="/berita" class="hover:text-white transition-colors">Berita 6 Bidang</Link>
                    <ChevronRight class="w-3.5 h-3.5 text-teal-500" />
                    <Link :href="`/berita/${article.category_slug}`" class="text-teal-300 hover:text-white transition-colors font-bold uppercase">
                        {{ article.category_name }}
                    </Link>
                </div>

                <!-- Category Badge & Reading Time -->
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <Link
                        :href="`/berita/${article.category_slug}`"
                        class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-400 text-slate-950 hover:bg-amber-300 transition-colors shadow-xs"
                    >
                        {{ article.category_name }}
                    </Link>
                    <span class="text-xs text-slate-300 flex items-center gap-1">
                        <Clock class="w-3.5 h-3.5 text-teal-400" />
                        {{ article.reading_time }}
                    </span>
                    <span class="text-slate-500">•</span>
                    <span class="text-xs text-slate-300 flex items-center gap-1">
                        <Eye class="w-3.5 h-3.5 text-teal-400" />
                        {{ article.views_count }} Kali Dibaca
                    </span>
                </div>

                <!-- Article Headline -->
                <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight leading-tight pt-1">
                    {{ article.title }}
                </h1>

                <!-- Author & Date -->
                <div class="flex items-center gap-3 pt-2 text-xs text-slate-300">
                    <div class="w-8 h-8 rounded-full bg-teal-700 text-white flex items-center justify-center font-bold text-xs">
                        BP
                    </div>
                    <div>
                        <span class="font-bold text-white block">{{ article.author_name }}</span>
                        <span class="text-slate-400 text-[11px]">{{ article.published_at }}</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Article Body -->
        <main class="py-12 px-4 sm:px-8 max-w-4xl mx-auto space-y-8">
            <!-- Lead Excerpt Callout -->
            <div class="p-6 sm:p-7 rounded-2xl bg-gradient-to-r from-teal-50 to-emerald-50 border-l-4 border-teal-800 shadow-2xs">
                <p class="text-sm sm:text-base text-slate-700 font-medium leading-relaxed italic">
                    "{{ article.excerpt }}"
                </p>
            </div>

            <!-- Share Buttons & Actions -->
            <div class="flex flex-wrap items-center justify-between gap-4 py-4 border-y border-slate-200 text-xs">
                <div class="flex items-center gap-2">
                    <span class="font-bold text-slate-700 mr-1">Bagikan Liputan:</span>
                    <button
                        type="button"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-teal-50 hover:text-teal-800 text-slate-700 font-bold transition-all cursor-pointer border border-slate-200"
                        @click="copyArticleLink"
                    >
                        <Copy class="w-3.5 h-3.5" />
                        Salin Tautan
                    </button>
                    <button
                        type="button"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold transition-all cursor-pointer shadow-xs"
                        @click="shareToWhatsapp"
                    >
                        <Share2 class="w-3.5 h-3.5" />
                        WhatsApp
                    </button>
                </div>

                <Link
                    :href="`/berita/${article.category_slug}`"
                    class="inline-flex items-center gap-1 text-teal-800 hover:text-teal-950 font-bold"
                >
                    <ChevronLeft class="w-4 h-4" />
                    <span>Kembali ke Rubrik {{ article.category_name }}</span>
                </Link>
            </div>

            <!-- Article Prose Content -->
            <div
                class="prose prose-slate max-w-none text-slate-800 leading-relaxed text-sm sm:text-base space-y-4 pt-2"
                v-html="article.content"
            />

            <!-- Editorial Tag Box -->
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1">
                    <span class="text-xs font-bold text-slate-800 block">
                        Diterbitkan oleh BAPPERIDA Kabupaten Pringsewu
                    </span>
                    <p class="text-xs text-slate-500">
                        Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah • Maju, Mandiri, Berkelanjutan
                    </p>
                </div>
                <Link
                    href="/berita"
                    class="px-4 py-2 rounded-xl bg-teal-800 text-white text-xs font-bold hover:bg-teal-900 transition-colors shrink-0"
                >
                    Jelajahi Warta Lainnya
                </Link>
            </div>

            <!-- Related Articles -->
            <section v-if="relatedArticles.length > 0" class="pt-8 border-t border-slate-200 space-y-5">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-5 bg-teal-700 rounded-full" />
                    <h3 class="text-base sm:text-lg font-black text-slate-900 tracking-tight">
                        Warta Terkait di Bidang {{ article.category_name }}
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <article
                        v-for="rel in relatedArticles"
                        :key="rel.id"
                        class="p-5 rounded-2xl bg-white border border-slate-200 hover:shadow-md transition-all flex flex-col justify-between space-y-3 group"
                    >
                        <div class="space-y-2">
                            <span class="text-[10px] font-bold text-teal-800 uppercase tracking-wider bg-teal-50 px-2 py-0.5 rounded border border-teal-200/60">
                                {{ rel.category_code }}
                            </span>
                            <Link :href="`/berita/${rel.slug}`" class="block">
                                <h4 class="text-xs font-bold text-slate-900 group-hover:text-teal-800 transition-colors leading-snug line-clamp-2">
                                    {{ rel.title }}
                                </h4>
                            </Link>
                        </div>
                        <span class="text-[10px] text-slate-400 block pt-1 border-t border-slate-100">
                            {{ rel.published_at }}
                        </span>
                    </article>
                </div>
            </section>
        </main>
    </PublicLayout>
</template>
