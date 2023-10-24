<template>
    <a-modal
        width="80%"
        @cancel="closeModal"
        :footer="null"
        v-model:open="isModalOpen"
        :title="$t('adherents.modal_ajouter')"
    >
        <form
            class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2 overflow-y-auto max-h-[30rem]"
            @submit.prevent="submit"
        >
            <div>
                <label
                    for="avatar"
                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                    >{{ $t("adherents.input_image") }}
                </label>
                <ImageUpload v-model="form.image" :default-src="defaultImg" />
                <span
                    v-if="form.errors.image"
                    class="text-xs text-red-600 mt-1"
                    id="hs-validation-name-error-helper"
                >
                    {{ form.errors.image }}
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label
                        for="last_name"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("adherents.input_nom")
                        }}<span class="text-red-600">*</span>
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
                        >{{ $t("adherents.input_prenom")
                        }}<span class="text-red-600">*</span>
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

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 lg:gap-6">
                <div>
                    <label
                        for="cin"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("adherents.input_cin") }}</label
                    >
                    <input
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
                        for="Sexe"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("adherents.input_sexe")
                        }}<span class="text-red-600">*</span></label
                    >
                    <select
                        v-model="form.sexe"
                        id="type"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
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
                        for="profession"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("adherents.input_profession")
                        }}<span class="text-red-600">*</span></label
                    >
                    <input
                        v-model="form.profession"
                        type="text"
                        name="profession"
                        id="profession"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                    />
                    <span
                        v-if="form.errors.profession"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.profession }}
                    </span>
                </div>
                <div>
                    <label
                        for="situation"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("adherents.input_situation_familiale")
                        }}<span class="text-red-600">*</span></label
                    >
                    <select
                        v-model="form.situation_familiale"
                        id="type"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    >
                        <option disabled value="">اختر الحالة العائلية</option>
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
                        {{ form.errors.situation_familiale }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label
                        for="tel"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("adherents.input_telephone") }}
                    </label>
                    <input
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
                        >{{ $t("adherents.input_email") }}</label
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

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label
                        for="date_of_birth"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("adherents.input_date_naissance")
                        }}<span class="text-red-600">*</span>
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
                        >{{ $t("adherents.input_date_adhesion")
                        }}<span class="text-red-600">*</span>
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
                    >{{ $t("adherents.input_addresse")
                    }}<span class="text-red-600">*</span></label
                >
                <textarea
                    v-model="form.address"
                    id="address"
                    name="address"
                    rows="1"
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

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label
                        for="region"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("adherents.input_region")
                        }}<span class="text-red-600">*</span></label
                    >
                    <select
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

                <div>
                    <label
                        for="city"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("adherents.input_ville")
                        }}<span class="text-red-600">*</span></label
                    >
                    <select
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
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label
                        for="frais_adhesion"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("adherents.input_montant_adhesion")
                        }}<span class="text-red-600">*</span></label
                    >
                    <input
                        v-model="form.montant"
                        type="number"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                        name="frais_adhesion"
                        min="1"
                        step="0.01"
                    />
                    <span
                        v-if="form.errors.montant"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.montant }}
                    </span>
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
    </a-modal>

    <div class="w-auto h-full py-4 px-2">
        <h2
            class="text-xl font-semibold text-black-600 mb-4"
            :class="$i18n.locale === 'ar' ? 'text-right' : 'text-left'"
        >
            {{ $t("adherents.titre") }}
        </h2>
        <div
            class="gap-2 py-1 mb-2 justify-between items-center block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
        >
            <div class="flex gap-2 me-auto">
                <a-tooltip>
                    <template #title>
                        {{ $t("adherents.modal_ajouter") }}
                    </template>
                    <el-button
                        type="primary"
                        size="large"
                        @click="isModalOpen = true"
                    >
                        <Plus />
                    </el-button>
                </a-tooltip>

                <a-tooltip>
                    <template #title>
                        {{ $t("adherents.export_pdf") }}</template
                    >
                    <el-button type="primary" size="large" @click="exportToPDF">
                        <FilePdfOutlined :style="{ fontSize: '24px' }" />
                    </el-button>
                </a-tooltip>

                <a-tooltip>
                    <template #title>
                        {{ $t("adherents.print_cards_adhesion") }}</template
                    >
                    <el-button
                        type="primary"
                        size="large"
                        @click="generateIDCards(adherents)"
                    >
                        <PrinterOutlined :style="{ fontSize: '24px' }" />
                    </el-button>
                </a-tooltip>
            </div>

            <div>
                <a-config-provider
                    :direction="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
                >
                    <a-input
                        placeholder="search"
                        @search="onSearch"
                        v-model:value="searchInput"
                    >
                        <template #suffix>
                            <a-tooltip title="Extra information">
                                <SearchOutlined
                                    style="color: rgba(0, 0, 0, 0.45)"
                                />
                            </a-tooltip>
                        </template>
                    </a-input>
                </a-config-provider>
            </div>
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
                <template v-slot:image="{ record }">
                    <a-avatar :size="50" :src="showImage(record)"> </a-avatar>
                </template>
                <template v-slot:actif="{ record }">
                    <a-badge
                        status="success"
                        v-if="record.is_actif === 1 || record.is_actif === true"
                    />
                    <a-badge status="error" v-else />
                </template>
                <template v-slot:action="{ record }">
                    <div class="flex gap-1">
                        <Eye
                            class="text-sky-500 cursor-pointer"
                            @click="show(record)"
                        />
                        <TrashCan
                            class="text-red-600 cursor-pointer"
                            @click="destroy(record)"
                        />
                        <Printer
                            class="text-amber-400 cursor-pointer"
                            @click="generateSingleIDCard(record.id)"
                        />
                    </div>
                </template> </a-table
        ></a-config-provider>
    </div>
