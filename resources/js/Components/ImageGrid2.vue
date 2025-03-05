<script setup>
import { ref, watch, computed, onMounted, onUnmounted } from "vue";

const props = defineProps({
    items: {
        type: Array,
        required: true,
    },
});

const mediaItems = ref([...props.items]);

watch(
    () => props.items,
    (newItems) => {
        mediaItems.value = [...newItems];
    },
    { deep: true }
);

const firstFive = computed(() => mediaItems.value.slice(0, 10));
const nextFive = computed(() => mediaItems.value.slice(10, 20));

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
    <div class="flex w-full px-5 gap-5 mt-10">
        <div class="w-1/2 space-y-24 p-20">
            <div v-for="(item, index) in firstFive" :key="index" class="text-center">
                <img
                    :src="item.image_url"
                    :alt="item.text"
                    class="w-full rounded-lg shadow-2xl cursor-pointer hover:opacity-80 transition"
                    @click="openPreview(index)"
                />
                <p class="mt-10 text-gray-500">{{ item.text }}</p>
            </div>
        </div>

        <div class="w-[4px] bg-gray-200"></div>

        <div class="w-1/2 space-y-24 p-20">
            <div v-for="(item, index) in nextFive" :key="index" class="text-center">
                <img
                    :src="item.image_url"
                    :alt="item.text"
                    class="w-full rounded-lg shadow-2xl cursor-pointer hover:opacity-80 transition"
                    @click="openPreview(index + 10)"
                />
                <p class="mt-2 text-gray-500">{{ item.text }}</p>
            </div>
        </div>
    </div>

    <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50">
        <div class="relative p-5 w-full max-w-2xl">
            <button @click="closePreview" class="absolute top-5 right-10 text-white text-3xl">&times;</button>

            <img :src="selectedImage" class="w-full max-h-[80vh] rounded-lg shadow-lg" />

            <button
                v-if="currentIndex > 0"
                @click="prevImage"
                class="absolute left-7 top-1/2 transform -translate-y-1/2 text-white text-3xl bg-gray-700 bg-opacity-50 p-2 rounded-full hover:bg-opacity-75">
                &#10094;
            </button>
            <button
                v-if="currentIndex < mediaItems.length - 1"
                @click="nextImage"
                class="absolute right-7 top-1/2 transform -translate-y-1/2 text-white text-3xl bg-gray-700 bg-opacity-50 p-2 rounded-full hover:bg-opacity-75">
                &#10095;
            </button>
        </div>
    </div>
</template>
