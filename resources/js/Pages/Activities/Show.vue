<script>
import RootLayout from "../../Layouts/RootLayout.vue";
export default {
    layout: RootLayout,
};
</script>
<script setup>
import Swal from "sweetalert2";
import { useForm, Link, usePage } from "@inertiajs/vue3";
import { ref, computed, reactive, watchEffect, onMounted } from "vue";
import { jsPDF } from "jspdf";
import html2canvas from "html2canvas";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import Multiselect from "@vueform/multiselect";
import regionsFile from "../../regions.json";
import { useI18n } from "vue-i18n";
import ArrowRight from "vue-material-design-icons/ArrowRight.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";
import Printer from "vue-material-design-icons/Printer.vue";
import { VueGoodTable } from "vue-good-table-next";
import "vue-good-table-next/dist/vue-good-table-next.css";
import Quill from "quill";
import autoTable from "jspdf-autotable";
import "quill/dist/quill.snow.css";

const { t } = useI18n();

const page = usePage();

const pageSize = ref(10);

const $toast = useToast();
const isEnabled = ref(false);
const regions = ref(regionsFile);

const editor = ref(null);
const editorClass = ref(
    "block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500",
);
let quill;

onMounted(() => {
    quill = new Quill(editor.value, {
        theme: "snow",
        direction: {
            // this will apply the RTL layout
            default: "rtl",
            // handler that switches between rtl and ltr text directions
            buttonHTML: '<i class="icon name"></i>',
            tooltip: "Change text direction",
        },

        modules: {
            toolbar: [
                ["bold", "italic", "underline", "strike"],
                ["blockquote"],
                [{ header: 1 }, { header: 2 }],
                // [{ list: "ordered" }, { list: "bullet" }],
                [{ indent: "-1" }, { indent: "+1" }],
                [{ size: ["small", false, "large", "huge"] }],
                [{ header: [1, 2, 3, 4, false] }],
                [{ align: [] }],
                ["direction"],
            ],
        },
    });

    quill.clipboard.dangerouslyPasteHTML(form.description);

    quill.on("text-change", () => {
        form.description = quill.root.innerHTML;
    });
});

function enableEditor() {
    // isEnabled.value = true;
    editorClass.value += " bg-slate-100 cursor-not-allowed";
}

function disableEditor() {
    // isEnabled.value = false;
    editorClass.value = editorClass.value.replace(
        " bg-slate-100 cursor-not-allowed",
        "",
    );
}

const printAttendanceList = () => {
    const doc = new jsPDF();

    if (props.activity.adherents.length === 0) {
        Swal.fire({
            icon: "error",
            text: "لا يوجد مشاركين في هذا النشاط",
            showConfirmButton: false,
            timer: 1500,
        });
        return;
    }

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
            20,
        );
    }

    doc.setFontSize(14);
    const title = t("activities.liste_participants");
    const titleWidth = doc.getTextWidth(title);
    const titleX = (pageWidth - titleWidth) / 2;
    doc.text(title, titleX, 30);

    doc.setFontSize(25);
    const activityName = props.activity.title;
    const activityNameWidth = doc.getTextWidth(activityName);
    const activityNameX = (pageWidth - activityNameWidth) / 2;
    doc.text(activityName, activityNameX, 42);

    doc.setFontSize(12);
    const activityType = props.activity.activity_type.name;
    const activityTypeWidth = doc.getTextWidth(activityType);
    const activityTypeX = (pageWidth - activityTypeWidth) / 2;
    doc.text(activityType, activityTypeX, 50);

    doc.setFontSize(12);
    // const activityDate = props.activity.start_date;
    // const activityDateWidth = doc.getTextWidth(activityDate);
    // const activityDateX = (pageWidth - activityDateWidth) / 2;
    // doc.text(activityDate, activityDateX, 58);
    doc.line(0, 65, 400, 65);

    const headers = [
        t("adherents.table_telephone"),
        t("adherents.table_cin"),
        t("adherents.table_nom_complete"),
        "#",
    ];

    const data = props.activity.adherents.map((adherent, index) => [
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
    const docTitle = "participants_list_" + props.activity.title + ".pdf";

    doc.save(docTitle);
};

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

const columns = computed(() => [
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
        title: t("adherents.table_nom_complete"),
        dataIndex: "nom_complet",
        key: "nom_complet",
        sorter: {
            compare: (a, b) => a.nom_complet.localeCompare(b.nom_complet),
        },
        multipe: 1,
    },
    {
        title: t("adherents.table_cin"),
        dataIndex: "cin",
        key: "cin",
        sorter: {
            compare: (a, b) => a.cin.localeCompare(b.cin),
        },
        multipe: 1,
    },
]);
const rows = computed(() =>
    Object.values(props.activity.adherents).map((adherent) => ({
        id: adherent.id,
        nom_complet: adherent.first_name + " " + adherent.last_name,
        cin: adherent.cin ?? "-",
    })),
);

const toggleEnabled = () => {
    isEnabled.value = !isEnabled.value;
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
        },
    });
};

const formattedAdherents = computed(() =>
    Object.values(props.adherents).map((adherent) => ({
        value: adherent.id,
        label: adherent.last_name + " " + adherent.first_name,
    })),
);

const generatePDF = async () => {
    const element = document.getElementById("editor");
    const canvas = await html2canvas(element);
    const imgData = canvas.toDataURL("image/png");
    let pdf = new jsPDF();
    let imgProps = pdf.getImageProperties(imgData);
    let pdfWidth = pdf.internal.pageSize.getWidth();
    let pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
    pdf.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);
    pdf.save("activite_description.pdf");
};
</script>

<style scoped>
#editor {
    height: 200px;
}
</style>
<template>
    <div class="inline-flex items-center mb-5">
        <Link
            :href="route('activities.index')"
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
                    <div ref="editor" id="editor"></div>

                    <!-- <textarea
                        :disabled="!isEnabled"
                        :class="{
                            'bg-slate-100 cursor-not-allowed': !isEnabled,
                        }"
                        id="description"
                        rows="8"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        v-model="form.description"
                    ></textarea> -->
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
                <span class="ml-4"></span>
                <button
                    @click="generatePDF"
                    class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button"
                >
                    طباعة الوصف
                </button>
            </div>
        </form>
    </div>

    <div class="w-auto h-full py-2 px-2 mt-5">
        <h2
            class="text-xl font-semibold text-black-600 mb-2"
            :class="$i18n.locale === 'ar' ? 'text-right' : 'text-left'"
        >
            {{ $t("activities.liste_participants") }}
        </h2>

        <div
            class="py-3 justify-between items-center block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
        >
            <el-button
                class="me-auto"
                type="primary"
                size="large"
                @click="printAttendanceList"
            >
                <Printer />
            </el-button>
        </div>
        <a-config-provider :direction="$i18n.locale === 'ar' ? 'rtl' : 'ltr'">
            <a-table
                :columns="columns"
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
<style src="@vueform/multiselect/themes/default.css"></style>
