<template>
  <div class="flex h-screen bg-gray-200 font-roboto">
    <Sidebar />

    <div class="flex-1 flex flex-col overflow-hidden">
      <Header />

      <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
        <div class="container mx-auto px-6 py-8">
          <slot />
        </div>
      </main>
      <!-- <Footer /> -->
      <footer
        class="sticky top-[100vh] dark:border-gray-800 text-gray-500 bg-white"
      >
        <div
          class="flex items-center justify-center sm:justify-center max-w-7xl mx-auto p-4 sm:px-6 lg:px-8"
        >
          <p class="text-center">
            Copyright ©️ {{ new Date().getFullYear() }}
            <a href="#" target="_blank" class="font-bold text-primary"
              >Access Point</a
            >
          </p>
        </div>
      </footer>
    </div>
  </div>
</template>

<script setup>
import Sidebar from "../Components/Sidebar.vue";
import Header from "../Components/Header.vue";
import Footer from "../Components/Header.vue";
</script>
