<template>
    <button
        @click="isModalOpen = true"
        class="rounded-full fixed bottom-8 right-5 z-50 text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium text-sm p-5 focus:outline-none"
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
            Gestion Adhérants
        </h1>
    </div>
    <div class="bg-white px-4 py-6 shadow-md">
        <div
            class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100"
        >
            <div class="flex items-center mb-4 sm:mb-0">
                <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                    <input
                        type="text"
                        v-model="search"
                        class="bg-slate-200 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :text-white :focus:ring-blue-500 :focus:border-blue-500"
                        placeholder="rechercher adhérants..."
                    />
                </div>
            </div>
        </div>
        <div class="">
            <Modal size="3xl" v-if="isModalOpen" @close="closeModal">
                <template #header>
                    <div class="flex items-center text-lg">
                        {{
                            form.id
                                ? "Mettre à jour un adhérant"
                                : "Ajouter un adhérant"
                        }}
                    </div>
                </template>
                <template #body>
                    image {{ form.image }}
                    <form
                        class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2 overflow-y-auto max-h-[30rem]"
                        @submit.prevent="submit"
                    >
                        <div>
                            <label
                                for="avatar"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >Profile
                            </label>
                            <ImageUpload
                                v-model="form.image"
                                :default-src="defaultImg"
                            />
                            <span
                                v-if="form.errors.image"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.image }}
                            </span>
                        </div>

                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6"
                        >
                            <div>
                                <label
                                    for="last_name"
                                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                    >Nom
                                </label>
                                <input
                                    v-model="form.last_name"
                                    type="text"
                                    name="last_name"
                                    id="last_name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
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
                                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                    >Prénom
                                </label>
                                <input
                                    v-model="form.first_name"
                                    type="text"
                                    name="first_name"
                                    id="first_name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
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

                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6"
                        >
                            <div>
                                <label
                                    for="cin"
                                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                    >CIN</label
                                >
                                <input
                                    pattern="^[A-Za-z\d]+$"
                                    v-model="form.cin"
                                    type="text"
                                    name="cin"
                                    id="cin"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
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
                                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                    >Sexe</label
                                >
                                <div class="flex gap-x-6">
                                    <div class="flex">
                                        <input
                                            type="radio"
                                            name="sexe"
                                            class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 :bg-gray-800 :border-gray-700 :checked:bg-blue-500 :checked:border-blue-500 :focus:ring-offset-gray-800"
                                            id="homme"
                                            checked
                                            value="homme"
                                            v-model="form.sexe"
                                        />
                                        <label
                                            for="homme"
                                            class="text-sm text-gray-500 ml-2 :text-gray-400"
                                            >Homme</label
                                        >
                                    </div>

                                    <div class="flex">
                                        <input
                                            type="radio"
                                            name="sexe"
                                            class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 :bg-gray-800 :border-gray-700 :checked:bg-blue-500 :checked:border-blue-500 :focus:ring-offset-gray-800"
                                            id="femme"
                                            value="femme"
                                            v-model="form.sexe"
                                        />
                                        <label
                                            for="femme"
                                            class="text-sm text-gray-500 ml-2 :text-gray-400"
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

                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6"
                        >
                            <div>
                                <label
                                    for="tel"
                                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                    >Tel</label
                                >
                                <input
                                    pattern="^06|07\d{9}$"
                                    v-model="form.tel"
                                    type="text"
                                    name="tel"
                                    id="tel"
                                    autocomplete="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
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
                                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                    >Email</label
                                >
                                <input
                                    v-model="form.email"
                                    type="email"
                                    name="email"
                                    id="email"
                                    autocomplete="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
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

                        <div
                            class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6"
                        >
                            <div>
                                <label
                                    for="date_of_birth"
                                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                    >Date de naissance
                                </label>

                                <input
                                    v-model="form.date_of_birth"
                                    type="date"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
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
                                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                    >Date d'adhésion
                                </label>

                                <input
                                    v-model="form.date_of_membership"
                                    type="date"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
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
                        <div>
                            <label
                                for="hs-about-hire-us-1"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >Addresse</label
                            >
                            <textarea
                                v-model="form.address"
                                id="address"
                                name="address"
                                rows="3"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                            ></textarea>
                            <span
                                v-if="form.errors.address"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.address }}
                            </span>
                        </div>
                        <div class="flex justify-end gap-x-2">
                            <button
                                @click="closeModal"
                                type="button"
                                class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm :bg-slate-900 :hover:bg-slate-800 :border-gray-700 :text-gray-400 :hover:text-white :focus:ring-offset-gray-800"
                            >
                                Annuler
                            </button>
                            <button
                                type="submit"
                                class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm :focus:ring-offset-gray-800"
                            >
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </template>
                <!-- <template #footer>

            </template> -->
            </Modal>
        </div>
        <div class="mt-4">
            <div class="overflow-hidden bg-white">
                <div class="bg-white">
                    <div class="relative overflow-x-auto shadow-lg mb-5">
                        <table
                            class="w-full sm:rounded-lg text-sm text-left text-gray-500 border-collapse :text-gray-400"
                        >
                            <thead class="bg-gray-100">
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-slate-400 text-xs font-medium text-left text-gray-500 uppercase :text-gray-400"
                                    >
                                        #
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-slate-400 text-xs font-medium text-left text-gray-500 uppercase :text-gray-400"
                                    >
                                        Nom
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-slate-400 text-xs font-medium text-left text-gray-500 uppercase :text-gray-400"
                                    >
                                        Prénom
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-slate-400 text-xs font-medium text-left text-gray-500 uppercase :text-gray-400"
                                    >
                                        CIN
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-slate-400 text-xs font-medium text-left text-gray-500 uppercase :text-gray-400"
                                    >
                                        Telephone
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 border border-slate-400 text-xs font-medium text-left text-gray-500 uppercase :text-gray-400"
                                    >
                                        Date d'adhésion
                                    </th>
                                    <th
                                        @click="
                                            printJS({
                                                printable: adherants.data,
                                                properties: [
                                                    {
                                                        field: 'first_name',
                                                        displayName: 'Prenom',
                                                    },
                                                    {
                                                        field: 'last_name',
                                                        displayName: 'Nom',
                                                    },
                                                    {
                                                        field: 'sexe',
                                                        displayName: 'Sexe',
                                                    },
                                                    {
                                                        field: 'date_of_birth',
                                                        displayName:
                                                            'Date de naissance',
                                                    },
                                                    {
                                                        field: 'date_of_membership',
                                                        displayName:
                                                            'Date d\'adhésion',
                                                    },
                                                    {
                                                        field: 'cin',
                                                        displayName: 'CIN',
                                                    },
                                                    {
                                                        field: 'tel',
                                                        displayName:
                                                            'Telephone',
                                                    },
                                                    {
                                                        field: 'address',
                                                        displayName: 'Addresse',
                                                    },
                                                ],

                                                type: 'json',
                                            })
                                        "
                                        scope="col"
                                        class="px-6 py-3 border border-slate-400 text-xs font-medium text-left text-gray-500 uppercase :text-gray-400"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-printer"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="#2c3e50"
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
                                            <path
                                                d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"
                                            />
                                        </svg>
                                    </th>
                                </tr>
                            </thead>
                            <tbody
                                class="bg-white divide-y divide-gray-200 :bg-gray-800"
                            >
                                <tr
                                    v-for="adherant in adherants.data"
                                    :key="adherant.id"
                                >
                                    <td
                                        class="px-6 py-3 border border-slate-400 text-base font-medium text-gray-900 whitespace-nowrap :text-white"
                                    >
                                        <img
                                            class="w-10 h-10 rounded-full"
                                            :src="showImage() + adherant.image"
                                        />
                                    </td>
                                    <td
                                        class="px-6 py-3 border border-slate-400 text-base font-medium text-gray-900 whitespace-nowrap :text-white"
                                    >
                                        {{ adherant.last_name }}
                                    </td>
                                    <td
                                        class="px-6 py-3 border border-slate-400 text-base font-medium text-gray-900 whitespace-nowrap :text-white"
                                    >
                                        {{ adherant.first_name }}
                                    </td>
                                    <td
                                        class="px-6 py-3 border border-slate-400 text-base font-medium text-gray-900 whitespace-nowrap :text-white"
                                    >
                                        {{ adherant.cin }}
                                    </td>
                                    <td
                                        class="px-6 py-3 border border-slate-400 text-base font-medium text-gray-900 whitespace-nowrap :text-white"
                                    >
                                        {{ adherant.tel }}
                                    </td>
                                    <td
                                        class="px-6 py-3 border border-slate-400 text-base font-medium text-gray-900 whitespace-nowrap :text-white"
                                    >
                                        {{ adherant.date_of_membership }}
                                    </td>
                                    <td
                                        class="px-6 py-3 border border-slate-400 text-base font-medium text-gray-900 whitespace-nowrap :text-white"
                                    >
                                        <div v-show="false" id="#print-section">
                                            <div>
                                                <h2>
                                                    {{ adherant.first_name }}
                                                    {{ adherant.last_name }}
                                                </h2>
                                                <p>CIN: {{ adherant.cin }}</p>
                                                <p>Tel: {{ adherant.tel }}</p>
                                                <p>
                                                    Date of Membership:
                                                    {{
                                                        adherant.date_of_membership
                                                    }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex">
                                            <!-- Eye -->
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
                                                @click="openEditModal(adherant)"
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
                                                @click="printContent"
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
    </div>
</template>

<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
};
</script>

