<script>
import RootLayout from "../../Layouts/RootLayout.vue";
export default {
    layout: RootLayout,
};
</script>

<script setup>
import moment from "moment";
import dayjs from "dayjs";
import {
    PrinterOutlined,
    SearchOutlined,
    ClearOutlined,
} from "@ant-design/icons-vue";

import Multiselect from "@vueform/multiselect";
import Swal from "sweetalert2";
import QRCode from "qrcode";
import jsPDF from "jspdf";
import {
    ref,
    computed,
    reactive,
    watchEffect,
    nextTick,
    toRaw,
    watch,
} from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { Modal } from "flowbite-vue";
import { useI18n } from "vue-i18n";
import TrashCan from "vue-material-design-icons/TrashCan.vue";
import Eye from "vue-material-design-icons/Eye.vue";
import Printer from "vue-material-design-icons/Printer.vue";
import Plus from "vue-material-design-icons/Plus.vue";
import Filter from "vue-material-design-icons/Filter.vue";
import { message } from "ant-design-vue";
import html2pdf from "html2pdf.js";
import html2canvas from "html2canvas";

const value1 = ref("");

const selectedPayementStartDate = ref(null);
const selectedPayementEndDate = ref(null);

const filteredAbonnements = ref([...props.abonnements]);

const searchInput = ref("");
const deepSearch = (obj, searchTerm) => {
    if (typeof obj === "string") {
        return obj.toLowerCase().includes(searchTerm.toLowerCase());
    } else if (Array.isArray(obj)) {
        return obj.some((item) => deepSearch(item, searchTerm));
    } else if (typeof obj === "object" && obj !== null) {
        // Added null check
        return Object.values(obj).some((value) =>
            deepSearch(value, searchTerm),
        );
    }
    return false;
};

const onSearch = computed(() => {
    filteredAbonnements.value = Object.values(props.abonnements).filter(
        (abonnement) => deepSearch(abonnement, searchInput.value),
    );
});
const printSingleInvoice = (id) => {
    const abonnement = filteredAbonnements.value.find(
        (abonnement) => abonnement.id === id,
    );
    printAllInvoices([abonnement]);
};

const { t } = useI18n();

const props = defineProps({
    adherents: {
        type: Object,
        default: () => ({}),
    },
    abonnements: {
        type: Object,
        default: () => ({}),
    },
    last_reunion: {
        type: Object,
        default: () => ({}),
    },
    associaton: {
        type: Object,
        default: () => ({}),
    },
});

const page = usePage();
const pageSize = ref(10);

const showImage = () => {
    if (
        page.props.auth.association !== null &&
        page.props.auth.association.image !== null
    ) {
        return "/storage/" + page.props.auth.association.image;
    }
    return "";
};

const associationName = computed(() => {
    if (page.props.auth.association !== null) {
        return page.props.auth.association.name;
    }
    return "";
});

const form = useForm({
    montant: null,
    adherent_id: null,
});
const showFilterForm = ref(false);
let isModalOpen = ref(false);

const clearFilters = () => {
    value1.value = "";
    selectedPayementStartDate.value = null;
    selectedPayementEndDate.value = null;
    filteredAbonnements.value = props.abonnements;
};

const applyFilters = () => {
    filteredAbonnements.value = Object.values(props.abonnements).filter(
        (item) => {
            let isMatch = true;
            if (
                selectedPayementStartDate.value &&
                dayjs(item.date_payement).isBefore(
                    selectedPayementStartDate.value,
                )
            ) {
                isMatch = false;
            }

            if (
                selectedPayementEndDate.value &&
                dayjs(item.date_payement).isAfter(selectedPayementEndDate.value)
            ) {
                isMatch = false;
            }

            return isMatch;
        },
    );
};

watchEffect(() => {
    if (value1.value && value1.value.length === 2) {
        selectedPayementStartDate.value = dayjs(value1.value[0]);
        selectedPayementEndDate.value = dayjs(value1.value[1]);
        applyFilters();
    }
});

