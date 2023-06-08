<template>
    <div class="inline-flex items-center mb-5">
        <Link
            :href="route('adherants.index')"
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
            Détails de l'adhérant
        </h1>
    </div>

    <div class="bg-white px-4 py-6 shadow-md">
        <form @submit.prevent="submit">
            <div class="mt-4 grid gap-4 lg:gap-6">
                <div class="col-span-full">
                    <label
                        for="photo"
                        class="block text-sm font-medium leading-6 text-gray-900"
                        >Photo</label
                    >
                    <div class="mt-2 flex items-center gap-x-3">
                        <img
                            v-if="adherant.image"
                            :src="showImage() + adherant.image"
                            class="h-16 w-16 rounded-full"
                            alt=""
                        />
                        <svg
                            v-else
                            class="h-16 w-16 text-gray-300"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                clip-rule="evenodd"
                            />
                        </svg>

                        <input
                            type="file"
                            name=""
                            id="file-upload"
                            class="rounded-md bg-white text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 cursor-pointer"
                        />
                        <span
                            v-if="form.errors.image"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.image }}
                        </span>
                    </div>
                </div>
                <!-- Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                    <div>
                        <label
                            for="last_name"
                            class="block text-sm text-gray-700 font-medium dark:text-white"
                            >Nom
                        </label>
                        <input
                            :class="{
                                'bg-gray-200 cursor-not-allowed': isDisabled,
                                'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                            }"
                            :disabled="isDisabled"
                            v-model="form.last_name"
                            type="text"
                            name="last_name"
                            id="last_name"
                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                        />
                        <span
                            v-if="form.errors.last_name"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.last_name }}
                        </span>
                    </div>

                    <div>
                        <label
                            for="first_name"
                            class="block text-sm text-gray-700 font-medium dark:text-white"
                            >Prénom
                        </label>
                        <input
                            :class="{
                                'bg-gray-200 cursor-not-allowed': isDisabled,
                                'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                            }"
                            :disabled="isDisabled"
                            v-model="form.first_name"
                            type="text"
                            name="first_name"
                            id="first_name"
                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                        />
                        <span
                            v-if="form.errors.first_name"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.first_name }}
                        </span>
                    </div>
                </div>
                <!-- Grid -->

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                    <div>
                        <label
                            for="cin"
                            class="block text-sm text-gray-700 font-medium dark:text-white"
                            >CIN</label
                        >
                        <input
                            :class="{
                                'bg-gray-200 cursor-not-allowed': isDisabled,
                                'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                            }"
                            :disabled="isDisabled"
                            v-model="form.cin"
                            pattern="^[A-Za-z\d]+$"
                            type="text"
                            name="cin"
                            id="cin"
                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                        />
                        <span
                            v-if="form.errors.cin"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.cin }}
                        </span>
                    </div>
                    <div>
                        <label
                            for="sexe"
                            class="block text-sm text-gray-700 font-medium dark:text-white"
                            >Sexe</label
                        >
                        <div class="flex gap-x-6">
                            <div class="flex">
                                <input
                                    :class="{
                                        'bg-gray-200 cursor-not-allowed':
                                            isDisabled,
                                        'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                                    }"
                                    :disabled="isDisabled"
                                    v-model="form.sexe"
                                    type="radio"
                                    name="sexe"
                                    class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                    id="homme"
                                    checked
                                    value="homme"
                                />
                                <label
                                    for="homme"
                                    class="text-sm text-gray-500 ml-2 dark:text-gray-400"
                                    >Homme</label
                                >
                            </div>

                            <div class="flex">
                                <input
                                    :class="{
                                        'bg-gray-200 cursor-not-allowed':
                                            isDisabled,
                                        'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                                    }"
                                    :disabled="isDisabled"
                                    v-model="form.sexe"
                                    type="radio"
                                    name="sexe"
                                    class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                    id="femme"
                                    value="femme"
                                />
                                <label
                                    for="femme"
                                    class="text-sm text-gray-500 ml-2 dark:text-gray-400"
                                    >Femme</label
                                >
                            </div>
                        </div>
                        <span
                            v-if="form.errors.sexe"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.sexe }}
                        </span>
                    </div>
                </div>

                <!-- Grid -->

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                    <div>
                        <label
                            for="tel"
                            class="block text-sm text-gray-700 font-medium dark:text-white"
                            >Téléphone</label
                        >
                        <!-- pattern="^0\d{9}$" -->
                        <input
                            :class="{
                                'bg-gray-200 cursor-not-allowed': isDisabled,
                                'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                            }"
                            :disabled="isDisabled"
                            v-model="form.tel"
                            type="text"
                            name="tel"
                            id="tel"
                            autocomplete="text"
                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                        />
                        <span
                            v-if="form.errors.tel"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.tel }}
                        </span>
                    </div>

                    <div>
                        <label
                            for="email"
                            class="block text-sm text-gray-700 font-medium dark:text-white"
                            >Email</label
                        >
                        <input
                            :class="{
                                'bg-gray-200 cursor-not-allowed': isDisabled,
                                'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                            }"
                            :disabled="isDisabled"
                            v-model="form.email"
                            type="email"
                            name="email"
                            id="email"
                            autocomplete="text"
                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                        />
                        <span
                            v-if="form.errors.email"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.email }}
                        </span>
                    </div>
                </div>

                <!-- //////////////////////// -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                    <div>
                        <label
                            for="date_of_birth"
                            class="block text-sm text-gray-700 font-medium dark:text-white"
                            >Date de naissance
                        </label>

                        <input
                            :class="{
                                'bg-gray-200 cursor-not-allowed': isDisabled,
                                'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                            }"
                            :disabled="isDisabled"
                            v-model="form.date_of_birth"
                            type="date"
                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                            placeholder="Select date"
                            name="date_of_birth"
                        />
                        <span
                            v-if="form.errors.date_of_birth"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.date_of_birth }}
                        </span>
                    </div>
                    <div>
                        <label
                            for="date_of_membership"
                            class="block text-sm text-gray-700 font-medium dark:text-white"
                            >Date d'inscription
                        </label>

                        <input
                            :class="{
                                'bg-gray-200 cursor-not-allowed': isDisabled,
                                'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                            }"
                            :disabled="isDisabled"
                            v-model="form.date_of_membership"
                            type="date"
                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                            placeholder="Select date"
                            name="date_of_membership"
                        />
                        <span
                            v-if="form.errors.date_of_membership"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.date_of_membership }}
                        </span>
                    </div>
                </div>

                <!-- TEXTAREA -->
                <div>
                    <label
                        for="hs-about-hire-us-1"
                        class="block text-sm text-gray-700 font-medium dark:text-white"
                        >Addresse</label
                    >
                    <textarea
                        :class="{
                            'bg-gray-200 cursor-not-allowed': isDisabled,
                            'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                        }"
                        :disabled="isDisabled"
                        v-model="form.address"
                        id="address"
                        name="address"
                        rows="2"
                        class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                    ></textarea>
                    <span
                        v-if="form.errors.address"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.address }}
                    </span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                    <div>
                        <label
                            for="tel"
                            class="block text-sm text-gray-700 font-medium dark:text-white"
                            >Région</label
                        >
                        <select
                            :class="{
                                'bg-gray-200 cursor-not-allowed': isDisabled,
                                'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                            }"
                            :disabled="isDisabled"
                            v-model="form.region"
                            id="type"
                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
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
                            for="city"
                            class="block text-sm text-gray-700 font-medium dark:text-white"
                            >Ville</label
                        >
                        <select
                            :class="{
                                'bg-gray-200 cursor-not-allowed': isDisabled,
                                'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                            }"
                            :disabled="isDisabled"
                            v-model="form.city"
                            id="type"
                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
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
            </div>
            <div class="mt-4">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input
                        :class="{
                            'bg-gray-200 cursor-not-allowed': isDisabled,
                            'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                        }"
                        :disabled="isDisabled"
                        type="checkbox"
                        value=""
                        class="sr-only peer"
                        v-model="form.is_actif"
                        :checked="form.is_actif"
                    />
                    <div
                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"
                    ></div>
                    <span
                        class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                        >Statut d'adhésion
                    </span>
                </label>
            </div>

            <div class="mt-6 flex justify-end">
                <button
                    @click="print"
                    type="button"
                    class="inline-flex mr-4 justify-center items-center gap-x-3 text-center bg-blue-600 hover:bg-blue-700 border border-transparent text-sm lg:text-base text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-white transition py-3 px-4 dark:focus:ring-offset-gray-800"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-printer"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path
                            stroke="none"
                            d="M0 0h24v24H0z"
                            fill="none"
                        ></path>
                        <path
                            d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"
                        ></path>
                        <path
                            d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"
                        ></path>
                        <path
                            d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"
                        ></path>
                    </svg>
                    Print PDF
                </button>
                <button
                    :class="{
                        'bg-gray-500 cursor-not-allowed': isDisabled,
                        'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                    }"
                    :disabled="isDisabled"
                    type="submit"
                    class="inline-flex mr-4 justify-center items-center gap-x-3 text-center bg-blue-600 hover:bg-blue-700 border border-transparent text-sm lg:text-base text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-white transition py-3 px-4 dark:focus:ring-offset-gray-800"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-pencil"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path
                            stroke="none"
                            d="M0 0h24v24H0z"
                            fill="none"
                        ></path>
                        <path
                            d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"
                        ></path>
                        <path d="M13.5 6.5l4 4"></path>
                    </svg>
                    Mettre à jour
                </button>
                <button
                    type="button"
                    @click="toggleDisabled"
                    class="inline-flex justify-center border-blue-200 items-center gap-x-3 text-center hover:bg-blue-200 border border-transparent text-sm lg:text-base text-blue-700 font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-white transition py-3 px-4 dark:focus:ring-offset-gray-800"
                >
                    Modifier
                </button>
            </div>
        </form>
        <div class="" v-show="false">
            <div id="card" class="py-4 rounded-lg border border-cyan-950">
                <img
                    :src="showImage() + adherant.image"
                    class="h-16 w-16 rounded-full"
                    alt="Profile Image"
                />

                <div class="my-2 h-10 bg-blue-900 w-full my-div"></div>

                <div class="flex justify-between items-start px-2">
                    <div>
                        <p class="text-slate-600 text-2xl">
                            Prénom:
                            <span class="text-black font-bold">{{
                                adherant.first_name
                            }}</span>
                        </p>
                        <p class="text-slate-600 text-2xl">
                            Nom:
                            <span class="text-black font-bold">{{
                                adherant.last_name
                            }}</span>
                        </p>
                        <p class="text-slate-600 text-2xl">
                            CIN:
                            <span class="text-black font-bold">{{
                                adherant.cin
                            }}</span>
                        </p>
                        <p class="text-slate-600 text-2xl">
                            Téléphone:
                            <span class="text-black font-bold">{{
                                adherant.tel
                            }}</span>
                        </p>
                    </div>
                    <div>
                        <p class="text-slate-600 text-2xl">
                            Date de naissance:
                            <span class="text-black font-bold">{{
                                adherant.date_of_birth
                            }}</span>
                        </p>
                        <p class="text-slate-600 text-2xl">
                            Date d'inscription:
                            <span class="text-black font-bold">{{
                                adherant.date_of_membership
                            }}</span>
                        </p>
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
import { ref, computed } from "vue";

