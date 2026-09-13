<script setup lang="ts">
import { ref } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';
import { notify } from '@/lib/toast';
import {
    ShieldCheck,
    Lock,
    Mail,
    Eye,
    EyeOff,
    ArrowRight,
    Sparkles,
} from 'lucide-vue-next';

const showPassword = ref(false);

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('/admin/login', {
        onError: (errors) => {
            if (errors.email) {
                notify.error('Autentikasi Gagal', errors.email);
            } else if (errors.password) {
                notify.error('Autentikasi Gagal', errors.password);
            } else {
                notify.error('Terjadi kesalahan', 'Silakan periksa input Anda.');
            }
        },
        onSuccess: () => {
            notify.success('Berhasil Masuk', 'Selamat datang di Panel Administrasi BAPPERIDA.');
        },
    });
};
</script>

<template>
    <Head title="Masuk Administrator - BAPPERIDA Kabupaten Pringsewu" />

    <div class="min-h-screen bg-slate-100 flex flex-col justify-center items-center p-4 sm:p-6 relative overflow-hidden">
        <!-- Subtle Ambient Background Accents -->
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-teal-200/50 rounded-full blur-3xl pointer-events-none" />
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-amber-100/60 rounded-full blur-3xl pointer-events-none" />

        <div class="w-full max-w-md relative z-10">
            <!-- Brand Badge -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-teal-800 text-white font-black text-2xl shadow-lg mb-4 ring-4 ring-teal-700/10">
                    BP
                </div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                    BAPPERIDA
                </h1>
                <p class="text-xs font-semibold text-teal-800 uppercase tracking-widest mt-0.5">
                    Kabupaten Pringsewu
                </p>
                <div class="mt-3 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-50 border border-teal-200 text-[11px] font-medium text-teal-800">
                    <ShieldCheck class="w-3.5 h-3.5 text-teal-700" />
                    Sistem Akses Terproteksi Pemerintah
                </div>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200/80 p-8 sm:p-10 backdrop-blur-sm">
                <div class="mb-6 text-center">
                    <h2 class="text-lg font-bold text-slate-900">
                        Masuk Administrator
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Gunakan kredensial resmi instansi untuk mengelola portal
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-5">
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Alamat Email Kedinasan
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <Mail class="w-4 h-4" />
                            </div>
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                required
                                autofocus
                                autocomplete="email"
                                placeholder="nama@bapperida.pringsewukab.go.id"
                                :class="[
                                    form.errors.email ? 'border-rose-400 focus:ring-rose-500' : 'border-slate-200 focus:border-teal-700 focus:ring-teal-700/20',
                                    'w-full pl-10 pr-4 py-2.5 rounded-xl text-sm bg-slate-50/50 focus:bg-white border outline-none transition-all duration-150',
                                ]"
                            />
                        </div>
                        <p v-if="form.errors.email" class="text-xs text-rose-600 mt-1.5">
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">
                            Kata Sandi
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <Lock class="w-4 h-4" />
                            </div>
                            <input
                                id="password"
                                v-model="form.password"
                                :type="showPassword ? 'text' : 'password'"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••••••"
                                :class="[
                                    form.errors.password ? 'border-rose-400 focus:ring-rose-500' : 'border-slate-200 focus:border-teal-700 focus:ring-teal-700/20',
                                    'w-full pl-10 pr-10 py-2.5 rounded-xl text-sm bg-slate-50/50 focus:bg-white border outline-none transition-all duration-150',
                                ]"
                            />
                            <button
                                type="button"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600"
                                @click="showPassword = !showPassword"
                            >
                                <component :is="showPassword ? EyeOff : Eye" class="w-4 h-4" />
                            </button>
                        </div>
                        <p v-if="form.errors.password" class="text-xs text-rose-600 mt-1.5">
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <!-- Remember & Security Info -->
                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center gap-2 cursor-pointer select-none text-slate-600">
                            <input
                                v-model="form.remember"
                                type="checkbox"
                                class="w-4 h-4 rounded text-teal-700 focus:ring-teal-700/20 border-slate-300"
                            />
                            Ingat sesi ini
                        </label>
                        <span class="text-slate-400 text-[11px]">
                            SSL / TLS Terenkripsi
                        </span>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-semibold text-white bg-teal-800 hover:bg-teal-900 active:scale-[0.98] disabled:opacity-70 transition-all duration-150 shadow-md shadow-teal-900/10 cursor-pointer"
                    >
                        <span v-if="form.processing">Memverifikasi Kredensial...</span>
                        <template v-else>
                            <span>Masuk ke Panel Admin</span>
                            <ArrowRight class="w-4 h-4" />
                        </template>
                    </button>
                </form>

                <!-- Back to Public Site -->
                <div class="mt-6 pt-6 border-t border-slate-100 text-center">
                    <a
                        href="/"
                        class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 hover:text-teal-800 transition-colors"
                    >
                        <Sparkles class="w-3.5 h-3.5 text-teal-700" />
                        Kembali ke Halaman Publik Bapperida
                    </a>
                </div>
            </div>

            <!-- Security Footer Note -->
            <p class="text-center text-[11px] text-slate-400 mt-6">
                Aktivitas masuk tercatat dalam audit trail demi menjaga integritas data daerah.
            </p>
        </div>
    </div>
</template>
