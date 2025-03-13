<script setup>
import {computed} from "vue";

const bgImg = computed(() => ({
    backgroundRepeat:"no-repeat",
    backgroundSize:"cover",
    backgroundAttachment:"fixed",
    backgroundPosition:"center",
}));
</script>

<template>
    <div class="landing w-full" :style="bgImg">
    </div>
</template>

<style scoped>
.landing{
    height: 80vh;
    background-image: url("https://i.ibb.co/txpgF0T/IMG-1304.jpg");
}
</style>
