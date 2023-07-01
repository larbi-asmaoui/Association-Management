<template>
    <button
        @click="isModalOpen = true"
        class="rounded-full fixed bottom-8 z-50 text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium text-sm p-5 focus:outline-none"
        type="button"
        :class="$i18n.locale === 'ar' ? 'left-5' : 'right-5'"
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

    <div class="bg-white pt-6 shadow-md rounded-xl relative mt-5">
        <!-- Start  -->
        <div
            class="shadow-lg bg-blue-600 p-4 absolute top-1.5 left-1/2 w-11/12 rounded-full transform -translate-x-1/2 -translate-y-1/2"
        >
            <h2
                class="text-xl font-semibold text-white"
                :class="$i18n.locale === 'ar' ? 'text-right' : 'text-left'"
            >
                {{ $t("adherents.titre") }}
            </h2>
        </div>
        <!-- End -->
        <div
            class="mt-7 items-center justify-between block sm:flex md:divide-x md:divide-gray-100"
        >
            <div class="px-2 flex items-center mb-4 sm:mb-0"></div>
        </div>
        <Modal size="5xl" v-if="isModalOpen" @close="closeModal">
            <template #header>
                <div
                    class="flex items-center text-lg"
                    :class="
                        $i18n.locale === 'ar' ? 'justify-end' : 'justify-start'
                    "
                >
                    {{ $t("adherents.modal_ajouter") }}
                </div>
            </template>
            <template #body>
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
                        <!-- <span
                                v-if="form.errors.image"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.image }}
                            </span> -->
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
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
                            <!-- <span
                                    v-if="form.errors.last_name"
                                    class="text-xs text-red-600 mt-1"
                                    id="hs-validation-name-error-helper"
                                >
                                    {{ form.errors.last_name }}
                                </span> -->
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
                            <!-- <span
                                    v-if="form.errors.first_name"
                                    class="text-xs text-red-600 mt-1"
                                    id="hs-validation-name-error-helper"
                                >
                                    {{ form.errors.first_name }}
                                </span> -->
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 lg:gap-6">
                        <div>
                            <label
                                for="cin"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >CIN</label
                            >
                            <input
                                v-model="form.cin"
                                type="text"
                                name="cin"
                                id="cin"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
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
                                for="Sexe"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >Sexe</label
                            >
                            <select
                                v-model="form.sexe"
                                id="type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            >
                                <option disabled value="">
                                    Séléctionner Sexe
                                </option>
                                <option value="homme">homme</option>
                                <option value="femme">femme</option>
                            </select>
                            <!-- <span
                                    v-if="form.errors.region"
                                    class="text-xs text-red-600 mt-1"
                                    id="hs-validation-name-error-helper"
                                >
                                    {{ form.errors.region }}
                                </span> -->
                        </div>

                        <div>
                            <label
                                for="profession"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >Profession</label
                            >
                            <input
                                v-model="form.profession"
                                type="text"
                                name="profession"
                                id="profession"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                            />
                            <!-- <span
                                    v-if="form.errors.profession"
                                    class="text-xs text-red-600 mt-1"
                                    id="hs-validation-name-error-helper"
                                >
                                    {{ form.errors.profession }}
                                </span> -->
                        </div>
                        <div>
                            <label
                                for="situation"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >Situation Familiale</label
                            >
                            <select
                                v-model="form.situation_familiale"
                                id="type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            >
                                <option disabled value="">
                                    Séléctionner situation familiale
                                </option>
                                <option value="Mariee">Mariee</option>
                                <option value="Celibataire">Celibataire</option>
                            </select>
                            <!-- <span
                                    v-if="form.errors.region"
                                    class="text-xs text-red-600 mt-1"
                                    id="hs-validation-name-error-helper"
                                >
                                    {{ form.errors.region }}
                                </span> -->
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                        <div>
                            <label
                                for="tel"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >Telephone</label
                            >
                            <input
                                v-model="form.tel"
                                type="text"
                                name="tel"
                                id="tel"
                                autocomplete="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
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
                            <!-- <span
                                    v-if="form.errors.email"
                                    class="text-xs text-red-600 mt-1"
                                    id="hs-validation-name-error-helper"
                                >
                                    {{ form.errors.email }}
                                </span> -->
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
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
                            <!-- <span
                                    v-if="form.errors.date_of_birth"
                                    class="text-xs text-red-600 mt-1"
                                    id="hs-validation-name-error-helper"
                                >
                                    {{ form.errors.date_of_birth }}
                                </span> -->
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
                            <!-- <span
                                    v-if="form.errors.date_of_membership"
                                    class="text-xs text-red-600 mt-1"
                                    id="hs-validation-name-error-helper"
                                >
                                    {{ form.errors.date_of_membership }}
                                </span> -->
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
                            rows="1"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                        ></textarea>
                        <!-- <span
                                v-if="form.errors.address"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.address }}
                            </span> -->
                    </div>

                    <div>
                        <label
                            for="region"
                            class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                            >Statut</label
                        >
                        <select
                            v-model="form.statut_id"
                            id="type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        >
                            <option disabled value="">
                                Séléctionner statut
                            </option>
                            <option
                                v-for="statut in status"
                                :key="statut.id"
                                :value="statut.id"
                            >
                                {{ statut.name }}
                            </option>
                        </select>
                        <!-- <span
                                    v-if="form.errors.region"
                                    class="text-xs text-red-600 mt-1"
                                    id="hs-validation-name-error-helper"
                                >
                                    {{ form.errors.region }}
                                </span> -->
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                        <div>
                            <label
                                for="region"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
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
                            <!-- <span
                                    v-if="form.errors.region"
                                    class="text-xs text-red-600 mt-1"
                                    id="hs-validation-name-error-helper"
                                >
                                    {{ form.errors.region }}
                                </span> -->
                        </div>

                        <div>
                            <label
                                for="city"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
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
                                    :key="city.id"
                                    :value="city"
                                >
                                    {{ city }}
                                </option>
                            </select>
                            <!-- <span
                                    v-if="form.errors.city"
                                    class="text-xs text-red-600 mt-1"
                                    id="hs-validation-name-error-helper"
                                >
                                    {{ form.errors.city }}
                                </span> -->
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                        <div>
                            <label
                                for="frais_adhesion"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >Frais d'adhésion</label
                            >
                            <input
                                v-model="form.montant"
                                type="number"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                                placeholder="Frais d'adhésion (en DH)"
                                name="frais_adhesion"
                                min="1"
                                step="0.01"
                            />
                            <!-- <span
                                    v-if="form.errors.city"
                                    class="text-xs text-red-600 mt-1"
                                    id="hs-validation-name-error-helper"
                                >
                                    {{ form.errors.city }}
                                </span> -->
                        </div>
                        <div></div>
                    </div>
                    <div class="flex justify-end gap-x-2 mt-4">
                        <button
                            @click="closeModal"
                            type="button"
                            class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm :bg-slate-900 :hover:bg-slate-800 :border-gray-700 :text-gray-400 :hover:text-white :focus:ring-offset-gray-800"
                        >
                            {{ $t("buttons.annuler") }}
                        </button>
                        <button
                            type="submit"
                            class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm :focus:ring-offset-gray-800"
                        >
                            {{ $t("buttons.enregistrer") }}
                        </button>
                    </div>
                </form>
            </template>
        </Modal>

        <div class="mt-4">
            <vue-good-table
                :columns="columns"
                :rows="rows"
                :pagination-options="{
                    enabled: true,
                }"
                :search-options="{
                    enabled: true,
                    placeholder: $t('adherents.table_search'),
                }"
                :rtl="$i18n.locale === 'ar'"
            >
                <template v-slot:table-row="{ row, column, formattedRow }">
                    <div v-if="column.field === 'actions'" class="flex">
                        <div
                            @click="show(row)"
                            class="cursor-pointer w-4 mr-2 transform hover:text-yellow-200 hover:scale-110"
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

                        <!-- Delete -->

                        <div
                            @click="destroy(row)"
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
                    <div v-if="column.field === 'image'" class="flex">
                        <img
                            class="w-10 h-10 rounded-full"
                            :src="showImage() + row.image"
                        />
                    </div>
                    <div
                        v-if="column.field === 'is_actif'"
                        class="flex items-center justify-center"
                    >
                        <div
                            v-if="row.is_actif === 1"
                            class="w-4 h-4 bg-green-700 rounded-full"
                        ></div>
                        <div
                            v-else
                            class="w-4 h-4 bg-red-700 rounded-full"
                        ></div>
                    </div>
                    <div v-else>
                        {{ formattedRow[column.field] }}
                    </div>
                </template>
            </vue-good-table>
        </div>
    </div>
    <!-- <div class="w-5 h-5">
        <Cropper
            src="https://images.unsplash.com/photo-1575936123452-b67c3203c357?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8aW1hZ2V8ZW58MHx8MHx8fDA%3D&w=1000&q=80"
            @change="change"
        />
    </div> -->
