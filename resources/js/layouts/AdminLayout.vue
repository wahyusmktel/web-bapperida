<script setup lang="ts">
import { ref } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { confirmAction } from '@/lib/swal';
import { notify } from '@/lib/toast';
import {
    LayoutDashboard,
    FileText,
    Newspaper,
    Inbox,
    BarChart3,
    Users,
    ShieldCheck,
    LogOut,
    ExternalLink,
    Menu,
    X,
    ChevronRight,
    Sparkles,
    Activity,
} from 'lucide-vue-next';

interface Props {
    title?: string;
    breadcrumb?: string;
}

defineProps<Props>();

const page = usePage();
const user = page.props.auth?.user as { name: string; email: string; id: string } | undefined;

const isMobileMenuOpen = ref(false);

const navigation = [
    {
        name: 'Dashboard',
        href: '/admin/dashboard',
        icon: LayoutDashboard,
        active: page.url.startsWith('/admin/dashboard'),
    },
    {
        name: 'Dokumen Perencanaan',
        href: '#',
        badge: 'Tahap 3',
        icon: FileText,
        active: page.url.startsWith('/admin/documents'),
    },
    {
        name: 'Publikasi & Berita',
        href: '#',
        badge: 'Tahap 3',
        icon: Newspaper,
        active: page.url.startsWith('/admin/news'),
    },
    {
        name: 'Layanan & Aspirasi',
        href: '#',
        badge: 'Tahap 3',
        icon: Inbox,
        active: page.url.startsWith('/admin/services'),
    },
    {
        name: 'Indeks & Laporan',
        href: '#',
        badge: 'Tahap 3',
        icon: BarChart3,
        active: page.url.startsWith('/admin/indexes'),
    },
    {
        name: 'Manajemen Pengguna',
        href: '#',
        icon: Users,
        active: page.url.startsWith('/admin/users'),
    },
    {
        name: 'Audit Trail Keamanan',
        href: '#',
        icon: ShieldCheck,
        active: page.url.startsWith('/admin/audit'),
    },
];

const handleLogout = async () => {
    const confirmed = await confirmAction({
        title: 'Konfirmasi Keluar',
        text: 'Apakah Anda yakin ingin mengakhiri sesi administrator ini?',
        confirmButtonText: 'Ya, Keluar',
        cancelButtonText: 'Tetap di Sini',
        isDestructive: true,
    });

    if (confirmed) {
        notify.info('Mengakhiri sesi...');
        router.post('/admin/logout');
    }
};
</script>

