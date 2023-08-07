<script>
import MainLayout from "../../Layouts/MainLayout.vue";
export default {
    layout: MainLayout,
};
</script>

<script setup>
import moment from "moment";
import Multiselect from "@vueform/multiselect";
import Swal from "sweetalert2";
import QRCode from "qrcode";
import jsPDF from "jspdf";
import { VueGoodTable } from "vue-good-table-next";
import "vue-good-table-next/dist/vue-good-table-next.css";
import { ref, computed, reactive, watchEffect, nextTick, toRaw } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { Modal } from "flowbite-vue";
import { useI18n } from "vue-i18n";
import TrashCan from "vue-material-design-icons/TrashCan.vue";
import Eye from "vue-material-design-icons/Eye.vue";
import Printer from "vue-material-design-icons/Printer.vue";
import Plus from "vue-material-design-icons/Plus.vue";
import Filter from "vue-material-design-icons/Filter.vue";
import Toast from "../../utils.js";
import html2pdf from "html2pdf.js";
import html2canvas from "html2canvas";

const selectedPayementStartDate = ref("");
const selectedPayementEndDate = ref("");
const selectedAbonnements = ref(props.abonnements);

const filteredItems = reactive([]);

const printSingleInvoice = (id) => {
    const abonnement = selectedAbonnements.value.find(
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
    return "/storage/";
};

const form = useForm({
    montant: null,
    adherent_id: null,
    // : null,
});
const showFilterForm = ref(false);
let isModalOpen = ref(false);

const clearFilters = () => {
    selectedPayementStartDate.value = "";
    selectedAbonnements.value = props.abonnements;
};

const applyFilters = () => {
    const abonnementArray = props.abonnements;
    filteredItems.value = abonnementArray.filter((item) => {
        let isMatch = true;

        if (
            selectedPayementStartDate.value &&
            item.date_payement <= selectedPayementStartDate.value
        ) {
            isMatch = false;
        }

        if (
            selectedPayementEndDate.value &&
            item.date_payement >= selectedPayementEndDate.value
        ) {
            isMatch = false;
        }

        return isMatch;
    });

    selectedAbonnements.value = filteredItems.value;
};
watchEffect(() => {
    applyFilters();
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
    Object.values(selectedAbonnements.value).map((abonnement) => ({
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
                    Toast.fire({
                        icon: "success",
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

const submit = () => {
    form.post(route("abonnements.store"), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            Toast.fire({
                icon: "success",
                title: t("toasts.ajout_success"),
            });
        },
        onError: () => {
            Toast.fire({
                icon: "error",
                title: t("toasts.ajout_error"),
            });
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

    <!-- <div
            class="shadow-lg bg-blue-600 p-4 absolute top-1.5 left-1/2 w-11/12 rounded-full transform -translate-x-1/2 -translate-y-1/2"
        >
            <h2
                class="text-xl font-semibold text-white"
                :class="$i18n.locale === 'ar' ? 'text-right' : 'text-left'"
            >
                {{ $t("abonnements.titre") }}
            </h2>
        </div> -->

    <!-- <div
            class="mt-7 items-center justify-between block sm:flex md:divide-x md:divide-gray-100"
        >
            <div
                class="px-2 w-full flex items-center justify-end mb-4 gap-4 sm:mb-0"
            >
                <button
                    @click="printAllInvoices(selectedAbonnements)"
                    class="relative text-white py-2 px-2 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 hover:bg-blue-600 transition-all text-sm"
                >
                    <Printer />
                </button>
                <button
                    @click="showFilter"
                    class="relative text-white py-2 px-2 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 hover:bg-blue-600 transition-all text-sm"
                >
                    <Filter />
                </button>
            </div>
        </div> -->

    <!-- <div class="mt-1 px-4">
            <div
                class="transition-all ease-in-out delay-950 w-full m-auto bg-gray-100 border border-gray-300 shadow-md p-4"
                v-if="showFilterForm"
            >
                <div class="flex" id="filter">
                    <div class="flex gap-5 w-full lg:flex-row flex-col">
                        <div class="w-full">
                            <label
                                for="start_date"
                                class="text-sm font-medium text-gray-900 block mb-2"
                                >{{ $t("abonnements.date_debut") }}
                            </label>
                            <input
                                v-model="selectedPayementStartDate"
                                type="date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Select date"
                                name="start_date"
                            />
                        </div>

                        <div class="w-full">
                            <label
                                for="start_date"
                                class="text-sm font-medium text-gray-900 block mb-2"
                                >{{ $t("abonnements.date_fin") }}
                            </label>
                            <input
                                v-model="selectedPayementEndDate"
                                type="date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Select date"
                                name="start_date"
                            />
                        </div>
                    </div>
                </div>
                <div class="flex gap-4">
                    <button
                        @click="clearFilters"
                        class="py-2 px-3 mt-5 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800"
                    >
                        {{ $t("abonnements.clear") }}
                    </button>
                </div>
            </div>
        </div> -->
    <!-- <div class="mt-4">
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
                ><template v-slot:table-row="{ row, column, formattedRow }">
                    <div v-if="column.field === 'actions'" class="flex">
                        <div
                            @click="router.get(`/adherents/${row.adherent_id}`)"
                            class="cursor-pointer w-4 mr-2 transform hover:text-blue-500 hover:scale-110"
                        >
                            <Eye :size="20" />
                        </div>

                        <div
                            @click="destroy(row.id)"
                            class="cursor-pointer w-4 mr-2 transform hover:text-blue-500 hover:scale-110"
                        >
                            <TrashCan :size="20" />
                        </div>
                        <div
                            @click="printSingleInvoice(row.id)"
                            class="cursor-pointer w-4 mr-2 transform hover:text-blue-500 hover:scale-110"
                        >
                            <Printer :size="20" />
                        </div>
                    </div>
                    <div v-else>
                        {{ formattedRow[column.field] }}
                    </div>
                </template>
            </vue-good-table>
        </div> -->
    <div
        v-for="(selectedAbonnement, index) in selectedAbonnements"
        :key="index"
        :id="'invoice' + selectedAbonnement.id"
        class="p-6 bg-white"
        style="clip-path: inset(0 100% 0 0)"
    >
        <div class="border border-gray-400 border-dashed p-4">
            <div class="flex justify-between items-start mb-3">
                <p>
                    <strong>No:</strong>
                    {{ selectedAbonnement ? selectedAbonnement.id : "" }}
                </p>
                <div class="flex flex-col items-center justify-start">
                    <img
                        alt="Logo"
                        class="h-16 w-auto"
                        :src="showImage() + props.associaton.image"
                    />
                    <p>{{ props.associaton.name ?? "--" }}</p>
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
                        {{
                            selectedAbonnement
                                ? selectedAbonnement.adherent.first_name +
                                  " " +
                                  selectedAbonnement.adherent.last_name
                                : ""
                        }}
                    </p>

                    <p>
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
                <p>
                    <strong>Signature</strong>
                </p>
                <p>{{ $page.props.auth.user.name }}</p>
            </div>
        </div>
    </div>
</template>