</template>

<script>
import MainLayout from "../../Layouts/MainLayout.vue";
import html2pdf from "html2pdf.js";

export default {
    layout: MainLayout,
    methods: {},
};
</script>

<script setup>
import { VueGoodTable } from "vue-good-table-next";
import "vue-good-table-next/dist/vue-good-table-next.css";
import { Cropper } from "vue-advanced-cropper";
import "vue-advanced-cropper/dist/style.css";
import defaultImg from "../../../assets/image.jpeg";
import { ref, nextTick, computed, onMounted } from "vue";
import { watch } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { Avatar } from "flowbite-vue";
import Pagination from "../../Components/Pagination.vue";
import ImageUpload from "../../Components/ImageUpload.vue";
import { Modal } from "flowbite-vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import printJS from "print-js";
import AdherentInfo from "./AdherentInfo.vue";
import JsonCSV from "vue-json-csv";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
import regionsFile from "../../regions.json";
import { useI18n } from "vue-i18n";
const { t, availableLocales, locale } = useI18n();

const columns = ref([
    {
        label: "#",
        field: "image",
    },
    {
        label: t("adherents.table_nom_complete"),
        field: "nom_complet",
    },
    {
        label: t("adherents.table_cin"),
        field: "cin",
    },
    {
        label: t("adherents.table_profession"),
        field: "profession",
    },
    {
        label: t("adherents.table_situation_familiale"),
        field: "situation_familiale",
    },
    {
        label: t("adherents.table_telephone"),
        field: "tel",
    },
    {
        label: "Statut",
        field: "is_actif",
    },
    {
        label: t("adherents.table_actions"),
        field: "actions",
    },
]);
const rows = computed(() =>
    Object.values(props.all_adherents).map((adherent) => ({
        id: adherent.id,
        // image: adherent.image,
        nom_complet: adherent.first_name + " " + adherent.last_name,
        profession: adherent.profession,
        situation_familiale: adherent.situation_familiale,
        cin: adherent.cin,
        tel: adherent.tel,
        is_actif: adherent.is_actif,
    }))
);

