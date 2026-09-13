<script setup lang="ts">
import { ref } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import PublicLayout from '@/layouts/PublicLayout.vue';
import { alertSuccess } from '@/lib/swal';
import { notify } from '@/lib/toast';
import {
    Inbox,
    ShieldCheck,
    FileText,
    Sparkles,
    CheckCircle2,
    Send,
    ExternalLink,
    Star,
    ArrowRight,
} from 'lucide-vue-next';

interface Props {
    ikmStats: {
        total_respondents: number;
        score: number;
        predicate: string;
    };
}

defineProps<Props>();

const page = usePage();

// Permohonan Data Form
const dataForm = useForm({
    name: '',
    email: '',
    phone: '',
    institution: '',
    purpose: 'Penelitian / Akademik',
    data_description: '',
});

const submitDataRequest = () => {
    dataForm.post('/layanan/permohonan-data', {
        preserveScroll: true,
        onSuccess: () => {
            const ticket = (page.props.flash as any)?.ticket_number || 'REQ-TERSIMPAN';
            alertSuccess(
                'Permohonan Terkirim!',
                `Permohonan data Anda telah diterima dengan Nomor Tiket: ${ticket}. Tim BAPPERIDA akan menindaklanjuti dalam 3 hari kerja.`
            );
            dataForm.reset();
        },
        onError: (errors) => {
            if (errors.rate_limit) {
                notify.error('Batas Pengiriman', errors.rate_limit);
            } else {
                notify.error('Validasi Gagal', 'Silakan lengkapi formulir permohonan data.');
            }
        },
    });
};

// IKM Survey Form
const surveyForm = useForm({
    respondent_type: 'Masyarakat Umum',
    rating_service_ease: 5,
    rating_speed: 5,
    rating_transparency: 5,
    rating_satisfaction: 5,
    feedback: '',
});

const submitSurvey = () => {
    surveyForm.post('/layanan/survei-ikm', {
        preserveScroll: true,
        onSuccess: () => {
            notify.success(
                'Terima Kasih!',
                'Penilaian Survei Kepuasan Masyarakat (IKM) Anda berhasil tercatat.'
            );
            surveyForm.reset();
        },
        onError: (errors) => {
            if (errors.rate_limit) {
                notify.error('Batas Pengiriman', errors.rate_limit);
            } else {
                notify.error('Validasi Gagal', 'Silakan berikan penilaian pada seluruh poin survei.');
            }
        },
    });
};
</script>

