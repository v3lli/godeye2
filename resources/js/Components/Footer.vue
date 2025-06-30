<template>
    <footer class=" mx-auto px-3 sm:px-4 py-8 sm:py-10 text-center body">
      <!-- Mailing List Section -->
      <div class="mb-8 sm:mb-10 md:mb-12">
<!--        <h2 class="text-2xl font-normal mb-6">JOIN OUR MAILING LIST</h2>-->

<!--        <div class="flex justify-center max-w-xl mx-auto mb-5">-->
<!--          <input -->
<!--            type="email" -->
<!--            v-model="email" -->
<!--            placeholder="Email" -->
<!--            class="flex-grow border border-gray-300 px-4 py-3 text-base"-->
<!--          />-->
<!--          <button -->
<!--            @click="subscribe" -->
<!--            class="bg-white border border-gray-300 px-8 py-3 text-base uppercase hover:bg-gray-50"-->
<!--          >-->
<!--            SUBSCRIBE-->
<!--          </button>-->
<!--        </div>-->

        <p class="text-xs sm:text-sm mb-6 sm:mb-8 md:mb-10">
<!--          By signing up to receive emails, you agree to our-->
          <a href="/privacy" class="underline hover:no-underline transition-all">privacy policy.</a>
        </p>
      </div>

      <!-- Navigation Links -->
      <nav class="mb-10 sm:mb-12 md:mb-16 w-100">
        <ul class="flex flex-wrap justify-center gap-x-4 sm:gap-x-6 gap-y-2">
          <li><a href="/" class="text-sm sm:text-base hover:underline focus:underline transition-all">home</a></li>
          <li><a href="/about" class="text-sm sm:text-base hover:underline focus:underline transition-all">about</a></li>
          <li><a href="/albums" class="text-sm sm:text-base hover:underline focus:underline transition-all">collections</a></li>
        </ul>
      </nav>

      <!-- Copyright Section -->
      <div>
        <p class="text-base sm:text-lg">© EMEKA ONYEJESI</p>
      </div>
    </footer>
  </template>

  <script setup>
  import { ref } from 'vue';

  // State
  const email = ref('');

  // Methods
  const subscribe = () => {
    if (email.value) {
      // Add your subscription logic here
      console.log('Subscribing email:', email.value);
      // Reset the field after subscription
      email.value = '';
      // You might want to add success/error handling here
    }
  };
  </script>

<style scoped>
.body{
    width: 100%;
    background-color: transparent;
    color: grey;
    mix-blend-mode: difference;
}
</style>
