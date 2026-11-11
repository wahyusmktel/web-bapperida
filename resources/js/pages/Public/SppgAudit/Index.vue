<script setup lang="ts">
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import SppgGuideModal from '@/components/SppgGuideModal.vue';
import { SPPG_GUIDELINES, SPPG_CATEGORIES } from '@/data/sppgGuidelines';
import {
    ClipboardCheck,
    ShieldCheck,
    CheckCircle2,
    AlertCircle,
    Info,
    BookOpen,
    Plus,
    Search,
    Building2,
    Calendar,
    Users,
    Utensils,
    FileText,
    Activity,
    Award,
    TrendingUp,
    ChevronRight,
    ArrowRight,
    ExternalLink,
    Filter,
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
    total_score: number;
    grade: string;
    recommendation: string;
    recommendation_reason: string | null;
    status: string;
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
    stats: {
        total_audits: number;
        total_pm: number;
        grade_a_count: number;
        grade_b_count: number;
        grade_d_count: number;
        avg_score: number;
        avg_food_safety: number;
        avg_legality_hr: number;
        avg_safety_land: number;
    };
    filters: {
        search?: string;
        grade?: string;
        recommendation?: string;
    };
}

const props = defineProps<Props>();

// Search & Filter
const searchQuery = ref(props.filters.search || '');
const selectedGrade = ref(props.filters.grade || '');

const handleFilter = () => {
    router.get(
        '/audit-sppg',
        {
            search: searchQuery.value || undefined,
            grade: selectedGrade.value || undefined,
        },
        { preserveState: true, replace: true }
    );
};

// Modal Panduan
const activeGuideId = ref<number | null>(null);
const isGuideModalOpen = ref(false);

const openGuide = (id: number) => {
    activeGuideId.value = id;
    isGuideModalOpen.value = true;
};
</script>

