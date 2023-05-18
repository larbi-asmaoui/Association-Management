<template>
    <div class="flex h-screen bg-gray-200 font-roboto">
        <Sidebar />

        <div class="flex-1 flex flex-col overflow-hidden">
            <Header />

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="w-full mx-auto px-6 py-6">
                    <slot />
                </div>
            </main>
            <!-- <Footer /> -->
        </div>
    </div>
</template>

<script setup>
import Sidebar from "../Components/Sidebar.vue";
import Header from "../Components/Header.vue";
import Footer from "../Components/Footer.vue";
</script>
