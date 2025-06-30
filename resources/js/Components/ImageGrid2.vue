<script setup>
import { ref, watch, computed, onMounted, onUnmounted } from "vue";

const props = defineProps({
    items: {
        type: Array,
        required: true,
    },
    newItems: {
        type: Array,
        default: null,
    }
});

const emit = defineEmits(['itemsAdded']);

// Store all media items
const mediaItems = ref([...props.items]);

// Compute the items to display in each column
const firstColumn = computed(() => {
    const items = mediaItems.value.filter((_, i) => i % 2 === 0);
    return items;
});

const secondColumn = computed(() => {
    const items = mediaItems.value.filter((_, i) => i % 2 === 1);
    return items;
});

watch(
    () => props.newItems,
    (newItems) => {

        if (newItems !== null) {
            const array = Object.keys(newItems).map(key => ({id: key, ...newItems[key]}));
            mediaItems.value = [...mediaItems.value, ...array];
            emit('itemsAdded');
        }
    },
    {immediate: true}
);

// Modal/preview functionality
const selectedImage = ref(null);
const currentIndex = ref(0);
const isOpen = ref(false);

// Open the image preview modal
const openPreview = (index) => {
    currentIndex.value = index;
    selectedImage.value = mediaItems.value[index].image_url;
    isOpen.value = true;
};

// Close the modal
const closePreview = () => {
    isOpen.value = false;
    selectedImage.value = null;
};

// Navigate to previous image
const prevImage = () => {
    if (currentIndex.value > 0) {
        currentIndex.value--;
        selectedImage.value = mediaItems.value[currentIndex.value].image_url;
    }
};

// Navigate to next image
const nextImage = () => {
    if (currentIndex.value < mediaItems.value.length - 1) {
        currentIndex.value++;
        selectedImage.value = mediaItems.value[currentIndex.value].image_url;
    }
};

// Close modal on 'Escape' key press
const handleKeyDown = (event) => {
    if (event.key === "Escape") closePreview();
};

onMounted(() => {
    window.addEventListener("keydown", handleKeyDown);
});

onUnmounted(() => {
    window.removeEventListener("keydown", handleKeyDown);
});
</script>

<template>
    <div class="flex flex-col lg:flex-row w-full px-3 sm:px-4 md:px-5 gap-3 sm:gap-4 md:gap-5 mt-6 sm:mt-8 md:mt-10">
        <div class="w-full lg:w-1/2 space-y-8 sm:space-y-12 md:space-y-16 lg:space-y-20 xl:space-y-24 p-3 sm:p-6 md:p-10 lg:p-16 xl:p-20">
            <div v-for="(item, index) in firstColumn" :key="'first-' + index" class="text-center">
                <img
                    :src="item.image_url"
                    :alt="item.text"
                    class="rounded-lg shadow-2xl cursor-pointer hover:opacity-80 transition w-full"
                    @click="openPreview(index * 2)"
                />
                <p class="mt-4 sm:mt-6 md:mt-8 lg:mt-10 text-sm sm:text-base text-gray-500">{{ item.text }}</p>
            </div>
        </div>

        <div class="hidden lg:block w-[4px] bg-gray-200"></div>

        <div class="w-full lg:w-1/2 space-y-8 sm:space-y-12 md:space-y-16 lg:space-y-20 xl:space-y-24 p-3 sm:p-6 md:p-10 lg:p-16 xl:p-20">
            <div v-for="(item, index) in secondColumn" :key="'second-' + index" class="text-center">
                <img
                    :src="item.image_url"
                    :alt="item.text"
                    class="w-full rounded-lg shadow-2xl cursor-pointer hover:opacity-80 transition"
                    @click="openPreview(index * 2 + 1)"
                />
                <p class="mt-2 sm:mt-3 md:mt-4 lg:mt-6 text-sm sm:text-base text-gray-500">{{ item.text }}</p>
            </div>
        </div>
    </div>

    <!-- Image preview modal -->
    <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-2 sm:p-4">
        <div class="relative w-full max-w-xs sm:max-w-sm md:max-w-lg lg:max-w-2xl xl:max-w-4xl">
            <button @click="closePreview" class="absolute top-2 right-2 sm:top-3 sm:right-3 md:top-5 md:right-5 lg:right-10 text-white text-xl sm:text-2xl md:text-3xl z-10">&times;</button>

            <img :src="selectedImage" class="w-full h-auto max-h-[85vh] sm:max-h-[90vh] object-contain rounded-lg shadow-lg"/>

            <button
                v-if="currentIndex > 0"
                @click="prevImage"
                class="absolute left-2 sm:left-3 md:left-5 lg:left-7 top-1/2 transform -translate-y-1/2 text-white text-lg sm:text-xl md:text-2xl lg:text-3xl bg-gray-700 bg-opacity-50 p-1 sm:p-1.5 md:p-2 rounded-full hover:bg-opacity-75">
                &#10094;
            </button>
            <button
                v-if="currentIndex < mediaItems.length - 1"
                @click="nextImage"
                class="absolute right-2 sm:right-3 md:right-5 lg:right-7 top-1/2 transform -translate-y-1/2 text-white text-lg sm:text-xl md:text-2xl lg:text-3xl bg-gray-700 bg-opacity-50 p-1 sm:p-1.5 md:p-2 rounded-full hover:bg-opacity-75">
                &#10095;
            </button>
        </div>
    </div>
</template>
