<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { confirmAction } from '@/lib/swal';
import { notify } from '@/lib/toast';
import {
    ClipboardCheck,
    ShieldCheck,
    CheckCircle2,
    AlertCircle,
    XCircle,
    Search,
    Filter,
    Plus,
    Printer,
    Eye,
    Trash2,
    Building2,
    Calendar,
    Users,
    Utensils,
    Activity,
    Award,
    TrendingUp,
    ExternalLink,
    BadgeCheck,
} from 'lucide-vue-next';

interface AuditItem {
    id: string;
    inspection_number: string;
    inspection_date: string;
    sppg_id_code: string;
    sppg_name: string;
    sppg_type: string;
    regency_city: string;
    inspector_name: string;
    beneficiary_count: number;
    score_keamanan_pangan: number;
    score_legalitas_sdm: number;
    score_lahan_keselamatan: number;
    total_score: number;
    grade: string;
    recommendation: string;
    recommendation_reason: string | null;
    status: string;
    created_at: string;
}

interface PaginationProps {
    data: AuditItem[];
    current_page: number;
    last_page: number;
    total: number;
    links: Array<{ url: string | null; label: string; active: boolean }>;
}

interface Props {
    audits: PaginationProps;
    analytics: {
        total_audits: number;
        total_pm: number;
        grade_a_count: number;
        grade_b_count: number;
        grade_d_count: number;
        grade_a_percentage: number;
        grade_b_percentage: number;
        grade_d_percentage: number;
        avg_total_score: number;
        avg_food_safety: number;
        avg_legality_hr: number;
        avg_safety_land: number;
        verified_count: number;
        submitted_count: number;
        by_type: Record<string, number>;
    };
    filters: {
        search?: string;
        grade?: string;
        recommendation?: string;
        type?: string;
    };
}

const props = defineProps<Props>();

const searchQuery = ref(props.filters.search || '');
const selectedGrade = ref(props.filters.grade || '');
const selectedType = ref(props.filters.type || '');

const handleFilter = () => {
    router.get(
        '/admin/sppg-audits',
        {
            search: searchQuery.value || undefined,
            grade: selectedGrade.value || undefined,
            type: selectedType.value || undefined,
        },
        { preserveState: true, replace: true }
    );
};

const toggleVerify = (id: string, name: string) => {
    router.patch(`/admin/sppg-audits/${id}/toggle-verify`, {}, {
        onSuccess: () => {
            notify.success(`Status verifikasi audit ${name} berhasil diubah.`);
        },
    });
};

const deleteAudit = async (id: string, name: string) => {
    const confirmed = await confirmAction({
        title: 'Hapus Laporan Audit?',
        text: `Data inspeksi untuk "${name}" akan dihapus permanen dari sistem.`,
        confirmButtonText: 'Ya, Hapus Data',
        cancelButtonText: 'Batal',
        isDestructive: true,
    });

    if (confirmed) {
        router.delete(`/admin/sppg-audits/${id}`, {
            onSuccess: () => {
                notify.success(`Audit ${name} berhasil dihapus.`);
            },
        });
    }
};
</script>