</template>

<script>
import RootLayout from "../../Layouts/RootLayout.vue";

export default {
    layout: RootLayout,
    methods: {},
};
</script>

<script setup>
import {
    FilePdfOutlined,
    PrinterOutlined,
    SearchOutlined,
} from "@ant-design/icons-vue";
import Swal from "sweetalert2";
import "vue-advanced-cropper/dist/style.css";
import defaultImg from "../../../assets/image.jpeg";
import { ref, computed } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import ImageUpload from "../../Components/ImageUpload.vue";
import { useForm } from "@inertiajs/vue3";
import autoTable from "jspdf-autotable";
import jsPDF from "jspdf";
import regionsFile from "../../regions.json";
import { useI18n } from "vue-i18n";
import QRCode from "qrcode";
import TrashCan from "vue-material-design-icons/TrashCan.vue";
import Eye from "vue-material-design-icons/Eye.vue";
import Printer from "vue-material-design-icons/Printer.vue";
import Plus from "vue-material-design-icons/Plus.vue";
import { message } from "ant-design-vue";

const { t, availableLocales, locale } = useI18n();

let isModalOpen = ref(false);
const page = usePage();
const props = defineProps({
    adherents: {
        type: Object,
        default: () => ({}),
    },

    status: {
        type: Object,
        default: () => ({}),
    },
});
const regions = ref(regionsFile);
const pageSize = ref(10);
const searchInput = ref("");

const onSearch = computed(() => {
    filteredAdherents.value = Object.values(props.adherents).filter(
        (adherent) =>
            Object.values(adherent).some((value) =>
                String(value)
                    .toLowerCase()
                    .includes(searchInput.value.toLowerCase()),
            ),
    );
});

const columns = computed(() => [
    {
        title: "#",
        dataIndex: "image",
        key: "image",
        slots: { customRender: "image" },
    },
    {
        title: t("adherents.table_adhesion_number"),
        dataIndex: "num_adhesion",
        key: "num_adhesion",
        sorter: {
            compare: (a, b) => a.num_adhesion.localeCompare(b.num_adhesion),
        },
    },
    {
        title: t("adherents.table_nom_complete"),
        dataIndex: "nom_complet",
        key: "nom_complet",
        sorter: {
            compare: (a, b) => a.nom_complet.localeCompare(b.nom_complet),
        },
    },
    {
        title: t("adherents.table_cin"),
        dataIndex: "cin",
        key: "cin",
        sorter: {
            compare: (a, b) => a.cin.localeCompare(b.cin),
        },
    },
    {
        title: t("adherents.table_profession"),
        dataIndex: "profession",
        key: "profession",
    },
    {
        title: t("adherents.table_situation_familiale"),
        dataIndex: "situation_familiale",
        key: "situation_familiale",
    },
    {
        title: t("adherents.table_telephone"),
        dataIndex: "tel",
        key: "tel",
        sorter: {
            compare: (a, b) => a.tel.localeCompare(b.tel),
        },
    },
    {
        title: t("adherents.table_statut_adhesion"),
        dataIndex: "is_actif",
        key: "is_actif",
        slots: { customRender: "actif" },
    },
    {
        title: t("adherents.table_actions"),
        dataIndex: "action",
        key: "action",
        slots: { customRender: "action" },
    },
]);

