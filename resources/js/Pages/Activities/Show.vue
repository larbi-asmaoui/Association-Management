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
import Multiselect from "@vueform/multiselect";
import regionsFile from "../../regions.json";
import { useI18n } from "vue-i18n";
import ArrowRight from "vue-material-design-icons/ArrowRight.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";
import { VueGoodTable } from "vue-good-table-next";
import "vue-good-table-next/dist/vue-good-table-next.css";

const { t } = useI18n();

const $toast = useToast();
const isEnabled = ref(false);
const regions = ref(regionsFile);

const props = defineProps({
    activity: {
        type: Object,
    },
    activityTypes: {
        type: Object,
    },
    adherents: {
        type: Object,
    },
});

const columns = ref([
    {
        label: "#",
        field: "id",
    },
    {
        label: t("adherents.table_nom_complete"),
        field: "nom_complet",
    },
    {
        label: t("adherents.table_cin"),
        field: "cin",
    },

    // {
    //     label: t("activities.table_actions"),
    //     field: "actions",
    // },
]);
const rows = computed(() =>
    Object.values(props.activity.adherents).map((adherent) => ({
        id: adherent.id,
        nom_complet: adherent.first_name + " " + adherent.last_name,
        cin: adherent.cin ?? "-",
    }))
);

const toggleEnabled = () => {
    isEnabled.value = !isEnabled.value;
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

const form = useForm({
    id: props.activity.id,
    title: props.activity.title,
    description: props.activity.description,
    start: props.activity.start,
    end: props.activity.end,
    location: props.activity.location,
    city: props.activity.city,
    region: props.activity.region,
    depense: props.activity.depense,
    revenue: props.activity.revenue,
    activity_type_id: props.activity.activity_type_id,
    adherents: props.activity.adherents.map((adherent) => adherent.id),
});

const submit = () => {
    form.put(route("activities.update", props.activity.id), {
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
                message: "Activité modifié avec succès",
                type: "success",
                dismissible: true,
                duration: 3000,
            });
        },
    });
};

const formattedAdherents = computed(() =>
    Object.values(props.adherents).map((adherent) => ({
        value: adherent.id,
        label: adherent.last_name + " " + adherent.first_name,
    }))
);
</script>
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
            {{ $t("activities.details_activite") }}
        </h1>
    </div>
    <div class="bg-white px-4 py-6 shadow-md">
        <form @submit.prevent="submit">
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">
                    <label
                        for="name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("activities.input_nom") }}</label
                    >
                    <input
                        :disabled="!isEnabled"
                        :class="{
                            'bg-slate-100 cursor-not-allowed': !isEnabled,
                        }"
                        type="text"
                        name="name"
                        id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="titre de l'Activité"
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
                        >{{ $t("activities.input_date_debut") }}</label
                    >

                    <input
                        :disabled="!isEnabled"
                        :class="{
                            'bg-slate-100 cursor-not-allowed': !isEnabled,
                        }"
                        lang="fr-CA"
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
                        >{{ $t("activities.input_date_fin") }}</label
                    >

                    <input
                        :disabled="!isEnabled"
                        :class="{
                            'bg-slate-100 cursor-not-allowed': !isEnabled,
                        }"
                        lang="fr-CA"
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
                            >{{ $t("activities.input_type") }}</label
                        >
                        <select
                            :disabled="!isEnabled"
                            :class="{
                                'bg-slate-100 cursor-not-allowed': !isEnabled,
                            }"
                            v-model="form.activity_type_id"
                            id="type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        >
                            <option
                                v-for="activityType in activityTypes"
                                :key="activityType.id"
                                :value="activityType.id"
                                class="bg-white :bg-gray-800 py-2.5 px-4 cursor-pointer hover:bg-gray-200 :hover:bg-gray-700"
                            >
                                {{ activityType.name }}
                            </option>
                        </select>
                        <span
                            v-if="form.errors.activity_type_id"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.activity_type_id }}
                        </span>
                    </div>
                    <div class="w-full">
                        <label
                            for="revenue"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >{{
                                $t("activities.input_revenus_activite")
                            }}</label
                        >
                        <input
                            :disabled="!isEnabled"
                            :class="{
                                'bg-slate-100 cursor-not-allowed': !isEnabled,
                            }"
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
                            >{{
                                $t("activities.input_depenses_activite")
                            }}</label
                        >
                        <input
                            :disabled="!isEnabled"
                            :class="{
                                'bg-slate-100 cursor-not-allowed': !isEnabled,
                            }"
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
                            >{{ $t("activities.input_lieu") }}</label
                        >
                        <input
                            :disabled="!isEnabled"
                            :class="{
                                'bg-slate-100 cursor-not-allowed': !isEnabled,
                            }"
                            v-model="form.location"
                            type="text"
                            name="lieu"
                            id="lieu"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="lieu de l'Activité"
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
                            >{{ $t("activities.input_region") }}</label
                        >
                        <select
                            :disabled="!isEnabled"
                            :class="{
                                'bg-slate-100 cursor-not-allowed': !isEnabled,
                            }"
                            v-model="form.region"
                            id="type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        >
                            <option disabled value="">اختر جهة</option>
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
                            >{{ $t("activities.input_ville") }}</label
                        >
                        <select
                            :disabled="!isEnabled"
                            :class="{
                                'bg-slate-100 cursor-not-allowed': !isEnabled,
                            }"
                            v-model="form.city"
                            id="type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        >
                            <option disabled value="">اختر مدينة</option>
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
                <div class="sm:col-span-2">
                    <label
                        for="description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >{{ $t("activities.input_description") }}</label
                    >
                    <textarea
                        :disabled="!isEnabled"
                        :class="{
                            'bg-slate-100 cursor-not-allowed': !isEnabled,
                        }"
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
                <div class="sm:col-span-2">
                    <label
                        for="adherents"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("activities.input_adherents") }}</label
                    >
                    <Multiselect
                        :disabled="!isEnabled"
                        :class="{
                            'bg-slate-100 cursor-not-allowed': !isEnabled,
                        }"
                        v-model="form.adherents"
                        mode="tags"
                        :close-on-select="false"
                        :searchable="true"
                        :create-option="true"
                        :options="formattedAdherents"
                    />
                </div>
            </div>

            <div class="col-span-6 sm:col-full mt-4">
                <button
                    class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="submit"
                >
                    {{ $t("buttons.enregistrer") }}
                </button>
                <span class="ml-4"></span>
                <button
                    @click="toggleEnabled"
                    class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button"
                >
                    {{ $t("buttons.modifier") }}
                </button>
            </div>
        </form>
    </div>

    <div class="mt-4 bg-white rounded-md pt-4">
        <h3 class="mb-2 px-4 text-xl font-bold text-slate-800 uppercase">
            {{ $t("activities.liste_participants") }}
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
<style src="@vueform/multiselect/themes/default.css"></style>
