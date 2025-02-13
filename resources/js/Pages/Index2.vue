<script setup>
import { ref, watchEffect } from 'vue';
import { Head } from '@inertiajs/vue3';
import ImageGrid from '@/Components/ImageGrid.vue';
import Hero from "@/Components/Hero.vue";

// ✅ Receive `mediaData` from the backend as a prop
const props = defineProps({
    mediaData: Object
});

// ✅ Store all media items
const mediaItems = ref([...props.mediaData.data]);

// ✅ Track pagination details
const currentPage = ref(props.mediaData.current_page);
const nextPageUrl = ref(props.mediaData.next_page_url);

// ✅ Function to fetch next page
const fetchNextPage = async () => {
    if (!nextPageUrl.value) return; // Stop if no more pages

    try {
        const response = await fetch(nextPageUrl.value);
        const json = await response.json();

        // ✅ Append new items
        mediaItems.value.push(...json.data);
        currentPage.value = json.current_page;
        nextPageUrl.value = json.next_page_url; // Update next page URL

    } catch (error) {
        console.error('Error loading more media:', error);
    }
};

// ✅ Infinite Scroll - Detect when user scrolls near bottom
const handleScroll = () => {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500) {
        fetchNextPage();
    }
};

// ✅ Attach event listener for scrolling
watchEffect(() => {
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <Head title="Media Gallery" />
    <Hero background-style=""/>
    <div>
        <!-- ✅ Pass `mediaItems` to ImageGrid -->
        <ImageGrid :media-items="mediaItems" />

        <!-- ✅ Load More Button for Manual Loading -->
        <button v-if="nextPageUrl" @click="fetchNextPage" class="load-more">
            Load More
        </button>
    </div>
</template>

<style scoped>
.load-more {
    display: block;
    margin: 20px auto;
    padding: 10px 20px;
    background-color: #333;
    color: white;
    border: none;
    cursor: pointer;
}
</style>
