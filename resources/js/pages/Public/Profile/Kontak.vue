<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    MapPin,
    Phone,
    Mail,
    Clock,
    ChevronRight,
    FileText,
    ExternalLink,
    Send,
    MessageSquare
} from 'lucide-vue-next';
</script>

<template>
    <Head title="Kontak Kami - BAPPERIDA Kabupaten Pringsewu" />

    <PublicLayout>
        <!-- Breadcrumb Bar -->
        <div class="bg-slate-100/80 border-b border-slate-200/80 py-2.5 px-4 sm:px-8">
            <div class="max-w-7xl mx-auto flex items-center gap-2 text-xs text-slate-600">
                <Link href="/" class="hover:text-teal-800 transition-colors">Beranda</Link>
                <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                <span class="text-slate-400">Profil</span>
                <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                <span class="font-semibold text-teal-800">Kontak Kami</span>
            </div>
        </div>

        <!-- Header Banner -->
        <section class="relative bg-gradient-to-r from-teal-950 via-teal-900 to-slate-900 text-white py-14 sm:py-20 px-4 sm:px-8 overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#00C096_1px,transparent_1px)] [background-size:20px_20px] pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative max-w-7xl mx-auto space-y-4">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-500/20 border border-teal-400/30 text-xs font-semibold text-teal-200">
                    <MapPin class="w-3.5 h-3.5" />
                    <span>Layanan Informasi & Kontak</span>
                </div>
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white max-w-4xl leading-tight">
                    Kontak BAPPERIDA Pringsewu
                </h1>
                <p class="text-sm sm:text-base text-teal-100/90 max-w-3xl leading-relaxed">
                    Kami siap melayani kebutuhan data perencanaan, fasilitasi riset akademis, pendaftaran inovasi daerah, dan permohonan informasi publik Anda.
                </p>
            </div>
        </section>

        <!-- Main Content -->
        <main class="py-12 sm:py-16 bg-slate-50/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <!-- Detail Kontak Kantor -->
                    <div class="lg:col-span-6 space-y-6">
                        <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-6">
                            <h3 class="text-base font-bold text-slate-900">Alamat & Jam Operasional</h3>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0">
                                    <MapPin class="w-5 h-5" />
                                </div>
                                <div class="space-y-1">
                                    <h4 class="text-xs font-bold text-slate-900 uppercase">Kantor Pusat</h4>
                                    <p class="text-xs text-slate-600 leading-relaxed">
                                        Kompleks Perkantoran Pemerintah Kabupaten Pringsewu<br />
                                        Jl. Dr. Sugiri Syarief, MPH, Pekon Way Rejo, Kec. Pagelaran, Kabupaten Pringsewu, Provinsi Lampung 35372
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0">
                                    <Clock class="w-5 h-5" />
                                </div>
                                <div class="space-y-1">
                                    <h4 class="text-xs font-bold text-slate-900 uppercase">Jam Pelayanan Kantor</h4>
                                    <p class="text-xs text-slate-600 leading-relaxed">
                                        Senin – Kamis : 07.30 – 16.00 WIB<br />
                                        Jumat : 07.30 – 16.30 WIB<br />
                                        Sabtu, Minggu & Libur Nasional : Tutup
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0">
                                    <Phone class="w-5 h-5" />
                                </div>
                                <div class="space-y-1">
                                    <h4 class="text-xs font-bold text-slate-900 uppercase">Telepon & Fax</h4>
                                    <p class="text-xs text-slate-600 leading-relaxed">
                                        Telepon: (0729) 7081363<br />
                                        Call Center Pemkab Pringsewu: 112
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0">
                                    <Mail class="w-5 h-5" />
                                </div>
                                <div class="space-y-1">
                                    <h4 class="text-xs font-bold text-slate-900 uppercase">Email & Media Resmi</h4>
                                    <p class="text-xs text-slate-600 leading-relaxed">
                                        Email: <a href="mailto:bapperida@pringsewukab.go.id" class="text-teal-700 font-semibold hover:underline">bapperida@pringsewukab.go.id</a><br />
                                        Portal: <a href="https://bapperida.pringsewukab.go.id" class="text-teal-700 font-semibold hover:underline">bapperida.pringsewukab.go.id</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Saluran Layanan & Aspirasi -->
                    <div class="lg:col-span-6 space-y-6">
                        <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-teal-900 to-slate-900 text-white shadow-xl space-y-6">
                            <div class="space-y-2">
                                <span class="text-xs font-bold uppercase tracking-wider text-teal-300">Layanan Publik Online</span>
                                <h3 class="text-xl font-black">Permohonan Data & Aspirasi Publik</h3>
                                <p class="text-xs text-teal-100/80 leading-relaxed">
                                    Masyarakat, mahasiswa peneliti, akademisi, dan stakeholder dapat mengakses layanan informasi publik dan menyampaikan aspirasi pembangunan secara daring.
                                </p>
                            </div>

                            <div class="space-y-3">
                                <Link
                                    href="/layanan"
                                    class="flex items-center justify-between p-4 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/15 transition-colors group"
                                >
                                    <div class="flex items-center gap-3">
                                        <FileText class="w-5 h-5 text-teal-300" />
                                        <div>
                                            <div class="text-xs font-bold text-white">Formulir Permohonan Data & Informasi</div>
                                            <div class="text-[11px] text-teal-200">Layanan PPID Online BAPPERIDA</div>
                                        </div>
                                    </div>
                                    <ChevronRight class="w-4 h-4 text-white/60 group-hover:translate-x-0.5 transition-transform" />
                                </Link>

                                <a
                                    href="https://www.lapor.go.id"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex items-center justify-between p-4 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/15 transition-colors group"
                                >
                                    <div class="flex items-center gap-3">
                                        <ExternalLink class="w-5 h-5 text-teal-300" />
                                        <div>
                                            <div class="text-xs font-bold text-white">Saluran Pengaduan SPAN-LAPOR!</div>
                                            <div class="text-[11px] text-teal-200">Kanal aspirasi resmi terintegrasi nasional</div>
                                        </div>
                                    </div>
                                    <ChevronRight class="w-4 h-4 text-white/60 group-hover:translate-x-0.5 transition-transform" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </PublicLayout>
</template>
