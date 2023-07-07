<template>
    <div class="inline-flex items-center mb-5">
        <Link
            :href="route('adherents.index')"
            class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white"
        >
            <ArrowRight v-if="$i18n.locale === 'ar'" />
            <ArrowLeft v-else />
        </Link>
    </div>

    <div class="mb-4 bg-blue-600 px-4 py-4 shadow-md">
        <h1 class="text-xl font-semibold text-white sm:text-2xl">
            {{ $t("adherents.adherent_info") }}
        </h1>
    </div>

    <div class="bg-white px-4 py-6 shadow-md">
        <form @submit.prevent="submit">
            <div class="mt-4 grid gap-4 lg:gap-6">
                <div class="col-span-full mb-5">
                    <label
                        for="photo"
                        class="mb-3 block text-sm font-medium leading-6 text-gray-900"
                        >{{ $t("adherents.input_image") }}</label
                    >
                    <div class="mt-2 flex items-start flex-col gap-y-3">
                        <img
                            v-if="adherent.image"
                            :src="showImage() + adherent.image"
                            class="h-16 w-16 rounded-full border-2 border-gray-300 dark:border-gray-700"
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
                            v-show="!isDisabled"
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
                            class="mb-3 block text-sm text-gray-700 font-medium dark:text-white"
                            >{{ $t("adherents.input_nom") }}
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
                            class="mb-3 block text-sm text-gray-700 font-medium dark:text-white"
                            >{{ $t("adherents.input_prenom") }}
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

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 lg:gap-6">
                    <div>
                        <label
                            for="cin"
                            class="mb-3 block text-sm text-gray-700 font-medium dark:text-white"
                            >{{ $t("adherents.input_cin") }}</label
                        >
                        <!-- pattern="^[A-Za-z\d]+$" -->
                        <input
                            :class="{
                                'bg-gray-200 cursor-not-allowed': isDisabled,
                                'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                            }"
                            :disabled="isDisabled"
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
                            for="email"
                            class="mb-3 block text-sm text-gray-700 font-medium dark:text-white"
                            >{{ $t("adherents.input_sexe") }}</label
                        >
                        <select
                            v-model="form.sexe"
                            id="type"
                            :class="{
                                'bg-gray-200 cursor-not-allowed': isDisabled,
                                'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                            }"
                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                        >
                            <option disabled value="">اختر الجنس</option>
                            <option value="ذكر">ذكر</option>
                            <option value="أنثى">أنثى</option>
                        </select>
                        <span
                            v-if="form.errors.sexe"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.sexe }}
                        </span>
                    </div>
                    <div>
                        <label
                            for="email"
                            class="mb-3 block text-sm text-gray-700 font-medium dark:text-white"
                            >{{
                                $t("adherents.input_situation_familiale")
                            }}</label
                        >
                        <select
                            v-model="form.situation_familiale"
                            id="type"
                            :class="{
                                'bg-gray-200 cursor-not-allowed': isDisabled,
                                'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                            }"
                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                        >
                            <option disabled value="">
                                اختر الحالة العائلية
                            </option>
                            <option value="متزوج">متزوج</option>
                            <option value="عازب">عازب</option>
                            <option value="مطلق">مطلق</option>
                            <option value="أرمل">أرمل</option>
                        </select>
                        <span
                            v-if="form.errors.situation_familiale"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.sexe }}
                        </span>
                    </div>
                    <div>
                        <label
                            for="profession"
                            class="mb-3 block text-sm text-gray-700 font-medium dark:text-white"
                            >{{ $t("adherents.input_profession") }}</label
                        >
                        <input
                            :class="{
                                'bg-gray-200 cursor-not-allowed': isDisabled,
                                'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                            }"
                            :disabled="isDisabled"
                            v-model="form.profession"
                            type="profession"
                            name="profession"
                            id="profession"
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

                <!-- Grid -->

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                    <div>
                        <label
                            for="tel"
                            class="mb-3 block text-sm text-gray-700 font-medium dark:text-white"
                            >{{ $t("adherents.input_telephone") }}</label
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
                            class="mb-3 block text-sm text-gray-700 font-medium dark:text-white"
                            >{{ $t("adherents.input_email") }}</label
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
                            class="mb-3 block text-sm text-gray-700 font-medium dark:text-white"
                            >{{ $t("adherents.input_date_naissance") }}
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
                            class="mb-3 block text-sm text-gray-700 font-medium dark:text-white"
                            >{{ $t("adherents.input_date_adhesion") }}
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
                        class="mb-3 block text-sm text-gray-700 font-medium dark:text-white"
                        >{{ $t("adherents.input_addresse") }}</label
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
                            class="mb-3 block text-sm text-gray-700 font-medium dark:text-white"
                            >{{ $t("adherents.input_region") }}</label
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
                            class="mb-3 block text-sm text-gray-700 font-medium dark:text-white"
                            >{{ $t("adherents.input_ville") }}</label
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
                                :key="city.id"
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
            <!-- <div class="mt-4">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input :clss="ass="{ 'bg-gray-200 cursor-not-allowed':
                    isDisabmb-3 led, 'dark:bg-slate-900 dark:border-gray-700
                    dark:text-gray-400': true, }" :disabled="isDisabled"
                    type="checkbox" value="" class="sr-only peer"
                    v-model="form.is_actif" :checked="form.is_actif" />
                    <div
                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"
                    ></div>
                    <span
                        class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                        >Statut d'adhésion
                    </span>
                </label>
            </div> -->

            <div class="mt-6 flex justify-start">
                <button
                    :class="{
                        'bg-gray-500 cursor-not-allowed': isDisabled,
                        'dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400': true,
                    }"
                    :disabled="isDisabled"
                    type="submit"
                    class="inline-flex mr-4 justify-center items-center gap-x-3 text-center bg-blue-600 hover:bg-blue-700 border border-transparent text-sm lg:text-base text-white font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-white transition py-3 px-4 dark:focus:ring-offset-gray-800"
                >
                    <ContentSave />
                    {{ $t("buttons.enregistrer") }}
                </button>
                <button
                    type="button"
                    @click="toggleDisabled"
                    class="inline-flex justify-center items-center gap-x-3 text-center text-sm text-blue-700 font-medium rounded-md transition py-3 px-4 dark:focus:ring-offset-gray-800"
                >
                    <Pencil />
                </button>
            </div>
        </form>
        <div class="" v-show="false">
            <div id="card" class="py-4 rounded-lg border border-cyan-950">
                <img
                    :src="showImage() + adherent.image"
                    class="h-16 w-16 rounded-full"
                    alt="Profile Image"
                />

                <div class="my-2 h-10 bg-blue-900 w-full my-div"></div>

                <div class="flex justify-between items-start px-2">
                    <div>
                        <p class="text-slate-600 text-2xl">
                            Prénom:
                            <span class="text-black font-bold">{{
                                adherent.first_name
                            }}</span>
                        </p>
                        <p class="text-slate-600 text-2xl">
                            Nom:
                            <span class="text-black font-bold">{{
                                adherent.last_name
                            }}</span>
                        </p>
                        <p class="text-slate-600 text-2xl">
                            CIN:
                            <span class="text-black font-bold">{{
                                adherent.cin
                            }}</span>
                        </p>
                        <p class="text-slate-600 text-2xl">
                            Téléphone:
                            <span class="text-black font-bold">{{
                                adherent.tel
                            }}</span>
                        </p>
                    </div>
                    <div>
                        <p class="text-slate-600 text-2xl">
                            Date de naissance:
                            <span class="text-black font-bold">{{
                                adherent.date_of_birth
                            }}</span>
                        </p>
                        <p class="text-slate-600 text-2xl">
                            Date d'inscription:
                            <span class="text-black font-bold">{{
                                adherent.date_of_membership
                            }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 bg-white rounded-md pt-4">
        <h3 class="mb-2 px-4 text-xl font-bold text-slate-800 uppercase">
            {{ $t("adherents.adherent_activities") }}
        </h3>
        <div class="mt-4">
            <vue-good-table
                :columns="columns"
                :rows="rows"
                :pagination-options="{
                    enabled: true,
                    mode: 'records',
                    perPage: 5,
                    perPageDropdown: [5, 10, 20],
                }"
                :search-options="{
                    enabled: true,
                    placeholder: $t('adherents.table_search'),
                }"
            >
            </vue-good-table>
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
import { VueGoodTable } from "vue-good-table-next";
import "vue-good-table-next/dist/vue-good-table-next.css";
import regionsFile from "../../regions.json";
import { useForm, Link, router } from "@inertiajs/vue3";
import printJS from "print-js";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { useI18n } from "vue-i18n";
import ArrowRight from "vue-material-design-icons/ArrowRight.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";
import Pencil from "vue-material-design-icons/Pencil.vue";
import ContentSave from "vue-material-design-icons/ContentSave.vue";