<template>
    <Head title="Audit Kelayakan Operasional SPPG (Satgas MBG) - BAPPERIDA Pringsewu" />

    <PublicLayout>
        <!-- Hero Section -->
        <section class="bg-gradient-to-b from-teal-950 via-teal-900 to-slate-900 text-white pt-12 pb-20 relative overflow-hidden border-b border-teal-800/40">
            <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#5eead4_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none" />

            <div class="max-w-7xl mx-auto px-4 sm:px-8 relative space-y-6">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-800/70 border border-teal-500/40 text-xs font-bold text-teal-200">
                    <ShieldCheck class="w-4 h-4 text-teal-300" />
                    <span>Satuan Tugas Percepatan Program Makan Bergizi Gratis (MBG)</span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-8 space-y-4">
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight">
                            Audit Kelayakan Operasional SPPG
                        </h1>
                        <p class="text-sm sm:text-base text-teal-100/90 max-w-2xl leading-relaxed">
                            Aplikasi inspeksi checklist resmi Satgas MBG Kabupaten Pringsewu berdasarkan pedoman Badan Gizi Nasional (BGN). Menjamin 14 indikator higiene, rantai dingin, legalitas dapur, dan keamanan pangan bagi penerima manfaat.
                        </p>

                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <Link
                                href="/audit-sppg/form"
                                class="inline-flex items-center gap-2 px-6 py-3.5 rounded-2xl bg-teal-600 hover:bg-teal-500 text-white text-xs sm:text-sm font-bold transition-all shadow-lg hover:shadow-xl group"
                            >
                                <Plus class="w-4 h-4 group-hover:rotate-90 transition-transform" />
                                <span>Mulai Pengisian Form Checklist</span>
                            </Link>

                            <button
                                type="button"
                                class="inline-flex items-center gap-2 px-5 py-3.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs sm:text-sm font-bold transition-all cursor-pointer"
                                @click="openGuide(1)"
                            >
                                <BookOpen class="w-4 h-4 text-teal-300" />
                                <span>Lihat Paparan Panduan BGN</span>
                            </button>
                        </div>
                    </div>

                    <!-- Quick Summary Badge -->
                    <div class="lg:col-span-4 bg-white/10 backdrop-blur-md rounded-3xl p-6 border border-white/15 space-y-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-teal-300 block">
                            Standar Penilaian 100% Bobot
                        </span>
                        <div class="space-y-2.5 text-xs">
                            <div class="flex items-center justify-between p-2.5 rounded-xl bg-white/10">
                                <span class="font-bold">Keamanan Pangan (Food Safety)</span>
                                <span class="font-mono font-bold text-teal-300">65% (Kritis)</span>
                            </div>
                            <div class="flex items-center justify-between p-2.5 rounded-xl bg-white/10">
                                <span class="font-bold">Legalitas & Tenaga SDM</span>
                                <span class="font-mono font-bold text-teal-300">23%</span>
                            </div>
                            <div class="flex items-center justify-between p-2.5 rounded-xl bg-white/10">
                                <span class="font-bold">Lahan & Keselamatan Kerja</span>
                                <span class="font-mono font-bold text-teal-300">12%</span>
                            </div>
                        </div>
                        <div class="pt-2 text-[11px] text-teal-200/80 flex items-center justify-between border-t border-white/10">
                            <span>Kriteria Lulus: <strong>Grade A & B</strong></span>
                            <span>Grade D: <strong>Tidak Layak</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Bar -->
        <section class="max-w-7xl mx-auto px-4 sm:px-8 -mt-10 relative z-10">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-800 flex items-center justify-center shrink-0">
                        <Building2 class="w-6 h-6" />
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 font-medium block">Total SPPG Diaudit</span>
                        <span class="text-2xl font-black text-slate-900 font-mono">{{ stats.total_audits }}</span>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-800 flex items-center justify-center shrink-0">
                        <Utensils class="w-6 h-6" />
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 font-medium block">Porsi PM per Hari</span>
                        <span class="text-2xl font-black text-slate-900 font-mono">{{ Number(stats.total_pm).toLocaleString('id-ID') }}</span>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-800 flex items-center justify-center shrink-0">
                        <CheckCircle2 class="w-6 h-6" />
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 font-medium block">Layak Dilanjutkan</span>
                        <span class="text-2xl font-black text-emerald-700 font-mono">{{ stats.grade_a_count + stats.grade_b_count }}</span>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-800 flex items-center justify-center shrink-0">
                        <Activity class="w-6 h-6" />
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 font-medium block">Rata-Rata Skor</span>
                        <span class="text-2xl font-black text-slate-900 font-mono">{{ stats.avg_score }}%</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3 Pilar Penilaian Infografis -->
        <section class="max-w-7xl mx-auto px-4 sm:px-8 py-14 space-y-8">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-xs font-bold text-teal-800 uppercase tracking-wider">
                    Struktur Penilaian BGN
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    3 Pilar Penilaian Kelayakan Dapur SPPG
                </h2>
                <p class="text-xs sm:text-sm text-slate-500">
                    Akumulasi 14 indikator berbasis bukti foto timestamp dan observasi lapangan
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    v-for="pilar in SPPG_CATEGORIES"
                    :key="pilar.key"
                    class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200/90 shadow-xs hover:shadow-md transition-all flex flex-col justify-between group"
                >
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-mono font-bold px-3 py-1 rounded-full bg-teal-50 text-teal-800 border border-teal-200">
                                Bobot {{ pilar.weight }}
                            </span>
                            <span class="text-[11px] text-slate-400 font-medium">
                                {{ pilar.indicators.length }} Indikator
                            </span>
                        </div>

                        <h3 class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-teal-800 transition-colors">
                            {{ pilar.title }}
                        </h3>

                        <p class="text-xs text-slate-600 leading-relaxed">
                            {{ pilar.description }}
                        </p>

                        <div class="space-y-1.5 pt-2 border-t border-slate-100">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">
                                Indikator Terkait:
                            </span>
                            <div class="flex flex-wrap gap-1.5">
                                <button
                                    v-for="indId in pilar.indicators"
                                    :key="indId"
                                    type="button"
                                    class="text-[11px] font-bold px-2 py-0.5 rounded-lg bg-slate-100 hover:bg-teal-100 text-slate-700 hover:text-teal-900 transition-colors cursor-pointer"
                                    @click="openGuide(indId)"
                                >
                                    {{ SPPG_GUIDELINES[indId]?.code }}: {{ SPPG_GUIDELINES[indId]?.title }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Direktori Hasil Audit SPPG Pringsewu -->
        <section class="max-w-7xl mx-auto px-4 sm:px-8 pb-16 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 border-b border-slate-200 pb-4">
                <div>
                    <span class="text-xs font-bold text-teal-800 uppercase tracking-wider">
                        Transparansi & Akuntabilitas
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mt-0.5">
                        Daftar Hasil Audit SPPG Kabupaten Pringsewu
                    </h2>
                </div>

                <!-- Search & Filters -->
                <div class="flex flex-wrap items-center gap-2">
                    <div class="relative">
                        <Search class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" />
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Cari SPPG / ID 8 digit..."
                            class="pl-9 pr-3 py-2 rounded-xl border border-slate-200 text-xs w-48 sm:w-60 focus:border-teal-600"
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

                    <button
                        type="button"
                        class="px-4 py-2 rounded-xl bg-teal-800 hover:bg-teal-900 text-white text-xs font-bold transition-all cursor-pointer"
                        @click="handleFilter"
                    >
                        Filter
                    </button>
                </div>
            </div>

            <!-- Grid Kartu Audit SPPG -->
            <div v-if="audits.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="item in audits.data"
                    :key="item.id"
                    class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs hover:shadow-md hover:border-teal-400 transition-all flex flex-col justify-between group"
                >
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-mono font-bold px-2.5 py-1 rounded-lg bg-slate-100 text-slate-700">
                                ID: {{ item.sppg_id_code }}
                            </span>
                            <span
                                class="px-2.5 py-0.5 rounded-full text-[11px] font-black border"
                                :class="item.grade === 'Grade A' ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : (item.grade === 'Grade B' ? 'bg-amber-50 text-amber-800 border-amber-300' : 'bg-rose-50 text-rose-800 border-rose-300')"
                            >
                                {{ item.grade }}
                            </span>
                        </div>

                        <div>
                            <span class="text-[10px] font-bold text-teal-800 uppercase tracking-wider block">
                                SPPG {{ item.sppg_type }}
                            </span>
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-teal-800 transition-colors leading-snug mt-0.5">
                                {{ item.sppg_name }}
                            </h3>
                        </div>

                        <div class="grid grid-cols-2 gap-2 p-3 rounded-2xl bg-slate-50 text-xs">
                            <div>
                                <span class="text-[10px] text-slate-400 block">Kapasitas PM:</span>
                                <span class="font-bold text-slate-800 font-mono">{{ item.beneficiary_count }} porsi/hari</span>
                            </div>
                            <div>
                                <span class="text-[10px] text-slate-400 block">Skor Total:</span>
                                <span class="font-bold font-mono text-slate-900 text-sm">{{ item.total_score }}%</span>
                            </div>
                        </div>

                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed italic">
                            "{{ item.recommendation_reason || 'Rekomendasi resmi tercatat oleh Satgas MBG.' }}"
                        </p>
                    </div>

                    <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="text-[11px] text-slate-400 font-mono">
                            {{ item.inspection_date }}
                        </span>

                        <Link
                            :href="`/audit-sppg/${item.id}`"
                            class="inline-flex items-center gap-1.5 font-bold text-teal-800 hover:text-teal-900 group/btn"
                        >
                            <span>Lihat Lembar Audit</span>
                            <ChevronRight class="w-3.5 h-3.5 group-hover/btn:translate-x-0.5 transition-transform" />
                        </Link>
                    </div>
                </div>
            </div>

            <div v-else class="text-center py-16 bg-white rounded-3xl border border-slate-200 p-8 space-y-3">
                <Building2 class="w-12 h-12 text-slate-300 mx-auto" />
                <h3 class="text-base font-bold text-slate-700">Belum Ada Data Audit</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                    Data audit tidak ditemukan untuk pencarian ini. Silakan mulai audit baru atau reset filter pencarian.
                </p>
                <Link
                    href="/audit-sppg/form"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-teal-800 text-white text-xs font-bold"
                >
                    <Plus class="w-4 h-4" /> Mulai Audit Baru
                </Link>
            </div>
        </section>

        <!-- Sppg Guide Modal -->
        <SppgGuideModal
            :is-open="isGuideModalOpen"
            :indicator-id="activeGuideId"
            @close="isGuideModalOpen = false"
        />
    </PublicLayout>
</template>
