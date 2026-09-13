<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    Sparkles,
    CheckCircle2,
    Building2,
    Scale,
    ShieldCheck,
    ChevronRight,
    Target,
    Layers,
    ArrowRight,
    FileText
} from 'lucide-vue-next';

interface OfficialItem {
    id: string;
    name: string;
    nip: string;
    position: string;
    category_code: string;
}

interface Props {
    officials?: OfficialItem[];
}

defineProps<Props>();

const scopePoints = [
    {
        number: '01',
        title: 'Perumusan Kebijakan Teknis',
        desc: 'Perumusan kebijakan teknis di bidang perencanaan pembangunan daerah, penelitian, pengembangan, pengkajian, dan penerapan inovasi daerah.'
    },
    {
        number: '02',
        title: 'Koordinasi & Sinkronisasi Perencanaan',
        desc: 'Koordinasi, sinkronisasi, dan integrasi perencanaan pembangunan lintas perangkat daerah, lintas sektor, dan kewilayahan.'
    },
    {
        number: '03',
        title: 'Pemantauan, Pengendalian & Evaluasi',
        desc: 'Pemantauan, pengendalian, dan evaluasi berkala pelaksanaan rencana pembangunan serta kinerja program prioritas daerah.'
    },
    {
        number: '04',
        title: 'Riset & Evidence-Based Policy',
        desc: 'Penyelenggaraan penelitian, pengkajian ilmiah, dan fasilitasi kebijakan berbasis bukti (evidence-based policy) untuk memecahkan isu strategis daerah.'
    },
    {
        number: '05',
        title: 'Ekosistem & Budaya Inovasi',
        desc: 'Penumbuhan, fasilitasi, pendampingan, dan pengembangan ekosistem inovasi daerah di lingkungan pemerintah daerah maupun masyarakat luas.'
    },
    {
        number: '06',
        title: 'Satu Data & Informasi Pembangunan',
        desc: 'Pengelolaan satu data perencanaan, statistik sektoral, dan sistem informasi perencanaan pembangunan daerah yang terpadu dan akuntabel.'
    },
    {
        number: '07',
        title: 'Tugas Penunjang Pemerintahan Lainnya',
        desc: 'Pelaksanaan tugas kedinasan dan fungsi penunjang urusan pemerintahan lainnya yang diberikan oleh Bupati sesuai ketentuan peraturan perundang-undangan.'
    }
];

const legalBasics = [
    { code: 'UU No. 48 / 2008', title: 'Pembentukan Kabupaten Pringsewu di Provinsi Lampung (Pemekaran Kab. Tanggamus)' },
    { code: 'UU No. 23 / 2014', title: 'Pemerintahan Daerah & Pembagian Urusan Wajib Penunjang Pemerintahan' },
    { code: 'PP No. 18 / 2016', title: 'Perangkat Daerah sebagai Landasan Pembentukan Struktur Kelembagaan Organisasi' },
    { code: 'Perda No. 6 / 2024', title: 'Perubahan Kedua Perda No. 16/2016 tentang Pembentukan BAPPERIDA Kabupaten Pringsewu' },
];
</script>

