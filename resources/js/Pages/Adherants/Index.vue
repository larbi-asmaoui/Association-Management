<template>
    <h3 class="text-gray-700 text-3xl font-medium">Gestion Adhérants</h3>

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
                        title="Ajouter adhérant"
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
                                            for="last_name"
                                            class="block text-sm text-gray-700 font-medium dark:text-white"
                                            >Nom
                                        </label>
                                        <input
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

                                <div
                                    class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6"
                                >
                                    <div>
                                        <label
                                            for="cin"
                                            class="block text-sm text-gray-700 font-medium dark:text-white"
                                            >CIN</label
                                        >
                                        <input
                                            pattern="^[A-Za-z\d]+$"
                                            v-model="form.cin"
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
                                            for="cin"
                                            class="block text-sm text-gray-700 font-medium dark:text-white"
                                            >Sexe</label
                                        >
                                        <div class="flex gap-x-6">
                                            <div class="flex">
                                                <input
                                                    type="radio"
                                                    name="sexe"
                                                    class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                                    id="homme"
                                                    checked
                                                    value="homme"
                                                    v-model="form.sexe"
                                                />
                                                <label
                                                    for="homme"
                                                    class="text-sm text-gray-500 ml-2 dark:text-gray-400"
                                                    >Homme</label
                                                >
                                            </div>

                                            <div class="flex">
                                                <input
                                                    type="radio"
                                                    name="sexe"
                                                    class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                                    id="femme"
                                                    value="femme"
                                                    v-model="form.sexe"
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

                                <div
                                    class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6"
                                >
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

                            <div class="mt-6 grid">
                                <button
                                    type="submit"
                                    class="inline-flex justify-center items-center gap-x-3 text-center text-white bg-indigo-600 hover:bg-indigo-700 border border-transparent text-sm lg:text-base text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-white transition py-3 px-4 dark:focus:ring-offset-gray-800"
                                >
                                    Ajouter
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
                                <th scope="col" class="px-6 py-3">Prenom</th>
                                <th scope="col" class="px-6 py-3">Nom</th>
                                <th scope="col" class="px-6 py-3">CIN</th>
                                <th scope="col" class="px-6 py-3">Tel</th>
                                <th scope="col" class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="adherant in adherants.data"
                                :key="adherant.id"
                            >
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium whitespace-nowrap"
                                >
                                    {{ adherant.id }}
                                </th>
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium whitespace-nowrap"
                                >
                                    {{ adherant.first_name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ adherant.last_name }}
                                </td>
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium whitespace-nowrap"
                                >
                                    {{ adherant.cin }}
                                </th>
                                <th
                                    scope="row"
                                    class="px-6 py-4 font-medium whitespace-nowrap"
                                >
                                    {{ adherant.tel }}
                                </th>
                                <td class="px-6 py-4">
                                    <div
                                        class="flex item-center justify-center"
                                    >
                                        <!-- Eye -->
                                        <div
                                            @click="show(adherant.id)"
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
                                            @click="
                                                $inertia.visit(
                                                    route(
                                                        'adherants.edit',
                                                        adherant.id
                                                    )
                                                )
                                            "
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
                                            @click="destroy(adherant.id)"
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

                                        <!-- Print -->
                                        <div
                                            @click="
                                                $inertia.visit(
                                                    route(
                                                        'adherants.print',
                                                        adherant.id
                                                    )
                                                )
                                            "
                                            class="cursor-pointer w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-printer"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                fill="none"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
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
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :data="adherants" />
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
import { ref } from "vue";
import { watch } from "vue";
import { router } from "@inertiajs/vue3";
import Pagination from "../../Components/Pagination.vue";
import CustomModal from "../../Components/CustomModal.vue";

import { useForm } from "@inertiajs/vue3";

const form = useForm({
    first_name: "",
    last_name: "",
    date_of_birth: null,
    sexe: null,
    cin: null,
    address: null,
    tel: null,
});

const show = (id) => {
    form.get(route("adherants.show", id));
};

const destroy = (id) => {
    if (confirm("Are you sure to delete?")) {
        form.delete(route("adherants.destroy", id));
    }
};

const submit = () => {
    form.post(route("adherants.store"), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    isOpen = false;

    form.reset();
};
const props = defineProps({
    adherants: {
        type: Object,
        default: () => ({}),
    },
    // filters: {
    //     type: Object,
    //     default: () => ({}),
    // },
});

// pass filters in search
let search = ref("");
watch(search, (value) => {
    router.get(
        "/adherants",
        { search: value },
        {
            preserveState: true,
            replace: true,
        }
    );
});
</script>
