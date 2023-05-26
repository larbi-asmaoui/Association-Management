<template>
    <button
        @click="isModalOpen = true"
        class="rounded-full fixed z-50 bottom-8 right-5 text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium text-sm p-5 focus:outline-none"
        type="button"
    >
        <svg
            class="w-5 h-5"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                fill-rule="evenodd"
                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                clip-rule="evenodd"
            ></path>
        </svg>
    </button>
    <div class="mb-4 bg-blue-600 px-4 py-4 shadow-md">
        <h1 class="text-xl font-semibold text-white sm:text-2xl">
            Gestion Événements
        </h1>
    </div>
    <div class="bg-white px-4 py-6 shadow-md">
        <div
            class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
        >
            <div class="flex items-center mb-4 sm:mb-0">
                <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                    <input
                        type="text"
                        v-model="search"
                        class="bg-slate-200 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="rechercher Événements..."
                    />
                </div>
            </div>
        </div>

        <teleport to="body">
            <Modal size="xl" v-if="isModalOpen" @close="closeModal">
                <template #header>
                    <div class="flex items-center text-lg">
                        Ajouter un Événement {{ reference.value }}
                    </div>
                </template>
                <template #body>
                    <form
                        class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2 overflow-y-auto max-h-[30rem]"
                        @submit.prevent="submit"
                    >
                        <div>
                            <label
                                for="title"
                                class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                >Titre de l'Événement</label
                            >
                            <input
                                v-model="form.title"
                                type="text"
                                name="title"
                                id="title"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                required
                            />
                            <span
                                v-if="form.errors.title"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.title }}
                            </span>
                        </div>
                        <div>
                            <label
                                for="start"
                                class="block text-sm text-gray-700 font-medium dark:text-white"
                                >Date de début
                            </label>

                            <input
                                :min="new Date().toISOString().split('T')[0]"
                                v-model="form.start"
                                lang="fr-FR"
                                type="date"
                                class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                                placeholder="Select date"
                                name="start"
                            />
                            <span
                                v-if="form.errors.start"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.start }}
                            </span>
                        </div>
                        <!--  -->
                        <div>
                            <label
                                for="end"
                                class="block text-sm text-gray-700 font-medium dark:text-white"
                                >Date de Fin
                            </label>

                            <input
                                lang="fr-CA"
                                :min="new Date().toISOString().split('T')[0]"
                                v-model="form.end"
                                type="date"
                                class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                                placeholder="Select date"
                                name="end"
                            />
                            <span
                                v-if="form.errors.end"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.end }}
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
                                rows="3"
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
                        <div>
                            <label
                                for="type"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >Type
                            </label>
                            <select
                                v-model="form.evenement_type_id"
                                id="evenment_type_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-blue-500 :focus:border-blue-500 appearance-none select-none relative z-10"
                            >
                                <option
                                    v-for="evenementType in evenementTypes"
                                    :key="evenementType.id"
                                    :value="evenementType.id"
                                    class="bg-white :bg-gray-800 py-2.5 px-4 cursor-pointer hover:bg-gray-200 :hover:bg-gray-700"
                                >
                                    {{ evenementType.name }}
                                </option>
                            </select>
                            <span
                                v-if="form.errors.evenement_type_id"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.evenement_type_id }}
                            </span>
                        </div>

                        <div>
                            <label
                                for="location"
                                class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                >Lieu de l'événement</label
                            >
                            <input
                                v-model="form.location"
                                type="text"
                                name="location"
                                id="location"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                required
                            />
                            <span
                                v-if="form.errors.location"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.location }}
                            </span>
                        </div>
                        <div>
                            <label
                                for="type"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Région</label
                            >
                            <select
                                v-model="form.region"
                                id="type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            >
                                <option disabled value="">
                                    Séléctionner région
                                </option>
                                <option
                                    v-for="region in regions"
                                    @change="filterCities"
                                    :key="region.id"
                                    :value="region.name"
                                >
                                    {{ region.name }}
                                </option>
                            </select>
                            <span
                                v-if="form.errors.region"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.region }}
                            </span>
                        </div>
                        <div>
                            <label
                                for="type"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Ville</label
                            >
                            <select
                                v-model="form.city"
                                id="type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            >
                                <option disabled value="">
                                    Séléctionner ville
                                </option>
                                <option
                                    v-for="city in filteredCities"
                                    key="city.id"
                                    :value="city"
                                >
                                    {{ city }}
                                </option>
                            </select>
                            <span
                                v-if="form.errors.city"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.city }}
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
            <div class="overflow-hidden bg-white shadow-sm">
                <div class="bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto shadow-md">
                        <table
                            class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                        >
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th
                                        scope="col"
                                        class="border border-slate-400 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Événement
                                    </th>
                                    <th
                                        scope="col"
                                        class="border border-slate-400 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Date début
                                    </th>
                                    <th
                                        scope="col"
                                        class="border border-slate-400 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Date fin
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
                                    v-for="evenement in evenements.data"
                                    :key="evenement.id"
                                >
                                    <td
                                        class="border border-slate-400 px-6 py-3 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        {{ evenement.reference }}
                                    </td>
                                    <td
                                        class="border border-slate-400 px-6 py-3 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        {{ evenement.start }}
                                    </td>
                                    <td
                                        class="border border-slate-400 px-6 py-3 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        {{ evenement.end }}
                                    </td>

                                    <td
                                        class="border border-slate-400 px-6 py-3 whitespace-nowrap text-right text-sm font-medium"
                                    >
                                        <div class="flex space-x-2">
                                            <!-- Eye -->
                                            <button
                                                @click="show(evenement.id)"
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
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                    ></path>
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                    ></path>
                                                </svg>
                                            </button>

                                            <!-- Delete -->
                                            <button
                                                @click="destroy(evenement.id)"
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

                                            <!-- Print -->
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
                                                        stroke="none"
                                                        d="M0 0h24v24H0z"
                                                        fill="none"
                                                    />
                                                    <path
                                                        d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"
                                                    />
                                                    <path
                                                        d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"
                                                    />
                                                    <rect
                                                        x="7"
                                                        y="13"
                                                        width="10"
                                                        height="8"
                                                        rx="2"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