<template>
    <Head title="Profil BAPPERIDA - Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah Kabupaten Pringsewu" />

    <PublicLayout>
        <!-- Breadcrumb Bar -->
        <div class="bg-slate-100/80 border-b border-slate-200/80 py-2.5 px-4 sm:px-8">
            <div class="max-w-7xl mx-auto flex items-center gap-2 text-xs text-slate-600">
                <Link href="/" class="hover:text-teal-800 transition-colors">Beranda</Link>
                <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                <span class="text-slate-400">Profil</span>
                <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                <span class="font-semibold text-teal-800">Profil Bapperida</span>
            </div>
        </div>

        <!-- Header Banner -->
        <section class="relative bg-gradient-to-r from-teal-950 via-teal-900 to-slate-900 text-white py-14 sm:py-20 px-4 sm:px-8 overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#00C096_1px,transparent_1px)] [background-size:20px_20px] pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative max-w-7xl mx-auto space-y-4">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-500/20 border border-teal-400/30 text-xs font-semibold text-teal-200">
                    <Building2 class="w-3.5 h-3.5" />
                    <span>Profil Lembaga Perencana Daerah</span>
                </div>
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white max-w-4xl leading-tight">
                    Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah
                </h1>
                <p class="text-sm sm:text-base text-teal-100/90 max-w-3xl leading-relaxed">
                    Mengenal peran strategis BAPPERIDA Kabupaten Pringsewu dalam memandu arah haluan pembangunan, penelitian terpadu, dan percepatan ekosistem inovasi daerah.
                </p>

                <!-- Slogan Highlight Pill -->
                <div class="pt-2">
                    <div class="inline-flex flex-wrap items-center gap-3 px-4 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-xs sm:text-sm font-medium text-white">
                        <span class="text-teal-300 font-bold uppercase tracking-wider text-[11px]">Slogan Bapperida:</span>
                        <span class="italic text-teal-50">"Perencanaan Berdampak, Pembangunan Terarah, Pringsewu Makmur"</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <main class="py-12 sm:py-16 bg-slate-50/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-16">
                <!-- Slogan Official Banner -->
                <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-teal-900 via-teal-800 to-slate-900 p-8 sm:p-12 text-white shadow-xl shadow-teal-950/10">
                    <div class="relative z-10 max-w-3xl space-y-4">
                        <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-teal-300">
                            <Sparkles class="w-4 h-4" />
                            Motto & Komitmen Pengabdian
                        </span>
                        <blockquote class="text-2xl sm:text-4xl font-extrabold tracking-tight text-white leading-snug">
                            "Perencanaan Berdampak, Pembangunan Terarah, Pringsewu Makmur"
                        </blockquote>
                        <p class="text-xs sm:text-sm text-teal-100/90 leading-relaxed pt-2">
                            Setiap garis dokumen perencanaan yang dirumuskan di BAPPERIDA bukan sekadar angka atau regulasi administratif, melainkan cetak biru kesejahteraan riil bagi seluruh lapisan warga Pringsewu dari kota hingga pelosok pekon.
                        </p>
                    </div>
                    <div class="absolute -bottom-12 -right-12 w-64 h-64 bg-teal-500/20 rounded-full blur-2xl pointer-events-none"></div>
                </div>

                <!-- Sejarah & Transformasi Kelembagaan -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <div class="lg:col-span-7 space-y-6">
                        <div class="space-y-2">
                            <span class="text-xs font-bold text-teal-700 uppercase tracking-widest block">Sejarah & Landasan</span>
                            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                                Transformasi Menuju Lembaga Perencana & Riset Terpadu
                            </h2>
                        </div>

                        <div class="prose prose-slate max-w-none text-xs sm:text-sm text-slate-600 leading-relaxed space-y-4">
                            <p>
                                Badan Perencanaan Pembangunan Daerah Kabupaten Pringsewu terbentuk seiring dengan lahirnya Kabupaten Pringsewu sebagai daerah otonom baru di Provinsi Lampung berdasarkan <strong>Undang-Undang Republik Indonesia Nomor 48 Tahun 2008</strong> tentang Pembentukan Kabupaten Pringsewu di Provinsi Lampung (pemekaran dari Kabupaten Tanggamus).
                            </p>
                            <p>
                                Sebagai pilar penggerak pembangunan, instansi ini terus berevolusi sejalan dengan dinamika regulasi nasional melalui <strong>Undang-Undang Nomor 23 Tahun 2014</strong> tentang Pemerintahan Daerah dan <strong>Peraturan Pemerintah Nomor 18 Tahun 2016</strong> tentang Perangkat Daerah.
                            </p>
                            <p>
                                Puncak perubahan kelembagaan terjadi melalui <strong>Peraturan Daerah Kabupaten Pringsewu Nomor 16 Tahun 2016</strong> yang kemudian diubah dengan Perda No. 1 Tahun 2020, dan diperbarui secara komprehensif melalui <strong>Peraturan Daerah Kabupaten Pringsewu Nomor 6 Tahun 2024</strong>. Regulasi ini secara resmi mentransformasi <strong>BAPPEDA</strong> menjadi <strong>BAPPERIDA</strong> (Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah) dengan mengintegrasikan fungsi Badan Riset dan Inovasi Daerah (BRIDA) sebagai wujud komitmen kebijakan berbasis bukti (<em>evidence-based policy</em>).
                            </p>
                        </div>

                        <!-- Dasar Hukum Chips -->
                        <div class="pt-2 space-y-3">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 flex items-center gap-2">
                                <Scale class="w-4 h-4 text-teal-700" />
                                <span>Dasar Hukum Pembentukan & Penyelenggaraan:</span>
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div v-for="law in legalBasics" :key="law.code" class="p-3.5 rounded-2xl bg-white border border-slate-200 shadow-2xs hover:border-teal-300 transition-colors">
                                    <div class="text-xs font-black text-teal-800">{{ law.code }}</div>
                                    <div class="text-[11px] text-slate-600 leading-tight mt-1">{{ law.title }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-5 space-y-6">
                        <!-- Card Info Singkat Lembaga -->
                        <div class="rounded-3xl bg-white border border-slate-200/80 p-6 sm:p-8 shadow-xs space-y-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center font-bold">
                                    <Building2 class="w-5 h-5" />
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900">Identitas Lembaga</h3>
                                    <p class="text-[11px] text-slate-500">Pemerintah Kabupaten Pringsewu</p>
                                </div>
                            </div>

                            <div class="divide-y divide-slate-100 text-xs">
                                <div class="py-2.5 flex justify-between gap-4">
                                    <span class="text-slate-500">Nama Resmi:</span>
                                    <span class="font-semibold text-slate-900 text-right">BAPPERIDA Kab. Pringsewu</span>
                                </div>
                                <div class="py-2.5 flex justify-between gap-4">
                                    <span class="text-slate-500">Tipe Lembaga:</span>
                                    <span class="font-semibold text-slate-900 text-right">Badan Penunjang Urusan Pemerintahan</span>
                                </div>
                                <div class="py-2.5 flex justify-between gap-4">
                                    <span class="text-slate-500">Regulasi Terkini:</span>
                                    <span class="font-semibold text-teal-700 text-right">Perda No. 6 Tahun 2024</span>
                                </div>
                                <div class="py-2.5 flex justify-between gap-4">
                                    <span class="text-slate-500">Fokus Fungsi:</span>
                                    <span class="font-semibold text-slate-900 text-right">Perencanaan, Riset, Inovasi & Data</span>
                                </div>
                                <div class="py-2.5 flex justify-between gap-4">
                                    <span class="text-slate-500">Alamat Kantor:</span>
                                    <span class="font-semibold text-slate-900 text-right">Jl. Dr. Sugiri Syarief, MPH</span>
                                </div>
                            </div>

                            <div class="p-4 rounded-2xl bg-teal-50/70 border border-teal-100 text-xs text-teal-900 leading-relaxed">
                                <strong>Komitmen Utama:</strong> Memastikan setiap rupiah anggaran pembangunan daerah dialokasikan secara transparan, berbasis riset ilmiah, dan memberi dampak nyata bagi 400.000+ masyarakat Pringsewu.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 7 Ruang Lingkup BAPPERIDA -->
                <div class="space-y-6 pt-4">
                    <div class="text-center max-w-2xl mx-auto space-y-2">
                        <span class="text-xs font-bold text-teal-700 uppercase tracking-widest">Amanat Regulasi</span>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                            7 Ruang Lingkup Utama BAPPERIDA
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600">
                            Mandat resmi tugas dan wewenang yang diampu BAPPERIDA Kabupaten Pringsewu dalam menyelenggarakan tata kelola pembangunan daerah.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        <div
                            v-for="scope in scopePoints"
                            :key="scope.number"
                            class="relative group p-6 rounded-3xl bg-white border border-slate-200/80 shadow-xs hover:border-teal-400 hover:shadow-md transition-all duration-200 flex flex-col justify-between"
                        >
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-black text-teal-700/30 group-hover:text-teal-600 transition-colors">
                                        {{ scope.number }}
                                    </span>
                                    <div class="w-8 h-8 rounded-full bg-teal-50 text-teal-700 flex items-center justify-center">
                                        <CheckCircle2 class="w-4 h-4" />
                                    </div>
                                </div>
                                <h3 class="text-sm font-bold text-slate-900 group-hover:text-teal-800 transition-colors">
                                    {{ scope.title }}
                                </h3>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    {{ scope.desc }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Nav Links to Other Standalone Pages -->
                <div class="pt-8 border-t border-slate-200">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-4 text-center">Informasi Profil Lainnya</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                        <Link href="/profil/visi-misi" class="p-3 rounded-2xl bg-white border border-slate-200 hover:border-teal-400 hover:bg-teal-50/50 text-center transition-all">
                            <Target class="w-5 h-5 text-teal-700 mx-auto mb-1.5" />
                            <span class="text-xs font-bold text-slate-800">Visi & Misi</span>
                        </Link>
                        <Link href="/profil/struktur-organisasi" class="p-3 rounded-2xl bg-white border border-slate-200 hover:border-teal-400 hover:bg-teal-50/50 text-center transition-all">
                            <Layers class="w-5 h-5 text-teal-700 mx-auto mb-1.5" />
                            <span class="text-xs font-bold text-slate-800">Struktur Organisasi</span>
                        </Link>
                        <Link href="/profil/tupoksi" class="p-3 rounded-2xl bg-white border border-slate-200 hover:border-teal-400 hover:bg-teal-50/50 text-center transition-all">
                            <ShieldCheck class="w-5 h-5 text-teal-700 mx-auto mb-1.5" />
                            <span class="text-xs font-bold text-slate-800">Tupoksi</span>
                        </Link>
                        <Link href="/profil/pejabat" class="p-3 rounded-2xl bg-white border border-slate-200 hover:border-teal-400 hover:bg-teal-50/50 text-center transition-all">
                            <Building2 class="w-5 h-5 text-teal-700 mx-auto mb-1.5" />
                            <span class="text-xs font-bold text-slate-800">Profil Pejabat</span>
                        </Link>
                        <Link href="/profil/statistik-pegawai" class="p-3 rounded-2xl bg-white border border-slate-200 hover:border-teal-400 hover:bg-teal-50/50 text-center transition-all">
                            <FileText class="w-5 h-5 text-teal-700 mx-auto mb-1.5" />
                            <span class="text-xs font-bold text-slate-800">Statistik Pegawai</span>
                        </Link>
                        <Link href="/profil/kontak" class="p-3 rounded-2xl bg-white border border-slate-200 hover:border-teal-400 hover:bg-teal-50/50 text-center transition-all">
                            <Sparkles class="w-5 h-5 text-teal-700 mx-auto mb-1.5" />
                            <span class="text-xs font-bold text-slate-800">Kontak Kami</span>
                        </Link>
                    </div>
                </div>
            </div>
        </main>
    </PublicLayout>
</template>
