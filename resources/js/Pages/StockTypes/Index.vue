<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
};
</script>

<template>
    <div class="mb-4">
        <h1
            class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"
        >
            Type de stocks
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
                    class="bg-white-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="rechercher types..."
                />
            </div>
        </div>
        <button
            @click="isModalOpen = true"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
            type="button"
        >
            Ajouter Type de stock
        </button>
    </div>

    <teleport to="body">
        <Modal size="xl" v-if="isModalOpen" @close="closeModal">
            <template #header>
                <div class="flex items-center text-lg">
                    Ajouter un type de stock
                </div>
            </template>
            <template #body>
                <form
                    class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2"
                    @submit.prevent="submit"
                >
                    <div class="grid grid-cols-1 gap-4 lg:gap-6">
                        <div>
                            <label
                                for="name"
                                class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                >Nom du type de stock
                            </label>
                            <input
                                v-model="form.name"
                                type="text"
                                name="name"
                                id="name"
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
                </form></template
            ></Modal
        ></teleport
    >
    <!-- Your other content here -->
    <div class="mt-4">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="bg-white border-b border-gray-200">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table
                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                    >
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    #
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Type de stock
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Date d'ajout
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-right"
                                ></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr
                                v-for="(stockType, index) in stockTypes.data"
                                :key="stockType.id"
                            >
                                <td
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    {{ index + 1 }}
                                </td>
                                <td
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    {{ stockType.name }}
                                </td>
                                <td
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    {{ stockType.created_at }}
                                </td>
                                <td
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    <div
                                        class="flex items-center justify-end space-x-2"
                                    >
                                        <!-- Edit -->
                                        <button
                                            class="text-gray-400 hover:text-purple-500 transition-colors duration-200"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
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
                                        </button>

                                        <!-- Delete -->
                                        <button
                                            @click="destroy(stockType.id)"
                                            class="text-gray-400 hover:text-purple-500 transition-colors duration-200"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
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
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :data="stockTypes" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { Modal } from "flowbite-vue";
import { ref } from "vue";
import { watch } from "vue";
import { router } from "@inertiajs/vue3";
import Pagination from "../../Components/Pagination.vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

const $toast = useToast();

const props = defineProps({
    stockTypes: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    name: null,
});

const destroy = (id) => {
    if (confirm("vous êtes sûr?")) {
        form.delete(route("stock-types.destroy", id), {
            onSuccess: () => {
                $toast.open({
                    message: "Type de stock supprimé avec succès",
                    type: "success",
                    duration: 3000,
                    dismissible: true,
                });
            },
            onError: () => {
                $toast.open({
                    message: "Une erreur s'est produite",
                    type: "error",
                    duration: 3000,
                    dismissible: true,
                });
            },
        });
    }
};

const submit = (event) => {
    event.preventDefault();

    form.post(route("stock-types.store"), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            $toast.open({
                message: "Type de stock ajouté avec succès",
                type: "success",
                duration: 3000,
                dismissible: true,
            });
        },
    });
};

let isModalOpen = ref(false);

const closeModal = () => {
    isModalOpen.value = false;

    form.reset();
};

// pass filters in search
let search = ref("");
watch(search, (value) => {
    router.get(
        "/stock-types",
        { search: value },
        {
            preserveState: true,
            replace: true,
        }
    );
});
</script>
