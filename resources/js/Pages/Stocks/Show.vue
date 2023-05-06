<template>
    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="text-gray-700 text-3xl font-medium">
                Stock #{{ stock.id }}
            </h3>
            <p>Nom de stock: {{ stock.name }}</p>
            <p>Type de stock: {{ stock.type }}</p>
            <p>Prix unitaire : {{ stock.pricePerUnit }}</p>
            <p>Quantité : {{ stock.quantity }}</p>
            <p>Date d'achat : {{ stock.purchaseDate }}</p>
        </div>
        <!-- <div class="flex"></div> -->
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
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
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
