<template>
    <div class="inline-flex items-center mb-5">
        <Link
            :href="route('reunions.index')"
            class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white"
        >
            <ArrowRight v-if="$i18n.locale === 'ar'" />
            <ArrowLeft v-else />
        </Link>
    </div>
    <div class="mb-4 bg-blue-600 px-4 py-4 shadow-md">
        <h1 class="text-xl font-semibold text-white sm:text-2xl">
            {{ $t("reunions.details_reunion") }}
        </h1>
    </div>

    <div class="grid grid-cols-1 pt-2 xl:grid-cols-3 xl:gap-4">
        <div class="col-span-full xl:col-auto">
            <div
                class="mb-4 px-2 py-3 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800"
            >
                <div
                    class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4"
                >
                    <h3 class="mb-2 text-xl font-bold text-slate-800 uppercase">
                        {{ $t("reunions.modifier_reunion_details") }}
                    </h3>
                    <form @submit.prevent="submit">
                        <div class="col-span-6 sm:col-span-3 mb-3">
                            <label
                                for="name"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >{{ $t("a-propos.input_nom") }}</label
                            >
                            <input
                                v-model="form.name"
                                :disabled="!isEnabled"
                                :class="{
                                    'bg-slate-100 cursor-not-allowed':
                                        !isEnabled,
                                }"
                                type="text"
                                name="name"
                                id="name"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-3 mb-3">
                            <label
                                for="description"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >{{ $t("reunions.input_description") }}</label
                            >
                            <textarea
                                v-model="form.description"
                                :disabled="!isEnabled"
                                :class="{
                                    'bg-slate-100 cursor-not-allowed':
                                        !isEnabled,
                                }"
                                name="description"
                                id="description"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            ></textarea>
                        </div>
                        <div class="col-span-6 sm:col-span-3 mb-3">
                            <label
                                for="name"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >{{ $t("reunions.input_date") }}</label
                            >
                            <input
                                v-model="form.date"
                                :disabled="!isEnabled"
                                :class="{
                                    'bg-slate-100 cursor-not-allowed':
                                        !isEnabled,
                                }"
                                type="date"
                                name="name"
                                id="name"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-3 mb-3">
                            <label
                                for="type"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >{{ $t("reunions.input_type") }}</label
                            >
                            <select
                                :disabled="!isEnabled"
                                :class="{
                                    'bg-slate-100 cursor-not-allowed':
                                        !isEnabled,
                                }"
                                v-model="form.reunion_type_id"
                                id="type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            >
                                <option
                                    v-for="reunionType in reunionTypes"
                                    :key="reunionType.id"
                                    :value="reunionType.id"
                                    class="bg-white :bg-gray-800 py-2.5 px-4 cursor-pointer hover:bg-gray-200 :hover:bg-gray-700"
                                >
                                    {{ reunionType.name }}
                                </option>
                            </select>
                            <span
                                v-if="form.errors.reunion_type_id"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.reunion_type_id }}
                            </span>
                        </div>
                        <div class="col-span-6 sm:col-span-3 mb-3">
                            <label
                                for="type"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >{{ $t("reunions.input_adherents") }}</label
                            >
                            <Multiselect
                                :disabled="!isEnabled"
                                :class="{
                                    'bg-slate-100 cursor-not-allowed':
                                        !isEnabled,
                                }"
                                v-model="form.adherents"
                                mode="tags"
                                :close-on-select="false"
                                :searchable="true"
                                :create-option="true"
                                :options="formattedAdherents"
                            />
                        </div>

                        <div
                            class="col-span-6 sm:col-full flex justify-start items-center mt-4"
                        >
                            <button
                                @click="toggleEnabled"
                                class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                type="button"
                            >
                                <Pencil />
                            </button>
                            <span class="ml-4"></span>
                            <button
                                v-show="isEnabled"
                                class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                type="submit"
                            >
                                {{ $t("buttons.enregistrer") }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-span-2">
            <div
                class="bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2"
            >
                <div class="flex mb-4 p-4">
                    <h3 class="text-xl font-semibold uppercase text-slate-800">
                        {{ $t("reunions.input_adherents") }}
                    </h3>
                    <button
                        @click="printAttendanceList"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full mr-auto"
                    >
                        <Printer :size="22" />
                    </button>
                </div>
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
        </div>
    </div>
</template>
<script setup>
import autoTable from "jspdf-autotable";
import { useForm, Link, usePage } from "@inertiajs/vue3";
import { ref, computed, reactive, watchEffect } from "vue";
import jsPDF from "jspdf";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import Multiselect from "@vueform/multiselect";
import { useI18n } from "vue-i18n";
import { VueGoodTable } from "vue-good-table-next";
import "vue-good-table-next/dist/vue-good-table-next.css";
import ArrowRight from "vue-material-design-icons/ArrowRight.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";
import Printer from "vue-material-design-icons/Printer.vue";
import Pencil from "vue-material-design-icons/Pencil.vue";

const $toast = useToast();
const { t } = useI18n();
const isEnabled = ref(false);
const props = defineProps({
    reunion: {
        type: Object,
        default: () => ({}),
    },
    reunionTypes: {
        type: Object,
        default: () => ({}),
    },
    adherents: {
        type: Object,
        default: () => ({}),
    },
});

const page = usePage();

const form = useForm({
    id: props.reunion.id,
    name: props.reunion.name,
    description: props.reunion.description,
    reunion_type_id: props.reunion.reunion_type_id,
    date: props.reunion.date,
    adherents: props.reunion.adherents.map((adherent) => adherent.id),
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
    {
        label: t("adherents.table_telephone"),
        field: "tel",
    },

    // {
    //     label: t("activities.table_actions"),
    //     field: "actions",
    // },
]);
const rows = computed(() =>
    Object.values(props.reunion.adherents).map((adherent) => ({
        id: adherent.id,
        nom_complet: adherent.first_name + " " + adherent.last_name,
        cin: adherent.cin ?? "-",
        tel: adherent.tel ?? "-",
    }))
);

const toggleEnabled = () => {
    isEnabled.value = !isEnabled.value;
};

const formattedAdherents = computed(() =>
    Object.values(props.adherents).map((adherent) => ({
        value: adherent.id,
        label: adherent.last_name + " " + adherent.first_name,
    }))
);

const submit = () => {
    form.put(route("reunions.update", props.reunion.id), {
        onError: () => {
            $toast.open({
                message: t("toasts.modif_error"),
                type: "error",
                dismissible: true,
                duration: 3000,
            });
        },
        onSuccess: () => {
            $toast.open({
                message: t("toasts.modif_success"),
                type: "success",
                dismissible: true,
                duration: 3000,
            });
            isEnabled.value = false;
        },
    });
};

const printAttendanceList = () => {
    const doc = new jsPDF();

    // Step 1: Load the Arabic font file
    const arabicFontFile = "/fonts/Amiri-Regular.ttf";
    const arabicFontName = "Amiri";

    doc.addFont(arabicFontFile, arabicFontName, "normal");

    doc.setFont(arabicFontName);

    const pageWidth = doc.internal.pageSize.getWidth();
    if (page.props.auth.association !== null) {
        // Add the image to the PDF
        doc.addImage(
            "/storage/" + page.props.auth.association.image,
            "JPEG",
            (pageWidth - 20) / 2,
            2,
            20,
            20
        );
    }

    doc.setFontSize(14);
    const title = t("reunions.doc_title_adherents");
    const titleWidth = doc.getTextWidth(title);
    const titleX = (pageWidth - titleWidth) / 2;
    doc.text(title, titleX, 30);

    doc.setFontSize(25);
    const reunionName = props.reunion.name;
    const reunionNameWidth = doc.getTextWidth(reunionName);
    const reunionNameX = (pageWidth - reunionNameWidth) / 2;
    doc.text(reunionName, reunionNameX, 42);

    doc.setFontSize(12);
    const reunionType = props.reunion.reunion_type.name;
    const reunionTypeWidth = doc.getTextWidth(reunionType);
    const reunionTypeX = (pageWidth - reunionTypeWidth) / 2;
    doc.text(reunionType, reunionTypeX, 50);

    doc.setFontSize(12);
    const reunionDate = props.reunion.date;
    const reunionDateWidth = doc.getTextWidth(reunionDate);
    const reunionDateX = (pageWidth - reunionDateWidth) / 2;
    doc.text(reunionDate, reunionDateX, 58);
    doc.line(0, 65, 400, 65);

    const headers = [
        t("adherents.table_telephone"),
        t("adherents.table_cin"),
        t("adherents.table_nom_complete"),
        "#",
    ];

    const data = props.reunion.adherents.map((adherent, index) => [
        adherent.tel,
        adherent.cin,
        adherent.first_name + " " + adherent.last_name,
        index + 1,
    ]);

    doc.autoTable({
        margin: { top: 70 },
        theme: "grid",
        head: [headers],
        body: data,
        styles: {
            font: arabicFontName,
            halign: "center",
        },
        headStyles: {
            valign: "middle",
            halign: "center",
        },
    });
    doc.save("AttendanceList.pdf");
};
</script>

<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
