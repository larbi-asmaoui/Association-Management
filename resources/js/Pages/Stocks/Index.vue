<template>
    <a-modal
        @cancel="closeModal"
        :footer="null"
        v-model:open="isModalOpen"
        :title="
            form.id ? $t('biens.modal_modifier') : $t('biens.modal_ajouter')
        "
        ><form
            class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2"
            @submit.prevent="submit"
            :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
        >
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label
                        for="stock_name"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("biens.input_nom") }}
                    </label>
                    <input
                        v-model="form.name"
                        type="text"
                        name="stock_name"
                        id="stock_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :placeholder-gray-400"
                    />
                    <span
                        v-if="form.errors.name"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.name }}
                    </span>
                </div>

                <div>
                    <label
                        for="type"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("biens.input_type") }}
                    </label>
                    <select
                        v-model="form.stock_type_id"
                        id="stockTypes"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :focus:ring-blue-500 :focus:border-blue-500 appearance-none select-none relative z-10"
                    >
                        <option
                            v-for="stockType in stockTypes"
                            :key="stockType.id"
                            :value="stockType.id"
                            class="bg-white :bg-gray-800 py-2.5 px-4 cursor-pointer hover:bg-gray-200 :hover:bg-gray-700"
                        >
                            {{ stockType.name }}
                        </option>
                    </select>
                    <span
                        v-if="form.errors.stock_type_id"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.stock_type_id }}
                    </span>
                </div>
            </div>

            <div>
                <div>
                    <label
                        for="dpurchase_date"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("biens.input_date") }}
                    </label>

                    <input
                        v-model="form.purchase_date"
                        type="date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :placeholder-gray-400"
                        placeholder="Select date"
                        name="purchase_date"
                    />
                    <span
                        v-if="form.errors.purchase_date"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.purchase_date }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label
                        for="quantity"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("biens.input_quantity") }}
                    </label>
                    <input
                        v-model="form.quantity"
                        min="1"
                        type="number"
                        name="quantity"
                        id="quantity"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :placeholder-gray-400"
                    />
                    <span
                        v-if="form.errors.quantity"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.quantity }}
                    </span>
                </div>

                <div>
                    <label
                        for=" price_per_unit"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("biens.input_prix_unit") }}
                    </label>
                    <input
                        v-model="form.price_per_unit"
                        min="0"
                        step="0.01"
                        type="number"
                        name=" price_per_unit"
                        id=" price_per_unit"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :placeholder-gray-400"
                    />
                    <span
                        v-if="form.errors.price_per_unit"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.price_per_unit }}
                    </span>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-x-2">
                <button
                    @click="isModalOpen = false"
                    type="button"
                    class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm :bg-slate-900 :hover:bg-slate-800 :border-gray-700 :text-gray-400 :hover:text-white :focus:ring-offset-gray-800"
                >
                    {{ $t("buttons.annuler") }}
                </button>
                <button
                    type="submit"
                    class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm :focus:ring-offset-gray-800"
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
            {{ $t("biens.titre") }}
        </h2>

        <div
            class="gap-2 py-1 mb-2 justify-between items-center block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
        >
            <div class="flex gap-2 me-auto">
                <a-tooltip>
                    <template #title>
                        {{ $t("biens.modal_ajouter") }}
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
                    <el-button type="primary" size="large" @click="generatePDF">
                        <FilePdfOutlined :style="{ fontSize: '24px' }" />
                    </el-button>
                </a-tooltip>
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
                :scroll="{ x: 1000 }"
                :expand-column-width="100"
            >
                <template v-slot:action="{ record }">
                    <el-button
                        type="primary"
                        size="small"
                        @click="openEditModal(record)"
                        ><Pencil />
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

<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
};
</script>

<script setup>
import { FilePdfOutlined } from "@ant-design/icons-vue";
import Swal from "sweetalert2";
import { ref, watch, computed } from "vue";
import { useForm, router, usePage } from "@inertiajs/vue3";
import { useI18n } from "vue-i18n";
import TrashCan from "vue-material-design-icons/TrashCan.vue";
import Pencil from "vue-material-design-icons/Pencil.vue";
import Plus from "vue-material-design-icons/Plus.vue";
import Toast from "../../utils.js";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";