const props = defineProps({
    all_adherents: {
        type: Object,
        default: () => ({}),
    },

    status: {
        type: Object,
        default: () => ({}),
    },
});

const change = ({ coordinates, canvas }) => {
    console.log(coordinates, canvas);
};

const page = usePage();
const exportToPDF = () => {
    // Create a new jsPDF instance
    const doc = new jsPDF();
    const pageWidth = doc.internal.pageSize.getWidth();
    // Add the image to the PDF
    const img = doc.addImage(
        `/storage/${page.props.auth.user.association.image}`,
        "JPEG",
        (pageWidth - 30) / 2,
        2,
        30,
        30
    );

    doc.setFontSize(10);
    const title = `${page.props.auth.user.association.name}`;
    const titleWidth = doc.getTextWidth(title);

    const titleX = (pageWidth - titleWidth) / 2;
    doc.text(title, titleX, 32);
    doc.setFontSize(9);
    doc.text("Liste de membres", 10, 43);
    doc.line(0, 45, 400, 45);
    // Define the table headers and data
    const headers = [
        "ID",
        "Nom",
        "Prenom",
        "CIN",
        "Telephone",
        "Date d'adhesion",
        " ",
        //
    ];

    const data = props.all_adherents.map((adherent) => [
        adherent.id,
        adherent.last_name,
        adherent.first_name,
        adherent.cin,
        adherent.tel,
        adherent.date_of_membership,
        "  ",
    ]);

    // Add the table to the PDF
    doc.autoTable({
        margin: { top: 50 },
        head: [headers],
        body: data,
    });

    // Save the PDF
    doc.save("membres_list.pdf");
};

const csvFields = ref({
    separator: ",",
    labels: {
        first_name: "First Name",
        last_name: "Last Name",
        is_actif: "Active Status",
        cin: "CIN",
        sexe: "Gender",
        date_of_birth: "Date of Birth",
        date_of_membership: "Date of Membership",
        address: "Address",
        tel: "Phone Number",
        email: "Email Address",
    },
});

const $toast = useToast();

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
    image: null,
    first_name: null,
    last_name: null,
    date_of_birth: null,
    date_of_membership: null,
    sexe: null,
    cin: null,
    profession: null,
    situation_familiale: null,
    address: null,
    region: null,
    city: null,
    tel: null,
    statut_id: null,
    montant: null,
});

const showImage = () => {
    return "/storage/";
};

const show = (id) => {
    router.get(route("adherents.show", id));
};

const destroy = (id) => {
    if (confirm("Are you sure to delete?")) {
        frouter.delete(route("adherents.destroy", id), {
            onError: () => {
                $toast.open({
                    message: "Erreur lors de la suppression d'adhérent",
                    type: "error",
                    duration: 3000,
                    dismissible: true,
                });
            },
            onSuccess: () => {
                $toast.open({
                    message: "adhérent est supprimé avec succès",
                    type: "success",
                    duration: 3000,
                    dismissible: true,
                });
            },
        });
    }
};

const submit = () => {
    form.post(route("adherents.store"), {
        // forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            $toast.open({
                message: "adhérent est ajouté avec succès",
                type: "success",
                duration: 3000,
                dismissible: true,
            });
        },
        onError: () => {
            $toast.open({
                message: "Erreur lors de l'ajout d'adhérent",
                type: "error",
                duration: 3000,
                dismissible: true,
            });
        },
    });
};

let isModalOpen = ref(false);

const closeModal = () => {
    isModalOpen.value = false;

    form.reset();
};
</script>

<style scoped>
#my-doc {
    font: 33rem;
}
</style>
