<script setup lang="ts">
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    BarChart3,
    ChevronRight,
    Users,
    GraduationCap,
    Award,
    CheckCircle2,
    Search,
    Filter,
    Shield,
    Briefcase,
    Building2
} from 'lucide-vue-next';

// 44 Data Pegawai Resmi Berdasarkan Dokumen BAPPERIDA Kabupaten Pringsewu
interface Employee {
    no: number;
    name: string;
    rank: string;
    position: string;
    category: 'Struktural' | 'Fungsional' | 'Pelaksana/PPPK';
}

const employees: Employee[] = [
    { no: 1, name: 'Imam Fatkuroji, S.STP., M.IP', rank: 'Pembina Tk.I/ IV.b', position: 'Kepala Badan', category: 'Struktural' },
    { no: 2, name: 'Siti Rahma, S.I.Kom', rank: 'Pembina/ IV.a', position: 'Sekretaris', category: 'Struktural' },
    { no: 3, name: 'Fitri Faula, S.I.Kom', rank: 'Penata Tk.I/ III.d', position: 'Kasubag Umum & Kepegawaian', category: 'Struktural' },
    { no: 4, name: 'Febby Sabel Supriyatna, SE., MM', rank: 'Penata Tk.I/ III.d', position: 'Analis Keuangan Pusat & Daerah', category: 'Fungsional' },
    { no: 5, name: 'Evy Suryani Simatupang, MM', rank: 'Penata Tk.I/ III.d', position: 'Perencana Ahli Muda', category: 'Fungsional' },
    { no: 6, name: 'Novi Arum Artati, SE', rank: 'Penata/ III.c', position: 'Penyusun Kebutuhan Barang Inventaris', category: 'Pelaksana/PPPK' },
    { no: 7, name: 'Nelly Yulianti, A.Md', rank: 'Penata Muda Tk.I/ III.b', position: 'Bendahara', category: 'Pelaksana/PPPK' },
    { no: 8, name: 'Muhammad Faisal Zulfikri, SE', rank: 'Penata Muda/ III.b', position: 'Analis Perencanaan, Evaluasi & Pelaporan', category: 'Pelaksana/PPPK' },
    { no: 9, name: 'Felik Berimuda Arum', rank: 'Pengatur Tk. I/ II.d', position: 'Pengelola Bahan Perencanaan', category: 'Pelaksana/PPPK' },
    { no: 10, name: 'Dicky Rianto, S.Kom', rank: 'IX', position: 'Penata Layanan Operasional', category: 'Pelaksana/PPPK' },
    { no: 11, name: 'Ira Feriyalneti, SE', rank: 'IX', position: 'Penata Layanan Operasional', category: 'Pelaksana/PPPK' },
    { no: 12, name: 'Bety Astri Jayanti, S.Kom', rank: 'IX', position: 'Penata Layanan Operasional', category: 'Pelaksana/PPPK' },
    { no: 13, name: 'Mulyani Lestari', rank: 'V', position: 'Pengadministrasi Perkantoran', category: 'Pelaksana/PPPK' },
    { no: 14, name: 'Fani Yudi Setiawan', rank: 'V', position: 'Pengadministrasi Perkantoran', category: 'Pelaksana/PPPK' },
    { no: 15, name: 'Nurul Khomsiayun', rank: 'V', position: 'Pengadministrasian Perkantoran', category: 'Pelaksana/PPPK' },
    { no: 16, name: 'Asnawati', rank: 'I', position: 'Pengelola Umum Operasional', category: 'Pelaksana/PPPK' },
    { no: 17, name: 'Erwin Soni, ST., MM', rank: 'Pembina/ IV.a', position: 'Kabid Perekonomian & SDA', category: 'Struktural' },
    { no: 18, name: 'Nurul Khusna H, S.Farm, Apt, M.Kes', rank: 'Penata/ III.c', position: 'Perencana Ahli Muda', category: 'Fungsional' },
    { no: 19, name: 'Amrulloh Khusain, M.Kom.I', rank: 'Penata/ III.c', position: 'Perencana Ahli Muda', category: 'Fungsional' },
    { no: 20, name: 'Henia Amelia Sasmita, S.P.W.K', rank: 'Penata Muda/ III.a', position: 'Perencana Ahli Pertama', category: 'Fungsional' },
    { no: 21, name: 'Arihaniatul Evayanti, SE', rank: 'IX', position: 'Perencana Ahli Pertama', category: 'Fungsional' },
    { no: 22, name: 'A. Adam Althusius, ST., MURP', rank: 'Pembina/ IV.a', position: 'Kabid Infrastruktur & Pengembangan Wilayah', category: 'Struktural' },
    { no: 23, name: 'Fatkur Rokhman, S.Kom', rank: 'Penata/ III.c', position: 'Perencana Ahli Muda', category: 'Fungsional' },
    { no: 24, name: 'Liza Wardani, ST', rank: 'Penata Tk.I/ III.d', position: 'Perencana Ahli Muda', category: 'Fungsional' },
    { no: 25, name: 'Erwin Saifulloh, SE', rank: 'Penata Muda/ III. a', position: 'Analis Program Pengembangan', category: 'Pelaksana/PPPK' },
    { no: 26, name: 'Nadya Fatrah Balqis, S.P.W.K', rank: 'Penata Muda/ III.a', position: 'Perencana Ahli Pertama', category: 'Fungsional' },
    { no: 27, name: 'Fitri Saraswati', rank: 'PPPK Paruh Waktu', position: 'PPPK Paruh Waktu', category: 'Pelaksana/PPPK' },
    { no: 28, name: 'Rara Sukma, ST., M.P.W.K', rank: 'Pembina/ IV.a', position: 'Kabid Perencanaan Pengendalian & Evaluasi', category: 'Struktural' },
    { no: 29, name: 'Dwi Andysuprianto, S.Si., MM', rank: 'Penata/ III.c', position: 'Perencana Ahli Muda', category: 'Fungsional' },
    { no: 30, name: 'Elyani Rafida, SE', rank: 'Penata Tk.I/ III.d', position: 'Perencana Ahli Muda', category: 'Fungsional' },
    { no: 31, name: 'Firania Debby Prabhasari, S.IP', rank: 'Penata Muda Tk.I/ III.b', position: 'Penalaah Teknis Kebijakan', category: 'Pelaksana/PPPK' },
    { no: 32, name: 'Angelina Laksmiati. R. P, S.P.W.K', rank: 'Penata Muda/ III.a', position: 'Perencana Ahli Pertama', category: 'Fungsional' },
    { no: 33, name: 'Surya Tri Saputra, A.Md', rank: 'Pengatur Tk.I/ II.d', position: 'Pengelola Data', category: 'Pelaksana/PPPK' },
    { no: 34, name: 'Ismail Nahri Alfajri, M.IP', rank: 'Pembina/ IV.a', position: 'Analis Data & Informasi', category: 'Fungsional' },
    { no: 35, name: 'Debit Zuliansyah, ST', rank: 'Pembina/ IV.a', position: 'Kabid Pemerintahan & Pembangunan Manusia', category: 'Struktural' },
    { no: 36, name: 'Bambang Adi Pranata, SE., MM', rank: 'Penata Tk.I/ III.d', position: 'Perencana Ahli Muda', category: 'Fungsional' },
    { no: 37, name: 'Eka Oktarianti, S.Pt., M.M', rank: 'Penata Tk.I/ III.d', position: 'Perencana Ahli Muda', category: 'Fungsional' },
    { no: 38, name: 'Yulia Setyaningrum, S.KM., M.Kes', rank: 'Penata Tk.I/ III.d', position: 'Perencana Ahli Muda', category: 'Fungsional' },
    { no: 39, name: 'Muliarta Diputra, S.T', rank: 'Penata Muda/ III.a', position: 'Perencana Ahli Pertama', category: 'Fungsional' },
    { no: 40, name: 'M Rizal Sobri, S.Kom', rank: 'IX', position: 'Penata Layanan Operasional', category: 'Pelaksana/PPPK' },
    { no: 41, name: 'Fenny Aprilia, S.Sos', rank: 'Penata Tk.I/ III.d', position: 'Kabid Riset & Inovasi Daerah', category: 'Struktural' },
    { no: 42, name: 'Eko Waluyo, S.Kom', rank: 'Penata/ III.c', position: 'Analis Kebijakan', category: 'Fungsional' },
    { no: 43, name: 'Yasir Arafat, S.K.M., MM', rank: 'Penata Tk.I/ III.d', position: 'Analis Kebijakan', category: 'Fungsional' },
    { no: 44, name: 'Eva Desi Yuniarti', rank: 'V', position: 'Pengadministrasi Perkantoran', category: 'Pelaksana/PPPK' }
];