import regionsFile from "../../regions.json";
import { useForm, Link, router } from "@inertiajs/vue3";
import printJS from "print-js";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

const $toast = useToast();
const props = defineProps({
    adherant: {
        type: Object,
        default: () => ({}),
    },
});
const isDisabled = ref(true);

const form = useForm({
    id: props.adherant.id,
    first_name: props.adherant.first_name,
    last_name: props.adherant.last_name,
    image: props.adherant.last_name,
    email: props.adherant.email,
    date_of_birth: props.adherant.date_of_birth,
    date_of_membership: props.adherant.date_of_birth,
    sexe: props.adherant.sexe,
    cin: props.adherant.cin,
    address: props.adherant.address,
    tel: props.adherant.tel,
    region: props.adherant.region,
    city: props.adherant.city,
    is_actif: props.adherant.is_actif,
});

const toggleDisabled = () => {
    isDisabled.value = !isDisabled.value;
};

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

const submit = () => {
    // form.put(route("adherants.update", props.adherant.id), {
    //     forceFormData: true,
    //     preserveScroll: true,
    //     onSuccess: () => {
    //         $toast.open({
    //             message: "Adhérant est modifié avec succès",
    //             type: "success",
    //             duration: 3000,
    //             dismissible: true,
    //         });
    //     },
    //     onError: () => {
    //         console.log(form.errors);
    //         $toast.open({
    //             message: "Une erreur s'est produite",
    //             type: "error",
    //             duration: 3000,
    //             dismissible: true,
    //         });
    //     },
    // });
    router.post(`/adherants/${props.adherant.id}`, {
        _method: "put",
        headers: {
            "Content-Type": "multipart/form-data",
        },
        id: props.adherant.id,
        first_name: props.adherant.first_name,
        last_name: props.adherant.last_name,
        image: props.adherant.last_name,
        email: props.adherant.email,
        date_of_birth: props.adherant.date_of_birth,
        date_of_membership: props.adherant.date_of_birth,
        sexe: props.adherant.sexe,
        cin: props.adherant.cin,
        address: props.adherant.address,
        tel: props.adherant.tel,
        region: props.adherant.region,
        city: props.adherant.city,
        is_actif: props.adherant.is_actif,
        preserveScroll: true,
        onSuccess: () => {
            $toast.open({
                message: "Adhérant est modifié avec succès",
                type: "success",
                duration: 3000,
                dismissible: true,
            });
        },
        onError: () => {
            console.log(form.errors);
            $toast.open({
                message: "Une erreur s'est produite",
                type: "error",
                duration: 3000,
                dismissible: true,
            });
        },
    });
};

const print = () => {
    printJS({
        maxWidth: 500,
        maxHeight: 310,
        printable: "card",
        type: "html",
        targetStyles: ["*"],
        // targetStyles: ["height,width,position, font-size"],
        // css: "../../../css/printing.css",
    });
};

const showImage = () => {
    return "/storage/";
};
</script>
<style scoped>
#card {
    height: 310px;
    width: 500px;
}

@media print {
    .my-div {
        height: 310px;
        width: 500px;
        background-color: red;
    }
}
</style>
