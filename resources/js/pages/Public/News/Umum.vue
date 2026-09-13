<script setup lang="ts">
import MagazineView, { type Props } from '@/components/News/MagazineView.vue';

defineProps<Omit<Props, 'baseUrl'>>();
</script>

<template>
    <MagazineView v-bind="$props" baseUrl="/berita/umum" />
</template>
