<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import {
    FileText,
    Newspaper,
    Inbox,
    Users,
    TrendingUp,
    ShieldCheck,
    Clock,
    Sparkles,
    ArrowUpRight,
    Server,
    Database,
    Cpu,
    CheckCircle2,
} from 'lucide-vue-next';

interface ActivityItem {
    id: string;
    action: string;
    description: string;
    user_name: string;
    ip_address: string;
    created_at: string;
}

interface Props {
    stats: {
        total_users: number;
        total_documents: number;
        total_news: number;
        total_services: number;
        indexes: {
            iid: { name: string; score: string; category: string; year: number };
            idsd: { name: string; score: string; category: string; year: number };
            ipkd: { name: string; score: string; category: string; year: number };
        };
        system: {
            php_version: string;
            laravel_version: string;
            db_driver: string;
            server_time: string;
        };
    };
    recentActivities: ActivityItem[];
    currentUser: {
        id: string;
        name: string;
        email: string;
        role: string;
        last_login_at: string;
    };
}

defineProps<Props>();
</script>

<template>
    <Head title="Dashboard Administrasi - BAPPERIDA Pringsewu" />

    <AdminLayout title="Dashboard">
        <div class="space-y-8">
            <!-- Welcome Greeting Card -->
            <div class="relative overflow-hidden rounded-3xl bg-linear-to-r from-teal-900 via-teal-800 to-slate-900 p-6 sm:p-8 text-white shadow-lg">
                <div class="absolute -top-24 -right-24 w-72 h-72 bg-teal-500/20 rounded-full blur-3xl pointer-events-none" />
                <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-amber-500/10 rounded-full blur-3xl pointer-events-none" />

                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-xs text-xs font-medium text-teal-200">
                            <Sparkles class="w-3.5 h-3.5 text-teal-300" />
                            <span>Pusat Kendali Perencanaan & Riset Daerah</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">
                            Selamat Datang, {{ currentUser.name }}
                        </h1>
                        <p class="text-sm text-teal-100/80 max-w-2xl leading-relaxed">
                            Kelola dokumen perencanaan pembangunan, rilis berita 6 bidang, permohonan data publik, dan pantau indeks capaian Kabupaten Pringsewu dengan aman dan terpadu.
                        </p>
                    </div>

                    <div class="flex flex-col items-start md:items-end gap-1.5 shrink-0">
                        <span class="text-xs text-teal-200">Peran Akses</span>
                        <span class="inline-flex items-center px-3.5 py-1.5 rounded-xl bg-teal-700/60 border border-teal-500/30 text-xs font-bold text-white tracking-wide">
                            {{ currentUser.role }}
                        </span>
                        <span class="text-[11px] text-teal-300/70 mt-1 flex items-center gap-1">
                            <Clock class="w-3 h-3" />
                            Masuk: {{ currentUser.last_login_at }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Metric Statistics Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Stat 1: Dokumen Perencanaan -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <FileText class="w-6 h-6" />
                        </div>
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-teal-100/60 text-teal-800">
                            RPJMD & RKPD
                        </span>
                    </div>
                    <div class="mt-4">
                        <span class="text-3xl font-black text-slate-900 tracking-tight">
                            {{ stats.total_documents }}
                        </span>
                        <p class="text-xs font-semibold text-slate-500 mt-1">
                            Dokumen Perencanaan Publik
                        </p>
                    </div>
                </div>

                <!-- Stat 2: Berita & Publikasi -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <Newspaper class="w-6 h-6" />
                        </div>
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-blue-100/60 text-blue-800">
                            6 Bidang
                        </span>
                    </div>
                    <div class="mt-4">
                        <span class="text-3xl font-black text-slate-900 tracking-tight">
                            {{ stats.total_news }}
                        </span>
                        <p class="text-xs font-semibold text-slate-500 mt-1">
                            Rilis Berita & Publikasi
                        </p>
                    </div>
                </div>

                <!-- Stat 3: Permohonan Data & Layanan -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <Inbox class="w-6 h-6" />
                        </div>
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-amber-100/60 text-amber-800">
                            PPID & Data
                        </span>
                    </div>
                    <div class="mt-4">
                        <span class="text-3xl font-black text-slate-900 tracking-tight">
                            {{ stats.total_services }}
                        </span>
                        <p class="text-xs font-semibold text-slate-500 mt-1">
                            Aspirasi & Permohonan
                        </p>
                    </div>
                </div>

                <!-- Stat 4: Administrator Terdaftar -->
                <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <Users class="w-6 h-6" />
                        </div>
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-purple-100/60 text-purple-800">
                            RBAC Aktif
                        </span>
                    </div>
                    <div class="mt-4">
                        <span class="text-3xl font-black text-slate-900 tracking-tight">
                            {{ stats.total_users }}
                        </span>
                        <p class="text-xs font-semibold text-slate-500 mt-1">
                            Pengguna Administrator
                        </p>
                    </div>
                </div>
            </div>

            <!-- Regional Development Indexes Highlight -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-teal-600" />
                            <h2 class="text-lg font-bold text-slate-900">
                                Indeks Capaian Pembangunan Daerah
                            </h2>
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Metrik kinerja inovasi, daya saing, dan tata kelola keuangan BAPPERIDA Pringsewu
                        </p>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 bg-slate-50 px-3 py-1 rounded-full border border-slate-200/60 self-start sm:self-auto">
                        Tahun Penilaian 2025
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- IID -->
                    <div class="rounded-2xl p-5 bg-slate-50/70 border border-slate-200/70 space-y-2">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">
                            {{ stats.indexes.iid.name }}
                        </span>
                        <div class="flex items-baseline gap-2">
                            <span class="text-2xl font-black text-teal-800">
                                {{ stats.indexes.iid.score }}
                            </span>
                            <span class="text-xs font-bold px-2.5 py-0.5 rounded-md bg-teal-100 text-teal-800">
                                {{ stats.indexes.iid.category }}
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-400 leading-tight">
                            Kementerian Dalam Negeri RI
                        </p>
                    </div>

                    <!-- IDSD -->
                    <div class="rounded-2xl p-5 bg-slate-50/70 border border-slate-200/70 space-y-2">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">
                            {{ stats.indexes.idsd.name }}
                        </span>
                        <div class="flex items-baseline gap-2">
                            <span class="text-2xl font-black text-blue-800">
                                {{ stats.indexes.idsd.score }}
                            </span>
                            <span class="text-xs font-bold px-2.5 py-0.5 rounded-md bg-blue-100 text-blue-800">
                                {{ stats.indexes.idsd.category }}
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-400 leading-tight">
                            Badan Riset & Inovasi Nasional (BRIN)
                        </p>
                    </div>

                    <!-- IPKD -->
                    <div class="rounded-2xl p-5 bg-slate-50/70 border border-slate-200/70 space-y-2">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wide">
                            {{ stats.indexes.ipkd.name }}
                        </span>
                        <div class="flex items-baseline gap-2">
                            <span class="text-2xl font-black text-amber-800">
                                {{ stats.indexes.ipkd.score }}
                            </span>
                            <span class="text-xs font-bold px-2.5 py-0.5 rounded-md bg-amber-100 text-amber-800">
                                {{ stats.indexes.ipkd.category }}
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-400 leading-tight">
                            Pengelolaan Keuangan Daerah
                        </p>
                    </div>
                </div>
            </div>

            <!-- Two-Column Section: Audit Trail & System Status -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
                <!-- Audit Trail Widget (2 Cols) -->
                <div class="lg:col-span-2 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-800 flex items-center justify-center">
                                <ShieldCheck class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900">
                                    Log Aktivitas Keamanan (Audit Trail)
                                </h3>
                                <p class="text-xs text-slate-500">
                                    Riwayat mutasi data dan autentikasi administrator
                                </p>
                            </div>
                        </div>
                        <span class="text-xs text-slate-400 flex items-center gap-1 font-medium">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" />
                            Live
                        </span>
                    </div>

                    <!-- Activity List -->
                    <div class="divide-y divide-slate-100">
                        <div
                            v-for="log in recentActivities"
                            :key="log.id"
                            class="py-3.5 flex items-start justify-between gap-4 text-xs"
                        >
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-800">{{ log.user_name }}</span>
                                    <span class="px-2 py-0.5 rounded-md text-[10px] font-mono bg-slate-100 text-slate-600">
                                        {{ log.action }}
                                    </span>
                                </div>
                                <p class="text-slate-600 text-xs">
                                    {{ log.description }}
                                </p>
                                <span class="text-[11px] font-mono text-slate-400">
                                    IP: {{ log.ip_address }}
                                </span>
                            </div>

                            <span class="text-[11px] text-slate-400 whitespace-nowrap">
                                {{ log.created_at }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- System Health & Quick Actions (1 Col) -->
                <div class="space-y-6">
                    <!-- Quick Actions Card -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <Sparkles class="w-4 h-4 text-teal-700" />
                            Aksi Cepat
                        </h3>

                        <div class="space-y-2">
                            <a
                                href="#"
                                class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-700 bg-slate-50 hover:bg-teal-50 hover:text-teal-800 border border-slate-200/60 transition-all"
                            >
                                <span>Unggah Dokumen Perencanaan</span>
                                <ArrowUpRight class="w-3.5 h-3.5 opacity-60" />
                            </a>
                            <a
                                href="#"
                                class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-700 bg-slate-50 hover:bg-teal-50 hover:text-teal-800 border border-slate-200/60 transition-all"
                            >
                                <span>Tulis Berita Bidang Baru</span>
                                <ArrowUpRight class="w-3.5 h-3.5 opacity-60" />
                            </a>
                            <a
                                href="#"
                                class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-700 bg-slate-50 hover:bg-teal-50 hover:text-teal-800 border border-slate-200/60 transition-all"
                            >
                                <span>Perbarui Nilai Indeks Daerah</span>
                                <ArrowUpRight class="w-3.5 h-3.5 opacity-60" />
                            </a>
                        </div>
                    </div>

                    <!-- Environment & System Card -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-3">
                        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <Server class="w-4 h-4 text-teal-700" />
                            Status Infrastruktur
                        </h3>

                        <div class="space-y-2 text-xs divide-y divide-slate-100">
                            <div class="pt-1 flex items-center justify-between">
                                <span class="text-slate-500">PHP Framework</span>
                                <span class="font-mono font-bold text-slate-700">Laravel {{ stats.system.laravel_version }}</span>
                            </div>
                            <div class="pt-2 flex items-center justify-between">
                                <span class="text-slate-500">Versi PHP</span>
                                <span class="font-mono font-bold text-slate-700">v{{ stats.system.php_version }}</span>
                            </div>
                            <div class="pt-2 flex items-center justify-between">
                                <span class="text-slate-500">Database Driver</span>
                                <span class="font-bold text-slate-700 uppercase">{{ stats.system.db_driver }} (UUID)</span>
                            </div>
                            <div class="pt-2 flex items-center justify-between">
                                <span class="text-slate-500">Redis Driver</span>
                                <span class="inline-flex items-center gap-1 font-bold text-teal-700">
                                    <CheckCircle2 class="w-3.5 h-3.5" /> Siap Pakai
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