const { t, availableLocales, locale } = useI18n();

const page = usePage();

const pageSize = ref(10);
const props = defineProps({
    stocks: {
        type: Object,
        default: () => ({}),
    },
    stockTypes: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    id: null,
    name: "",
    quantity: null,
    price_per_unit: null,
    purchase_date: null,
    stock_type_id: null,
});

const generatePDF = () => {
    const doc = new jsPDF();
    if (props.stocks.length === 0) {
        Swal.fire({
            icon: "error",
            text: "Aucun stock n'est disponible pour le moment",
            showConfirmButton: false,
            timer: 1500,
        });
        return;
    }

    const arabicFontFile = "/fonts/Amiri-Regular.ttf";
    const arabicFontName = "Amiri";

    doc.addFont(arabicFontFile, arabicFontName, "normal");
    doc.setFont(arabicFontName);

    const pageWidth = doc.internal.pageSize.getWidth();
    if (page.props.auth.association !== null) {
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

    const title = t("biens.titre");
    const titleWidth = doc.getTextWidth(title);
    const titleX = (pageWidth - titleWidth) / 2;
    doc.text(title, titleX, 40);

    doc.line(0, 45, 400, 45);
    const headers = [
        t("biens.table_date"),
        t("biens.table_montant"),
        t("biens.table_prix_unit"),
        t("biens.table_quantity"),
        t("biens.table_nom"),
        "#",
    ];

    const data = props.stocks.map((stock, index) => [
        stock.purchase_date,
        stock.quantity * stock.price_per_unit,
        stock.price_per_unit,
        stock.quantity,
        stock.name,
        index + 1,
    ]);

    doc.autoTable({
        margin: { top: 50 },
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

    doc.save("stocks.pdf");
};

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
        title: t("biens.table_nom"),
        dataIndex: "name",
        key: "name",
        sorter: {
            compare: (a, b) => a.name.localeCompare(b.name),
        },
        multipe: 1,
    },
    {
        title: t("biens.table_quantity"),
        dataIndex: "quantity",
        key: "quantity",
        sorter: {
            compare: (a, b) => a.quantity.localeCompare(b.quantity),
        },
        multipe: 1,
    },
    {
        title: t("biens.table_prix_unit"),
        dataIndex: "price_per_unit",
        key: "price_per_unit",
        sorter: {
            compare: (a, b) => a.price_per_unit.localeCompare(b.price_per_unit),
        },
        multipe: 1,
    },
    {
        title: t("biens.table_montant"),
        dataIndex: "total_price",
        key: "total_price",
        sorter: {
            compare: (a, b) => a.total_price.localeCompare(b.total_price),
        },
        multipe: 1,
    },
    {
        title: t("biens.table_date"),
        dataIndex: "purchase_date",
        key: "purchase_date",
        sorter: {
            compare: (a, b) => a.purchase_date.localeCompare(b.purchase_date),
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
    Object.values(props.stocks).map((stock) => ({
        id: stock.id,
        name: stock.name,
        quantity: stock.quantity,
        price_per_unit: stock.price_per_unit,
        total_price: stock.price_per_unit * stock.quantity,
        purchase_date: stock.purchase_date,
        stock_type_id: stock.stock_type_id,
    })),
);

let isModalOpen = ref(false);

const closeModal = () => {
    isModalOpen.value = false;

    form.reset();
};

const openEditModal = (stock) => {
    form.id = stock.id;
    form.name = stock.name;
    form.quantity = stock.quantity;
    form.price_per_unit = stock.price_per_unit;
    form.purchase_date = stock.purchase_date;
    form.stock_type_id = stock.stock_type_id;
    isModalOpen.value = true;
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
            form.delete(route("stocks.destroy", id), {
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
    form.get(route("stocks.show", id));
};

const submit = () => {
    if (form.id) {
        form.put(route("stocks.update", form.id), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
                Toast.fire({
                    icon: "success",
                    title: t("toasts.modif_success"),
                });
            },
            onError: () => {
                Toast.fire({
                    icon: "error",
                    title: t("toasts.modif_error"),
                });
            },
        });
    } else {
        form.post(route("stocks.store"), {
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
    }
};
</script>
