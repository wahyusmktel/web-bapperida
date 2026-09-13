<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    Users,
    ChevronRight,
    CheckCircle2,
    Shield,
    Briefcase,
    GraduationCap,
    Award,
    Building2,
    Layers,
    Clock,
    FileCheck,
    Sparkles
} from 'lucide-vue-next';

interface OfficialItem {
    id?: string;
    name: string;
    nip: string;
    position: string;
    category_code?: string;
}

interface Props {
    officials?: OfficialItem[];
}

defineProps<Props>();

// 1. Data Kepala Badan (Executive Profile)
const kaban = {
    name: 'Dr. Imam Fatkuroji, S.STP., M.IP',
    nip: '19841110 200312 1 001',
    rank: 'Pembina Tingkat I (IV/b)',
    position: 'Kepala BAPPERIDA Kabupaten Pringsewu',
    photo: '/images/pejabat/imam_fatkuroji.png',
    education: [
        'Doktoral Studi Pembangunan Daerah, Universitas Lampung',
        'Magister Ilmu Pemerintahan, Universitas Lampung',
        'Manajemen Sumberdaya Aparatur, Sekolah Tinggi Pemerintahan Dalam Negeri'
    ],
    experience: [
        'Kepala Badan Perencanaan Pembangunan Daerah Kabupaten Pringsewu',
        'Kepala Badan Perencanaan Pembangunan Daerah Kabupaten Lampung Tengah',
        'Plt. Kepala Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kabupaten Lampung Tengah',
        'Sekretaris Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu Kabupaten Lampung Tengah',
        'Kepala Bagian Protokol dan Komunikasi Pimpinan Kabupaten Lampung Tengah'
    ]
};

// 2. Data Pejabat Sekretariat
const sekretariatPejabat = [
    {
        name: 'Siti Rahma, S.I.Kom., MM',
        nip: '19850609 201001 2 014',
        position: 'Sekretaris BAPPERIDA',
        roleCategory: 'Pimpinan Sekretariat',
        photo: '/images/pejabat/siti_rahma.png'
    },
    {
        name: 'Fitri Faula, S.I.Kom',
        nip: '19880429 201001 2 006',
        position: 'Kasubag Umum dan Kepegawaian',
        roleCategory: 'Pejabat Pengawas',
        photo: '/images/pejabat/fitri_faula.png'
    },
    {
        name: 'Evy Suryani S, MM',
        nip: '19830331 201101 2 006',
        position: 'JF Perencana Ahli Muda',
        roleCategory: 'Jabatan Fungsional',
        photo: '/images/pejabat/evy_suryani.png'
    },
    {
        name: 'Febby Sabel S, SE., MM',
        nip: '19860204 201001 2 021',
        position: 'JF Analis Keuangan Pusat dan Daerah Ahli Muda',
        roleCategory: 'Jabatan Fungsional',
        photo: '/images/pejabat/febby_sabel.png'
    }
];

// 3. Data Pejabat Bidang Teknis
const bidangPejabat = [
    {
        code: 'PPE',
        name: 'Rara Sukma, ST., M.PWK',
        nip: '19850724 201001 2 016',
        position: 'Kepala Bidang Perencanaan Pengendalian dan Evaluasi',
        photo: '/images/pejabat/rara_sukma.png',
        scope: 'RPJPD, RPJMD, RKPD & Pengendalian Evaluasi Kinerja'
    },
    {
        code: 'IPW',
        name: 'Ir. A. Adam Althusius, ST., MURP',
        nip: '19800422 201001 1 009',
        position: 'Kepala Bidang Infrastruktur Pengembangan Wilayah',
        photo: '/images/pejabat/adam_althusius.png',
        scope: 'Tata Ruang Wilayah, Transportasi & Sarana Permukiman'
    },
    {
        code: 'PPM',
        name: 'Debit Zuliansyah, ST',
        nip: '19801012 201001 1 023',
        position: 'Kepala Bidang Pemerintahan dan Pembangunan Manusia',
        photo: '/images/pejabat/debit_zuliansyah.png',
        scope: 'Pendidikan, Kesehatan, Pengentasan Stunting & Sosial'
    },
    {
        code: 'PSDA',
        name: 'Ir. Erwin Soni, ST., MM',
        nip: '19801208 201001 1 011',
        position: 'Kepala Bidang Perekonomian dan Sumber Daya Alam',
        photo: '/images/pejabat/erwin_soni.png',
        scope: 'Agribisnis Pertanian, Ketahanan Pangan, UMKM & SDA'
    },
    {
        code: 'RIDA',
        name: 'Fenny Aprilia, S.Sos',
        nip: '19840405 201001 2 032',
        position: 'Kepala Bidang Riset dan Inovasi Daerah',
        photo: '/images/pejabat/fenny_aprilia.png',
        scope: 'Riset Kebijakan, Indeks Inovasi Daerah (IID) & HAKI'
    }
];
</script>

