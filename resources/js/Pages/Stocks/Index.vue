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
                    <CustomModal
                        :open="isOpen"
                        title="Ajouter stock"
                        actionText="Ajouter"
                    >
                        <form @submit.prevent="submit">
                            <div class="mt-4 grid gap-4 lg:gap-6">
                                <!-- Grid -->
                                <div
                                    class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6"
                                >
                                    <div>
                                        <label
                                            for="stock_name"
                                            class="block text-sm text-gray-700 font-medium dark:text-white"
                                            >Nom de stock
                                        </label>
                                        <input
                                            v-model="form.name"
                                            type="text"
                                            name="stock_name"
                                            id="stock_name"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
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
                                            class="block text-sm text-gray-700 font-medium dark:text-white"
                                            >Type
                                        </label>
                                        <input
                                            v-model="form.type"
                                            type="text"
                                            name="type"
                                            id="type"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                                        />
                                        <span
                                            v-if="form.errors.type"
                                            class="text-xs text-red-600 mt-1"
                                            id="hs-validation-name-error-helper"
                                        >
                                            {{ form.errors.type }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <div>
                                        <label
                                            for="dpurchase_date"
                                            class="block text-sm text-gray-700 font-medium dark:text-white"
                                            >Date d'achat
                                        </label>

                                        <input
                                            v-model="form.purchaseDate"
                                            type="date"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                                            placeholder="Select date"
                                            name="purchase_date"
                                        />
                                        <span
                                            v-if="form.errors.purchaseDate"
                                            class="text-xs text-red-600 mt-1"
                                            id="hs-validation-name-error-helper"
                                        >
                                            {{ form.errors.purchaseDate }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 grid gap-4 lg:gap-6">
                                <!-- Grid -->
                                <div
                                    class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6"
                                >
                                    <div>
                                        <label
                                            for="quantity"
                                            class="block text-sm text-gray-700 font-medium dark:text-white"
                                            >Quantité
                                        </label>
                                        <input
                                            v-model="form.quantity"
                                            min="1"
                                            type="number"
                                            name="quantity"
                                            id="quantity"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
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
                                            for="pricePerUnit"
                                            class="block text-sm text-gray-700 font-medium dark:text-white"
                                            >Prix unitaire d'achat
                                        </label>
                                        <input
                                            v-model="form.pricePerUnit"
                                            type="text"
                                            name="pricePerUnit"
                                            id="pricePerUnit"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                                        />
                                        <span
                                            v-if="form.errors.pricePerUnit"
                                            class="text-xs text-red-600 mt-1"
                                            id="hs-validation-name-error-helper"
                                        >
                                            {{ form.errors.pricePerUnit }}
                                        </span>
                                    </div>
                                </div>
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
                                <th scope="col" class="px-6 py-3">Stock</th>
                                <th scope="col" class="px-6 py-3">Type</th>
                                <th scope="col" class="px-6 py-3">Quantité</th>
                                <th scope="col" class="px-6 py-3">
                                    Prix unitaire
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
                                    {{ stock.type }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ stock.quantity }}
                                </td>

                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium whitespace-nowrap"
                                >
                                    {{ stock.pricePerUnit }}
                                </th>
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium whitespace-nowrap"
                                >
                                    {{ stock.purchaseDate }}
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
import CustomModal from "../../Components/CustomModal.vue";
import { useForm } from "@inertiajs/vue3";
import Pagination from "../../Components/Pagination.vue";

const form = useForm({
    name: "",
    type: "",
    quantity: "",
    pricePerUnit: "",
    purchaseDate: null,
});

let isOpen = ref(false);

const closeModal = () => {
    isOpen.value = false;

    form.reset();
};

const destroy = (id) => {
    if (confirm("Are you sure?")) {
        form.delete(route("stocks.destroy", id));
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
    // filters: {
    //     type: Object,
    //     default: () => ({}),
    // },
});

const submit = () => {
    form.post(route("stocks.store"), {
        onSuccess: () => closeModal(),
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
