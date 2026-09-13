<script setup lang="ts">
import { ref, watch } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { confirmAction } from '@/lib/swal';
import { notify } from '@/lib/toast';
import {
    Newspaper,
    Plus,
    Search,
    Eye,
    EyeOff,
    Edit3,
    Trash2,
    X,
    Calendar,
    User,
    Sparkles,
} from 'lucide-vue-next';

interface ArticleItem {
    id: string;
    title: string;
    slug: string;
    excerpt: string;
    content: string;
    category_name: string;
    category_code: string;
    category_color: string;
    category_id: string;
    author_name: string;
    featured_image: string | null;
    views_count: number;
    is_published: boolean;
    published_at: string;
}

interface CategoryItem {
    id: string;
    name: string;
    code: string;
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
        category_id?: string;
    };
}

const props = defineProps<Props>();

const search = ref(props.filters.search || '');
const selectedCategory = ref(props.filters.category_id || '');

watch([search, selectedCategory], () => {
    router.get(
        '/admin/news',
        {
            search: search.value || undefined,
            category_id: selectedCategory.value || undefined,
        },
        { preserveState: true, replace: true }
    );
});

// Modal State
const isModalOpen = ref(false);
const isEditing = ref(false);
const editingId = ref<string | null>(null);

const form = useForm({
    category_id: '',
    title: '',
    excerpt: '',
    content: '',
    image: null as File | null,
    is_published: true,
});

const openCreateModal = () => {
    isEditing.value = false;
    editingId.value = null;
    form.reset();
    form.clearErrors();
    form.category_id = props.categories[0]?.id || '';
    isModalOpen.value = true;
};

const openEditModal = (art: ArticleItem) => {
    isEditing.value = true;
    editingId.value = art.id;
    form.reset();
    form.clearErrors();
    form.category_id = art.category_id;
    form.title = art.title;
    form.excerpt = art.excerpt;
    form.content = art.content;
    form.is_published = art.is_published;
    form.image = null;
    isModalOpen.value = true;
};

const handleImageChange = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.image = target.files[0];
    }
};

const submitForm = () => {
    if (isEditing.value && editingId.value) {
        form.put(`/admin/news/${editingId.value}`, {
            onSuccess: () => {
                isModalOpen.value = false;
                notify.success('Berita Diperbarui', 'Perubahan artikel rilis berita berhasil disimpan.');
            },
            onError: () => notify.error('Validasi Gagal', 'Silakan periksa input artikel Anda.'),
        });
    } else {
        form.post('/admin/news', {
            onSuccess: () => {
                isModalOpen.value = false;
                notify.success('Berita Diterbitkan', 'Rilis berita baru berhasil dipublikasikan.');
            },
            onError: () => notify.error('Validasi Gagal', 'Silakan lengkapi formulir berita.'),
        });
    }
};

const deleteArticle = async (art: ArticleItem) => {
    const confirmed = await confirmAction({
        title: 'Hapus Berita?',
        text: `Apakah Anda yakin ingin menghapus rilis berita "${art.title}"? Tindakan ini tidak dapat dibatalkan.`,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        isDestructive: true,
    });

    if (confirmed) {
        router.delete(`/admin/news/${art.id}`, {
            onSuccess: () => notify.success('Terhapus', 'Rilis berita berhasil dihapus.'),
        });
    }
};
</script>