const filteredAdherents = ref(props.adherents);

const rows = computed(() =>
    filteredAdherents.value.map((adherent) => ({
        id: adherent.id,
        num_adhesion: adherent.num_adhesion,
        image: adherent.image,
        nom_complet: adherent.first_name + " " + adherent.last_name,
        profession: adherent.profession ?? "غير محدد",
        situation_familiale: adherent.situation_familiale,
        cin: adherent.cin ?? "-",
        tel: adherent.tel,
        is_actif: adherent.is_actif,
    })),
);

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
    montant: null,
});

const generateSingleIDCard = (id) => {
    const adherents = props.adherents.filter((adherent) => adherent.id === id);
    generateIDCards(adherents);
};

const generateIDCards = async (adherents = props.adherents) => {
    // filter the same array is_adherent === 1
    // adherents = adherents.filter(
    //     (adherent) => adherent.is_actif === true || adherent.is_actif === 1,
    // );

    // if (adherents.length === 0) {
    //     Swal.fire({
    //         icon: "error",
    //         text: "لا يوجد أعضاء نشطين للطباعة",
    //         showConfirmButton: false,
    //         timer: 1500,
    //     });
    //     return;
    // }

    const doc = new jsPDF();

    // Step 1: Load the Arabic font file
    const arabicFontFile = "/fonts/Amiri-Regular.ttf";
    const arabicFontName = "Amiri";

    doc.addFont(arabicFontFile, "Amiri", "normal");

    // const adherents = props.adherents;
    for (let i = 0; i < adherents.length; i += 8) {
        if (i !== 0) {
            doc.addPage();
        }

        const remainingAdherents = adherents.slice(i);
        const cardsToPrint =
            remainingAdherents.length >= 2
                ? remainingAdherents.slice(0, 8)
                : remainingAdherents;

        for (let j = 0; j < cardsToPrint.length; j++) {
            const adherent = cardsToPrint[j];

            const cardText = `المنصب : ${
                adherent.statut !== null ? adherent.statut.name : "منخرط"
            }\nالاسم والنسب : ${adherent.first_name} ${adherent.last_name}\n${
                adherent.date_of_birth
            } :  تاريخ الميلاد\n${
                adherent.date_of_membership
            } :  تاريخ الإنخراط\nالمهنة : ${adherent.profession}`;

            const qrCode = await QRCode.toDataURL(cardText);

            const x = j % 2 ? 110 : 10;
            const y = Math.floor(j / 2) * 60 + 10;

            doc.setDrawColor(0);
            doc.setLineWidth(0.1);
            doc.rect(x, y, 80, 50, "S"); // Adjust the coordinates and size of the rectangle for the ID card
            doc.setFont(arabicFontName);
            doc.setFontSize(10);
            doc.text(cardText, x + 76, y + 28, {
                align: "right",
                fontWeight: "bold",
            });

            const numAdhesion = `${adherent.num_adhesion ?? ""}`;

            doc.setFontSize(12);
            doc.setFont(arabicFontName, "bold");
            // in the center of the card
            doc.text(numAdhesion, x + 40, y + 18, { align: "center" });
            doc.setFont(arabicFontName, "normal");
            doc.setFontSize(10);
            const qrImg = new Image();
            qrImg.src = qrCode;
            doc.addImage(qrImg, "PNG", x + 2, y + 34, 14, 14);

            const profilePath = adherent.image;
            if (profilePath !== null) {
                const profileImgUrl = "/storage/" + profilePath;
                imageExists(profileImgUrl, function (exists) {
                    if (exists) {
                        const profileImg = new Image();
                        profileImg.src = profileImgUrl;
                        const profileImgX = x + 63;
                        const profileImgY = y + 4;
                        const profileImgSize = 15;

                        // Add the rounded profile image
                        doc.addImage(
                            profileImg,
                            "PNG",
                            profileImgX,
                            profileImgY,
                            profileImgSize,
                            profileImgSize,
                        );

                        doc.rect(
                            profileImgX,
                            profileImgY,
                            profileImgSize,
                            profileImgSize,
                            "S",
                        );
                    } else {
                        console.error(
                            "Image does not exist at path:",
                            profileImgUrl,
                        );
                        // Handle image not found
                    }
                });
                // doc.clip("evenodd");
            }
            // Reset the clipping path

            if (
                page.props.auth.association !== null &&
                page.props.auth.association.image !== null
            ) {
                const logoImg = new Image();
                const logoPath = page.props.auth.association.image;
                logoImg.src = "/storage/" + logoPath;
                const logoImgX = x + 2;
                const logoImgY = y + 4;
                const logoImgSize = 13;
                // Create a rounded clipping path for logo image
                doc.setLineWidth(0.1);
                doc.setDrawColor(0);
                // doc.circle(
                //     logoImgX + logoImgSize / 2,
                //     logoImgY + logoImgSize / 2,
                //     logoImgSize / 2,
                //     "S",
                // );

                // doc.clip();
                doc.addImage(
                    logoImg,
                    "PNG",
                    logoImgX,
                    logoImgY,
                    logoImgSize,
                    logoImgSize,
                );
                doc.rect(logoImgX, logoImgY, logoImgSize, logoImgSize, "S");
            }

            // doc.addImage(logoImg, "PNG", x + 5, y + 4, 15, 15);
        }
    }
    doc.save("cartes.pdf");
};