<template>
    <Head title="Layanan Publik, Permohonan Data & Survei IKM - BAPPERIDA" />

    <PublicLayout>
        <!-- Header -->
        <section class="bg-linear-to-b from-teal-900 via-teal-800 to-slate-900 text-white py-14 px-4 sm:px-8">
            <div class="max-w-7xl mx-auto space-y-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-xs text-teal-200">
                    <Sparkles class="w-3.5 h-3.5" />
                    <span>Aspirasi & Transparansi Layanan</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                    Pusat Layanan Informasi & Aspirasi Publik
                </h1>
                <p class="text-xs sm:text-sm text-teal-100/80 max-w-2xl leading-relaxed">
                    Ajukan permohonan data perencanaan dan riset secara daring, sampaikan masukan, serta berikan penilaian kepuasan masyarakat terhadap kinerja BAPPERIDA Kabupaten Pringsewu.
                </p>
            </div>
        </section>

        <section class="py-12 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-8 space-y-12">
                <!-- 2 Big Cards: External Channels -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- SPAN-LAPOR! Card -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-700 flex items-center justify-center">
                                <ShieldCheck class="w-6 h-6" />
                            </div>
                            <h2 class="text-lg font-bold text-slate-900">
                                Pengaduan SPAN-LAPOR!
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Saluran aspirasi dan pengaduan resmi nasional yang terhubung langsung dengan Kementerian PANRB, Kemendagri, dan Kantor Staf Presiden (KSP). Laporkan kendala pelayanan publik dengan aman.
                            </p>
                        </div>
                        <a
                            href="https://lapor.go.id/"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-between px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-rose-700 hover:bg-rose-800 transition-all self-start"
                        >
                            <span>Buka SPAN-LAPOR!</span>
                            <ExternalLink class="w-3.5 h-3.5 ml-2" />
                        </a>
                    </div>

                    <!-- PPID Card -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs flex flex-col justify-between space-y-4">
                        <div class="space-y-3">
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center">
                                <FileText class="w-6 h-6" />
                            </div>
                            <h2 class="text-lg font-bold text-slate-900">
                                PPID Kabupaten Pringsewu
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                                Pejabat Pengelola Informasi dan Dokumentasi (PPID) memastikan pemenuhan hak masyarakat atas informasi publik yang transparan sesuai Undang-Undang No. 14 Tahun 2008.
                            </p>
                        </div>
                        <a
                            href="https://ppid.pringsewukab.go.id/"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-between px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-blue-700 hover:bg-blue-800 transition-all self-start"
                        >
                            <span>Akses Portal PPID</span>
                            <ExternalLink class="w-3.5 h-3.5 ml-2" />
                        </a>
                    </div>
                </div>

                <!-- Two-Column Interactive Forms: Permohonan Data & Survei IKM -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <!-- Form Permohonan Data (7 cols) -->
                    <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs space-y-6">
                        <div class="space-y-1">
                            <span class="text-xs font-bold text-teal-800 uppercase tracking-wider block">
                                Layanan Daring Resmi
                            </span>
                            <h2 class="text-xl font-bold text-slate-900">
                                Formulir Permohonan Data & Informasi Publik
                            </h2>
                            <p class="text-xs text-slate-500">
                                Data perencanaan, peta spasial, kajian riset, atau statistik daerah.
                            </p>
                        </div>

                        <form @submit.prevent="submitDataRequest" class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Nama Lengkap Pemohon *
                                    </label>
                                    <input
                                        v-model="dataForm.name"
                                        type="text"
                                        required
                                        placeholder="Contoh: Rahmat Hidayat"
                                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none"
                                    />
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Email Aktif *
                                    </label>
                                    <input
                                        v-model="dataForm.email"
                                        type="email"
                                        required
                                        placeholder="nama@email.com"
                                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none"
                                    />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Nomor Telepon / WhatsApp *
                                    </label>
                                    <input
                                        v-model="dataForm.phone"
                                        type="tel"
                                        required
                                        placeholder="0812xxxxxxxx"
                                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none"
                                    />
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                                        Instansi / Asal Lembaga
                                    </label>
                                    <input
                                        v-model="dataForm.institution"
                                        type="text"
                                        placeholder="Universitas / Perusahaan / Pribadi"
                                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none"
                                    />
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">
                                    Tujuan Penggunaan Data *
                                </label>
                                <select
                                    v-model="dataForm.purpose"
                                    required
                                    class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none"
                                >
                                    <option>Penelitian / Skripsi / Tesis</option>
                                    <option>Perencanaan Bisnis & Investasi</option>
                                    <option>Pengawasan Publik & Jurnalisme</option>
                                    <option>Keperluan Kedinasan / Pemerintahan</option>
                                    <option>Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">
                                    Rincian Data yang Dibutuhkan *
                                </label>
                                <textarea
                                    v-model="dataForm.data_description"
                                    required
                                    rows="4"
                                    placeholder="Jelaskan jenis data, tahun data, dan format yang Anda harapkan..."
                                    class="w-full px-3.5 py-2 rounded-xl text-xs bg-slate-50 border border-slate-200 focus:bg-white focus:border-teal-700 outline-none"
                                />
                            </div>

                            <button
                                type="submit"
                                :disabled="dataForm.processing"
                                class="w-full py-3 rounded-xl text-xs font-bold text-white bg-teal-800 hover:bg-teal-900 active:scale-[0.98] transition-all disabled:opacity-50 flex items-center justify-center gap-2 cursor-pointer shadow-xs"
                            >
                                <Send class="w-4 h-4" />
                                <span>{{ dataForm.processing ? 'Mengirim Permohonan...' : 'Kirim Permohonan Data' }}</span>
                            </button>
                        </form>
                    </div>

                    <!-- Form Survei IKM (5 cols) -->
                    <div class="lg:col-span-5 bg-teal-50/50 rounded-3xl p-6 sm:p-8 border border-teal-200/80 shadow-xs space-y-6">
                        <div class="space-y-1">
                            <span class="text-xs font-bold text-teal-800 uppercase tracking-wider block">
                                Evaluasi Kinerja Publik
                            </span>
                            <h2 class="text-xl font-bold text-slate-900">
                                Survei Kepuasan Masyarakat (IKM)
                            </h2>
                            <p class="text-xs text-slate-600">
                                Bantu kami mengukur dan meningkatkan kualitas mutu layanan BAPPERIDA.
                            </p>
                        </div>

                        <!-- IKM Score Banner -->
                        <div class="bg-white rounded-2xl p-4 border border-teal-100 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] uppercase font-bold text-slate-400 block">Indeks Kepuasan Terkini</span>
                                <span class="text-2xl font-black text-teal-800">{{ ikmStats.score }} / 100</span>
                            </div>
                            <span class="text-xs font-bold px-3 py-1 rounded-full bg-teal-100 text-teal-800">
                                {{ ikmStats.predicate }}
                            </span>
                        </div>

                        <form @submit.prevent="submitSurvey" class="space-y-4 text-xs">
                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">
                                    Kategori Responden
                                </label>
                                <select
                                    v-model="surveyForm.respondent_type"
                                    class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 focus:border-teal-700 outline-none"
                                >
                                    <option>Masyarakat Umum</option>
                                    <option>Aparatur Sipil Negara (ASN)</option>
                                    <option>Akademisi / Mahasiswa / Pelajar</option>
                                    <option>Pelaku Usaha / Swasta</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="block font-semibold text-slate-700">
                                    1. Kemudahan Persyaratan & Alur Akses (Skala 1 - 5)
                                </label>
                                <div class="flex gap-2">
                                    <button
                                        v-for="r in [1, 2, 3, 4, 5]"
                                        :key="r"
                                        type="button"
                                        class="flex-1 py-1.5 rounded-lg font-bold border transition-all text-center"
                                        :class="surveyForm.rating_service_ease === r ? 'bg-teal-800 text-white border-teal-800' : 'bg-white text-slate-600 border-slate-200'"
                                        @click="surveyForm.rating_service_ease = r"
                                    >
                                        {{ r }}
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block font-semibold text-slate-700">
                                    2. Kecepatan Respons Layanan (Skala 1 - 5)
                                </label>
                                <div class="flex gap-2">
                                    <button
                                        v-for="r in [1, 2, 3, 4, 5]"
                                        :key="r"
                                        type="button"
                                        class="flex-1 py-1.5 rounded-lg font-bold border transition-all text-center"
                                        :class="surveyForm.rating_speed === r ? 'bg-teal-800 text-white border-teal-800' : 'bg-white text-slate-600 border-slate-200'"
                                        @click="surveyForm.rating_speed = r"
                                    >
                                        {{ r }}
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block font-semibold text-slate-700">
                                    3. Kepuasan Menyeluruh (Skala 1 - 5)
                                </label>
                                <div class="flex gap-2">
                                    <button
                                        v-for="r in [1, 2, 3, 4, 5]"
                                        :key="r"
                                        type="button"
                                        class="flex-1 py-1.5 rounded-lg font-bold border transition-all text-center"
                                        :class="surveyForm.rating_satisfaction === r ? 'bg-teal-800 text-white border-teal-800' : 'bg-white text-slate-600 border-slate-200'"
                                        @click="surveyForm.rating_satisfaction = r"
                                    >
                                        {{ r }}
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block font-semibold text-slate-700 mb-1">
                                    Saran & Masukan Konstruktif
                                </label>
                                <textarea
                                    v-model="surveyForm.feedback"
                                    rows="3"
                                    placeholder="Tuliskan saran perbaikan untuk BAPPERIDA..."
                                    class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 focus:border-teal-700 outline-none"
                                />
                            </div>

                            <button
                                type="submit"
                                :disabled="surveyForm.processing"
                                class="w-full py-2.5 rounded-xl font-bold text-white bg-teal-800 hover:bg-teal-900 active:scale-[0.98] transition-all disabled:opacity-50 flex items-center justify-center gap-2 cursor-pointer shadow-xs"
                            >
                                <Sparkles class="w-4 h-4" />
                                <span>Kirim Penilaian Survei</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
