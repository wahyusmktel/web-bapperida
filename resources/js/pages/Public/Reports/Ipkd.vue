<script setup lang="ts">
import ReportListView, { type Props } from '@/components/Reports/ReportListView.vue';

defineProps<Omit<Props, 'baseUrl'>>();
</script>

<template>
    <ReportListView v-bind="$props" baseUrl="/laporan/ipkd" />
</template>
