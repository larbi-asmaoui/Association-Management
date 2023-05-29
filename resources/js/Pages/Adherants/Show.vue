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
                        <svg
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
                        <button
                            type="button"
                            class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                        >
                            <input type="file" name="" id="" />
                            Change
                        </button>
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
                            :class="formEnabled ? 'bg-slate-300' : ''"
                            disabled="formEnabled"
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
                            v-model="form.first_name"
                            type="text"
                            name="first_name"
                            id="first_name"
                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                        />
                        <!-- <span
                                v-if="form.errors.first_name"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.first_name }}
                            </span> -->
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
                            v-model="form.cin"
                            pattern="^[A-Za-z\d]+$"
                            type="text"
                            name="cin"
                            id="cin"
                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                        />
                        <!-- <span
                                v-if="form.errors.cin"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.cin }}
                            </span> -->
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
                        <!-- <span
                                v-if="form.errors.sexe"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.sexe }}
                            </span> -->
                    </div>
                </div>

                <!-- Grid -->

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                    <div>
                        <label
                            for="tel"
                            class="block text-sm text-gray-700 font-medium dark:text-white"
                            >Tel</label
                        >
                        <!-- pattern="^0\d{9}$" -->
                        <input
                            v-model="form.tel"
                            type="text"
                            name="tel"
                            id="tel"
                            autocomplete="text"
                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                        />
                        <!-- <span
                                v-if="form.errors.tel"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.tel }}
                            </span> -->
                    </div>

                    <div>
                        <label
                            for="email"
                            class="block text-sm text-gray-700 font-medium dark:text-white"
                            >Email</label
                        >
                        <input
                            v-model="form.email"
                            type="email"
                            name="email"
                            id="email"
                            autocomplete="text"
                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                        />
                        <!-- <span
                                v-if="form.errors.email"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.email }}
                            </span> -->
                    </div>
                </div>

                <!-- //////////////////////// -->
                <div>
                    <div>
                        <label
                            for="date_of_birth"
                            class="block text-sm text-gray-700 font-medium dark:text-white"
                            >Date de naissance
                        </label>

                        <input
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
                </div>

                <!-- TEXTAREA -->
                <div>
                    <label
                        for="hs-about-hire-us-1"
                        class="block text-sm text-gray-700 font-medium dark:text-white"
                        >Addresse</label
                    >
                    <textarea
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
            </div>

            <div class="mt-6 flex">
                <button
                    type="submit"
                    class="inline-flex mr-4 justify-center items-center gap-x-3 text-center bg-blue-600 hover:bg-blue-700 border border-transparent text-sm lg:text-base text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-white transition py-3 px-4 dark:focus:ring-offset-gray-800"
                >
                    Mettre à jour
                </button>
                <button
                    type="button"
                    @click="formEnabled = true"
                    class="inline-flex justify-center border-blue-200 items-center gap-x-3 text-center hover:bg-blue-200 border border-transparent text-sm lg:text-base text-blue-700 font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-white transition py-3 px-4 dark:focus:ring-offset-gray-800"
                >
                    Modifer
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
};
</script>

<script setup>
import { ref } from "vue";
import { useForm, Link } from "@inertiajs/vue3";

const props = defineProps({
    adherant: {
        type: Object,
        default: () => ({}),
    },
});

const formEnabled = ref(true);

const form = useForm({
    first_name: props.adherant.first_name,
    last_name: props.adherant.last_name,
    email: props.adherant.email,
    date_of_birth: props.adherant.date_of_birth,
    sexe: props.adherant.sexe,
    cin: props.adherant.cin,
    address: props.adherant.address,
    tel: props.adherant.tel,
});

const submit = () => {
    form.put(route("adherants.update", props.adherant.id));
};
</script>
