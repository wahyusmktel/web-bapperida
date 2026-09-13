<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import {
    Menu,
    X,
    Home,
    FileText,
    Newspaper,
    Inbox,
    Phone,
    Sparkles,
    Shield,
    ExternalLink,
    ChevronRight,
    ArrowUpRight,
    Search,
} from 'lucide-vue-next';

interface Props {
    title?: string;
}

defineProps<Props>();

const page = usePage();
const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 20;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});

const navigation = [
    { name: 'Beranda', href: '/' },
    { name: 'Profil', href: '/profil' },
    { name: 'Dokumen Perencanaan', href: '/dokumen' },
    { name: 'Berita 6 Bidang', href: '/berita' },
    { name: 'Layanan & Aspirasi', href: '/layanan' },
];

const externalLinks = [
    { name: 'Pemkab Pringsewu', href: 'https://www.pringsewukab.go.id/' },
    { name: 'Satu Data Pringsewu', href: 'https://satudata.pringsewukab.go.id/' },
    { name: 'LPSE Pengadaan', href: 'https://lpse.pringsewukab.go.id/' },
    { name: 'ePajak Pringsewu', href: 'https://epajak.pringsewukab.go.id/' },
    { name: 'CCTV Pringsewu', href: 'https://cctv.pringsewukab.go.id/' },
    { name: 'SPAN LAPOR!', href: 'https://lapor.go.id/' },
];
</script>

