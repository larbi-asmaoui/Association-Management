<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
};
</script>

<script setup>
import { Dropdown, ListGroup, ListGroupItem } from "flowbite-vue";
import { Sidebar } from "flowbite-vue";
</script>
<template>
    <div class="bg-white px-4 py-6 shadow-md rounded-lg">
        <div class="mb-4">
            <h1
                class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"
            >
                Revenues
            </h1>
        </div>
        <div
            class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
        >
            <div class="flex items-center mb-4 sm:mb-0">
                <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                    <input
                        type="text"
                        v-model="search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="rechercher..."
                    />
                </div>
            </div>
            <button
                @click="isModalOpen = true"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                type="button"
            >
                Ajouter Revenue
            </button>
        </div>
        <div class="mt-4">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg"></div>
        </div>
    </div>
</template>