<template>
    <div class="min-h-screen bg-slate-50 text-slate-800 flex">
        <!-- Desktop Sidebar -->
        <aside
            class="hidden lg:flex lg:w-72 lg:flex-col fixed inset-y-0 z-30 bg-white border-r border-slate-200/80 shadow-xs"
        >
            <!-- Brand Header -->
            <div class="h-20 flex items-center px-6 border-b border-slate-100 gap-3">
                <div
                    class="w-11 h-11 rounded-xl bg-teal-800 flex items-center justify-center text-white font-black text-lg shadow-sm tracking-tighter"
                >
                    BP
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-black tracking-tight text-slate-900 leading-tight">
                        BAPPERIDA
                    </span>
                    <span class="text-[11px] font-medium text-teal-800 tracking-wide uppercase">
                        Kabupaten Pringsewu
                    </span>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 overflow-y-auto px-4 py-6 space-y-1.5">
                <div class="px-3 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">
                    Menu Utama
                </div>

                <template v-for="item in navigation" :key="item.name">
                    <Link
                        :href="item.href"
                        :class="[
                            item.active
                                ? 'bg-teal-50 text-teal-800 font-semibold border-l-3 border-teal-700'
                                : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900',
                            'group flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm transition-all duration-150',
                        ]"
                    >
                        <component
                            :is="item.icon"
                            :class="[
                                item.active ? 'text-teal-700' : 'text-slate-400 group-hover:text-slate-600',
                                'w-4 h-4 shrink-0 transition-colors',
                            ]"
                        />
                        <span class="truncate flex-1">{{ item.name }}</span>
                        <span
                            v-if="item.badge"
                            class="text-[10px] px-2 py-0.5 rounded-full font-medium bg-slate-100 text-slate-500"
                        >
                            {{ item.badge }}
                        </span>
                    </Link>
                </template>
            </div>

            <!-- Sidebar Footer / Quick Portal Link -->
            <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                <a
                    href="/"
                    target="_blank"
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-medium text-slate-600 hover:text-teal-800 hover:bg-teal-50/60 border border-slate-200/60 transition-all duration-150"
                >
                    <span class="flex items-center gap-2">
                        <Sparkles class="w-3.5 h-3.5 text-teal-700" />
                        Lihat Portal Publik
                    </span>
                    <ExternalLink class="w-3.5 h-3.5 opacity-60" />
                </a>
            </div>
        </aside>

        <!-- Mobile Drawer Overlay -->
        <div
            v-if="isMobileMenuOpen"
            class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-xs lg:hidden transition-opacity"
            @click="isMobileMenuOpen = false"
        />

        <!-- Mobile Drawer -->
        <aside
            :class="[
                isMobileMenuOpen ? 'translate-x-0' : '-translate-x-full',
                'fixed inset-y-0 left-0 z-50 w-72 bg-white shadow-2xl transition-transform duration-300 ease-in-out lg:hidden flex flex-col',
            ]"
        >
            <div class="h-20 flex items-center justify-between px-6 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-teal-800 flex items-center justify-center text-white font-bold text-base">
                        BP
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-slate-900">BAPPERIDA</span>
                        <span class="text-[11px] text-teal-800 font-medium">Kab. Pringsewu</span>
                    </div>
                </div>
                <button
                    class="p-2 text-slate-400 hover:text-slate-600 rounded-lg"
                    @click="isMobileMenuOpen = false"
                >
                    <X class="w-5 h-5" />
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-4 py-6 space-y-1">
                <template v-for="item in navigation" :key="item.name">
                    <Link
                        :href="item.href"
                        :class="[
                            item.active ? 'bg-teal-50 text-teal-800 font-semibold' : 'text-slate-600',
                            'flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm',
                        ]"
                        @click="isMobileMenuOpen = false"
                    >
                        <component :is="item.icon" class="w-4 h-4 text-slate-400" />
                        <span class="truncate">{{ item.name }}</span>
                    </Link>
                </template>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 lg:pl-72 flex flex-col min-h-screen">
            <!-- Top Header -->
            <header class="h-20 bg-white border-b border-slate-200/80 sticky top-0 z-20 flex items-center justify-between px-4 sm:px-8">
                <div class="flex items-center gap-4">
                    <button
                        class="lg:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 focus:outline-none"
                        @click="isMobileMenuOpen = true"
                    >
                        <Menu class="w-5 h-5" />
                    </button>

                    <div class="flex items-center gap-2 text-xs text-slate-500">
                        <span class="font-medium text-slate-400">Admin</span>
                        <ChevronRight class="w-3.5 h-3.5 text-slate-300" />
                        <span class="font-semibold text-slate-800">{{ breadcrumb || title || 'Dashboard' }}</span>
                    </div>
                </div>

                <!-- Right Header Actions -->
                <div class="flex items-center gap-4">
                    <!-- User Profile Badge -->
                    <div class="flex items-center gap-3 pl-3 py-1">
                        <div class="w-9 h-9 rounded-full bg-teal-100 text-teal-800 font-bold flex items-center justify-center text-xs ring-2 ring-teal-600/20">
                            {{ user?.name?.charAt(0) || 'A' }}
                        </div>
                        <div class="hidden sm:flex flex-col text-left">
                            <span class="text-xs font-bold text-slate-900 leading-tight">
                                {{ user?.name || 'Administrator' }}
                            </span>
                            <span class="text-[11px] text-teal-700 font-medium">
                                Super Administrator
                            </span>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <button
                        type="button"
                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all cursor-pointer"
                        title="Keluar dari Sistem"
                        @click="handleLogout"
                    >
                        <LogOut class="w-4 h-4" />
                    </button>
                </div>
            </header>

            <!-- Page Body -->
            <main class="flex-1 p-4 sm:p-8 max-w-7xl w-full mx-auto">
                <slot />
            </main>

            <!-- Admin Footer -->
            <footer class="py-4 px-8 text-center text-xs text-slate-400 border-t border-slate-100 bg-white">
                Portal Resmi BAPPERIDA Kabupaten Pringsewu &copy; 2026. All rights reserved.
            </footer>
        </div>
    </div>
</template>
