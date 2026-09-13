<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    BarChart3,
    ChevronRight,
    Users,
    GraduationCap,
    Award,
    CheckCircle2
} from 'lucide-vue-next';

const employeeStats = [
    { label: 'Total Aparatur Sipil Negara', value: '42', unit: 'Orang', note: 'PNS & PPPK Aktif' },
    { label: 'Tingkat Pendidikan S2 / Magister', value: '12', unit: 'Orang', note: '28.5% dari seluruh aparatur' },
    { label: 'Tingkat Pendidikan S1 / Sarjana', value: '24', unit: 'Orang', note: '57.1% dari seluruh aparatur' },
    { label: 'Pejabat Fungsional (Perencana/Peneliti)', value: '18', unit: 'Orang', note: 'Tenaga Fungsional Khusus' },
];
</script>

<template>
    <Head title="Statistik Pegawai - BAPPERIDA Kabupaten Pringsewu" />

    <PublicLayout>
        <!-- Breadcrumb Bar -->
        <div class="bg-slate-100/80 border-b border-slate-200/80 py-2.5 px-4 sm:px-8">
            <div class="max-w-7xl mx-auto flex items-center gap-2 text-xs text-slate-600">
                <Link href="/" class="hover:text-teal-800 transition-colors">Beranda</Link>
                <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                <span class="text-slate-400">Profil</span>
                <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                <span class="font-semibold text-teal-800">Statistik Pegawai</span>
            </div>
        </div>

        <!-- Header Banner -->
        <section class="relative bg-gradient-to-r from-teal-950 via-teal-900 to-slate-900 text-white py-14 sm:py-20 px-4 sm:px-8 overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#00C096_1px,transparent_1px)] [background-size:20px_20px] pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative max-w-7xl mx-auto space-y-4">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-500/20 border border-teal-400/30 text-xs font-semibold text-teal-200">
                    <BarChart3 class="w-3.5 h-3.5" />
                    <span>Demografi Kepegawaian</span>
                </div>
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white max-w-4xl leading-tight">
                    Statistik Pegawai BAPPERIDA
                </h1>
                <p class="text-sm sm:text-base text-teal-100/90 max-w-3xl leading-relaxed">
                    Data profil demografi aparatur sipil negara BAPPERIDA Kabupaten Pringsewu berdasarkan jenjang pendidikan, golongan kepangkatan, dan rumpun jabatan.
                </p>
            </div>
        </section>

        <!-- Main Content -->
        <main class="py-12 sm:py-16 bg-slate-50/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-12">
                <!-- Highlight Metrics -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div
                        v-for="stat in employeeStats"
                        :key="stat.label"
                        class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-2"
                    >
                        <span class="text-xs font-semibold text-slate-500">{{ stat.label }}</span>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-black text-teal-800">{{ stat.value }}</span>
                            <span class="text-xs font-bold text-slate-600">{{ stat.unit }}</span>
                        </div>
                        <p class="text-[11px] text-slate-400">{{ stat.note }}</p>
                    </div>
                </div>

                <!-- Composition Panels -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Jenjang Pendidikan -->
                    <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center font-bold">
                                <GraduationCap class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Distribusi Jenjang Pendidikan</h3>
                                <p class="text-[11px] text-slate-500">Kualifikasi akademik aparatur sipil negara</p>
                            </div>
                        </div>

                        <div class="space-y-3.5 pt-2">
                            <div>
                                <div class="flex justify-between text-xs font-medium mb-1">
                                    <span class="text-slate-700">Pascasarjana (S2 / Magister)</span>
                                    <span class="font-bold text-teal-800">12 Orang (28.5%)</span>
                                </div>
                                <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-teal-800 rounded-full" style="width: 28.5%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-medium mb-1">
                                    <span class="text-slate-700">Sarjana (S1)</span>
                                    <span class="font-bold text-teal-800">24 Orang (57.1%)</span>
                                </div>
                                <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-teal-600 rounded-full" style="width: 57.1%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-medium mb-1">
                                    <span class="text-slate-700">Diploma (D3)</span>
                                    <span class="font-bold text-teal-800">4 Orang (9.5%)</span>
                                </div>
                                <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-teal-500 rounded-full" style="width: 9.5%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-medium mb-1">
                                    <span class="text-slate-700">SMA / SMK Sederajat</span>
                                    <span class="font-bold text-teal-800">2 Orang (4.9%)</span>
                                </div>
                                <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-teal-400 rounded-full" style="width: 4.9%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Distribusi Golongan & Jabatan -->
                    <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center font-bold">
                                <Users class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Distribusi Golongan Kepangkatan</h3>
                                <p class="text-[11px] text-slate-500">Berdasarkan jenjang golongan ruang kepegawaian</p>
                            </div>
                        </div>

                        <div class="space-y-3.5 pt-2">
                            <div>
                                <div class="flex justify-between text-xs font-medium mb-1">
                                    <span class="text-slate-700">Golongan IV (Pembina)</span>
                                    <span class="font-bold text-teal-800">8 Orang (19.0%)</span>
                                </div>
                                <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-emerald-700 rounded-full" style="width: 19%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-medium mb-1">
                                    <span class="text-slate-700">Golongan III (Penata)</span>
                                    <span class="font-bold text-teal-800">26 Orang (62.0%)</span>
                                </div>
                                <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-emerald-600 rounded-full" style="width: 62%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs font-medium mb-1">
                                    <span class="text-slate-700">Golongan II (Pengatur)</span>
                                    <span class="font-bold text-teal-800">8 Orang (19.0%)</span>
                                </div>
                                <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-emerald-500 rounded-full" style="width: 19%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </PublicLayout>
</template>
