<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import {
    Sparkles,
    CheckCircle2,
    Building2,
    Users,
    Compass,
    Award,
} from 'lucide-vue-next';

interface OfficialItem {
    id: string;
    name: string;
    nip: string;
    position: string;
    category_code: string;
}

interface Props {
    officials: OfficialItem[];
}

defineProps<Props>();
</script>

<template>
    <Head title="Profil BAPPERIDA Kabupaten Pringsewu - Visi, Misi, & Struktur Organisasi" />

    <PublicLayout>
        <!-- Header -->
        <section class="bg-linear-to-b from-teal-900 via-teal-800 to-slate-900 text-white py-14 px-4 sm:px-8">
            <div class="max-w-7xl mx-auto space-y-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-xs text-teal-200">
                    <Sparkles class="w-3.5 h-3.5" />
                    <span>Mengenal Lembaga Perencana Daerah</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                    Profil Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah
                </h1>
                <p class="text-xs sm:text-sm text-teal-100/80 max-w-2xl leading-relaxed">
                    Dedikasi mewujudkan tata kelola perencanaan pembangunan yang berkualitas, riset terpadu, dan inovasi solutif untuk kemajuan masyarakat Kabupaten Pringsewu.
                </p>
            </div>
        </section>

        <!-- Institutional Overview & Vision/Mission -->
        <section class="py-16 bg-white border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-16">
                <!-- Overview -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-7 space-y-4">
                        <span class="text-xs font-bold text-teal-800 uppercase tracking-wider block">
                            Tentang Instansi
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                            Pilar Utama Perencanaan Strategis Kabupaten Pringsewu
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            BAPPERIDA Kabupaten Pringsewu merupakan perangkat daerah yang berkedudukan di bawah dan bertanggung jawab kepada Bupati melalui Sekretaris Daerah. Memiliki fungsi sentral dalam menyusun perencanaan pembangunan jangka panjang (RPJPD), jangka menengah (RPJMD), rencana tahunan (RKPD), serta mengoordinasikan riset daerah dan ekosistem inovasi pelayanan publik.
                        </p>
                    </div>

                    <div class="lg:col-span-5 bg-teal-50/60 rounded-3xl p-8 border border-teal-200/80 space-y-4">
                        <div class="w-12 h-12 rounded-2xl bg-teal-800 text-white flex items-center justify-center font-black text-xl">
                            BP
                        </div>
                        <h3 class="text-base font-bold text-slate-900">
                            Prinsip Perencanaan Pringsewu
                        </h3>
                        <ul class="space-y-2 text-xs text-slate-700">
                            <li class="flex items-center gap-2">
                                <CheckCircle2 class="w-4 h-4 text-teal-700 shrink-0" />
                                <span><strong>Partisipatif & Inklusif:</strong> Melibatkan seluruh lapisan warga.</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <CheckCircle2 class="w-4 h-4 text-teal-700 shrink-0" />
                                <span><strong>Berbasis Bukti (Evidence-based):</strong> Menggunakan riset dan data nyata.</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <CheckCircle2 class="w-4 h-4 text-teal-700 shrink-0" />
                                <span><strong>Inovatif & Berkelanjutan:</strong> Solutif dan ramah lingkungan.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Visi & Misi Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Visi -->
                    <div class="bg-slate-50 rounded-3xl p-8 border border-slate-200/80 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-teal-800 text-white flex items-center justify-center">
                                <Compass class="w-5 h-5" />
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">
                                Visi Pembangunan Daerah
                            </h3>
                        </div>
                        <blockquote class="text-base sm:text-lg font-semibold text-teal-900 italic border-l-4 border-teal-700 pl-4 py-2 bg-white rounded-r-2xl">
                            "Pringsewu yang Berdaya Saing, Harmonis, dan Berkelanjutan Berbasis Pertanian dan Inovasi."
                        </blockquote>
                    </div>

                    <!-- Misi -->
                    <div class="bg-slate-50 rounded-3xl p-8 border border-slate-200/80 space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-teal-800 text-white flex items-center justify-center">
                                <Award class="w-5 h-5" />
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">
                                Misi Pembangunan Daerah
                            </h3>
                        </div>
                        <ul class="space-y-2.5 text-xs sm:text-sm text-slate-700">
                            <li class="flex items-start gap-2">
                                <span class="w-5 h-5 rounded-full bg-teal-200 text-teal-900 text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">1</span>
                                <span>Mewujudkan perekonomian daerah yang inklusif dan berdaya saing berbasis agribisnis dan UMKM.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-5 h-5 rounded-full bg-teal-200 text-teal-900 text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">2</span>
                                <span>Meningkatkan kualitas sumber daya manusia yang sehat, cerdas, berkarakter, dan berdaya guna.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-5 h-5 rounded-full bg-teal-200 text-teal-900 text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">3</span>
                                <span>Memperkuat tata kelola pemerintahan yang bersih, inovatif, transparan, dan berorientasi pelayanan publik.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="w-5 h-5 rounded-full bg-teal-200 text-teal-900 text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">4</span>
                                <span>Mewujudkan pembangunan infrastruktur wilayah yang merata dan berwawasan lingkungan.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- Struktur Organisasi & Profil Pejabat -->
        <section class="py-16 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-10">
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs font-bold text-teal-800 uppercase tracking-wider">
                        Aparatur Penggerak Perencanaan
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        Struktur Pejabat Pimpinan BAPPERIDA
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500">
                        Susunan pejabat pimpinan struktural Badan Perencanaan Pembangunan, Riset dan Inovasi Daerah Kabupaten Pringsewu.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="official in officials"
                        :key="official.id"
                        class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs hover:shadow-md transition-all flex items-start gap-4"
                    >
                        <div class="w-12 h-12 rounded-2xl bg-teal-100 text-teal-800 font-bold flex items-center justify-center text-sm shrink-0">
                            {{ official.name.charAt(0) }}
                        </div>
                        <div class="space-y-1">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-teal-800 px-2 py-0.5 rounded-md bg-teal-50 inline-block">
                                {{ official.category_code }}
                            </span>
                            <h3 class="text-sm font-bold text-slate-900 leading-snug">
                                {{ official.name }}
                            </h3>
                            <p class="text-xs text-slate-600 font-medium">
                                {{ official.position }}
                            </p>
                            <p class="text-[11px] font-mono text-slate-400">
                                NIP: {{ official.nip }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
