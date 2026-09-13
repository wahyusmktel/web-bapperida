<script setup lang="ts">
import { ref, watch } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { confirmAction } from '@/lib/swal';
import { notify } from '@/lib/toast';
import {
    FileText,
    Plus,
    Search,
    Download,
    Eye,
    EyeOff,
    Edit3,
    Trash2,
    X,
    UploadCloud,
    CheckCircle2,
    Calendar,
    Tag,
} from 'lucide-vue-next';

interface DocumentItem {
    id: string;
    title: string;
    slug: string;
    category_name: string;
    year: number;
    document_number: string;
    file_name: string | null;
    file_size: string;
    downloads_count: number;
    is_published: boolean;
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
        category_id?: string;
        year?: string;
    };
}

const props = defineProps<Props>();

const search = ref(props.filters.search || '');
const selectedCategory = ref(props.filters.category_id || '');
const selectedYear = ref(props.filters.year || '');

// Watch filters
watch([search, selectedCategory, selectedYear], () => {
    router.get(
        '/admin/documents',
        {
            search: search.value || undefined,
            category_id: selectedCategory.value || undefined,
            year: selectedYear.value || undefined,
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
    year: new Date().getFullYear(),
    document_number: '',
    description: '',
    file: null as File | null,
    is_published: true,
});

const openCreateModal = () => {
    isEditing.value = false;
    editingId.value = null;
    form.reset();
    form.clearErrors();
    form.category_id = props.categories[0]?.id || '';
    form.year = new Date().getFullYear();
    isModalOpen.value = true;
};

const openEditModal = (doc: DocumentItem) => {
    isEditing.value = true;
    editingId.value = doc.id;
    form.reset();
    form.clearErrors();
    const matchedCategory = props.categories.find((c) => c.name === doc.category_name);
    form.category_id = matchedCategory ? matchedCategory.id : (props.categories[0]?.id || '');
    form.title = doc.title;
    form.year = doc.year;
    form.document_number = doc.document_number !== '-' ? doc.document_number : '';
    form.description = '';
    form.is_published = doc.is_published;
    form.file = null;
    isModalOpen.value = true;
};

const handleFileChange = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        form.file = target.files[0];
    }
};

const submitForm = () => {
    if (isEditing.value && editingId.value) {
        form.put(`/admin/documents/${editingId.value}`, {
            onSuccess: () => {
                isModalOpen.value = false;
                notify.success('Dokumen Diperbarui', 'Perubahan dokumen perencanaan berhasil disimpan.');
            },
            onError: () => notify.error('Validasi Gagal', 'Silakan periksa input dokumen Anda.'),
        });
    } else {
        form.post('/admin/documents', {
            onSuccess: () => {
                isModalOpen.value = false;
                notify.success('Dokumen Tersimpan', 'Dokumen perencanaan baru berhasil ditambahkan.');
            },
            onError: () => notify.error('Validasi Gagal', 'Silakan periksa kelengkapan berkas Anda.'),
        });
    }
};

const togglePublish = (doc: DocumentItem) => {
    router.patch(
        `/admin/documents/${doc.id}/toggle-publish`,
        {},
        {
            onSuccess: () => {
                notify.success(
                    'Status Diperbarui',
                    `Dokumen ${doc.is_published ? 'dinonaktifkan (Draft)' : 'dipublikasikan'}.`
                );
            },
        }
    );
};

const deleteDocument = async (doc: DocumentItem) => {
    const confirmed = await confirmAction({
        title: 'Hapus Dokumen?',
        text: `Apakah Anda yakin ingin menghapus "${doc.title}"? Berkas PDF terkait juga akan dihapus dari penyimpanan.`,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        isDestructive: true,
    });

    if (confirmed) {
        router.delete(`/admin/documents/${doc.id}`, {
            onSuccess: () => notify.success('Terhapus', 'Dokumen berhasil dihapus dari sistem.'),
        });
    }
};
</script>

