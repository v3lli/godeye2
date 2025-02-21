<script setup>
import { ref, watch } from "vue";

const props = defineProps({
    items: {
        type: Array,
        required: true,
    },
});

const mediaItems = ref([...props.items]); // Initialize with current items


// Watch for changes in `items` prop and update `mediaItems`
watch(
    () => props.items,
    (newItems) => {
        console.log("New items received:", newItems); // Debugging log
        mediaItems.value = [...newItems]; // Update list reactively
    },
    { deep: true } // Ensures Vue detects changes inside the array
)
</script>

<template>
    <div class="image-grid">
        <div v-for="(item, index) in mediaItems" :key="index" class="image-item">
            <img :src="item.image_url" :alt ="item.text" />
            <p>{{ item.text }}</p>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div v-if="loading" class="loading">
        Loading more images...
    </div>
</template>

<style scoped>
.image-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 10px;
}

.image-item img {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

.loading {
    text-align: center;
    padding: 20px;
    font-size: 18px;
    font-weight: bold;
}
</style>