// Interactive Filter & Search
const searchQuery = ref('');
const selectedCategory = ref('Semua');

const filteredEmployees = computed(() => {
    return employees.filter(emp => {
        const matchesCategory = selectedCategory.value === 'Semua' || emp.category === selectedCategory.value;
        const q = searchQuery.value.toLowerCase().trim();
        const matchesSearch = !q ||
            emp.name.toLowerCase().includes(q) ||
            emp.rank.toLowerCase().includes(q) ||
            emp.position.toLowerCase().includes(q);
        return matchesCategory && matchesSearch;
    });
});

// Helper for Rank Badge Styling
const getRankBadgeClass = (rank: string) => {
    if (rank.includes('IV.')) return 'bg-emerald-100 text-emerald-800 border-emerald-300';
    if (rank.includes('III.')) return 'bg-teal-100 text-teal-800 border-teal-300';
    if (rank.includes('II.')) return 'bg-sky-100 text-sky-800 border-sky-300';
    if (rank.includes('IX') || rank.includes('V') || rank.includes('PPPK')) return 'bg-amber-100 text-amber-800 border-amber-300';
    return 'bg-slate-100 text-slate-800 border-slate-300';
};
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
                    <span>Demografi Aparatur Pemerintah</span>
                </div>
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white max-w-4xl leading-tight">
                    Statistik Pegawai BAPPERIDA
                </h1>
                <p class="text-sm sm:text-base text-teal-100/90 max-w-3xl leading-relaxed">
                    Data resmi kepegawaian Badan Perencanaan Pembangunan Riset dan Inovasi Daerah Kabupaten Pringsewu meliputi komposisi pangkat, golongan, dan formasi jabatan.
                </p>
            </div>
        </section>

        <!-- Main Content -->
        <main class="py-12 sm:py-16 bg-slate-50/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-16">

                <!-- 1. STATISTIC HIGHLIGHT CARDS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="p-6 rounded-3xl bg-white border border-slate-200/90 shadow-xs space-y-2">
                        <div class="flex items-center justify-between text-slate-500 text-xs font-semibold">
                            <span>Total Aparatur</span>
                            <Users class="w-4 h-4 text-teal-700" />
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl sm:text-4xl font-black text-slate-900">44</span>
                            <span class="text-xs font-bold text-teal-700">Orang</span>
                        </div>
                        <p class="text-[11px] text-slate-500">PNS dan PPPK Resmi Aktif</p>
                    </div>

                    <div class="p-6 rounded-3xl bg-white border border-slate-200/90 shadow-xs space-y-2">
                        <div class="flex items-center justify-between text-slate-500 text-xs font-semibold">
                            <span>Golongan IV (Pembina)</span>
                            <Shield class="w-4 h-4 text-emerald-700" />
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl sm:text-4xl font-black text-emerald-700">7</span>
                            <span class="text-xs font-bold text-slate-600">Pejabat</span>
                        </div>
                        <p class="text-[11px] text-slate-500">Kaban, Sekretaris, 5 Kabid & Analis</p>
                    </div>

                    <div class="p-6 rounded-3xl bg-white border border-slate-200/90 shadow-xs space-y-2">
                        <div class="flex items-center justify-between text-slate-500 text-xs font-semibold">
                            <span>Golongan III (Penata)</span>
                            <Briefcase class="w-4 h-4 text-teal-700" />
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl sm:text-4xl font-black text-teal-700">22</span>
                            <span class="text-xs font-bold text-slate-600">Aparatur</span>
                        </div>
                        <p class="text-[11px] text-slate-500">50% Komposisi Kekuatan Inti ASN</p>
                    </div>

                    <div class="p-6 rounded-3xl bg-white border border-slate-200/90 shadow-xs space-y-2">
                        <div class="flex items-center justify-between text-slate-500 text-xs font-semibold">
                            <span>PPPK (Ahli & Terampil)</span>
                            <Award class="w-4 h-4 text-amber-600" />
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl sm:text-4xl font-black text-amber-700">11</span>
                            <span class="text-xs font-bold text-slate-600">Pegawai</span>
                        </div>
                        <p class="text-[11px] text-slate-500">Golongan IX, V, & Paruh Waktu</p>
                    </div>
                </div>

                <!-- 2. KOMPOSISI VISUAL: DISTRIBUSI GOLONGAN & JABATAN -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Berdasarkan Golongan / Kepangkatan -->
                    <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-200/90 shadow-xs space-y-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center font-bold">
                                <BarChart3 class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Distribusi Golongan Kepangkatan</h3>
                                <p class="text-[11px] text-slate-500">Berdasarkan data resmi 44 aparatur</p>
                            </div>
                        </div>

                        <div class="space-y-4 pt-2">
                            <div>
                                <div class="flex justify-between text-xs font-medium mb-1">
                                    <span class="text-slate-700">Golongan IV (Pembina Tk. I & Pembina)</span>
                                    <span class="font-bold text-emerald-800">7 Orang (15.9%)</span>
                                </div>
                                <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-emerald-700 rounded-full" style="width: 15.9%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-xs font-medium mb-1">
                                    <span class="text-slate-700">Golongan III (Penata Tk.I, Penata, Penata Muda)</span>
                                    <span class="font-bold text-teal-800">22 Orang (50.0%)</span>
                                </div>
                                <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-teal-600 rounded-full" style="width: 50%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-xs font-medium mb-1">
                                    <span class="text-slate-700">Golongan II & I (Pengatur & Pengelola Umum)</span>
                                    <span class="font-bold text-sky-800">3 Orang (6.8%)</span>
                                </div>
                                <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-sky-600 rounded-full" style="width: 6.8%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-xs font-medium mb-1">
                                    <span class="text-slate-700">PPPK (Golongan IX, V & Paruh Waktu)</span>
                                    <span class="font-bold text-amber-800">11 Orang (25.0%)</span>
                                </div>
                                <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-amber-500 rounded-full" style="width: 25%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Berdasarkan Rumpun Formasi Jabatan -->
                    <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-200/90 shadow-xs space-y-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center font-bold">
                                <Users class="w-5 h-5" />
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Distribusi Rumpun Jabatan</h3>
                                <p class="text-[11px] text-slate-500">Struktural, Fungsional Keahlian & Pelaksana</p>
                            </div>
                        </div>

                        <div class="space-y-4 pt-2">
                            <div>
                                <div class="flex justify-between text-xs font-medium mb-1">
                                    <span class="text-slate-700">Pejabat Fungsional Keahlian (Perencana, Analis)</span>
                                    <span class="font-bold text-teal-800">18 Orang (40.9%)</span>
                                </div>
                                <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-teal-600 rounded-full" style="width: 40.9%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-xs font-medium mb-1">
                                    <span class="text-slate-700">Pelaksana, Layanan Operasional & Pengadministrasi</span>
                                    <span class="font-bold text-sky-800">18 Orang (40.9%)</span>
                                </div>
                                <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-sky-600 rounded-full" style="width: 40.9%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-xs font-medium mb-1">
                                    <span class="text-slate-700">Pejabat Struktural (Kaban, Sekretaris, 5 Kabid, Kasubag)</span>
                                    <span class="font-bold text-emerald-800">8 Orang (18.2%)</span>
                                </div>
                                <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                                    <div class="h-full bg-emerald-700 rounded-full" style="width: 18.2%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. TABEL RESMI 44 PEGAWAI DENGAN PENCARIAN & FILTER -->
                <div class="bg-white rounded-3xl border border-slate-200/90 shadow-xl overflow-hidden space-y-6 p-6 sm:p-8">
                    <!-- Title & Header Tabel -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                        <div>
                            <span class="text-xs font-bold text-teal-700 uppercase tracking-widest block">Daftar Nominatif</span>
                            <h3 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                                Data 44 Pegawai BAPPERIDA Kabupaten Pringsewu
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Sesuai dokumen resmi nominatif aparatur BAPPERIDA.
                            </p>
                        </div>

                        <!-- Search Box & Filter Tabs -->
                        <div class="flex flex-col sm:flex-row items-center gap-3">
                            <!-- Input Search -->
                            <div class="relative w-full sm:w-64">
                                <Search class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" />
                                <input
                                    v-model="searchQuery"
                                    type="text"
                                    placeholder="Cari nama, pangkat, atau jabatan..."
                                    class="w-full pl-9 pr-3 py-2 text-xs rounded-xl border border-slate-200 focus:outline-hidden focus:border-teal-500 focus:ring-1 focus:ring-teal-500 bg-slate-50"
                                />
                            </div>

                            <!-- Category Filter Chips -->
                            <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl w-full sm:w-auto overflow-x-auto">
                                <button
                                    v-for="cat in ['Semua', 'Struktural', 'Fungsional', 'Pelaksana/PPPK']"
                                    :key="cat"
                                    @click="selectedCategory = cat"
                                    class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all whitespace-nowrap cursor-pointer"
                                    :class="selectedCategory === cat ? 'bg-white text-teal-800 shadow-2xs' : 'text-slate-600 hover:text-slate-900'"
                                >
                                    {{ cat }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Data Pegawai -->
                    <div class="overflow-x-auto rounded-2xl border border-slate-200">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-gradient-to-r from-teal-900 to-slate-900 text-white font-bold uppercase tracking-wider text-[11px]">
                                    <th class="py-3 px-4 text-center w-12">No</th>
                                    <th class="py-3 px-4">Nama Pegawai</th>
                                    <th class="py-3 px-4">Pangkat / Golongan</th>
                                    <th class="py-3 px-4">Jabatan</th>
                                    <th class="py-3 px-4 text-center">Rumpun</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                <tr
                                    v-for="emp in filteredEmployees"
                                    :key="emp.no"
                                    class="hover:bg-slate-50/80 transition-colors"
                                >
                                    <td class="py-3 px-4 text-center font-bold text-slate-500 font-mono">
                                        {{ emp.no }}
                                    </td>
                                    <td class="py-3 px-4 font-bold text-slate-900">
                                        {{ emp.name }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <span
                                            class="inline-block px-2.5 py-1 rounded-md font-mono text-[11px] font-semibold border"
                                            :class="getRankBadgeClass(emp.rank)"
                                        >
                                            {{ emp.rank }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-slate-700 font-medium">
                                        {{ emp.position }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span
                                            class="inline-block px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wider"
                                            :class="emp.category === 'Struktural'
                                                ? 'bg-emerald-50 text-emerald-800'
                                                : emp.category === 'Fungsional'
                                                ? 'bg-teal-50 text-teal-800'
                                                : 'bg-slate-100 text-slate-700'"
                                        >
                                            {{ emp.category }}
                                        </span>
                                    </td>
                                </tr>
                                <tr v-if="filteredEmployees.length === 0">
                                    <td colspan="5" class="py-8 text-center text-slate-400">
                                        Tidak ditemukan pegawai dengan kata kunci "{{ searchQuery }}"
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Info Nominatif -->
                    <div class="flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 pt-2 gap-2">
                        <span>Menampilkan <strong>{{ filteredEmployees.length }}</strong> dari <strong>44</strong> pegawai terdaftar.</span>
                        <span class="flex items-center gap-1.5 text-teal-700 font-semibold">
                            <CheckCircle2 class="w-4 h-4" /> Data Resmi BAPPERIDA Kab. Pringsewu
                        </span>
                    </div>
                </div>

            </div>
        </main>
    </PublicLayout>
</template>