const { t, availableLocales, locale } = useI18n();

const $toast = useToast();
const regions = ref(regionsFile);

const props = defineProps({
    adherent: {
        type: Object,
        default: () => ({}),
    },
});
const isDisabled = ref(true);

const form = useForm({
    id: props.adherent.id,
    first_name: props.adherent.first_name,
    last_name: props.adherent.last_name,
    image: props.adherent.last_name,
    email: props.adherent.email,
    date_of_birth: props.adherent.date_of_birth,
    date_of_membership: props.adherent.date_of_birth,
    sexe: props.adherent.sexe,
    cin: props.adherent.cin,
    address: props.adherent.address,
    tel: props.adherent.tel,
    region: props.adherent.region,
    city: props.adherent.city,
    is_actif: props.adherent.is_actif,
    situation_familiale: props.adherent.situation_familiale,
    profession: props.adherent.profession,
});

const columns = ref([
    {
        label: "#",
        field: "id",
    },
    {
        label: t("activities.table_nom"),
        field: "title",
    },
    {
        label: t("activities.table_date_debut"),
        field: "start",
    },
    {
        label: t("activities.input_date_fin"),
        field: "end",
    },
    {
        label: t("activities.input_lieu"),
        field: "location",
    },
]);

const rows = computed(() =>
    Object.values(props.adherent.activities).map((activity) => ({
        id: activity.id,
        title: activity.title,
        start: activity.start,
        end: activity.end,
        location: activity.location,
    }))
);

const toggleDisabled = () => {
    isDisabled.value = !isDisabled.value;
};

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
    // form.put(route("adherents.update", props.adherent.id), {
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
    router.post(`/adherents/${props.adherent.id}`, {
        _method: "put",
        headers: {
            "Content-Type": "multipart/form-data",
        },
        id: props.adherent.id,
        first_name: props.adherent.first_name,
        last_name: props.adherent.last_name,
        image: props.adherent.last_name,
        email: props.adherent.email,
        date_of_birth: props.adherent.date_of_birth,
        date_of_membership: props.adherent.date_of_birth,
        sexe: props.adherent.sexe,
        cin: props.adherent.cin,
        address: props.adherent.address,
        tel: props.adherent.tel,
        region: props.adherent.region,
        city: props.adherent.city,
        is_actif: props.adherent.is_actif,
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
