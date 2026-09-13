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
    MessageSquare,
    Share2,
    Video,
    Camera
} from 'lucide-vue-next';

// Akun Media Sosial Resmi Sesuai Dokumen Resmi BAPPERIDA
const socialMediaList = [
    {
        name: 'Instagram',
        handle: '@bapperidapsw',
        url: 'https://www.instagram.com/bapperidapsw',
        description: 'Informasi visual terkini, liputan kegiatan kedinasan, agenda perencanaan, dan infografis pembangunan Kabupaten Pringsewu.',
        color: 'from-pink-500 via-red-500 to-amber-500',
        textColor: 'text-pink-600',
        bgColor: 'bg-pink-50',
        borderColor: 'border-pink-200',
        badge: 'Instagram Resmi',
        btnText: 'Ikuti @bapperidapsw'
    },
    {
        name: 'YouTube',
        handle: 'swarabapperida',
        url: 'https://www.youtube.com/@swarabapperida',
        description: 'Kanal video dokumentasi perencanaan, liputan forum konsultasi publik, podcast bincang inovasi daerah, dan siaran edukasi pembangunan.',
        color: 'from-red-600 to-red-700',
        textColor: 'text-red-600',
        bgColor: 'bg-red-50',
        borderColor: 'border-red-200',
        badge: 'YouTube Channel',
        btnText: 'Subscribe swarabapperida'
    }
];
</script>

