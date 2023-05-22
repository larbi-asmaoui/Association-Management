<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
};
</script>

<template>
    <div
        class="mb-4 bg-white px-4 py-4 rounded-md shadow-md justify-between items-center block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
    >
        <h1
            class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"
        >
            Type de revenues
        </h1>
        <button
            @click="isModalOpen = true"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
            type="button"
        >
            Ajouter un Type
        </button>
    </div>
</template>
<script setup>
import { ref } from "vue";
let isModalOpen = ref(false);

const closeModal = () => {
    isModalOpen.value = false;

    form.reset();
};
</script>