<script setup>
import defaultImg from "../../../assets/image.jpeg";
import { ref, nextTick, onMounted } from "vue";
import { watch } from "vue";
import { router } from "@inertiajs/vue3";
import { Avatar } from "flowbite-vue";
import Pagination from "../../Components/Pagination.vue";
import ImageUpload from "../../Components/ImageUpload.vue";
import { Modal } from "flowbite-vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import printJS from "print-js";
import AdherentInfo from "./AdherantInfo.vue";

// const printSection = ref(null);

const printContent = async () => {
    // await nextTick();
    // let printSection = document.getElementById("printSection");
    // printJS({
    //     printable: printSection.innerHTML,
    //     type: "html",
    //     header: "Adherant Information",
    //     targetStyles: ["*"],
    // });
};

onMounted(printContent);

const $toast = useToast();

const form = useForm({
    id: null,
    image: null,
    first_name: null,
    last_name: null,
    date_of_birth: null,
    date_of_membership: null,
    sexe: null,
    cin: null,
    address: null,
    tel: null,
});

const showImage = () => {
    return "/storage/";
};

const destroy = (id) => {
    if (confirm("Are you sure to delete?")) {
        form.delete(route("adherants.destroy", id), {
            onError: () => {
                $toast.open({
                    message: "Erreur lors de la suppression d'adhérant",
                    type: "error",
                    duration: 3000,
                    dismissible: true,
                });
            },
            onSuccess: () => {
                $toast.open({
                    message: "Adhérant est supprimé avec succès",
                    type: "success",
                    duration: 3000,
                    dismissible: true,
                });
            },
        });
    }
};

