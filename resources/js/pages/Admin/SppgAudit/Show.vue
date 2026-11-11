<script setup lang="ts">
import { computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { notify } from '@/lib/toast';
import {
    ArrowLeft,
    Printer,
    BadgeCheck,
    Building2,
    Calendar,
    CheckCircle2,
    AlertCircle,
    Activity,
    ShieldCheck,
    Utensils,
    Users,
    Scale,
    ExternalLink,
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
    satgas_leader_name: string;
    created_at: string;
}

interface Props {
    audit: AuditItem;
}

const props = defineProps<Props>();

const toggleVerify = () => {
    router.patch(`/admin/sppg-audits/${props.audit.id}/toggle-verify`, {}, {
        onSuccess: () => {
            notify.success('Status verifikasi berhasil diubah.');
        },
    });
};
</script>

<template>
    <Head :title="`Detail Analisa Audit - ${audit.sppg_name}`" />

    <AdminLayout title="Detail Analisa Audit SPPG" breadcrumb="Detail Audit">
        <div class="space-y-6 max-w-5xl mx-auto">
            <div class="flex items-center justify-between">
                <Link
                    href="/admin/sppg-audits"
                    class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-teal-800 transition-colors"
                >
                    <ArrowLeft class="w-4 h-4" />
                    <span>Kembali ke Daftar Audit</span>
                </Link>

                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        class="px-3.5 py-2 rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 cursor-pointer"
                        :class="audit.status === 'verified' ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-100 text-slate-700 hover:bg-slate-200'"
                        @click="toggleVerify"
                    >
                        <BadgeCheck class="w-4 h-4" />
                        <span>{{ audit.status === 'verified' ? 'Terverifikasi Resmi' : 'Tandai Verifikasi' }}</span>
                    </button>

                    <Link
                        :href="`/audit-sppg/${audit.id}`"
                        target="_blank"
                        class="px-4 py-2 rounded-xl bg-teal-800 hover:bg-teal-900 text-white text-xs font-bold transition-all shadow-xs flex items-center gap-1.5"
                    >
                        <Printer class="w-4 h-4" />
                        <span>Cetak Lampiran 1</span>
                        <ExternalLink class="w-3 h-3 opacity-70" />
                    </Link>
                </div>
            </div>

            <!-- Header Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-mono font-bold px-2.5 py-0.5 rounded-lg bg-slate-100 text-slate-700">
                            ID: {{ audit.sppg_id_code }}
                        </span>
                        <span class="text-xs font-mono text-slate-400">
                            {{ audit.inspection_number }}
                        </span>
                    </div>
                    <h1 class="text-2xl font-black text-slate-900">
                        {{ audit.sppg_name }}
                    </h1>
                    <p class="text-xs text-slate-500">
                        Tipe SPPG: <strong>{{ audit.sppg_type }}</strong> • Wilayah: <strong>{{ audit.regency_city }}</strong> • Diinspeksi oleh: <strong>{{ audit.inspector_name }}</strong>
                    </p>
                </div>

                <div class="text-center p-4 rounded-2xl border min-w-44" :class="audit.grade === 'Grade A' ? 'bg-emerald-50 border-emerald-300 text-emerald-900' : (audit.grade === 'Grade B' ? 'bg-amber-50 border-amber-300 text-amber-900' : 'bg-rose-50 border-rose-300 text-rose-900')">
                    <span class="text-[10px] font-bold uppercase tracking-wider block">Skor Evaluasi BGN</span>
                    <span class="text-3xl font-black font-mono">{{ audit.total_score }}%</span>
                    <span class="text-xs font-bold block mt-1">{{ audit.grade }}</span>
                </div>
            </div>

            <!-- 3 Pilar Breakdown -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs space-y-2">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-500 uppercase">
                        <span>Pilar 1: Legalitas & SDM</span>
                        <span class="font-mono text-blue-700">{{ audit.score_legalitas_sdm }}% / 23%</span>
                    </div>
                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-600 rounded-full" :style="{ width: `${(audit.score_legalitas_sdm / 23) * 100}%` }" />
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs space-y-2">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-500 uppercase">
                        <span>Pilar 2: Keamanan Pangan</span>
                        <span class="font-mono text-emerald-700">{{ audit.score_keamanan_pangan }}% / 65%</span>
                    </div>
                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-600 rounded-full" :style="{ width: `${(audit.score_keamanan_pangan / 65) * 100}%` }" />
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-xs space-y-2">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-500 uppercase">
                        <span>Pilar 3: Lahan & K3</span>
                        <span class="font-mono text-amber-700">{{ audit.score_lahan_keselamatan }}% / 12%</span>
                    </div>
                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500 rounded-full" :style="{ width: `${(audit.score_lahan_keselamatan / 12) * 100}%` }" />
                    </div>
                </div>
            </div>

            <!-- Rekomendasi Resmi -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-3 text-xs">
                <span class="font-bold text-slate-800 uppercase tracking-wider block">Catatan Rekomendasi Resmi Satgas MBG</span>
                <p class="text-sm italic text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-2xl border border-slate-200/80">
                    "{{ audit.recommendation_reason || 'Tidak ada catatan khusus yang dilampirkan.' }}"
                </p>
                <div class="flex items-center justify-between text-slate-400 pt-2">
                    <span>Disahkan oleh: <strong>{{ audit.satgas_leader_name }}</strong></span>
                    <span>Tanggal: <strong>{{ audit.inspection_date }}</strong></span>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