<template>
    <Head title="Manajemen & Analisa Audit Kelayakan SPPG - Admin BAPPERIDA" />

    <AdminLayout title="Audit Kelayakan SPPG (Satgas MBG)" breadcrumb="Audit SPPG">
        <div class="space-y-8">
            <!-- Header Banner Analitik -->
            <div class="bg-gradient-to-r from-teal-900 via-slate-900 to-teal-950 rounded-3xl p-6 sm:p-8 text-white shadow-md flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2 max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-800/80 border border-teal-500/40 text-[11px] font-bold text-teal-200">
                        <ShieldCheck class="w-3.5 h-3.5 text-teal-300" />
                        <span>Sistem Pengawasan & Evaluasi Satgas MBG</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                        Dashboard & Analisa Audit Kelayakan SPPG
                    </h1>
                    <p class="text-xs sm:text-sm text-teal-100/80 leading-relaxed">
                        Evaluasi terpadu 14 indikator operasional sentra dapur Makan Bergizi Gratis di Kabupaten Pringsewu. Pantau persentase kelayakan, skor pilar mutu pangan, dan ekspor lembar audit resmi.
                    </p>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <Link
                        href="/audit-sppg/form"
                        target="_blank"
                        class="px-5 py-3 rounded-2xl bg-teal-600 hover:bg-teal-500 text-white text-xs font-bold transition-all shadow-md flex items-center gap-2"
                    >
                        <Plus class="w-4 h-4" />
                        <span>Buka Form Audit</span>
                        <ExternalLink class="w-3.5 h-3.5 opacity-70" />
                    </Link>
                </div>
            </div>

            <!-- Kartu Metrik Analisa -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs space-y-2">
                    <div class="flex items-center justify-between text-slate-400">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Dapur Diaudit</span>
                        <Building2 class="w-5 h-5 text-teal-700" />
                    </div>
                    <div class="text-3xl font-black text-slate-900 font-mono">
                        {{ analytics.total_audits }}
                    </div>
                    <p class="text-[11px] text-slate-500">
                        Total Melayani: <strong class="text-slate-800 font-mono">{{ Number(analytics.total_pm).toLocaleString('id-ID') }}</strong> porsi/hari
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs space-y-2">
                    <div class="flex items-center justify-between text-slate-400">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Grade A (Layak)</span>
                        <CheckCircle2 class="w-5 h-5 text-emerald-600" />
                    </div>
                    <div class="text-3xl font-black text-emerald-700 font-mono">
                        {{ analytics.grade_a_count }} <span class="text-sm font-sans font-bold text-slate-400">({{ analytics.grade_a_percentage }}%)</span>
                    </div>
                    <p class="text-[11px] text-emerald-700 font-medium">
                        Operasional prima & aman penuh
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs space-y-2">
                    <div class="flex items-center justify-between text-slate-400">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Grade B (Perlu Perbaikan)</span>
                        <AlertCircle class="w-5 h-5 text-amber-500" />
                    </div>
                    <div class="text-3xl font-black text-amber-600 font-mono">
                        {{ analytics.grade_b_count }} <span class="text-sm font-sans font-bold text-slate-400">({{ analytics.grade_b_percentage }}%)</span>
                    </div>
                    <p class="text-[11px] text-amber-700 font-medium">
                        Layak dengan catatan perbaikan
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs space-y-2">
                    <div class="flex items-center justify-between text-slate-400">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Rata-Rata Skor Mutu</span>
                        <Activity class="w-5 h-5 text-blue-600" />
                    </div>
                    <div class="text-3xl font-black text-slate-900 font-mono">
                        {{ analytics.avg_total_score }}%
                    </div>
                    <p class="text-[11px] text-slate-500">
                        Pangan: <span class="font-mono font-bold">{{ analytics.avg_food_safety }}%</span> | SDM: <span class="font-mono font-bold">{{ analytics.avg_legality_hr }}%</span>
                    </p>
                </div>
            </div>

            <!-- Analisa 3 Pilar Mutu Rata-Rata Daerah -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Pilar 1: Legalitas & SDM</span>
                        <span class="text-xs font-mono font-bold text-blue-700">{{ analytics.avg_legality_hr }}% / 23%</span>
                    </div>
                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-600 rounded-full" :style="{ width: `${(analytics.avg_legality_hr / 23) * 100}%` }" />
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Evaluasi kepemilikan SLHS aktif, sertifikasi halal resmi BPJPH, serta verifikasi fisik Kepala SPPG, Chef berpengalaman 1 tahun, dan Pengawas Gizi.
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Pilar 2: Keamanan Pangan</span>
                        <span class="text-xs font-mono font-bold text-emerald-700">{{ analytics.avg_food_safety }}% / 65%</span>
                    </div>
                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-600 rounded-full" :style="{ width: `${(analytics.avg_food_safety / 65) * 100}%` }" />
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Bobot paling kritis mencakup air RO/galon, chiller (≤5°C) & freezer (≤-18°C), rasio kompor, wastafel 5 titik, IPAL, gudang non-kayu, dan CCTV 10 titik.
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Pilar 3: Lahan & K3</span>
                        <span class="text-xs font-mono font-bold text-amber-700">{{ analytics.avg_safety_land }}% / 12%</span>
                    </div>
                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full" :style="{ width: `${(analytics.avg_safety_land / 12) * 100}%` }" />
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Kesiapsiagaan proteksi kebakaran (APAR powder 3kg valid) dan kesesuaian luasan fisik dapur terhadap jumlah porsi PM yang dilayani.
                    </p>
                </div>
            </div>

            <!-- Tabel Riwayat & Data Inspeksi SPPG -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
                <!-- Table Filter & Search Header -->
                <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-base font-black text-slate-900">
                            Daftar Hasil Audit & Inspeksi SPPG
                        </h3>
                        <p class="text-xs text-slate-500">
                            Total {{ audits.total }} data inspeksi tercatat di Kabupaten Pringsewu
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 text-xs">
                        <div class="relative">
                            <Search class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                            <input
                                v-model="searchQuery"
                                type="text"
                                placeholder="Cari nama SPPG / ID / Petugas..."
                                class="pl-9 pr-3 py-2 rounded-xl border border-slate-200 text-xs w-52 sm:w-64 focus:border-teal-600"
                                @keyup.enter="handleFilter"
                            />
                        </div>

                        <select
                            v-model="selectedGrade"
                            class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white"
                            @change="handleFilter"
                        >
                            <option value="">Semua Grade</option>
                            <option value="Grade A">Grade A (Layak)</option>
                            <option value="Grade B">Grade B (Perbaikan)</option>
                            <option value="Grade D">Grade D (Tidak Layak)</option>
                        </select>

                        <select
                            v-model="selectedType"
                            class="px-3 py-2 rounded-xl border border-slate-200 text-xs bg-white"
                            @change="handleFilter"
                        >
                            <option value="">Semua Tipe SPPG</option>
                            <option value="BGN">BGN</option>
                            <option value="Mandiri">Mandiri</option>
                            <option value="Khusus">Khusus</option>
                            <option value="Terpencil">Terpencil</option>
                            <option value="Sekolah Rakyat">Sekolah Rakyat</option>
                        </select>

                        <button
                            type="button"
                            class="px-4 py-2 rounded-xl bg-teal-800 hover:bg-teal-900 text-white font-bold transition-all cursor-pointer"
                            @click="handleFilter"
                        >
                            Filter
                        </button>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="bg-slate-50/70 border-b border-slate-100 text-slate-500 font-bold uppercase text-[10px] tracking-wider">
                            <tr>
                                <th class="p-4">ID & Nama SPPG</th>
                                <th class="p-4">Tanggal Inspeksi</th>
                                <th class="p-4">Porsi PM</th>
                                <th class="p-4">Skor Total</th>
                                <th class="p-4">Status Kelayakan</th>
                                <th class="p-4">Verifikasi</th>
                                <th class="p-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr
                                v-for="item in audits.data"
                                :key="item.id"
                                class="hover:bg-slate-50/80 transition-colors"
                            >
                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <span class="font-mono text-[11px] font-bold px-2 py-0.5 rounded bg-slate-100 text-slate-700 shrink-0">
                                            {{ item.sppg_id_code }}
                                        </span>
                                        <div class="min-w-0">
                                            <div class="font-bold text-slate-900 truncate">
                                                {{ item.sppg_name }}
                                            </div>
                                            <span class="text-[10px] text-slate-400">
                                                Tipe: {{ item.sppg_type }} • Petugas: {{ item.inspector_name }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-4 whitespace-nowrap font-mono text-[11px]">
                                    {{ item.inspection_date }}
                                </td>

                                <td class="p-4 whitespace-nowrap font-mono font-bold">
                                    {{ Number(item.beneficiary_count).toLocaleString('id-ID') }}
                                </td>

                                <td class="p-4 whitespace-nowrap font-mono font-black text-sm" :class="item.total_score >= 85 ? 'text-emerald-700' : (item.total_score >= 70 ? 'text-amber-600' : 'text-rose-600')">
                                    {{ item.total_score }}%
                                </td>

                                <td class="p-4 whitespace-nowrap">
                                    <span
                                        class="px-2.5 py-1 rounded-full text-[11px] font-bold border inline-flex items-center gap-1"
                                        :class="item.grade === 'Grade A' ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : (item.grade === 'Grade B' ? 'bg-amber-50 text-amber-800 border-amber-300' : 'bg-rose-50 text-rose-800 border-rose-300')"
                                    >
                                        {{ item.grade }} • {{ item.recommendation === 'layak_dilanjutkan' ? 'Layak' : (item.recommendation === 'layak_dengan_perbaikan' ? 'Perbaikan' : 'Tidak Layak') }}
                                    </span>
                                </td>

                                <td class="p-4 whitespace-nowrap">
                                    <button
                                        type="button"
                                        class="px-2.5 py-1 rounded-lg text-[10px] font-bold transition-all flex items-center gap-1 cursor-pointer"
                                        :class="item.status === 'verified' ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                                        @click="toggleVerify(item.id, item.sppg_name)"
                                    >
                                        <BadgeCheck class="w-3.5 h-3.5" />
                                        <span>{{ item.status === 'verified' ? 'Terverifikasi' : 'Review' }}</span>
                                    </button>
                                </td>

                                <td class="p-4 text-right whitespace-nowrap space-x-1.5">
                                    <Link
                                        :href="`/audit-sppg/${item.id}`"
                                        target="_blank"
                                        title="Lihat & Cetak Lembar Resmi Lampiran 1"
                                        class="p-2 rounded-xl text-slate-600 hover:text-teal-800 hover:bg-teal-50 inline-flex items-center transition-colors"
                                    >
                                        <Printer class="w-4 h-4" />
                                    </Link>
                                    <button
                                        type="button"
                                        title="Hapus Data Audit"
                                        class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 inline-flex items-center transition-colors cursor-pointer"
                                        @click="deleteAudit(item.id, item.sppg_name)"
                                    >
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Empty State -->
                <div v-if="audits.data.length === 0" class="p-12 text-center text-slate-400 text-xs">
                    Tidak ada data inspeksi audit SPPG yang sesuai dengan filter.
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
