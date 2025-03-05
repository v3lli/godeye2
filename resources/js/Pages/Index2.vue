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

// ✅ Keep track of new items that should be added to the grid
const newItemsToAdd = ref(null);

// ✅ Loading state
const isLoading = ref(false);

// ** Watcher to detect new data and process it **
watch(
    () => props.mediaData,
    (newData) => {
        if (newData.data) {
            newItemsToAdd.value = newData.data;
            
            // Update pagination info
            currentPage.value = newData.current_page;
            nextPageUrl.value = newData.next_page_url;
            
            // Set loading to false when data arrives
            isLoading.value = false;
        }
    },
    { deep: true }
);

// After we've pushed the items to the child component, reset newItemsToAdd
const onItemsAdded = () => {
    newItemsToAdd.value = null;
};

// Function to fetch next page
const fetchNextPage = () => {
    if (!nextPageUrl.value || isLoading.value) {
        return;
    }
    
    // Set loading state to true before fetching
    isLoading.value = true;
    
    router.get(nextPageUrl.value, {}, {
        preserveState: true,
        preserveScroll: true,
        only: ["mediaData"],
        onSuccess: () => {
            // Loading state will be set to false when the watcher detects new data
        },
        onError: () => {
            // Make sure to set loading to false even on error
            isLoading.value = false;
        }
    });
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
    <FillScrNav/>
    <Hero background-style=""/>
    <div class="items-center justify-center flex flex-col">
        <span class="my-b mt-10 uppercase text-xl text-gray-500">Current Mood</span>
        <ImageGrid2 
            :items="mediaItems" 
            :new-items="newItemsToAdd" 
            @items-added="onItemsAdded" 
        />

        <!-- Loading spinner -->
        <div v-if="isLoading" class="spinner-container">
            <div class="spinner"></div>
            <p class="mt-3 text-gray-500">Loading more images...</p>
        </div>

        <!-- Only show load more button when not loading -->
        <button v-if="nextPageUrl && !isLoading" @click="fetchNextPage" class="load-more">
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

.spinner-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 20px 0;
}

.spinner {
    border: 4px solid rgba(0, 0, 0, 0.1);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border-left-color: #333;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>