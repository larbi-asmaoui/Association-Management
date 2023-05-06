<template>
    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h3 class="mb-4 text-gray-700 text-3xl font-medium">
                Groupe #{{ groupe.id }}
            </h3>

            <p class="mb-2">Nom de groupe : {{ groupe.name }}</p>
            <p>Description : {{ groupe.description }}</p>
        </div>
        <!-- <div class="flex"></div> -->
        <div
            class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md"
        >
            <!-- <div class="mr-3">
                <div class="text-sm text-gray-600" style="display: none">
                    Saved.
                </div>
            </div> -->
            <button
                @click="destroy(groupe.id)"
                type="button"
                class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="icon icon-tabler icon-tabler-trash"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="#fff"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <line x1="4" y1="7" x2="20" y2="7" />
                    <line x1="10" y1="11" x2="10" y2="17" />
                    <line x1="14" y1="11" x2="14" y2="17" />
                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                </svg>
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
    groupe: {
        type: Object,
    },
});

const destroy = (id) => {
    if (confirm("Are you sure?")) {
        form.delete(route("groupes.destroy", id));
    }
};
</script>
