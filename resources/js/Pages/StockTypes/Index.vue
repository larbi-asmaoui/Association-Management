<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
};
</script>

<template>
    <h3 class="text-gray-700 text-3xl font-medium">Type de stocks</h3>
    <!-- Your other content here -->
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
                    <button
                        @click="isModalOpen = true"
                        class="px-6 py-3 font-medium tracking-wide text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none"
                    >
                        Ajouter Type de stock
                    </button>

                    <!-- Main -->
                    <div
                        v-if="isModalOpen"
                        id="authentication-modal"
                        class="overflow-x-hidden overflow-y-auto fixed h-modal md:h-full top-4 mt-4 left-0 right-0 md:inset-0 z-50 flex justify-center items-start"
                    >
                        <!-- Backdrop -->
                        <div
                            @click="isModalOpen = false"
                            class="fixed inset-0 bg-black opacity-50"
                        ></div>
                        <div
                            class="relative w-full max-w-md px-4 h-full md:h-auto"
                        >
                            <!-- Modal content -->
                            <div
                                class="bg-white rounded-lg shadow relative dark:bg-gray-700"
                            >
                                <div class="flex justify-end p-2">
                                    <button
                                        @click="isModalOpen = false"
                                        type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                        data-modal-toggle="authentication-modal"
                                    >
                                        <svg
                                            class="w-5 h-5"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            ></path>
                                        </svg>
                                    </button>
                                </div>
                                <form
                                    class="space-y-6 px-6 lg:px-6 pb-4 sm:pb-6 xl:pb-8"
                                    @submit.prevent="submit"
                                >
                                    <h3
                                        class="text-xl font-medium text-gray-900 dark:text-white"
                                    >
                                        Ajouter un type de stock
                                    </h3>

                                    <div
                                        class="grid grid-cols-1 gap-4 lg:gap-6"
                                    >
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
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End -->
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
                                <th scope="col" class="px-6 py-3">
                                    Type de stock
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Date d'ajout
                                </th>
                                <th scope="col" class="px-6 py-3 text-right">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="stockType in stockTypes.data"
                                :key="stockType.id"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                            >
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    {{ stockType.id }}
                                </th>
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    {{ stockType.name }}
                                </th>
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    {{ stockType.created_at }}
                                </th>
                                <th
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
                                </th>
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
