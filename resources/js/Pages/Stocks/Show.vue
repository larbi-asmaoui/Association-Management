<template>
    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6">
            <div
                class="flex items-center space-x-2 font-semibold text-gray-900 leading-8"
            >
                <span clas="text-green-500">
                    <svg
                        class="h-5"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"
                        />
                    </svg>
                </span>
                <span class="tracking-wide">Informations du stock</span>
            </div>
            <div class="text-gray-700">
                <div class="grid md:grid-cols-2 text-sm">
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">Nom de stock:</div>
                        <div class="px-4 py-2">{{ stock.name }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">Prix unitaire</div>
                        <div class="px-4 py-2">{{ stock.pricePerUnit }} DH</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">
                            Type de stock:
                        </div>
                        <div class="px-4 py-2">{{ stock.type }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">Quantité</div>
                        <div class="px-4 py-2">{{ stock.quantity }}</div>
                    </div>
                    <div class="grid grid-cols-2">
                        <div class="px-4 py-2 font-semibold">Date d'achat</div>
                        <div class="px-4 py-2">
                            {{ stock.purchaseDate }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md"
        >
            <div class="mr-3">
                <div class="text-sm text-gray-600" style="display: none">
                    Saved.
                </div>
            </div>
            <button
                @click="destroy(stock.id)"
                type="button"
                class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800"
            >
                Supprimer
            </button>
        </div>
    </div>
</template>

<script>
import RootLayout from "../../Layouts/RootLayout.vue";

export default {
    layout: RootLayout,
};
</script>

<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({});

const props = defineProps({
    stock: {
        type: Object,
    },
});

const destroy = (id) => {
    if (confirm("Are you sure?")) {
        form.delete(route("stocks.destroy", id));
    }
};
</script>
