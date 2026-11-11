<script setup lang="ts">
import { computed } from 'vue';
import { SPPG_GUIDELINES, type SppgIndicatorGuide } from '@/data/sppgGuidelines';
import {
    X,
    BookOpen,
    CheckCircle2,
    Camera,
    Info,
    ShieldAlert,
    Sparkles,
    Scale,
    ExternalLink,
} from 'lucide-vue-next';

interface Props {
    indicatorId: number | null;
    isOpen: boolean;
}

const props = defineProps<Props>();
const emit = defineEmits<{
    (e: 'close'): void;
}>();

const currentGuide = computed<SppgIndicatorGuide | null>(() => {
    if (!props.indicatorId) return null;
    return SPPG_GUIDELINES[props.indicatorId] || null;
});
</script>

<template>
    <div
        v-if="isOpen && currentGuide"
        class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 sm:p-6"
        @click.self="emit('close')"
    >
        <div
            class="bg-white rounded-3xl shadow-2xl border border-slate-200 w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden animate-in fade-in zoom-in-95 duration-200"
        >
            <!-- Modal Header -->
            <div class="px-6 py-4.5 bg-gradient-to-r from-teal-900 to-slate-900 text-white flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-teal-800/80 border border-teal-500/40 flex items-center justify-center font-mono font-bold text-teal-200 text-sm">
                        {{ currentGuide.code }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-teal-700/60 text-teal-200 border border-teal-500/30">
                                {{ currentGuide.categoryLabel }}
                            </span>
                            <span class="text-xs font-bold text-amber-300">
                                Bobot {{ currentGuide.weight }}
                            </span>
                        </div>
                        <h3 class="text-base sm:text-lg font-black text-white mt-0.5">
                            {{ currentGuide.title }}
                        </h3>
                    </div>
                </div>

                <button
                    type="button"
                    class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors cursor-pointer"
                    @click="emit('close')"
                >
                    <X class="w-4 h-4" />
                </button>
            </div>

            <!-- Modal Content Scrollable -->
            <div class="p-6 overflow-y-auto space-y-6 text-slate-700 text-xs sm:text-sm">
                <!-- Tujuan Pemeriksaan -->
                <div class="p-4 rounded-2xl bg-teal-50/70 border border-teal-200/60 space-y-1.5">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-teal-900 flex items-center gap-1.5">
                        <Info class="w-3.5 h-3.5 text-teal-700" />
                        Tujuan Pemeriksaan
                    </span>
                    <p class="text-slate-800 leading-relaxed font-medium">
                        {{ currentGuide.objective }}
                    </p>
                </div>

                <!-- Tabel Kondisi & Skor -->
                <div class="space-y-2">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 flex items-center gap-1.5">
                        <Scale class="w-4 h-4 text-teal-700" />
                        Tabel Kondisi Penilaian & Nilai Skor (%)
                    </h4>
                    <div class="border border-slate-200 rounded-2xl overflow-hidden divide-y divide-slate-100">
                        <div
                            v-for="(crit, idx) in currentGuide.criteria"
                            :key="idx"
                            class="p-3.5 flex items-center justify-between gap-3 hover:bg-slate-50 transition-colors"
                            :class="crit.scoreValue > 0 ? 'bg-white' : 'bg-slate-50/50'"
                        >
                            <div class="flex items-start gap-2.5">
                                <CheckCircle2
                                    class="w-4 h-4 shrink-0 mt-0.5"
                                    :class="crit.scoreValue > 0 ? 'text-teal-600' : 'text-slate-300'"
                                />
                                <span class="text-xs text-slate-800 font-medium leading-snug">
                                    {{ crit.condition }}
                                </span>
                            </div>
                            <span
                                class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold shrink-0"
                                :class="crit.scoreValue > 0 ? 'bg-teal-100 text-teal-800' : 'bg-rose-100 text-rose-700'"
                            >
                                {{ crit.score }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Dokumentasi Wajib -->
                <div class="space-y-2">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 flex items-center gap-1.5">
                        <Camera class="w-4 h-4 text-teal-700" />
                        Dokumentasi Wajib (Wajib Menggunakan Timestamp)
                    </h4>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2">
                        <ul class="space-y-2">
                            <li
                                v-for="(doc, idx) in currentGuide.docRequirement"
                                :key="idx"
                                class="flex items-start gap-2.5 text-xs text-slate-700"
                            >
                                <span class="w-1.5 h-1.5 rounded-full bg-teal-600 shrink-0 mt-1.5" />
                                <span class="font-medium">{{ doc }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Petunjuk & Catatan Teknis BGN -->
                <div class="space-y-2">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 flex items-center gap-1.5">
                        <Sparkles class="w-4 h-4 text-amber-600" />
                        Petunjuk Teknis Satgas BGN
                    </h4>
                    <div class="p-4 rounded-2xl bg-amber-50/60 border border-amber-200/70 space-y-1.5">
                        <ul class="space-y-1.5 text-xs text-amber-950">
                            <li
                                v-for="(tip, idx) in currentGuide.officialTips"
                                :key="idx"
                                class="flex items-start gap-2"
                            >
                                <span class="text-amber-600 font-bold">•</span>
                                <span>{{ tip }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-200 flex items-center justify-between shrink-0">
                <span class="text-[11px] text-slate-400 font-medium">
                    Standar Resmi Badan Gizi Nasional (BGN) RI 2026
                </span>
                <button
                    type="button"
                    class="px-5 py-2 rounded-xl text-xs font-bold bg-teal-800 hover:bg-teal-900 text-white transition-all cursor-pointer shadow-xs"
                    @click="emit('close')"
                >
                    Paham & Lanjutkan
                </button>
            </div>
        </div>
    </div>
</template>