function imageExists(url, callback) {
    let img = new Image();
    img.onload = function () {
        callback(true);
    };
    img.onerror = function () {
        callback(false);
    };
    img.src = url;
}

const exportToPDF = () => {
    const doc = new jsPDF();
    if (props.adherents.length === 0) {
        Swal.fire({
            icon: "error",
            text: "لا يوجد أعضاء للطباعة",
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
        doc.setFontSize(15);
        const assoName = `${page.props.auth.association.name}` ?? "";
        const assoNameWidth = doc.getTextWidth(assoName);

        const assoNameX = (pageWidth - assoNameWidth) / 2;
        doc.text(assoName, assoNameX, 32);
    }

    doc.setFontSize(13);

    const title = t("adherents.liste_adherents");
    const titleWidth = doc.getTextWidth(title);
    const titleX = (pageWidth - titleWidth) / 2;
    doc.text(title, titleX, 40);

    doc.line(0, 50, 400, 50);
    // Define the table headers and data
    const headers = [
        t("adherents.input_date_adhesion"),
        t("adherents.table_date_naissance"),
        t("adherents.table_profession"),
        t("adherents.table_telephone"),
        t("adherents.table_cin"),
        t("adherents.table_nom_complete"),
        t("adherents.table_adhesion_number"),
        "#",
    ];

    const data = props.adherents.map((adherent, index) => [
        adherent.date_of_membership,
        adherent.date_of_birth,
        adherent.profession,
        adherent.tel,
        adherent.cin,
        adherent.first_name + " " + adherent.last_name,
        adherent.num_adhesion,
        index + 1,
    ]);

    // Add the table to the PDF
    doc.autoTable({
        margin: { top: 60 },
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

    // Save the PDF
    doc.save("liste_adherents.pdf");
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

const showImage = (adherent) => {
    return "/storage/" + adherent.image;
};

const show = (id) => {
    router.get(route("adherents.show", id));
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
            router.delete(route("adherents.destroy", id), {
                onError: () => {
                    message.error(t("toasts.supp_error"));
                },
                onSuccess: () => {
                    message.success(t("toasts.supp_success"));
                },
            });
        }
    });
};

const submit = () => {
    form.post(route("adherents.store"), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            message.success(t("toasts.ajout_success"));
        },
        onError: () => {
            message.error(t("toasts.ajout_error"));
        },
    });
};

const closeModal = () => {
    form.reset();
    form.clearErrors();
    isModalOpen.value = false;
};
</script>

<style scoped>
#my-doc {
    font: 33rem;
}

.card-info {
    font-size: 14px;
}

.card-info strong {
    font-weight: bold;
}

/* #qr-code {
    width: 10px;
    height: 10px;
    margin-top: 10px;
} */
</style>
