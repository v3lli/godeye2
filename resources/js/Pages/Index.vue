<script setup>
import Hero from "@/Components/Hero.vue";
import FillScrNav from "@/Components/FillScrNav.vue";
import ImageGrid from "@/Components/ImageGrid.vue";
import { ref, watch } from 'vue';
// import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    mediaData: {
        type: Object,
        required: true,
    },
});
const mediaItems = ref(props.mediaData.data); // Extract items
const currentPage = ref(props.mediaData.current_page); // Track page number

// Function to fetch next page
const fetchNextPage = async (pageUrl) => {
    if (!pageUrl) return; // No more pages

    const response = await fetch(pageUrl);
    const json = await response.json();

    mediaItems.value.push(...json.data); // Append new items
    currentPage.value = json.current_page;
};

</script>

<template>
    <FillScrNav/>
    <Hero background-style=""/>
    <ImageGrid :items="mediaItems" />
</template>

<style scoped>

</style>