<template>
    <Head title="Profil Pejabat - BAPPERIDA Kabupaten Pringsewu" />

    <PublicLayout>
        <!-- Breadcrumb Bar -->
        <div class="bg-slate-100/80 border-b border-slate-200/80 py-2.5 px-4 sm:px-8">
            <div class="max-w-7xl mx-auto flex items-center gap-2 text-xs text-slate-600">
                <Link href="/" class="hover:text-teal-800 transition-colors">Beranda</Link>
                <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                <span class="text-slate-400">Profil</span>
                <ChevronRight class="w-3.5 h-3.5 text-slate-400" />
                <span class="font-semibold text-teal-800">Profil Pejabat</span>
            </div>
        </div>

        <!-- Header Banner -->
        <section class="relative bg-gradient-to-r from-teal-950 via-teal-900 to-slate-900 text-white py-14 sm:py-20 px-4 sm:px-8 overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#00C096_1px,transparent_1px)] [background-size:20px_20px] pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative max-w-7xl mx-auto space-y-4">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-500/20 border border-teal-400/30 text-xs font-semibold text-teal-200">
                    <Users class="w-3.5 h-3.5" />
                    <span>Jajaran Pimpinan & Pejabat BAPPERIDA</span>
                </div>
                <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white max-w-4xl leading-tight">
                    Profil Pejabat BAPPERIDA
                </h1>
                <p class="text-sm sm:text-base text-teal-100/90 max-w-3xl leading-relaxed">
                    Mengenal lebih dekat jajaran aparatur pimpinan, sekretariat, dan kepala bidang teknis yang berdedikasi mengawal arah kebijakan pembangunan Kabupaten Pringsewu.
                </p>
            </div>
        </section>

        <!-- Main Content -->
        <main class="py-12 sm:py-16 bg-slate-50/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-16">

                <!-- 1. EXECUTIVE SPOTLIGHT: KEPALA BAPPERIDA -->
                <div class="rounded-3xl bg-white border border-slate-200/90 shadow-xl overflow-hidden">
                    <!-- Top Gold/Pattern Bar -->
                    <div class="h-3 bg-gradient-to-r from-amber-500 via-amber-400 to-amber-600"></div>

                    <div class="p-6 sm:p-10 lg:p-12 space-y-8">
                        <!-- Header & Title -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 pb-8 border-b border-slate-100">
                            <!-- Foto Resmi Kaban -->
                            <div class="w-28 h-32 sm:w-36 sm:h-40 rounded-2xl overflow-hidden shadow-lg border-4 border-white bg-slate-100 shrink-0">
                                <img
                                    :src="kaban.photo"
                                    :alt="kaban.name"
                                    class="w-full h-full object-cover object-top"
                                />
                            </div>

                            <div class="space-y-2 grow">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 text-teal-800 text-xs font-bold border border-teal-200">
                                    <Shield class="w-3.5 h-3.5 text-teal-700" />
                                    <span>Pimpinan Tinggi Pratama</span>
                                </div>
                                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 tracking-tight">
                                    {{ kaban.name }}
                                </h2>
                                <p class="text-sm font-bold text-teal-800 uppercase tracking-wider">
                                    {{ kaban.position }}
                                </p>
                            </div>
                        </div>

                        <!-- Grid 3 Kolom: Biodata, Pendidikan, Pengalaman -->
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                            <!-- Kolom 1: Profil / Biodata -->
                            <div class="md:col-span-4 space-y-4">
                                <div class="flex items-center gap-2 text-slate-900 font-black text-sm uppercase tracking-wider">
                                    <Users class="w-4 h-4 text-teal-700" />
                                    <span>Data Kepegawaian</span>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3 text-xs">
                                    <div>
                                        <span class="text-slate-400 block text-[10px] uppercase font-semibold">Nama Lengkap</span>
                                        <span class="font-bold text-slate-900">{{ kaban.name }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[10px] uppercase font-semibold">NIP Resmi</span>
                                        <span class="font-mono font-bold text-slate-800">{{ kaban.nip }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[10px] uppercase font-semibold">Pangkat / Golongan</span>
                                        <span class="font-bold text-teal-800">{{ kaban.rank }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[10px] uppercase font-semibold">Jabatan Definitif</span>
                                        <span class="font-bold text-slate-900">{{ kaban.position }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Kolom 2: Riwayat Pendidikan -->
                            <div class="md:col-span-4 space-y-4">
                                <div class="flex items-center gap-2 text-slate-900 font-black text-sm uppercase tracking-wider">
                                    <GraduationCap class="w-4 h-4 text-teal-700" />
                                    <span>Riwayat Pendidikan</span>
                                </div>

                                <ul class="space-y-2.5 text-xs text-slate-700">
                                    <li v-for="edu in kaban.education" :key="edu" class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-start gap-2.5">
                                        <CheckCircle2 class="w-4 h-4 text-teal-600 shrink-0 mt-0.5" />
                                        <span class="leading-relaxed font-medium">{{ edu }}</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Kolom 3: Riwayat Pengalaman Kerja -->
                            <div class="md:col-span-4 space-y-4">
                                <div class="flex items-center gap-2 text-slate-900 font-black text-sm uppercase tracking-wider">
                                    <Briefcase class="w-4 h-4 text-teal-700" />
                                    <span>Pengalaman Jabatan</span>
                                </div>

                                <ul class="space-y-2.5 text-xs text-slate-700">
                                    <li v-for="exp in kaban.experience" :key="exp" class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-start gap-2.5">
                                        <div class="w-1.5 h-1.5 rounded-full bg-teal-600 mt-1.5 shrink-0"></div>
                                        <span class="leading-relaxed">{{ exp }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. SECTION: JAJARAN SEKRETARIAT -->
                <div class="space-y-6">
                    <div class="text-center max-w-2xl mx-auto space-y-2">
                        <span class="text-xs font-bold text-teal-700 uppercase tracking-widest block">
                            Tata Kelola Administrasi & Perencanaan
                        </span>
                        <h3 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                            Pejabat Sekretariat Badan
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600">
                            Mendukung tata laksana kepegawaian, keuangan, dan koordinasi fungsional kedinasan BAPPERIDA.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div
                            v-for="s in sekretariatPejabat"
                            :key="s.nip"
                            class="rounded-3xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:border-teal-400 transition-all p-5 flex flex-col justify-between"
                        >
                            <div class="space-y-4 text-center">
                                <!-- Foto Pejabat -->
                                <div class="w-24 h-28 mx-auto rounded-2xl overflow-hidden shadow-md border-2 border-slate-100 bg-slate-100">
                                    <img
                                        :src="s.photo"
                                        :alt="s.name"
                                        class="w-full h-full object-cover object-top"
                                    />
                                </div>

                                <div class="space-y-1">
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-teal-50 text-teal-800 uppercase tracking-wider">
                                        {{ s.roleCategory }}
                                    </span>
                                    <h4 class="text-xs sm:text-sm font-black text-slate-900 leading-snug pt-1">
                                        {{ s.name }}
                                    </h4>
                                    <p class="text-[11px] font-semibold text-teal-800">
                                        {{ s.position }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-t border-slate-100 text-center">
                                <span class="text-[10px] text-slate-400 uppercase font-semibold block">NIP Resmi</span>
                                <span class="text-xs font-mono font-medium text-slate-700">{{ s.nip }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. SECTION: JAJARAN KEPALA BIDANG TEKNIS -->
                <div class="space-y-6 pt-6 border-t border-slate-200">
                    <div class="text-center max-w-2xl mx-auto space-y-2">
                        <span class="text-xs font-bold text-teal-700 uppercase tracking-widest block">
                            Unit Pelaksana Teknis Operasional
                        </span>
                        <h3 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                            Kepala Bidang Teknis BAPPERIDA
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600">
                            Mengawal 5 sektor strategis perencanaan makro, tata ruang, sumber daya manusia, ekonomi agribisnis, dan inovasi daerah.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div
                            v-for="b in bidangPejabat"
                            :key="b.code"
                            class="rounded-3xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md hover:border-teal-400 transition-all p-6 flex flex-col justify-between"
                        >
                            <div class="space-y-4">
                                <div class="flex items-center gap-4">
                                    <!-- Foto Pejabat -->
                                    <div class="w-20 h-24 rounded-2xl overflow-hidden shadow-md border-2 border-slate-100 bg-slate-100 shrink-0">
                                        <img
                                            :src="b.photo"
                                            :alt="b.name"
                                            class="w-full h-full object-cover object-top"
                                        />
                                    </div>

                                    <div class="space-y-1">
                                        <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-teal-50 text-teal-800 uppercase tracking-wider">
                                            BIDANG {{ b.code }}
                                        </span>
                                        <h4 class="text-xs sm:text-sm font-black text-slate-900 leading-snug">
                                            {{ b.name }}
                                        </h4>
                                        <p class="text-[11px] text-teal-800 font-semibold leading-tight">
                                            {{ b.position }}
                                        </p>
                                    </div>
                                </div>

                                <div class="pt-2 border-t border-slate-100 space-y-1">
                                    <div class="text-[10px] text-slate-400 uppercase font-semibold">Fokus Substansi</div>
                                    <p class="text-xs text-slate-600 leading-relaxed">{{ b.scope }}</p>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px]">
                                <span class="font-mono text-slate-600">{{ b.nip }}</span>
                                <span class="flex items-center gap-1 text-teal-700 font-semibold">
                                    <CheckCircle2 class="w-3.5 h-3.5" /> Aktif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </PublicLayout>
</template>