const submit = () => {
    if (form.id) {
        console.log(form.id);
        form.put(route("adherants.update", form.id), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
                $toast.open({
                    message: "Adhérant est modifié avec succès",
                    type: "success",
                    duration: 3000,
                    dismissible: true,
                });
            },
            onError: () => {
                $toast.open({
                    message: "Erreur lors de la modification d'adhérant",
                    type: "error",
                    duration: 3000,
                    dismissible: true,
                });
            },
        });
    } else {
        form.post(route("adherants.store"), {
            // forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
                $toast.open({
                    message: "Adhérant est ajouté avec succès",
                    type: "success",
                    duration: 3000,
                    dismissible: true,
                });
            },
            onError: () => {
                $toast.open({
                    message: "Erreur lors de l'ajout d'adhérant",
                    type: "error",
                    duration: 3000,
                    dismissible: true,
                });
            },
        });
    }
};

let isModalOpen = ref(false);

const closeModal = () => {
    isModalOpen.value = false;

    form.reset();
};

const openEditModal = (adherant) => {
    form.id = adherant.id;
    form.image = adherant.image;
    form.first_name = adherant.first_name;
    form.last_name = adherant.last_name;
    form.date_of_birth = adherant.date_of_birth;
    form.date_of_membership = adherant.date_of_membership;
    form.sexe = adherant.sexe;
    form.cin = adherant.cin;
    form.address = adherant.address;
    form.tel = adherant.tel;
    isModalOpen.value = true;
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