<template>
    <Head title="Manajemen Berita 6 Bidang - BAPPERIDA" />

    <AdminLayout title="Publikasi & Berita" breadcrumb="Publikasi & Berita">
        <div class="space-y-6">
            <!-- Header Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        <Newspaper class="w-5 h-5 text-teal-700" />
                        Publikasi & Rilis Berita 6 Bidang
                    </h1>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Kelola warta pembangunan Sekretariat, PPE, PPM, PSDA, IPW, dan RIDA
                    </p>
                </div>

                <button
                    type="button"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-teal-800 hover:bg-teal-900 active:scale-[0.98] transition-all shadow-xs cursor-pointer self-start sm:self-auto"
                    @click="openCreateModal"
                >
                    <Plus class="w-4 h-4" />
                    Tulis Berita Baru
                </button>
            </div>

            <!-- 6 Bidang Category Quick Filter Chips -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs">
                <button
                    type="button"
                    class="px-3.5 py-1.5 rounded-xl font-semibold transition-all whitespace-nowrap cursor-pointer"
                    :class="selectedCategory === '' ? 'bg-teal-800 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/80'"
                    @click="selectedCategory = ''"
                >
                    Semua Bidang
                </button>
                <button
                    v-for="cat in categories"
                    :key="cat.id"
                    type="button"
                    class="px-3.5 py-1.5 rounded-xl font-semibold transition-all whitespace-nowrap cursor-pointer"
                    :class="selectedCategory === cat.id ? 'bg-teal-800 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/80'"
                    @click="selectedCategory = cat.id"
                >
                    {{ cat.code }} • {{ cat.name }}
                </button>
            </div>

            <!-- Search Bar -->
            <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex items-center justify-between">
                <div class="relative w-full sm:w-96">
                    <Search class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Cari judul berita, kata kunci..."
                        class="w-full pl-9 pr-4 py-2 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none transition-all"
                    />
                </div>
            </div>

            <!-- Articles List Cards -->
            <div class="space-y-3">
                <div v-if="articles.data.length === 0" class="bg-white rounded-2xl p-12 text-center text-slate-400 border border-slate-200/80">
                    Belum ada artikel berita yang cocok dengan kriteria pencarian.
                </div>

                <div
                    v-for="art in articles.data"
                    :key="art.id"
                    class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex flex-col md:flex-row items-start justify-between gap-4"
                >
                    <div class="space-y-2 flex-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold tracking-wide uppercase bg-teal-50 text-teal-800 border border-teal-200/60">
                                {{ art.category_code }} • {{ art.category_name }}
                            </span>
                            <span class="text-slate-400 text-xs flex items-center gap-1">
                                <Calendar class="w-3 h-3" /> {{ art.published_at }}
                            </span>
                        </div>

                        <h3 class="text-base font-bold text-slate-900 leading-snug">
                            {{ art.title }}
                        </h3>

                        <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                            {{ art.excerpt }}
                        </p>

                        <div class="flex items-center gap-4 text-[11px] text-slate-400 pt-1">
                            <span class="flex items-center gap-1">
                                <User class="w-3 h-3" /> {{ art.author_name }}
                            </span>
                            <span class="flex items-center gap-1">
                                <Eye class="w-3 h-3" /> {{ art.views_count }} pembaca
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-2 self-end md:self-center shrink-0">
                        <button
                            type="button"
                            class="p-2 rounded-xl text-slate-500 hover:text-teal-700 hover:bg-teal-50 transition-colors"
                            title="Edit Artikel"
                            @click="openEditModal(art)"
                        >
                            <Edit3 class="w-4 h-4" />
                        </button>
                        <button
                            type="button"
                            class="p-2 rounded-xl text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition-colors"
                            title="Hapus Artikel"
                            @click="deleteArticle(art)"
                        >
                            <Trash2 class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add / Edit News Modal Dialog -->
        <div
            v-if="isModalOpen"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs overflow-y-auto"
        >
            <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 w-full max-w-2xl overflow-hidden my-8 animate-in fade-in zoom-in-95 duration-150">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-base font-bold text-slate-900">
                        {{ isEditing ? 'Edit Rilis Berita' : 'Tulis Rilis Berita Baru' }}
                    </h3>
                    <button
                        type="button"
                        class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg"
                        @click="isModalOpen = false"
                    >
                        <X class="w-5 h-5" />
                    </button>
                </div>

                <form @submit.prevent="submitForm" class="p-6 space-y-4">
                    <!-- Title -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Judul Berita *
                        </label>
                        <input
                            v-model="form.title"
                            type="text"
                            required
                            placeholder="Contoh: BAPPERIDA Pringsewu Gelar Konsultasi Publik Rancangan Awal RKPD 2026"
                            class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none"
                        />
                    </div>

                    <!-- Category (Bidang) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Bidang BAPPERIDA Terkait *
                        </label>
                        <select
                            v-model="form.category_id"
                            required
                            class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none"
                        >
                            <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                                {{ cat.code }} • {{ cat.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Excerpt -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Ringkasan Berita (Excerpt)
                        </label>
                        <textarea
                            v-model="form.excerpt"
                            rows="2"
                            placeholder="Ringkasan 1-2 kalimat pengantar berita..."
                            class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none"
                        />
                    </div>

                    <!-- Content (HTML Sanitized) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Isi Konten Berita Lengkap *
                        </label>
                        <textarea
                            v-model="form.content"
                            required
                            rows="7"
                            placeholder="Tuliskan berita lengkap di sini..."
                            class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none font-mono"
                        />
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Gambar Unggulan (WebP, JPG, PNG - Maks 4 MB)
                        </label>
                        <input
                            type="file"
                            accept="image/jpeg,image/png,image/webp"
                            class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-800 hover:file:bg-teal-100"
                            @change="handleImageChange"
                        />
                    </div>

                    <!-- Publication Checkbox -->
                    <div class="flex items-center gap-2 pt-2">
                        <input
                            id="news_is_published"
                            v-model="form.is_published"
                            type="checkbox"
                            class="w-4 h-4 text-teal-700 rounded border-slate-300"
                        />
                        <label for="news_is_published" class="text-xs font-medium text-slate-700">
                            Publikasikan langsung ke portal resmi BAPPERIDA
                        </label>
                    </div>

                    <!-- Modal Actions -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-2.5">
                        <button
                            type="button"
                            class="px-4 py-2 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-100"
                            @click="isModalOpen = false"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-teal-800 hover:bg-teal-900 active:scale-[0.98] disabled:opacity-50"
                        >
                            <span v-if="form.processing">Menyimpan...</span>
                            <span v-else>{{ isEditing ? 'Simpan Perubahan' : 'Terbitkan Berita' }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