<template>
    <Head title="Kontak & Media Sosial - BAPPERIDA Kabupaten Pringsewu" />

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
                    <span>Layanan Informasi & Saluran Komunikasi Publik</span>
                </div>
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white max-w-4xl leading-tight">
                    Kontak & Media Sosial Resmi
                </h1>
                <p class="text-sm sm:text-base text-teal-100/90 max-w-3xl leading-relaxed">
                    Terhubung langsung dengan BAPPERIDA Kabupaten Pringsewu melalui kantor pelayanan, surat elektronik resmi, dan jejaring media sosial interaktif kami.
                </p>
            </div>
        </section>

        <!-- Main Content -->
        <main class="py-12 sm:py-16 bg-slate-50/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-16">

                <!-- 1. SECTION: MEDIA SOSIAL RESMI BAPPERIDA (HIGHLIGHT) -->
                <div class="space-y-6">
                    <div class="text-center max-w-2xl mx-auto space-y-2">
                        <span class="text-xs font-bold text-teal-700 uppercase tracking-widest block">
                            Saluran Informasi Digital
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                            Media Sosial Resmi BAPPERIDA
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600">
                            Ikuti publikasi visual dan dokumentasi video inovasi perencanaan pembangunan Kabupaten Pringsewu.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                        <!-- Instagram Card -->
                        <div class="rounded-3xl bg-white border border-slate-200/90 shadow-lg hover:shadow-xl hover:border-pink-300 transition-all p-8 flex flex-col justify-between space-y-6 relative overflow-hidden group">
                            <!-- Background Subtle Accent -->
                            <div class="absolute -top-12 -right-12 w-40 h-40 bg-gradient-to-br from-pink-500/10 to-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>

                            <div class="space-y-5">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3.5">
                                        <!-- Instagram SVG Icon Box -->
                                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-amber-500 via-pink-500 to-purple-600 text-white flex items-center justify-center shadow-md shadow-pink-500/20 shrink-0">
                                            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/>
                                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
                                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-pink-50 text-pink-700 uppercase tracking-wider">
                                                Instagram Resmi
                                            </span>
                                            <h3 class="text-xl sm:text-2xl font-black text-slate-900 leading-tight mt-1">
                                                @bapperidapsw
                                            </h3>
                                        </div>
                                    </div>
                                </div>

                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                    Dapatkan update info infografis perencanaan, dokumentasi agenda kedinasan, kegiatan riset, dan publikasi inovasi daerah Kabupaten Pringsewu.
                                </p>
                            </div>

                            <div class="pt-4 border-t border-slate-100">
                                <a
                                    href="https://www.instagram.com/bapperidapsw"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="w-full py-3 px-5 rounded-2xl bg-gradient-to-r from-pink-600 via-purple-600 to-indigo-600 hover:opacity-95 text-white font-bold text-xs sm:text-sm flex items-center justify-center gap-2 shadow-sm shadow-pink-600/20 transition-transform active:scale-98"
                                >
                                    <span>Kunjungi Instagram @bapperidapsw</span>
                                    <ExternalLink class="w-4 h-4" />
                                </a>
                            </div>
                        </div>

                        <!-- YouTube Card -->
                        <div class="rounded-3xl bg-white border border-slate-200/90 shadow-lg hover:shadow-xl hover:border-red-300 transition-all p-8 flex flex-col justify-between space-y-6 relative overflow-hidden group">
                            <!-- Background Subtle Accent -->
                            <div class="absolute -top-12 -right-12 w-40 h-40 bg-red-500/10 rounded-full blur-2xl pointer-events-none"></div>

                            <div class="space-y-5">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3.5">
                                        <!-- YouTube SVG Icon Box -->
                                        <div class="w-14 h-14 rounded-2xl bg-red-600 text-white flex items-center justify-center shadow-md shadow-red-600/20 shrink-0">
                                            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-red-50 text-red-700 uppercase tracking-wider">
                                                YouTube Channel
                                            </span>
                                            <h3 class="text-xl sm:text-2xl font-black text-slate-900 leading-tight mt-1">
                                                swarabapperida
                                            </h3>
                                        </div>
                                    </div>
                                </div>

                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                    Tonton siaran dokumentasi forum konsultasi publik RKPD/RPJMD, podcast bincang inovasi daerah, serta video edukasi pembangunan Pringsewu.
                                </p>
                            </div>

                            <div class="pt-4 border-t border-slate-100">
                                <a
                                    href="https://www.youtube.com/@swarabapperida"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="w-full py-3 px-5 rounded-2xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs sm:text-sm flex items-center justify-center gap-2 shadow-sm shadow-red-600/20 transition-transform active:scale-98"
                                >
                                    <span>Tonton di YouTube swarabapperida</span>
                                    <ExternalLink class="w-4 h-4" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. SECTION: ALAMAT KANTOR & LAYANAN PUBLIK ONLINE -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start pt-8 border-t border-slate-200">
                    <!-- Detail Kontak Kantor -->
                    <div class="lg:col-span-6 space-y-6">
                        <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-200/90 shadow-xs space-y-6">
                            <h3 class="text-base font-bold text-slate-900">Alamat & Jam Pelayanan Kantor</h3>

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
                                    <h4 class="text-xs font-bold text-slate-900 uppercase">Telepon Pelayanan</h4>
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
                                    <h4 class="text-xs font-bold text-slate-900 uppercase">Email & Website Resmi</h4>
                                    <p class="text-xs text-slate-600 leading-relaxed">
                                        Email: <a href="mailto:bapperida@pringsewukab.go.id" class="text-teal-700 font-semibold hover:underline">bapperida@pringsewukab.go.id</a><br />
                                        Website Resmi: <a href="https://bapperida.pringsewukab.go.id" class="text-teal-700 font-semibold hover:underline">bapperida.pringsewukab.go.id</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Saluran Layanan Online & Aspirasi -->
                    <div class="lg:col-span-6 space-y-6">
                        <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-teal-900 via-teal-800 to-slate-900 text-white shadow-xl space-y-6">
                            <div class="space-y-2">
                                <span class="text-xs font-bold uppercase tracking-wider text-teal-300">Layanan Publik Online</span>
                                <h3 class="text-xl sm:text-2xl font-black">Permohonan Data & Aspirasi Publik</h3>
                                <p class="text-xs text-teal-100/80 leading-relaxed">
                                    Masyarakat, akademisi peneliti, mahasiswa, dan pemangku kepentingan dapat mengajukan permohonan data perencanaan dan menyampaikan aspirasi secara daring tanpa antre.
                                </p>
                            </div>

                            <div class="space-y-3 pt-2">
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
