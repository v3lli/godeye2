<script setup>
import { Head } from '@inertiajs/vue3';
import FillScrNav from "@/Components/FillScrNav.vue";
import Footer from '@/Components/Footer.vue';
import JournalBanner from "@/Components/JournalBanner.vue";

const props = defineProps({
    post: Object
});
</script>

<template>
    <Head :title="post.title" />
    <FillScrNav />
    <JournalBanner background-style=""/>
    
    <div class="items-center justify-center flex flex-col">
        <span class="my-b mt-10 uppercase text-xl text-gray-500">Journal</span>
        
        <div class="max-w-6xl mx-auto px-4 py-8">
            <!-- Post Content Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
                <!-- Hero Banner -->
                <div class="relative h-80 overflow-hidden">
                    <img :src="post.cover_image" :alt="post.title" class="w-full h-full object-cover">
                </div>
                
                <div class="p-8">
                    <!-- Header -->
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ post.title }}</h1>
                        <div class="text-sm text-gray-500 mt-2">
                            {{ new Date(post.created_at).toLocaleDateString('en-US', { 
                                year: 'numeric', 
                                month: 'long', 
                                day: 'numeric' 
                            }) }}
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="prose prose-lg max-w-none" v-html="post.text"></div>
                    </div>
                </div>
            </div>
            
            <!-- Back Button -->
            <div class="flex justify-center mt-8">
                <a href="/journal" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                    Back to Journal
                </a>
            </div>
        </div>
    </div>
    
    <Footer />
</template>

<style>
/* Additional styling for the content */
.prose img {
    border-radius: 0.5rem;
    margin: 2rem auto;
}

.prose h2 {
    margin-top: 2rem;
    color: #4B5563;
}

.prose p {
    margin-bottom: 1.5rem;
    line-height: 1.8;
}
</style> 