<script setup lang="ts">
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { notify } from '@/lib/toast';
import {
    BarChart3,
    Edit3,
    X,
    CheckCircle2,
    Calendar,
    Building2,
    Award,
    TrendingUp,
} from 'lucide-vue-next';

interface IndexItem {
    id: string;
    name: string;
    code: string;
    year: number;
    score: string;
    predicate: string;
    evaluator: string;
    description: string;
    is_active: boolean;
    updated_at: string;
}

interface Props {
    indexes: IndexItem[];
}

const props = defineProps<Props>();

const isModalOpen = ref(false);
const selectedIndex = ref<IndexItem | null>(null);

const form = useForm({
    year: 2025,
    score: '',
    predicate: '',
    evaluator: '',
    description: '',
});

const openEditModal = (idx: IndexItem) => {
    selectedIndex.value = idx;
    form.year = idx.year;
    form.score = idx.score;
    form.predicate = idx.predicate;
    form.evaluator = idx.evaluator;
    form.description = idx.description;
    isModalOpen.value = true;
};

const submitForm = () => {
    if (!selectedIndex.value) return;

    form.put(`/admin/indexes/${selectedIndex.value.id}`, {
        onSuccess: () => {
            isModalOpen.value = false;
            notify.success('Indeks Diperbarui', 'Nilai indeks capaian daerah berhasil diperbarui.');
        },
        onError: () => notify.error('Gagal Menyimpan', 'Silakan periksa input nilai indeks.'),
    });
};
</script>

<template>
    <Head title="Manajemen Indeks Pembangunan Daerah - BAPPERIDA" />

    <AdminLayout title="Indeks Pembangunan" breadcrumb="Indeks & Laporan">
        <div class="space-y-6">
            <!-- Header Bar -->
            <div>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                    <BarChart3 class="w-5 h-5 text-teal-700" />
                    Manajemen Indeks Capaian Pembangunan Daerah
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Perbarui nilai capaian IID, IDSD, IPKD, dan evaluasi SAKIP Kabupaten Pringsewu
                </p>
            </div>

            <!-- Indexes Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div
                    v-for="idx in indexes"
                    :key="idx.id"
                    class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex flex-col justify-between"
                >
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-teal-50 text-teal-800 border border-teal-200/60">
                                {{ idx.code }}
                            </span>
                            <span class="text-xs font-semibold text-slate-400 bg-slate-50 px-3 py-1 rounded-full border border-slate-200/60">
                                Tahun {{ idx.year }}
                            </span>
                        </div>

                        <div>
                            <h2 class="text-lg font-bold text-slate-900 leading-snug">
                                {{ idx.name }}
                            </h2>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                {{ idx.description }}
                            </p>
                        </div>

                        <!-- Score Box -->
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/60 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">
                                    Skor Capaian
                                </span>
                                <span class="text-3xl font-black text-teal-800 tracking-tight">
                                    {{ idx.score }}
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">
                                    Kategori Predikat
                                </span>
                                <span class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1 rounded-full bg-teal-100 text-teal-800 mt-0.5">
                                    <Award class="w-3.5 h-3.5" />
                                    {{ idx.predicate }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-1.5 text-xs text-slate-500">
                            <div class="flex items-center gap-2">
                                <Building2 class="w-3.5 h-3.5 text-slate-400" />
                                <span>Lembaga Penilai: <strong>{{ idx.evaluator }}</strong></span>
                            </div>
                            <div class="flex items-center gap-2 text-[11px] text-slate-400">
                                <Calendar class="w-3.5 h-3.5" />
                                <span>Terakhir diperbarui: {{ idx.updated_at }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Button -->
                    <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                        <button
                            type="button"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-teal-50 hover:text-teal-800 transition-all cursor-pointer"
                            @click="openEditModal(idx)"
                        >
                            <Edit3 class="w-3.5 h-3.5" />
                            Perbarui Nilai
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal Dialog -->
        <div
            v-if="isModalOpen"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs"
        >
            <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 w-full max-w-md overflow-hidden animate-in fade-in zoom-in-95 duration-150">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-base font-bold text-slate-900">
                        Perbarui Skor {{ selectedIndex?.code }}
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
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                Skor Penilaian *
                            </label>
                            <input
                                v-model="form.score"
                                type="text"
                                required
                                placeholder="Contoh: 62.45"
                                class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none font-mono"
                            />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">
                                Tahun Penilaian *
                            </label>
                            <input
                                v-model.number="form.year"
                                type="number"
                                required
                                min="2020"
                                max="2099"
                                class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none"
                            />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Predikat Capaian *
                        </label>
                        <input
                            v-model="form.predicate"
                            type="text"
                            required
                            placeholder="Contoh: Sangat Inovatif / Tinggi / Baik"
                            class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Lembaga Penilai / Rilis *
                        </label>
                        <input
                            v-model="form.evaluator"
                            type="text"
                            required
                            placeholder="Contoh: Kemendagri RI / BRIN"
                            class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none"
                        />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">
                            Catatan Ringkas
                        </label>
                        <textarea
                            v-model="form.description"
                            rows="3"
                            class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none"
                        />
                    </div>

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
                            <span v-else>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
