<script setup>
import { ref, watchEffect, watch } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import FillScrNav from "@/Components/FillScrNav.vue";
import ImageGrid2 from '@/Components/ImageGrid2.vue';
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

// ** Watcher to detect new data and append to mediaItems **
watch(
    () => props.mediaData,
    (newData) => {
        if (newData?.data?.length) {

            mediaItems.value.push(...newData.data); // Append new items
            nextPageUrl.value = newData.next_page_url; // Update next page URL
        }
        console.log("New data received:", mediaItems ); // Check response
    },
    { deep: true }
);
// Function to fetch next page
const fetchNextPage = () => {
    if (!nextPageUrl.value) return; // No more pages

    console.log("Fetching next page:", nextPageUrl.value);

    router.get(nextPageUrl.value, {}, {
        preserveState: true,
        preserveScroll: true,
        only: ["mediaData"],
    });
};

// const fetchNextPage = async () => {
//     if (!nextPageUrl.value) return;
//
//     console.log("Fetching next page:", nextPageUrl.value); // Debugging
//
//     const response = await fetch(nextPageUrl.value);
//     const json = await response.json();
//
//     console.log("New data received:", json); // Check response
//
//     if (json.data.length > 0) {
//         mediaItems.value.push(...json.data); // Append new items
//         nextPageUrl.value = json.next_page_url; // Update next page URL
//     } else {
//         nextPageUrl.value = null; // Stop fetching when no more pages
//     }
// };

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
    <FillScrNav/>
    <Hero background-style=""/>
    <div class="items-center justify-center flex flex-col">
        <!-- ✅ Pass `mediaItems` to ImageGrid -->
         <span class="my-b mt-10 uppercase text-xl text-gray-500">Current Mood</span>
        <ImageGrid2 :items="mediaItems" />

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
