<template>
    <a-modal
        @cancel="closeModal"
        :footer="null"
        v-model:open="isModalOpen"
        :title="$t('activities.modal_ajouter')"
    >
        <form
            :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
            class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2 overflow-y-auto max-h-[30rem]"
            @submit.prevent="submit"
        >
            <div>
                <label
                    for="title"
                    class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                    >{{ $t("activities.input_nom") }}</label
                >
                <input
                    v-model="form.title"
                    type="text"
                    name="title"
                    id="title"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    required
                />
                <span
                    v-if="form.errors.title"
                    class="text-xs text-red-600 mt-1"
                    id="hs-validation-name-error-helper"
                >
                    {{ form.errors.title }}
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label
                        for="start"
                        class="block text-sm text-gray-700 font-medium dark:text-white"
                        >{{ $t("activities.input_date_debut") }}
                    </label>

                    <input
                        v-model="form.start"
                        type="date"
                        class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700"
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
                <!--  -->
                <div>
                    <label
                        for="end"
                        class="block text-sm text-gray-700 font-medium dark:text-white"
                        >{{ $t("activities.input_date_fin") }}
                    </label>

                    <input
                        v-model="form.end"
                        type="date"
                        class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700"
                        placeholder="Select date"
                        name="end"
                    />
                    <span
                        v-if="form.errors.end"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.end }}
                    </span>
                </div>
            </div>
            <div>
                <label
                    for="type"
                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                    >{{ $t("activities.input_type") }}
                </label>
                <select
                    v-model="form.activity_type_id"
                    id="evenment_type_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-blue-500 :focus:border-blue-500 appearance-none select-none relative z-10"
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
            <!-- ************************************** -->
            <!-- <div>
                            <label
                                for="adherents"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >{{ $t("activities.input_adherents") }}</label
                            >
                            <Multiselect
                                v-model="form.adherents"
                                mode="tags"
                                :close-on-select="false"
                                :searchable="true"
                                :create-option="true"
                                :options="formattedAdherents"
                            />
                        </div> -->
            <!-- **********  Select  ********** -->

            <div>
                <label
                    for="location"
                    class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                    >{{ $t("activities.input_lieu") }}</label
                >
                <input
                    v-model="form.location"
                    type="text"
                    name="location"
                    id="location"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    required
                />
                <span
                    v-if="form.errors.location"
                    class="text-xs text-red-600 mt-1"
                    id="hs-validation-name-error-helper"
                >
                    {{ form.errors.location }}
                </span>
            </div>
            <div>
                <label
                    for="type"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >{{ $t("activities.input_region") }}</label
                >
                <select
                    v-model="form.region"
                    id="type"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                >
                    <option disabled value="">Séléctionner région</option>
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
                    for="type"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >{{ $t("activities.input_ville") }}</label
                >
                <select
                    v-model="form.city"
                    id="type"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                >
                    <option disabled value="">Séléctionner ville</option>
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

            <div class="mt-5 flex justify-end gap-x-2">
                <button
                    @click="isModalOpen = false"
                    type="button"
                    class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:hover:text-white dark:focus:ring-offset-gray-800"
                >
                    {{ $t("buttons.annuler") }}
                </button>
                <button
                    type="submit"
                    class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800"
                >
                    {{ $t("buttons.enregistrer") }}
                </button>
            </div>
        </form>
    </a-modal>

    <div class="w-auto h-full py-4 px-2">
        <h2
            class="text-xl font-semibold text-black-600 mb-4"
            :class="$i18n.locale === 'ar' ? 'text-right' : 'text-left'"
        >
            {{ $t("activities.titre") }}
        </h2>

        <div
            class="gap-2 py-1 mb-2 justify-between items-center block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
        >
            <el-button
                class="me-auto"
                type="primary"
                size="large"
                @click="isModalOpen = true"
            >
                <Plus />
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
                <template v-slot:action="{ record }">
                    <el-button type="primary" size="small" @click="show(record)"
                        ><Eye />
                    </el-button>
                    <span class="me-2"></span>
                    <el-button
                        type="info"
                        size="small"
                        @click="generatePDF(record.id)"
                        ><Printer />
                    </el-button>
                    <span class="me-2"></span>
                    <el-button
                        type="danger"
                        size="small"
                        @click="destroy(record)"
                        ><TrashCan
                    /></el-button>
                </template>
            </a-table>
        </a-config-provider>
    </div>