const columns = computed(() => [
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
        title: t("abonnements.table_montant"),
        dataIndex: "montant",
        key: "montant",
        sorter: {
            compare: (a, b) => a.montant - b.montant,
        },
    },
    {
        title: t("abonnements.table_date"),
        dataIndex: "date_payement",
        key: "date_payement",
        sorter: {
            compare: (a, b) => a.date_payement.localeCompare(b.date_payement),
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
    Object.values(filteredAbonnements.value).map((abonnement) => ({
        id: abonnement.id,
        nom_complet:
            abonnement.adherent.first_name +
            " " +
            abonnement.adherent.last_name,
        montant: abonnement.montant,
        adherent: abonnement.adherent,
        adherent_id: abonnement.adherent_id,
        date_payement: abonnement.date_payement,
    })),
);

const showFilter = () => {
    showFilterForm.value = !showFilterForm.value;
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
            router.delete(route("abonnements.destroy", id), {
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
    form.post(route("abonnements.store"), {
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
    isModalOpen.value = false;
    form.reset();
};

const formattedAdherents = computed(() =>
    Object.values(props.adherents).map((adherent) => ({
        value: adherent.id,
        label: adherent.last_name + " " + adherent.first_name,
    })),
);

const printAllInvoices = async (abonnements) => {
    if (abonnements.length === 0) {
        Swal.fire({
            icon: "error",
            text: "  لا يوجد أي وصل للطباعة",
            showConfirmButton: false,
            timer: 2000,
        });
        return;
    }
    const pdf = new jsPDF({
        format: "a4",
        orientation: "portrait",
    });

    const canvasList = abonnements.map((abonnement, index) => {
        const element = document.getElementById(`invoice${abonnement.id}`);
        return html2canvas(element, { scale: 0.78 }).then((canvas) => {
            const position =
                index % 3 === 0
                    ? 0
                    : ((index % 3) * pdf.internal.pageSize.height) / 3;

            const imgData = canvas.toDataURL("image/png");
            pdf.addImage(imgData, "PNG", 0, position);

            if (index % 3 === 2 && index < abonnements.length - 1) {
                pdf.addPage();
            }
        });
    });

    await Promise.all(canvasList);

    pdf.save("Invoices.pdf");
};
</script>

<template>
    <a-modal
        @cancel="closeModal"
        :footer="null"
        v-model:open="isModalOpen"
        :title="$t('abonnements.modal_ajouter')"
        ><form
            :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
            class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2"
            @submit.prevent="submit"
        >
            <div>
                <label
                    for="adherents"
                    class="block mb-2 text-sm font-medium text-gray-900"
                    >{{ $t("abonnements.choose_adherent") }}</label
                >

                <Multiselect
                    v-model="form.adherent_id"
                    :close-on-select="false"
                    :searchable="true"
                    :create-option="true"
                    :options="formattedAdherents"
                />
                <span
                    v-if="form.errors.adherent_id"
                    class="text-xs text-red-600 mt-1"
                    id="hs-validation-name-error-helper"
                >
                    {{ form.errors.adherent_id }}
                </span>
            </div>

            <div>
                <label
                    for="montant"
                    class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                    >{{ $t("abonnements.input_montant") }}
                </label>
                <input
                    step="any"
                    v-model="form.montant"
                    type="number"
                    name="montant"
                    id="montant"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400"
                />
                <span
                    v-if="form.errors.montant"
                    class="text-xs text-red-600 mt-1"
                    id="hs-validation-name-error-helper"
                >
                    {{ form.errors.montant }}
                </span>
            </div>

            <div>
                <label
                    for="date"
                    class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                    >{{ $t("abonnements.input_date") }}
                </label>

                <input
                    type="date"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400"
                    placeholder="Select date"
                    name="date"
                />
            </div>

            <div class="mt-4">
                <button
                    @click="closeModal"
                    type="button"
                    class="py-2 px-3 ml-2 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800"
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
        </form></a-modal
    >

    {{ $page.props.auth.associaton }}
    <div class="w-auto h-full py-4 px-2">
        <h2
            class="text-xl font-semibold text-black-600 mb-4"
            :class="$i18n.locale === 'ar' ? 'text-right' : 'text-left'"
        >
            {{ $t("abonnements.titre") }}
        </h2>

        <div
            class="gap-2 py-1 mb-2 justify-between items-center block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
        >
            <div class="flex gap-2 me-auto">
                <a-tooltip>
                    <template #title>
                        {{ $t("abonnements.modal_ajouter") }}
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
                    <template #title> {{ $t("abonnements.print") }}</template>
                    <el-button
                        type="primary"
                        size="large"
                        @click="printAllInvoices(filteredAbonnements)"
                    >
                        <PrinterOutlined :style="{ fontSize: '24px' }" />
                    </el-button>
                </a-tooltip>
            </div>
            <div class="flex gap-2 justify-between items-center">
                <a-tooltip>
                    <template #title>
                        {{ $t("abonnements.clear") }}
                    </template>
                    <el-button
                        type="primary"
                        size="small"
                        @click="clearFilters"
                    >
                        <ClearOutlined :style="{ fontSize: '24px' }" />
                    </el-button>
                </a-tooltip>
                <a-range-picker v-model:value="value1" />

                <a-config-provider
                    :direction="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
                >
                    <a-input
                        placeholder="search"
                        v-model:value="searchInput"
                        @search="onSearch"
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
                <template v-slot:action="{ record }">
                    <el-button
                        type="primary"
                        size="small"
                        @click="router.get(`/adherents/${record.adherent_id}`)"
                        ><Eye />
                    </el-button>
                    <span class="me-2"></span>

                    <el-button
                        type="danger"
                        size="small"
                        @click="destroy(record.id)"
                        ><TrashCan
                    /></el-button>
                    <span class="me-2"></span>
                    <el-button
                        type="warning"
                        size="small"
                        @click="printSingleInvoice(record.id)"
                    >
                        <Printer />
                    </el-button>
                </template>
            </a-table>
        </a-config-provider>
    </div>

    <!-- template of the invoice -->
    <!-- style="clip-path: inset(0 100% 0 0)" -->
    <div
        v-for="(selectedAbonnement, index) in filteredAbonnements"
        :key="index"
        :id="'invoice' + selectedAbonnement.id"
        class="p-6 bg-white"
        style="clip-path: inset(0 100% 0 0)"
    >
        <div class="border border-gray-400 border-dashed p-6 pb-8">
            <div class="flex justify-between items-start mb-3">
                <p>
                    <strong>No:</strong>
                    {{ selectedAbonnement ? selectedAbonnement.id : "" }}
                </p>
                <div class="flex flex-col items-center justify-start">
                    <img alt="Logo" class="h-16 w-auto" :src="showImage()" />
                    <p>{{ associationName }}</p>
                </div>
                <p>
                    {{
                        selectedAbonnement
                            ? moment(selectedAbonnement.date_payement).format(
                                  "DD/MM/YYYY",
                              )
                            : ""
                    }}
                </p>
            </div>

            <div class="text-right">
                <div class="flex flex-col gap-2">
                    <strong>{{ $t("adherents.info_perso") }}</strong>
                    <p>
                        <strong
                            >{{ $t("adherents.table_nom_complete") }} :
                        </strong>

                        {{
                            selectedAbonnement
                                ? selectedAbonnement.adherent.first_name +
                                  " " +
                                  selectedAbonnement.adherent.last_name
                                : ""
                        }}
                    </p>

                    <p>
                        <strong>{{ $t("adherents.input_addresse") }} : </strong>

                        {{
                            selectedAbonnement
                                ? selectedAbonnement.adherent.address +
                                  "," +
                                  selectedAbonnement.adherent.city +
                                  "," +
                                  selectedAbonnement.adherent.region
                                : ""
                        }}
                    </p>

                    <p>
                        <strong
                            >{{ $t("adherents.table_date_naissance") }} :
                        </strong>
                        {{
                            selectedAbonnement
                                ? selectedAbonnement.adherent.date_of_birth
                                : ""
                        }}
                    </p>
                    <p>
                        <strong>{{ $t("adherents.date_adhesion") }} : </strong>
                        {{
                            selectedAbonnement
                                ? selectedAbonnement.adherent.date_of_membership
                                : ""
                        }}
                    </p>
                    <p class="mt-5">
                        <strong
                            >{{ $t("abonnements.table_montant") }} :
                        </strong>
                        {{
                            selectedAbonnement ? selectedAbonnement.montant : 0
                        }}
                    </p>
                </div>
            </div>

            <div class="mt-4 text-left">
                <p class="mb-3">
                    <strong>التوقيع</strong>
                </p>
                <p>{{ $page.props.auth.user.name }}</p>
            </div>
        </div>
    </div>
</template>
<!-- <style src="@vueform/multiselect/themes/default.css"></style> -->