<template>
    <Head title="Manajemen Dokumen Perencanaan - BAPPERIDA" />

    <AdminLayout title="Dokumen Perencanaan" breadcrumb="Dokumen Perencanaan">
        <div class="space-y-6">
            <!-- Header Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        <FileText class="w-5 h-5 text-teal-700" />
                        Repositori Dokumen Perencanaan & Riset
                    </h1>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Kelola RPJPD, RPJMD, RKPD, Renstra, dan kajian strategis Kabupaten Pringsewu
                    </p>
                </div>

                <button
                    type="button"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-teal-800 hover:bg-teal-900 active:scale-[0.98] transition-all shadow-xs cursor-pointer self-start sm:self-auto"
                    @click="openCreateModal"
                >
                    <Plus class="w-4 h-4" />
                    Tambah Dokumen Baru
                </button>
            </div>

            <!-- Filters & Search Toolbar -->
            <div class="bg-white rounded-2xl p-4 border border-slate-200/80 shadow-xs flex flex-col md:flex-row gap-3 items-center justify-between">
                <!-- Search Input -->
                <div class="relative w-full md:w-80">
                    <Search class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Cari judul, nomor dokumen..."
                        class="w-full pl-9 pr-4 py-2 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none transition-all"
                    />
                </div>

                <!-- Dropdown Filters -->
                <div class="flex items-center gap-2.5 w-full md:w-auto">
                    <!-- Category Filter -->
                    <select
                        v-model="selectedCategory"
                        class="px-3 py-2 rounded-xl text-xs bg-slate-50 border border-slate-200 text-slate-700 outline-none focus:border-teal-700"
                    >
                        <option value="">Semua Kategori</option>
                        <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                            {{ cat.name }}
                        </option>
                    </select>

                    <!-- Year Filter -->
                    <select
                        v-model="selectedYear"
                        class="px-3 py-2 rounded-xl text-xs bg-slate-50 border border-slate-200 text-slate-700 outline-none focus:border-teal-700"
                    >
                        <option value="">Semua Tahun</option>
                        <option v-for="yr in years" :key="yr" :value="yr">
                            {{ yr }}
                        </option>
                    </select>
                </div>
            </div>

            <!-- Documents Table Card -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50/70 border-b border-slate-200 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Dokumen & Nomor</th>
                                <th class="px-4 py-4">Kategori</th>
                                <th class="px-4 py-4 text-center">Tahun</th>
                                <th class="px-4 py-4 text-center">Ukuran / Unduhan</th>
                                <th class="px-4 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr v-if="documents.data.length === 0">
                                <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                    Tidak ada dokumen perencanaan yang sesuai dengan filter pencarian.
                                </td>
                            </tr>
                            <tr
                                v-for="doc in documents.data"
                                :key="doc.id"
                                class="hover:bg-slate-50/60 transition-colors"
                            >
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center shrink-0 mt-0.5">
                                            <FileText class="w-4 h-4" />
                                        </div>
                                        <div>
                                            <span class="font-bold text-slate-900 block leading-tight text-sm">
                                                {{ doc.title }}
                                            </span>
                                            <span class="text-[11px] font-mono text-slate-400 mt-0.5 block">
                                                {{ doc.document_number }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-medium bg-slate-100 text-slate-700">
                                        {{ doc.category_name }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center font-bold text-slate-700">
                                    {{ doc.year }}
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="text-slate-700 font-medium block">{{ doc.file_size }}</span>
                                    <span class="text-[10px] text-teal-700 font-semibold inline-flex items-center gap-0.5">
                                        <Download class="w-3 h-3" /> {{ doc.downloads_count }}x
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button
                                        type="button"
                                        class="cursor-pointer inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold transition-all"
                                        :class="doc.is_published ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-500'"
                                        @click="togglePublish(doc)"
                                    >
                                        <component :is="doc.is_published ? Eye : EyeOff" class="w-3 h-3" />
                                        {{ doc.is_published ? 'Publik' : 'Draft' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="inline-flex items-center gap-1.5">
                                        <button
                                            type="button"
                                            class="p-1.5 rounded-lg text-slate-400 hover:text-teal-700 hover:bg-teal-50 transition-colors"
                                            title="Edit Dokumen"
                                            @click="openEditModal(doc)"
                                        >
                                            <Edit3 class="w-4 h-4" />
                                        </button>
                                        <button
                                            type="button"
                                            class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors"
                                            title="Hapus Dokumen"
                                            @click="deleteDocument(doc)"
                                        >
                                            <Trash2 class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Footer Summary -->
                <div class="px-6 py-3 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between text-xs text-slate-500">
                    <span>Total: {{ documents.total }} dokumen perencanaan terdata</span>
                </div>
            </div>
        </div>

        <!-- Add / Edit Modal Dialog -->
        <div
            v-if="isModalOpen"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs"
        >
            <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 w-full max-w-lg overflow-hidden animate-in fade-in zoom-in-95 duration-150">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-base font-bold text-slate-900">
                        {{ isEditing ? 'Edit Dokumen Perencanaan' : 'Tambah Dokumen Perencanaan Baru' }}
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
                            Judul Dokumen Perencanaan *
                        </label>
                        <input
                            v-model="form.title"
                            type="text"
                            required
                            placeholder="Contoh: Rencana Kerja Pemerintah Daerah (RKPD) 2026"
                            class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none"
                        />
                        <p v-if="form.errors.title" class="text-xs text-rose-600 mt-1">
                            {{ form.errors.title }}
                        </p>
                    </div>

                    <!-- Category & Year -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                Kategori Dokumen *
                            </label>
                            <select
                                v-model="form.category_id"
                                required
                                class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none"
                            >
                                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                                    {{ cat.name }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                Tahun Berkenaan *
                            </label>
                            <input
                                v-model.number="form.year"
                                type="number"
                                required
                                min="2000"
                                max="2099"
                                class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none"
                            />
                        </div>
                    </div>

                    <!-- Document Number -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Nomor Regulasi / Dokumen
                        </label>
                        <input
                            v-model="form.document_number"
                            type="text"
                            placeholder="Contoh: Perbup No. 18 Tahun 2025"
                            class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none"
                        />
                    </div>

                    <!-- File Upload (PDF Only) -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Berkas Dokumen PDF (Maks. 25 MB)
                        </label>
                        <input
                            type="file"
                            accept="application/pdf"
                            class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 file:text-teal-800 hover:file:bg-teal-100"
                            @change="handleFileChange"
                        />
                        <p v-if="form.errors.file" class="text-xs text-rose-600 mt-1">
                            {{ form.errors.file }}
                        </p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Ringkasan / Abstrak
                        </label>
                        <textarea
                            v-model="form.description"
                            rows="3"
                            placeholder="Ringkasan isi dan substansi dokumen perencanaan..."
                            class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none"
                        />
                    </div>

                    <!-- Publication Checkbox -->
                    <div class="flex items-center gap-2 pt-2">
                        <input
                            id="modal_is_published"
                            v-model="form.is_published"
                            type="checkbox"
                            class="w-4 h-4 text-teal-700 rounded border-slate-300"
                        />
                        <label for="modal_is_published" class="text-xs font-medium text-slate-700">
                            Publikasikan dokumen langsung ke portal publik BAPPERIDA
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
                            <span v-else>{{ isEditing ? 'Simpan Perubahan' : 'Unggah & Terbitkan' }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