</template>

<style src="@vueform/multiselect/themes/default.css"></style>

<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
    data() {
        return {
            value: null,
        };
    },
};
</script>

<script setup>
import html2pdf from "html2pdf.js";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
import Swal from "sweetalert2";
import Multiselect from "@vueform/multiselect";
import { VueGoodTable } from "vue-good-table-next";
import "vue-good-table-next/dist/vue-good-table-next.css";
import { ref, computed } from "vue";
import { Modal } from "flowbite-vue";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import TrashCan from "vue-material-design-icons/TrashCan.vue";
import Eye from "vue-material-design-icons/Eye.vue";
import Plus from "vue-material-design-icons/Plus.vue";
import Printer from "vue-material-design-icons/Printer.vue";
import Toast from "../../utils.js";
import regionsFile from "../../regions.json";
import { useI18n } from "vue-i18n";

const { t } = useI18n();

const props = defineProps({
    activities: {
        type: Object,
        default: () => ({}),
    },
    adherents: {
        type: Object,
        default: () => ({}),
    },

    activityTypes: {
        type: Object,
        default: () => ({}),
    },
});

const pageSize = ref(10);

const columns = computed(() => [
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
        multipe: 1,
    },

    {
        title: t("activities.table_date_fin"),
        dataIndex: "end",
        key: "end",
        sorter: {
            compare: (a, b) => a.end.localeCompare(b.end),
        },
        multipe: 1,
    },
    {
        title: t("adherents.table_actions"),
        dataIndex: "action",
        key: "action",
        slots: { customRender: "action" },
    },
]);

const rows = computed(() =>
    Object.values(props.activities).map((activity) => ({
        id: activity.id,
        title: activity.title,
        start: activity.start,
        end: activity.end,
        adherents: activity.adherents,
    })),
);

const formattedAdherents = computed(() =>
    Object.values(props.adherents).map((adherent) => ({
        value: adherent.id,
        label: adherent.last_name + " " + adherent.first_name,
    })),
);

const regions = ref(regionsFile);

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
    id: "",
    title: "",
    description: "",
    start: "",
    end: "",
    location: "",
    region: "",
    city: "",
    activity_type_id: "",
    adherents: [],
});

const submit = () => {
    //   form.adherents = selectedAdherents.value;
    form.post(route("activities.store"), {
        onError: () => {
            Toast.fire({
                icon: "error",
                title: t("toasts.ajout_error"),
            });
        },
        onSuccess: () => {
            closeModal();
            Toast.fire({
                icon: "success",
                title: t("toasts.ajout_success"),
            });
        },
    });
};

const isModalOpen = ref(false);

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
};

const destroy = (id) => {
    Swal.fire({
        text: t("modals_questions.supprimer"),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: t("buttons.supprimer"),
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route("activities.destroy", id), {
                onError: () => {
                    Toast.fire({
                        icon: "error",
                        title: t("toasts.supp_error"),
                    });
                },
                onSuccess: () => {
                    Toast.fire({
                        icon: "success",
                        title: t("toasts.supp_success"),
                    });
                },
            });
        }
    });
};

const show = (id) => {
    router.get(route("activities.edit", id));
};

