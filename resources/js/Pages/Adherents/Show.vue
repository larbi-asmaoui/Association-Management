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

    <div class="bg-white px-4 py-6 shadow-md rounded-md">
        <form @submit.prevent="submit" enctype="multipart/form-data">
            <div class="mt-4 grid gap-4 lg:gap-6">
                <div class="col-span-full mb-5">
                    <label
                        for="photo"
                        class="mb-3 block text-sm font-medium leading-6 text-gray-900"
                        >{{ $t("adherents.input_image") }}</label
                    >
                    <div class="mt-2 flex items-start flex-col gap-y-3">
                        <div
                            class="flex items-center justify-center h-32 w-32 rounded-full border-2 border-black-600"
                        >
                            <img
                                :src="showImage() + adherent.image"
                                class="object-cover h-32 w-32 rounded-full"
                                alt=""
                            />
                        </div>

                        <input
                            @change="onFileChange"
                            v-show="!isDisabled"
                            type="file"
                            name=""
                            accept="image/*"
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

    <div class="w-auto h-full py-2 px-2 mt-5 bg-white p-2 rounded-md">
        <h2
            class="text-xl font-semibold text-black-600 mb-2"
            :class="$i18n.locale === 'ar' ? 'text-right' : 'text-left'"
        >
            {{ $t("adherents.adherent_activities") }}
        </h2>

        <div
            class="py-3 justify-between items-center block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
        >
            <!-- <el-button
                class="me-auto"
                type="primary"
                size="large"
                @click="printAttendanceList"
            >
                <Printer />
            </el-button> -->
        </div>
        <a-config-provider :direction="$i18n.locale === 'ar' ? 'rtl' : 'ltr'">
            <a-table
                :columns="columns2"
                :data-source="rows"
                :pagination="{
                    pageSize: pageSize.value,
                    showSizeChanger: true,
                    pageSizeOptions: ['10', '20', '30', '40'],
                }"
            >
            </a-table>
        </a-config-provider>
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
import Toast from "../../utils.js";

const { t, availableLocales, locale } = useI18n();

const pageSize = ref(10);

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
    date_of_membership: props.adherent.date_of_membership,
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

const columns2 = computed(() => [
    {
        title: "#",
        dataIndex: "id",
        key: "id",
        sorter: {
            compare: (a, b) => a.id - b.id,
        },
        multipe: 1,
    },

    {
        title: t("activities.table_nom"),
        dataIndex: "title",
        key: "title",
        sorter: {
            compare: (a, b) => a.title.localeCompare(b.title),
        },
        multipe: 1,
    },

    {
        title: t("activities.table_date_debut"),
        dataIndex: "start",
        key: "start",
        sorter: {
            compare: (a, b) => a.start.localeCompare(b.start),
        },
    },
    {
        title: t("activities.input_date_fin"),
        dataIndex: "end",
        key: "end",
        sorter: {
            compare: (a, b) => a.end.localeCompare(b.end),
        },
    },
    {
        title: t("activities.input_lieu"),
        dataIndex: "location",
        key: "location",
        sorter: {
            compare: (a, b) => a.location.localeCompare(b.location),
        },
    },
]);

const rows = computed(() =>
    Object.values(props.adherent.activities).map((activity) => ({
        id: activity.id,
        title: activity.title,
        start: activity.start,
        end: activity.end,
        location: activity.location,
    })),
);

const toggleDisabled = () => {
    isDisabled.value = !isDisabled.value;
};

const filteredCities = computed(() => {
    if (form.region) {
        const regionData = regions.value.find(
            (region) => region.name === form.region,
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

const onFileChange = (e) => {
    const file = e.target.files[0];
    if (!file) {
        return;
    }
    form.image = file;
};

const submit = () => {
    router.post(
        `/adherents/${props.adherent.id}`,
        {
            _method: "put",
            headers: {
                "Content-Type": "multipart/form-data",
            },
            id: form.id,
            first_name: form.first_name,
            last_name: form.last_name,
            image: form.image,
            email: form.email,
            date_of_birth: form.date_of_birth,
            date_of_membership: form.date_of_membership,
            sexe: form.sexe,
            cin: form.cin,
            address: form.address,
            tel: form.tel,
            region: form.region,
            city: form.city,
            is_actif: form.is_actif,
            situation_familiale: form.situation_familiale,
            profession: form.profession,
            // preserveScroll: true,
        },
        {
            onSuccess: () => {
                Toast.fire({
                    icon: "success",
                    title: t("toasts.modif_success"),
                });
                isDisabled.value = true;
            },
            onError: () => {
                Toast.fire({
                    icon: "error",
                    title: t("toasts.modif_error"),
                });
            },
        },
    );
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
