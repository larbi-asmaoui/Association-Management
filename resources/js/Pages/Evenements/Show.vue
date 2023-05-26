<script>
import MainLayout from "../../Layouts/MainLayout.vue";
export default {
    layout: MainLayout,
};
</script>
<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { ref, computed, reactive, watchEffect } from "vue";

import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

import regionsFile from "../../regions.json";

const $toast = useToast();

const regions = ref(regionsFile);

const props = defineProps({
    evenement: {
        type: Object,
    },
    evenementTypes: {
        type: Object,
    },
});

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
    id: props.evenement.id,
    title: props.evenement.title,
    description: props.evenement.description,
    start: props.evenement.start,
    end: props.evenement.end,
    location: props.evenement.location,
    city: props.evenement.city,
    region: props.evenement.region,
    depense: props.evenement.depense,
    revenue: props.evenement.revenue,
    evenement_type_id: props.evenement.evenement_type_id,
});

const submit = () => {
    form.put(route("evenements.update", props.evenement.id), {
        onError: () => {
            $toast.open({
                message: "Une erreur s'est produite lors de la modification",
                type: "error",
                dismissible: true,
                duration: 3000,
            });
        },
        onSuccess: () => {
            $toast.open({
                message: "Événement modifié avec succès",
                type: "success",
                dismissible: true,
                duration: 3000,
            });
        },
    });
};
</script>
<template>
    <div class="inline-flex items-center mb-5">
        <Link
            :href="route('evenements.index')"
            class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="icon icon-tabler icon-tabler-arrow-left"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M5 12l14 0"></path>
                <path d="M5 12l6 6"></path>
                <path d="M5 12l6 -6"></path>
            </svg>
            &nbsp; Retour
        </Link>
    </div>

    <div class="mb-4 bg-blue-600 px-4 py-4 shadow-md">
        <h1 class="text-xl font-semibold text-white sm:text-2xl">
            Détails de l'événement: {{ evenement.reference }}
        </h1>
    </div>
    <div class="bg-white px-4 py-6 shadow-md">
        <form @submit.prevent="submit">
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                    <label
                        for="name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Libellé de l'événement</label
                    >
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="titre de l'événement"
                        v-model="form.title"
                    />
                    <span
                        v-if="form.errors.title"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.title }}
                    </span>
                </div>
                <div class="w-full">
                    <label
                        for="brand"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Date de début</label
                    >

                    <input
                        lang="fr-CA"
                        :min="new Date().toISOString().split('T')[0]"
                        v-model="form.start"
                        type="date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
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
                <div class="w-full">
                    <label
                        for="brand"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Date de fin</label
                    >

                    <input
                        lang="fr-CA"
                        :min="new Date().toISOString().split('T')[0]"
                        v-model="form.end"
                        type="date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Select date"
                        name="start"
                    />
                    <span
                        v-if="form.errors.end"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.end }}
                    </span>
                </div>
                <div class="flex sm:col-span-2 gap-4">
                    <div class="w-full">
                        <label
                            for="type"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Type</label
                        >
                        <select
                            v-model="form.evenement_type_id"
                            id="type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
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
                    <div class="w-full">
                        <label
                            for="revenue"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Revenues</label
                        >
                        <input
                            step="0.01"
                            type="number"
                            name="revenue"
                            id="revenue"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="1200Dh"
                            v-model="form.revenue"
                            min="0"
                        />
                        <span
                            v-if="form.errors.revenue"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.revenue }}
                        </span>
                    </div>
                    <div class="w-full">
                        <label
                            for="expenses"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Dépenses</label
                        >
                        <input
                            step="0.01"
                            type="number"
                            name="expenses"
                            id="expenses"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="1200Dh"
                            min="0"
                            v-model="form.depense"
                        />
                        <span
                            v-if="form.errors.depense"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.depense }}
                        </span>
                    </div>
                </div>
                <!-- ------------------------------------------ -->
                <div class="flex sm:col-span-2 gap-4">
                    <div class="w-full">
                        <label
                            for="lieu"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Lieu de l'événement</label
                        >
                        <input
                            v-model="form.location"
                            type="text"
                            name="lieu"
                            id="lieu"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="lieu de l'événement"
                        />
                        <span
                            v-if="form.errors.location"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.location }}
                        </span>
                    </div>
                    <div class="w-full">
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
                    <div class="w-full">
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
                </div>
                <div class="sm:col-span-2">
                    <label
                        for="description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Description</label
                    >
                    <textarea
                        id="description"
                        rows="8"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        v-model="form.description"
                    ></textarea>
                    <span
                        v-if="form.errors.description"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.description }}
                    </span>
                </div>
            </div>
            <button
                type="submit"
                class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800"
            >
                Modifier
            </button>
        </form>
    </div>
</template>
