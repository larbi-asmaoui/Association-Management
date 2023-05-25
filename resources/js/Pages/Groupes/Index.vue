<template>
    <div class="bg-white px-4 py-6 shadow-md rounded-lg">
        <div class="mb-4">
            <h1
                class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"
            >
                Gestion Groupes
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
                        placeholder="rechercher groupes..."
                    />
                </div>
            </div>
            <button
                @click="isModalOpen = true"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                type="button"
            >
                Ajouter un groupe
            </button>
        </div>

        <teleport to="body">
            <Modal size="xl" v-if="isModalOpen" @close="closeModal">
                <template #header>
                    <div class="flex items-center text-lg">
                        Ajouter un groupe
                    </div>
                </template>
                <template #body>
                    <form
                        class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2"
                        @submit.prevent="submit"
                    >
                        <div>
                            <label
                                for="title"
                                class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                >Titre du groupe</label
                            >
                            <input
                                v-model="form.name"
                                type="text"
                                name="title"
                                id="title"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            />
                            <span
                                v-if="form.errors.name"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.name }}
                            </span>
                        </div>
                        <div>
                            <label
                                for="description"
                                class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                >Description</label
                            >
                            <textarea
                                v-model="form.description"
                                rows="5"
                                name="description"
                                id="description"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            ></textarea>
                            <span
                                v-if="form.errors.description"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.description }}
                            </span>
                        </div>

                        <div class="mt-5 flex justify-end gap-x-2">
                            <button
                                @click="isModalOpen = false"
                                type="button"
                                class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800"
                            >
                                Annuler
                            </button>
                            <button
                                type="submit"
                                class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800"
                            >
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </template>
            </Modal>
        </teleport>

        <div class="mt-4">
            <div class="overflow-hidden bg-white">
                <div class="bg-white">
                    <div class="relative shadow-lg mb-5">
                        <table
                            class="w-full sm:rounded-lg text-sm text-left text-gray-500 border-collapse dark:text-gray-400"
                        >
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th
                                        scope="col"
                                        class="border border-slate-400 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        #
                                    </th>
                                    <th
                                        scope="col"
                                        class="border border-slate-400 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Groupe
                                    </th>
                                    <th
                                        scope="col"
                                        class="border border-slate-400 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Description
                                    </th>
                                    <th
                                        scope="col"
                                        class="border border-slate-400 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody
                                class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"
                            >
                                <tr
                                    v-for="groupe in groupes.data"
                                    :key="groupe.id"
                                >
                                    <td
                                        class="border border-slate-400 p-4 text-base font-medium text-gray-900 whitespace-normal dark:text-white"
                                    >
                                        {{ groupe.id }}
                                    </td>
                                    <td
                                        class="border border-slate-400 p-4 text-base font-medium text-gray-900 whitespace-normal dark:text-white"
                                    >
                                        {{ groupe.name }}
                                    </td>
                                    <td
                                        class="border border-slate-400 p-4 text-base font-medium text-gray-900 whitespace-normal dark:text-white"
                                    >
                                        {{ groupe.description }}
                                    </td>
                                    <td
                                        class="border border-slate-400 p-4 text-base font-medium text-gray-900 whitespace-normal dark:text-white"
                                    >
                                        <div
                                            class="flex items-center justify-center"
                                        >
                                            <!-- Eye -->
                                            <div
                                                @click="show(groupe.id)"
                                                class="cursor-pointer w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                    ></path>
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                    ></path>
                                                </svg>
                                            </div>

                                            <!-- Edit -->
                                            <div
                                                class="cursor-pointer w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                                    ></path>
                                                </svg>
                                            </div>

                                            <!-- Delete -->
                                            <div
                                                @click="destroy(groupe.id)"
                                                class="cursor-pointer w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                    ></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :data="groupes" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
};
</script>

<script setup>
import { ref } from "vue";
import { watch } from "vue";
import { Modal } from "flowbite-vue";
import { router } from "@inertiajs/vue3";
import Pagination from "../../Components/Pagination.vue";

import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: null,
    description: null,
});

const submit = () => {
    form.post(route("groupes.store"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
};

let isModalOpen = ref(false);

const closeModal = () => {
    isModalOpen.value = false;

    form.reset();
};

const show = (id) => {
    form.get(route("groupes.show", id));
};

const destroy = (id) => {
    if (confirm("Are you sure?")) {
        form.delete(route("groupes.destroy", id));
    }
};

const props = defineProps({
    groupes: {
        type: Object,
        default: () => ({}),
    },
    // filters: {
    //     type: Object,
    //     default: () => ({}),
    // },
});

// pass filters in search
let search = ref("");
watch(search, (value) => {
    router.get(
        "/groupes",
        { search: value },
        {
            preserveState: true,
            replace: true,
        }
    );
});
</script>
