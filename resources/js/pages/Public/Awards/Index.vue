<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    Award as AwardIcon,
    Calendar,
    Search,
    Filter,
    Building,
    ChevronRight,
    Sparkles,
    Eye,
    X,
    ExternalLink,
    CheckCircle2,
    ShieldCheck
} from 'lucide-vue-next';

interface AwardItem {
    id: string;
    name: string;
    slug: string;
    year: number;
    award_date: string;
    category: string;
    organizer: string;
    description: string;
    image_path: string | null;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Props {
    awards: {
        data: AwardItem[];
        links: PaginationLink[];
        total: number;
        current_page: number;
        last_page: number;
    };
    years: number[];
    categories: string[];
    filters: {
        year?: string;
        category?: string;
        search?: string;
    };
}

const props = defineProps<Props>();

const search = ref(props.filters.search || '');
const selectedYear = ref(props.filters.year || '');
const selectedCategory = ref(props.filters.category || '');

const selectedAwardModal = ref<AwardItem | null>(null);

const applyFilters = () => {
    router.get(
        '/penghargaan',
        {
            search: search.value || undefined,
            year: selectedYear.value || undefined,
            category: selectedCategory.value || undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    );
};

const resetFilters = () => {
    search.value = '';
    selectedYear.value = '';
    selectedCategory.value = '';
    applyFilters();
};

const openModal = (award: AwardItem) => {
    selectedAwardModal.value = award;
};

const closeModal = () => {
    selectedAwardModal.value = null;
};
</script>

<template>
    <Head title="Prestasi & Penghargaan Daerah - BAPPERIDA Pringsewu" />

    <PublicLayout>
        <!-- Hero Header -->
        <section class="relative overflow-hidden bg-slate-950 text-white py-16 sm:py-20 px-4 sm:px-8 border-b border-teal-900/40">
            <!-- Background Image with Scrim -->
            <div class="absolute inset-0 z-0 opacity-30 mix-blend-luminosity">
                <img
                    src="/images/pringsewu_magazine_bg.jpg"
                    alt="Background Pringsewu"
                    class="w-full h-full object-cover object-center"
                />
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/90 to-teal-950/80" />

            <div class="relative z-10 max-w-7xl mx-auto space-y-6">
                <!-- Breadcrumbs -->
                <div class="flex items-center gap-2 text-xs text-teal-300/80 font-medium">
                    <Link href="/" class="hover:text-white transition-colors">Beranda</Link>
                    <ChevronRight class="w-3.5 h-3.5 text-teal-500" />
                    <span class="text-white font-semibold">Penghargaan & Prestasi Daerah</span>
                </div>

                <div class="max-w-3xl space-y-3">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-400/20 text-xs font-semibold text-amber-300 border border-amber-400/30 backdrop-blur-md">
                        <AwardIcon class="w-3.5 h-3.5 text-amber-400" />
                        <span>Rekam Jejak Keunggulan Pringsewu</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight text-white leading-tight">
                        Prestasi & Penghargaan BAPPERIDA
                    </h1>

                    <p class="text-sm sm:text-base text-slate-300 leading-relaxed font-normal max-w-2xl">
                        Koleksi pengakuan resmi dan apresiasi prestisius dari kementerian, lembaga negara, dan pemerintah pusat atas dedikasi perencanaan, inovasi riset daerah, akuntabilitas, serta pelayanan publik Kabupaten Pringsewu.
                    </p>
                </div>

                <!-- Year Quick Filter Pills -->
                <div class="pt-4 flex flex-wrap items-center gap-2">
                    <span class="text-xs text-slate-400 font-semibold mr-1">Tahun:</span>
                    <button
                        type="button"
                        class="px-4 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer"
                        :class="selectedYear === ''
                            ? 'bg-amber-400 text-slate-950 shadow-md shadow-amber-400/20'
                            : 'bg-white/10 text-white hover:bg-white/20 border border-white/10'"
                        @click="selectedYear = ''; applyFilters()"
                    >
                        Semua Tahun
                    </button>
                    <button
                        v-for="yr in years"
                        :key="yr"
                        type="button"
                        class="px-4 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer"
                        :class="String(selectedYear) === String(yr)
                            ? 'bg-amber-400 text-slate-950 shadow-md shadow-amber-400/20'
                            : 'bg-white/10 text-white hover:bg-white/20 border border-white/10'"
                        @click="selectedYear = String(yr); applyFilters()"
                    >
                        Tahun {{ yr }}
                    </button>
                </div>
            </div>
        </section>

        <!-- Main Content Area -->
        <main class="py-12 px-4 sm:px-8 max-w-7xl mx-auto w-full space-y-8">
            <!-- Search & Category Filter Bar -->
            <div class="bg-white rounded-2xl p-4 sm:p-5 border border-slate-200/80 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="relative flex-1 w-full">
                    <Search class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" />
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Cari nama penghargaan, instansi pemberi, atau bidang prestasi..."
                        class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition-all"
                        @keyup.enter="applyFilters"
                    />
                    <button
                        v-if="search"
                        type="button"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-slate-400 hover:text-slate-600 cursor-pointer"
                        @click="search = ''; applyFilters()"
                    >
                        Reset
                    </button>
                </div>

                <div class="flex flex-wrap items-center gap-3 w-full md:w-auto shrink-0 justify-between md:justify-end">
                    <!-- Category Select -->
                    <select
                        v-model="selectedCategory"
                        class="px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:outline-none focus:ring-2 focus:ring-teal-500 cursor-pointer"
                        @change="applyFilters"
                    >
                        <option value="">Semua Kategori Penghargaan</option>
                        <option v-for="cat in categories" :key="cat" :value="cat">
                            {{ cat }}
                        </option>
                    </select>

                    <button
                        type="button"
                        class="px-4 py-2.5 rounded-xl bg-teal-800 text-white text-xs font-bold hover:bg-teal-900 transition-all cursor-pointer flex items-center gap-1.5 shadow-xs"
                        @click="applyFilters"
                    >
                        <Filter class="w-3.5 h-3.5" />
                        <span>Filter</span>
                    </button>

                    <button
                        v-if="search || selectedYear || selectedCategory"
                        type="button"
                        class="px-3 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-colors cursor-pointer"
                        @click="resetFilters"
                    >
                        Reset Semua
                    </button>
                </div>
            </div>

            <!-- Awards Grid Showcase -->
            <div v-if="awards.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="awd in awards.data"
                    :key="awd.id"
                    class="bg-white rounded-3xl border border-slate-200/90 shadow-2xs hover:shadow-xl hover:border-teal-600/40 transition-all duration-300 flex flex-col justify-between overflow-hidden group"
                >
                    <!-- Award Image Thumbnail with Sample AI Trophy -->
                    <div class="relative h-52 bg-slate-900 overflow-hidden cursor-pointer" @click="openModal(awd)">
                        <img
                            v-if="awd.image_path"
                            :src="awd.image_path"
                            :alt="awd.name"
                            class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500"
                        />
                        <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-teal-900 to-slate-900 text-amber-300">
                            <AwardIcon class="w-16 h-16 opacity-40" />
                        </div>

                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent" />

                        <!-- Category & Year Badges -->
                        <div class="absolute top-3.5 inset-x-3.5 flex items-center justify-between gap-2">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-400 text-slate-950 shadow-md">
                                {{ awd.category }}
                            </span>
                            <span class="px-2.5 py-1 rounded-full text-xs font-black bg-slate-950/80 text-teal-300 border border-teal-500/30 backdrop-blur-md">
                                {{ awd.year }}
                            </span>
                        </div>

                        <!-- Date at Bottom of Image -->
                        <div class="absolute bottom-3 left-3.5 flex items-center gap-1.5 text-xs text-slate-300 font-medium">
                            <Calendar class="w-3.5 h-3.5 text-amber-400" />
                            <span>{{ awd.award_date }}</span>
                        </div>
                    </div>

                    <!-- Award Card Details -->
                    <div class="p-6 space-y-3 flex-1 flex flex-col justify-between">
                        <div class="space-y-2">
                            <h3 class="text-base font-black text-slate-900 group-hover:text-teal-800 transition-colors leading-snug">
                                {{ awd.name }}
                            </h3>

                            <div class="flex items-center gap-1.5 text-xs text-teal-800 font-semibold">
                                <Building class="w-3.5 h-3.5 shrink-0" />
                                <span class="line-clamp-1">{{ awd.organizer }}</span>
                            </div>

                            <p class="text-xs text-slate-600 leading-relaxed line-clamp-3 pt-1">
                                {{ awd.description }}
                            </p>
                        </div>

                        <!-- Footer Actions -->
                        <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                            <button
                                type="button"
                                class="inline-flex items-center gap-1 text-xs font-bold text-teal-800 hover:text-teal-950 cursor-pointer"
                                @click="openModal(awd)"
                            >
                                <Eye class="w-3.5 h-3.5" />
                                <span>Pratinjau Piagam</span>
                            </button>

                            <span class="text-[11px] font-bold text-slate-400 flex items-center gap-1">
                                <ShieldCheck class="w-3.5 h-3.5 text-emerald-600" />
                                Terverifikasi
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="bg-white rounded-3xl p-12 text-center border border-slate-200/80 space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center mx-auto">
                    <AwardIcon class="w-6 h-6" />
                </div>
                <h3 class="text-base font-bold text-slate-900">
                    Tidak Ada Penghargaan Ditemukan
                </h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto">
                    Tidak ditemukan data penghargaan sesuai filter tahun atau kata kunci. Silakan reset filter untuk melihat seluruh prestasi daerah.
                </p>
                <button
                    type="button"
                    class="px-4 py-2 rounded-xl bg-teal-800 text-white text-xs font-bold hover:bg-teal-900 transition-colors cursor-pointer"
                    @click="resetFilters"
                >
                    Tampilkan Semua Penghargaan
                </button>
            </div>

            <!-- Pagination -->
            <div v-if="awards.links && awards.links.length > 3" class="pt-6 flex justify-center">
                <nav class="inline-flex items-center gap-1 bg-white p-1.5 rounded-2xl border border-slate-200 shadow-2xs">
                    <template v-for="(link, i) in awards.links" :key="i">
                        <span
                            v-if="!link.url"
                            class="px-3.5 py-1.5 text-xs text-slate-400 rounded-xl cursor-not-allowed select-none"
                            v-html="link.label"
                        />
                        <Link
                            v-else
                            :href="link.url"
                            class="px-3.5 py-1.5 text-xs rounded-xl font-bold transition-all"
                            :class="link.active ? 'bg-teal-800 text-white shadow-xs' : 'text-slate-600 hover:bg-slate-100'"
                            v-html="link.label"
                        />
                    </template>
                </nav>
            </div>
        </main>

        <!-- Award Preview Lightbox Modal -->
        <Transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div
                v-if="selectedAwardModal"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-slate-950/80 backdrop-blur-sm"
                @click.self="closeModal"
            >
                <div class="bg-white rounded-3xl max-w-2xl w-full overflow-hidden shadow-2xl border border-slate-200 flex flex-col max-h-[90vh]">
                    <!-- Modal Header -->
                    <div class="p-5 bg-slate-900 text-white flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-xl bg-amber-400 text-slate-950 flex items-center justify-center font-bold">
                                <AwardIcon class="w-4 h-4" />
                            </div>
                            <div>
                                <span class="text-[11px] text-amber-300 font-bold uppercase tracking-wider block">
                                    {{ selectedAwardModal.category }} • Tahun {{ selectedAwardModal.year }}
                                </span>
                                <h4 class="text-sm font-bold text-white line-clamp-1">
                                    {{ selectedAwardModal.name }}
                                </h4>
                            </div>
                        </div>

                        <button
                            type="button"
                            class="p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-white/10 transition-colors cursor-pointer"
                            @click="closeModal"
                        >
                            <X class="w-5 h-5" />
                        </button>
                    </div>

                    <!-- Modal Body (Scrollable) -->
                    <div class="p-6 overflow-y-auto space-y-5">
                        <!-- Award Image -->
                        <div class="rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 max-h-80 flex items-center justify-center">
                            <img
                                v-if="selectedAwardModal.image_path"
                                :src="selectedAwardModal.image_path"
                                :alt="selectedAwardModal.name"
                                class="w-full h-full object-contain max-h-80"
                            />
                            <div v-else class="p-12 text-slate-400 flex flex-col items-center gap-2">
                                <AwardIcon class="w-12 h-12" />
                                <span class="text-xs font-semibold">Piagam Penghargaan Resmi</span>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <h3 class="text-lg font-black text-slate-900 leading-snug">
                                {{ selectedAwardModal.name }}
                            </h3>

                            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-600">
                                <div class="flex items-center gap-1 font-semibold text-teal-800">
                                    <Building class="w-3.5 h-3.5" />
                                    <span>Pemberi: {{ selectedAwardModal.organizer }}</span>
                                </div>
                                <span>•</span>
                                <div class="flex items-center gap-1 text-slate-500">
                                    <Calendar class="w-3.5 h-3.5" />
                                    <span>Tanggal: {{ selectedAwardModal.award_date }}</span>
                                </div>
                            </div>

                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed pt-2">
                                {{ selectedAwardModal.description }}
                            </p>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="p-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between">
                        <span class="text-xs text-slate-500">
                            Dokumentasi Resmi Pemerintah Kabupaten Pringsewu
                        </span>
                        <button
                            type="button"
                            class="px-4 py-2 rounded-xl bg-teal-800 text-white text-xs font-bold hover:bg-teal-900 transition-colors cursor-pointer"
                            @click="closeModal"
                        >
                            Tutup Pratinjau
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </PublicLayout>
</template>
