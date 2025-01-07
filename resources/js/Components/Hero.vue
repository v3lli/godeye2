<script setup>
import {computed} from "vue";

defineProps({
    imgUrl:{
        type: String,
        required: true
    },
});


// const bgImg = computed(() => ({
//     backgroundImage: `url(${imgUrl})`,
//     backgroundRepeat:"no-repeat",
//     backgroundSize:"cover",
//     backgroundAttachment:"fixed",
//     backgroundPosition:"center",
// }));
</script>

<template>
    <div v-bind:style="{
        backgroundImage: imgUrl,
        backgroundColor:'black',
    }" class="landing w-full">
    </div>
</template>

<style scoped>
.landing{
    height: 100vh;
    width: 100%;
}
</style>