<template>
    <div class="min-h-screen bg-slate-50 text-slate-800 flex flex-col font-sans selection:bg-teal-100 selection:text-teal-900 pb-16 md:pb-0">
        <!-- Top Gov Bar -->
        <div class="bg-teal-950 text-teal-200 text-[11px] py-1.5 px-4 sm:px-8 border-b border-teal-900/60 hidden sm:block">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <span class="flex items-center gap-1 font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400" />
                        Portal Resmi BAPPERIDA Kabupaten Pringsewu
                    </span>
                    <span class="text-teal-400/60">|</span>
                    <span>Maju, Mandiri, dan Berkelanjutan</span>
                </div>
                <div class="flex items-center gap-4 text-[11px]">
                    <a href="tel:07297081363" class="hover:text-white transition-colors">
                        Hubungi: 0729 - 7081363
                    </a>
                    <Link href="/admin/login" class="hover:text-white transition-colors flex items-center gap-1 text-teal-300">
                        <Shield class="w-3 h-3" />
                        Portal Administrator
                    </Link>
                </div>
            </div>
        </div>

        <!-- Sticky Header Navigation -->
        <header
            :class="[
                isScrolled ? 'bg-white/95 backdrop-blur-md shadow-xs border-b border-slate-200/80 py-3' : 'bg-white border-b border-slate-100 py-4',
                'sticky top-0 z-40 transition-all duration-200 px-4 sm:px-8',
            ]"
        >
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <!-- Logo & Identity -->
                <Link href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-teal-800 flex items-center justify-center text-white font-black text-lg shadow-sm group-hover:bg-teal-900 transition-colors tracking-tight">
                        BP
                    </div>
                    <div class="flex flex-col">
                        <span class="text-base font-black text-slate-900 tracking-tight leading-tight group-hover:text-teal-800 transition-colors">
                            BAPPERIDA
                        </span>
                        <span class="text-[11px] font-semibold text-teal-800 tracking-wide uppercase">
                            Kabupaten Pringsewu
                        </span>
                    </div>
                </Link>

                <!-- Desktop Nav Items -->
                <nav class="hidden lg:flex items-center gap-1">
                    <template v-for="item in navigation" :key="item.name">
                        <Link
                            :href="item.href"
                            :class="[
                                page.url === item.href || (item.href !== '/' && page.url.startsWith(item.href))
                                    ? 'text-teal-800 font-bold bg-teal-50/80'
                                    : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50 font-medium',
                                'px-3.5 py-2 rounded-xl text-xs transition-all duration-150',
                            ]"
                        >
                            {{ item.name }}
                        </Link>
                    </template>
                </nav>

                <!-- Header Actions -->
                <div class="hidden sm:flex items-center gap-2.5">
                    <Link
                        href="/dokumen"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-teal-800 bg-teal-50 hover:bg-teal-100 border border-teal-200/80 transition-all"
                    >
                        <FileText class="w-3.5 h-3.5 text-teal-700" />
                        Unduh RKPD
                    </Link>
                    <Link
                        href="/layanan"
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-white bg-teal-800 hover:bg-teal-900 active:scale-[0.98] transition-all shadow-xs"
                    >
                        <span>Aspirasi & Data</span>
                        <ArrowUpRight class="w-3.5 h-3.5" />
                    </Link>
                </div>

                <!-- Mobile Hamburger Toggle -->
                <button
                    type="button"
                    class="lg:hidden p-2 text-slate-600 hover:text-slate-900 rounded-xl"
                    @click="isMobileMenuOpen = true"
                >
                    <Menu class="w-6 h-6" />
                </button>
            </div>
        </header>

        <!-- Mobile Drawer Menu -->
        <div
            v-if="isMobileMenuOpen"
            class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-xs lg:hidden transition-opacity"
            @click="isMobileMenuOpen = false"
        />

        <div
            :class="[
                isMobileMenuOpen ? 'translate-x-0' : 'translate-x-full',
                'fixed inset-y-0 right-0 z-50 w-80 bg-white shadow-2xl p-6 transition-transform duration-300 ease-in-out lg:hidden flex flex-col justify-between',
            ]"
        >
            <div class="space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-teal-800 flex items-center justify-center text-white font-bold text-sm">
                            BP
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-slate-900">BAPPERIDA</span>
                            <span class="text-[10px] text-teal-800 font-semibold">Kab. Pringsewu</span>
                        </div>
                    </div>
                    <button class="p-1.5 text-slate-400 hover:text-slate-600" @click="isMobileMenuOpen = false">
                        <X class="w-5 h-5" />
                    </button>
                </div>

                <!-- Navigation List -->
                <div class="space-y-1">
                    <template v-for="item in navigation" :key="item.name">
                        <Link
                            :href="item.href"
                            class="block px-3.5 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-teal-50 hover:text-teal-800 transition-colors"
                            @click="isMobileMenuOpen = false"
                        >
                            {{ item.name }}
                        </Link>
                    </template>
                </div>

                <!-- External Links in Drawer -->
                <div class="pt-4 border-t border-slate-100 space-y-1.5">
                    <span class="text-[10px] uppercase font-bold text-slate-400 px-3 block">
                        Tautan Pemerintah
                    </span>
                    <a
                        v-for="link in externalLinks"
                        :key="link.name"
                        :href="link.href"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs text-slate-600 hover:text-teal-800 hover:bg-slate-50"
                    >
                        <span>{{ link.name }}</span>
                        <ExternalLink class="w-3 h-3 opacity-50" />
                    </a>
                </div>
            </div>

            <!-- Drawer Bottom -->
            <div class="pt-4 border-t border-slate-100">
                <Link
                    href="/admin/login"
                    class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200"
                    @click="isMobileMenuOpen = false"
                >
                    <Shield class="w-3.5 h-3.5" />
                    Login Administrator
                </Link>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1">
            <slot />
        </main>

        <!-- Official Footer -->
        <footer class="bg-slate-900 text-slate-300 pt-14 pb-8 border-t border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-12">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Col 1: Instansi Brand -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-2xl bg-teal-700 flex items-center justify-center text-white font-black text-xl shadow-sm">
                                BP
                            </div>
                            <div class="flex flex-col">
                                <span class="text-base font-black text-white tracking-tight leading-tight">
                                    BAPPERIDA
                                </span>
                                <span class="text-xs font-bold text-teal-400 tracking-wide uppercase">
                                    Kabupaten Pringsewu
                                </span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah Kabupaten Pringsewu bertugas merumuskan kebijakan teknis perencanaan pembangunan makro, riset terpadu, dan penguatan ekosistem inovasi daerah.
                        </p>
                    </div>

                    <!-- Col 2: Kontak Resmi -->
                    <div class="space-y-3">
                        <h4 class="text-sm font-bold text-white tracking-tight">
                            Kontak & Lokasi
                        </h4>
                        <div class="space-y-2 text-xs text-slate-400 leading-relaxed">
                            <p class="flex items-start gap-2">
                                <span class="text-teal-400 font-bold">📍</span>
                                <span>Jl. Dr. Sugiri Syarief, MPH, Komplek Perkantoran Pemkab, Kode Pos 35373, Pringsewu - Lampung</span>
                            </p>
                            <p class="flex items-center gap-2">
                                <span class="text-teal-400 font-bold">📞</span>
                                <span>0729 - 7081363</span>
                            </p>
                            <p class="flex items-center gap-2">
                                <span class="text-teal-400 font-bold">✉️</span>
                                <span>bapperida@pringsewukab.go.id</span>
                            </p>
                            <p class="flex items-center gap-2">
                                <span class="text-teal-400 font-bold">📷</span>
                                <span>@bapperridapsw</span>
                            </p>
                        </div>
                    </div>

                    <!-- Col 3: Layanan & Tautan Cepat -->
                    <div class="space-y-3">
                        <h4 class="text-sm font-bold text-white tracking-tight">
                            Layanan Publik
                        </h4>
                        <ul class="space-y-2 text-xs text-slate-400">
                            <li>
                                <Link href="/dokumen" class="hover:text-teal-300 transition-colors flex items-center gap-1.5">
                                    <ChevronRight class="w-3 h-3 text-teal-400" />
                                    Dokumen Perencanaan (RKPD/RPJMD)
                                </Link>
                            </li>
                            <li>
                                <Link href="/layanan" class="hover:text-teal-300 transition-colors flex items-center gap-1.5">
                                    <ChevronRight class="w-3 h-3 text-teal-400" />
                                    Permohonan Data & Informasi Publik
                                </Link>
                            </li>
                            <li>
                                <Link href="/layanan" class="hover:text-teal-300 transition-colors flex items-center gap-1.5">
                                    <ChevronRight class="w-3 h-3 text-teal-400" />
                                    Survei Kepuasan Masyarakat (IKM)
                                </Link>
                            </li>
                            <li>
                                <a href="https://lapor.go.id/" target="_blank" rel="noopener noreferrer" class="hover:text-teal-300 transition-colors flex items-center gap-1.5">
                                    <ChevronRight class="w-3 h-3 text-teal-400" />
                                    Pengaduan SPAN-LAPOR!
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Col 4: Integrasi Daerah -->
                    <div class="space-y-3">
                        <h4 class="text-sm font-bold text-white tracking-tight">
                            Portal Terintegrasi
                        </h4>
                        <div class="space-y-2 text-xs">
                            <a
                                v-for="link in externalLinks.slice(0, 4)"
                                :key="link.name"
                                :href="link.href"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="flex items-center justify-between p-2 rounded-xl bg-slate-800/80 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-700/60 transition-colors"
                            >
                                <span>{{ link.name }}</span>
                                <ExternalLink class="w-3 h-3 opacity-60" />
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Bottom Copyright -->
                <div class="pt-8 border-t border-slate-800 text-center text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <span>
                        &copy; 2026 BAPPERIDA Kabupaten Pringsewu. Hak Cipta Dilindungi Undang-Undang.
                    </span>
                    <span class="text-slate-400 flex items-center gap-1">
                        Dikembangkan dengan standar arsitektur modern & berwibawa
                    </span>
                </div>
            </div>
        </footer>

        <!-- Thumb-Friendly Quick Access Bottom Navigation Bar for Mobile -->
        <nav class="md:hidden fixed bottom-0 inset-x-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200/80 shadow-lg px-2 py-1.5 flex items-center justify-around">
            <Link
                href="/"
                :class="page.url === '/' ? 'text-teal-800 font-bold' : 'text-slate-500'"
                class="flex flex-col items-center gap-1 py-1 px-3 text-[10px]"
            >
                <Home class="w-5 h-5" />
                <span>Beranda</span>
            </Link>
            <Link
                href="/dokumen"
                :class="page.url.startsWith('/dokumen') ? 'text-teal-800 font-bold' : 'text-slate-500'"
                class="flex flex-col items-center gap-1 py-1 px-3 text-[10px]"
            >
                <FileText class="w-5 h-5" />
                <span>Dokumen</span>
            </Link>
            <Link
                href="/layanan"
                :class="page.url.startsWith('/layanan') ? 'text-teal-800 font-bold' : 'text-slate-500'"
                class="flex flex-col items-center gap-1 py-1 px-3 text-[10px]"
            >
                <Inbox class="w-5 h-5" />
                <span>Layanan</span>
            </Link>
            <Link
                href="/berita"
                :class="page.url.startsWith('/berita') ? 'text-teal-800 font-bold' : 'text-slate-500'"
                class="flex flex-col items-center gap-1 py-1 px-3 text-[10px]"
            >
                <Newspaper class="w-5 h-5" />
                <span>Berita</span>
            </Link>
            <Link
                href="/profil"
                :class="page.url.startsWith('/profil') ? 'text-teal-800 font-bold' : 'text-slate-500'"
                class="flex flex-col items-center gap-1 py-1 px-3 text-[10px]"
            >
                <Sparkles class="w-5 h-5" />
                <span>Profil</span>
            </Link>
        </nav>
    </div>
</template>