const generatePDF = (id) => {
    const activity = props.activities.find((activity) => activity.id === id);
    // alert(activity.revenue);
    const doc = new jsPDF();
    const arabicFontFile = "/fonts/Amiri-Regular.ttf";
    const arabicFontName = "Amiri";

    doc.addFont(arabicFontFile, "Amiri", "normal");
    doc.setFont(arabicFontName);

    const title = t("activities.fiche_activite");

    const pageWidth = doc.internal.pageSize.getWidth();
    const titleWidth =
        (doc.getStringUnitWidth(title) * doc.internal.getFontSize()) /
        doc.internal.scaleFactor;

    const titleX = (pageWidth - titleWidth) / 2;
    doc.setFontSize(16);
    doc.text(title, titleX, 10);

    doc.setFontSize(20);
    const activityTitleWidth =
        (doc.getStringUnitWidth(activity.title) * doc.internal.getFontSize()) /
        doc.internal.scaleFactor;
    const activityTitleX = (pageWidth - activityTitleWidth) / 2;
    doc.text(activity.title, activityTitleX, 25);

    doc.setFontSize(12);
    const dateDebut = t("activities.input_date_debut") + " : " + activity.start;
    const dateFin = t("activities.input_date_fin") + " : " + activity.end;

    const dateDebutWidth =
        (doc.getStringUnitWidth(dateDebut) * doc.internal.getFontSize()) /
        doc.internal.scaleFactor;

    const dateFinWidth =
        (doc.getStringUnitWidth(dateFin) * doc.internal.getFontSize()) /
        doc.internal.scaleFactor;

    const dateDebutX = (pageWidth - dateDebutWidth) / 2;
    const dateFinX = (pageWidth - dateFinWidth) / 2;

    doc.text(dateDebut, dateDebutX, 35);
    doc.text(dateFin, dateFinX, 40);

    const headers = [
        t("activities.input_depenses_activite"),
        t("activities.input_revenus_activite"),
    ];

    const data = [[activity.depense, activity.revenue]];

    doc.autoTable({
        margin: { top: 45, bottom: 200 },
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

    const participants = t("activities.liste_participants");
    const participantsWidth =
        (doc.getStringUnitWidth(participants) * doc.internal.getFontSize()) /
        doc.internal.scaleFactor;
    const participantsX = (pageWidth - participantsWidth) / 2;
    doc.text(participants, participantsX, 65);

    const headers2 = [
        t("adherents.table_telephone"),
        t("adherents.table_cin"),
        t("adherents.table_nom_complete"),
        "#",
    ];

    const data2 = activity.adherents.map((adherent, index) => [
        adherent.tel,
        adherent.cin,
        adherent.first_name + " " + adherent.last_name,
        index + 1,
    ]);

    doc.autoTable({
        margin: { top: 100 },
        theme: "grid",
        head: [headers2],
        body: data2,
        styles: {
            font: arabicFontName,
            halign: "center",
        },
        headStyles: {
            valign: "middle",
            halign: "center",
        },
    });

    doc.setFontSize(18);
    const descriptionTitle = t("activities.input_description");
    const descriptionTitleWidth =
        (doc.getStringUnitWidth(descriptionTitle) *
            doc.internal.getFontSize()) /
        doc.internal.scaleFactor;
    const descriptionTitleX = (pageWidth - descriptionTitleWidth) / 2;
    doc.text(descriptionTitle, descriptionTitleX, 70);
    const activityDescription = extractTextFromHTML(activity.description);
    const descriptionStartY = 75; // Adjust this according to your requirements
    doc.text(activityDescription, 10, descriptionStartY, {
        maxWidth: pageWidth - 20,
    }); // maxWidth ensures the text doesn't go outside of the page bounds.
    const docTitle = `activite_${activity.title}.pdf`;
    doc.save(docTitle);
};

function extractTextFromHTML(html) {
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, "text/html");
    return doc.body.textContent || "";
}

const generateFiche = (id) => {
    const activity = props.activities.find((activity) => activity.id === id);
    const element = document.createElement("div");
    element.innerHTML = activity.description;

    const opt = {
        margin: 0,
        filename: "myfile.pdf",
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: "in", format: "a4", orientation: "portrait" },
    };

    // New Promise-based usage:
    html2pdf().set(opt).from(element).save();
};
</script>