import { ref, computed, reactive, watchEffect } from "vue";
import { Modal } from "flowbite-vue";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

import regionsFile from "../../regions.json";

const $toast = useToast();

const props = defineProps({
    evenements: {
        type: Object,
        default: () => ({}),
    },
    groupes: {
        type: Object,
        default: () => ({}),
    },
    lastEvenement: {
        type: Object,
        default: () => ({}),
    },
    evenementTypes: {
        type: Object,
        default: () => ({}),
    },
});

const incrementPart = computed(() => {
    // Get the increment part of the last event's reference
    const lastIncrementPart =
        props.lastEvenement && props.lastEvenement.reference
            ? parseInt(props.lastEvenement.reference.split("-")[1])
            : 0;
    return lastIncrementPart + 1;
});

const reference = reactive({
    value: null,
});

watchEffect(() => {
    const currentYear = new Date().getFullYear();
    const nextYear = currentYear + 1;
    reference.value = `${currentYear}/${nextYear}-${incrementPart.value}`;
});

const regions = ref(regionsFile);

const filteredCities = computed(() => {
    if (form.region) {
        const regionData = regions.value.find(
            (region) => region.name === form.region
        );
        if (regionData) {
            return regionData.cities_list;
        }
    }
    return [];
});

const filterCities = () => {
    form.city = "";
};

const form = useForm({
    id: "",
    title: "",
    description: "",
    start: "",
    end: "",
    location: "",
    region: "",
    city: "",
    evenement_type_id: "",
});

const submit = () => {
    form.post(route("evenements.store"), {
        onError: () => {
            $toast.open({
                message: "Une erreur s'est produite",
                type: "error",
                dismissible: true,
                duration: 3000,
            });
        },
        onSuccess: () => {
            closeModal();
            $toast.open({
                message: "Événement ajouté avec succès",
                type: "success",
                dismissible: true,
                duration: 3000,
            });
            // form.reset("title", "description", "start", "end", "location");
            // page.value.$inertia.$refresh(); // This will refresh the page
        },
    });
};

const isModalOpen = ref(false);
const isDropdownOpen = ref(false);

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

const closeModal = () => {
    form.reset("title", "description", "start", "end", "location");
    isModalOpen.value = false;
};

const destroy = (id) => {
    if (confirm("Êtes-vous sûr de vouloir supprimer cet Événement ?")) {
        form.delete(route("evenements.destroy", id), {
            onError: () => {
                $toast.open({
                    message: "Une erreur s'est produite",
                    type: "error",
                    dismissible: true,
                    duration: 3000,
                });
            },
            onSuccess: () => {
                $toast.open({
                    message: "Événement supprimé avec succès",
                    type: "success",
                    dismissible: true,
                    duration: 3000,
                });
                // page.value.$inertia.$refresh(); // This will refresh the page
            },
        });
    }
};

const show = (id) => {
    form.get(route("evenements.edit", id));
};
</script>
