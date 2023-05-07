<template>
    <h3 class="text-gray-700 text-3xl font-medium">Gestion Groupes</h3>
    <!------------------  -->
    <!-- <CustomModal title="Ajouter Groupe" /> -->
    <!-- ------------------------- -->
    <div class="mt-4">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-2 py-4 flex justify-between content-center">
                    <input
                        type="text"
                        v-model="search"
                        placeholder="Search..."
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5"
                    />
                    <CustomModal
                        :open="isOpen"
                        title="Ajouter Groupe"
                        actionText="Ajouter"
                    >
                        <form @submit.prevent="submit">
                            <!-- Grid -->
                            <div class="grid grid-cols-12 gap-4 sm:gap-6">
                                <div class="col-span-3">
                                    <label
                                        id="groupe-name"
                                        class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200"
                                    >
                                        Nom de groupe
                                    </label>
                                </div>
                                <!-- End Col -->

                                <div class="col-span-9">
                                    <input
                                        id="groupe-name"
                                        v-model="form.name"
                                        type="text"
                                        class="py-2 px-3 pr-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                                        placeholder="titre de groupe"
                                    />
                                </div>
                                <!-- End Col -->

                                <div class="col-span-3">
                                    <label
                                        for="description"
                                        class="inline-block text-sm text-gray-800 mt-2.5 dark:text-gray-200"
                                    >
                                        Description
                                    </label>
                                </div>
                                <!-- End Col -->

                                <div class="col-span-9">
                                    <textarea
                                        id="description"
                                        v-model="form.description"
                                        class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                                        rows="6"
                                        placeholder="Description de groupe..."
                                    ></textarea>
                                </div>

                                <!-- End Col -->
                            </div>
                            <!-- End Grid -->

                            <div class="mt-5 flex justify-end gap-x-2">
                                <button
                                    @click="closeModal"
                                    type="button"
                                    class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800"
                                >
                                    Annuler
                                </button>
                                <button
                                    :disabled="form.processing"
                                    type="submit"
                                    class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800"
                                >
                                    Enregistrer
                                </button>
                            </div>
                        </form>
                    </CustomModal>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table
                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">#</th>
                                <th scope="col" class="px-6 py-3">Groupe</th>
                                <th scope="col" class="px-6 py-3">
                                    Description
                                </th>
                                <th scope="col" class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="groupe in groupes.data" :key="groupe.id">
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium whitespace-nowrap"
                                >
                                    {{ groupe.id }}
                                </th>
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium whitespace-nowrap"
                                >
                                    {{ groupe.name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ groupe.description }}
                                </td>
                                <td class="px-6 py-4">
                                    <div
                                        class="flex item-center justify-center"
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
import { router } from "@inertiajs/vue3";
import Pagination from "../../Components/Pagination.vue";
import CustomModal from "../../Components/CustomModal.vue";

import { useForm } from "@inertiajs/vue3";
let isOpen = ref(false);
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

const closeModal = () => {
    isOpen.value = false;

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
