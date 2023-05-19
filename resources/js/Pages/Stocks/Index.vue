<template>
    <h3 class="text-gray-700 text-3xl font-medium">Liste Stock</h3>
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
                        Ajouter Stock
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
                                        Ajouter un stock
                                    </h3>
                                    <div
                                        class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6"
                                    >
                                        <div>
                                            <label
                                                for="stock_name"
                                                class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                                >Nom de stock
                                            </label>
                                            <input
                                                v-model="form.name"
                                                type="text"
                                                name="stock_name"
                                                id="stock_name"
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
                                                for="type"
                                                class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                                >Type
                                            </label>
                                            <select
                                                v-model="form.stock_type_id"
                                                id="stockTypes"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 appearance-none select-none relative z-10"
                                            >
                                                <option
                                                    v-for="stockType in stockTypes"
                                                    :key="stockType.id"
                                                    :value="stockType.id"
                                                    class="bg-white dark:bg-gray-800 py-2.5 px-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700"
                                                >
                                                    {{ stockType.name }}
                                                </option>
                                            </select>
                                            <span
                                                v-if="form.errors.stock_type_id"
                                                class="text-xs text-red-600 mt-1"
                                                id="hs-validation-name-error-helper"
                                            >
                                                {{ form.errors.stock_type_id }}
                                            </span>
                                        </div>
                                    </div>

                                    <div>
                                        <div>
                                            <label
                                                for="dpurchase_date"
                                                class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                                >Date d'achat
                                            </label>

                                            <input
                                                v-model="form.purchase_date"
                                                type="date"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                                placeholder="Select date"
                                                name="purchase_date"
                                            />
                                            <span
                                                v-if="form.errors.purchase_date"
                                                class="text-xs text-red-600 mt-1"
                                                id="hs-validation-name-error-helper"
                                            >
                                                {{ form.errors.purchase_date }}
                                            </span>
                                        </div>
                                    </div>

                                    <div
                                        class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6"
                                    >
                                        <div>
                                            <label
                                                for="quantity"
                                                class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                                >Quantité
                                            </label>
                                            <input
                                                v-model="form.quantity"
                                                min="1"
                                                type="number"
                                                name="quantity"
                                                id="quantity"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                            />
                                            <span
                                                v-if="form.errors.quantity"
                                                class="text-xs text-red-600 mt-1"
                                                id="hs-validation-name-error-helper"
                                            >
                                                {{ form.errors.quantity }}
                                            </span>
                                        </div>

                                        <div>
                                            <label
                                                for=" price_per_unit"
                                                class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                                >Prix unitaire d'achat
                                            </label>
                                            <input
                                                v-model="form.price_per_unit"
                                                min="1"
                                                type="number"
                                                name=" price_per_unit"
                                                id=" price_per_unit"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                            />
                                            <span
                                                v-if="
                                                    form.errors.price_per_unit
                                                "
                                                class="text-xs text-red-600 mt-1"
                                                id="hs-validation-name-error-helper"
                                            >
                                                {{ form.errors.price_per_unit }}
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
                                <th scope="col" class="px-6 py-3">Stock</th>
                                <th scope="col" class="px-6 py-3">Type</th>
                                <th scope="col" class="px-6 py-3">Quantité</th>
                                <th scope="col" class="px-6 py-3">
                                    Prix unitaire (DH)
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Date d'achat
                                </th>
                                <th scope="col" class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="stock in stocks.data" :key="stock.id">
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium whitespace-nowrap"
                                >
                                    {{ stock.id }}
                                </th>
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium whitespace-nowrap"
                                >
                                    {{ stock.name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ stock.stockType.name }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ stock.quantity }}
                                </td>

                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium whitespace-nowrap"
                                >
                                    {{ stock.price_per_unit }}
                                </th>
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium whitespace-nowrap"
                                >
                                    {{ stock.purchase_date }}
                                </th>
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium whitespace-nowrap"
                                >
                                    <div
                                        class="flex item-center justify-center"
                                    >
                                        <!-- Eye -->
                                        <div
                                            @click="show(stock.id)"
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
                                            @click="destroy(stock.id)"
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
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :data="stocks" />
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
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import Pagination from "../../Components/Pagination.vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

const $toast = useToast();

const form = useForm({
    name: "",
    quantity: "",
    price_per_unit: "",
    purchase_date: null,
    stock_type_id: null,
});

let isModalOpen = ref(false);

const closeModal = () => {
    isModalOpen.value = false;

    form.reset();
};

const destroy = (id) => {
    if (confirm("Are you sure?")) {
        form.delete(route("stocks.destroy", id), {
            onSuccess: () => {
                $toast.open({
                    message: "Stock supprimé avec succès",
                    type: "success",
                    duration: 3000,
                    dismissible: true,
                });
            },
            onError: () => {
                $toast.open({
                    message: "Erreur lors de la suppression",
                    type: "error",
                    duration: 3000,
                    dismissible: true,
                });
            },
        });
    }
};

const show = (id) => {
    form.get(route("stocks.show", id));
};
const props = defineProps({
    stocks: {
        type: Object,
        default: () => ({}),
    },
    stockTypes: {
        type: Object,
        default: () => ({}),
    },
});

const submit = () => {
    form.post(route("stocks.store"), {
        onSuccess: () => {
            closeModal();
            $toast.open({
                message: "Stock ajouté avec succès",
                type: "success",
                duration: 3000,
                dismissible: true,
            });
        },
        onError: () => {
            $toast.open({
                message: "Erreur lors de l'ajout",
                type: "error",
                duration: 3000,
                dismissible: true,
            });
        },
    });
};

let search = ref("");
watch(search, (value) => {
    router.get(
        "/stocks",
        { search: value },
        {
            preserveState: true,
            replace: true,
        }
    );
});
</script>
