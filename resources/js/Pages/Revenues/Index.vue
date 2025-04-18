<template>
    <a-modal
        @cancel="closeModal"
        :footer="null"
        v-model:open="isModalOpen"
        :title="
            form.id
                ? $t('revenues.modal_modifier')
                : $t('revenues.modal_ajouter')
        "
    >
        <form
            :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
            class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2 overflow-y-auto max-h-[30rem]"
            @submit.prevent="submit"
            enctype="multipart/form-data"
        >
            <div>
                <label
                    for="titre"
                    class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                    >{{ $t("revenues.input_nom") }}
                </label>
                <input
                    v-model="form.titre"
                    type="text"
                    name="titre"
                    id="titre"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                />
                <span
                    v-if="form.errors.titre"
                    class="text-xs text-red-600 mt-1"
                    id="hs-validation-name-error-helper"
                >
                    {{ form.errors.titre }}
                </span>
            </div>
            <div>
                <label
                    for="montant"
                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                    >{{ $t("revenues.input_montant") }}
                </label>
                <input
                    v-model="form.montant"
                    min="1"
                    step="0.01"
                    type="number"
                    name="montant"
                    id="montant"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :placeholder-gray-400 :text-white"
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
                    for="type"
                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                    >{{ $t("revenues.input_type") }}
                </label>
                <select
                    v-model="form.revenue_type_id"
                    id="revenueTypes"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-blue-500 :focus:border-blue-500 appearance-none select-none relative z-10"
                >
                    <option
                        v-for="revenueType in revenueTypes"
                        :key="revenueType.id"
                        :value="revenueType.id"
                        class="bg-white :bg-gray-800 py-2.5 px-4 cursor-pointer hover:bg-gray-200 :hover:bg-gray-700"
                    >
                        {{ revenueType.name }}
                    </option>
                </select>
                <span
                    v-if="form.errors.revenue_type_id"
                    class="text-xs text-red-600 mt-1"
                    id="hs-validation-name-error-helper"
                >
                    {{ form.errors.revenue_type_id }}
                </span>
            </div>

            <div>
                <div>
                    <label
                        for="revenue_date"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("revenues.input_date") }}
                    </label>

                    <input
                        v-model="form.revenue_date"
                        type="date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :placeholder-gray-400 :text-white"
                        placeholder="Select date"
                        name="revenue_date"
                    />
                    <span
                        v-if="form.errors.revenue_date"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.revenue_date }}
                    </span>
                </div>
            </div>
            <div>
                <label
                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                    for="file_input"
                    >{{ $t("revenues.input_image") }}
                </label>
                <input
                    @change="selectImage"
                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 :text-gray-400 focus:outline-none :bg-gray-700 :border-gray-600 :placeholder-gray-400"
                    id="file_input"
                    type="file"
                    accept="image/*"
                />
                <p
                    class="mt-1 text-sm text-gray-500 :text-gray-300"
                    id="file_input_help"
                >
                    SVG, PNG, JPG, PDF.
                </p>
                <span
                    v-if="form.errors.reference_file"
                    class="text-xs text-red-600 mt-1"
                    id="hs-validation-name-error-helper"
                >
                    {{ form.errors.reference_file }}
                </span>
            </div>
            <div class="border border-gray-300 rounded-sm" v-if="imagePreview">
                <img :src="imagePreview" />
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
            {{ $t("revenues.titre") }}
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
import RootLayout from "../../Layouts/RootLayout.vue";

export default {
    layout: RootLayout,
};
</script>

<script setup>
import Swal from "sweetalert2";
import { ref, computed } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import { Modal } from "flowbite-vue";
import { useI18n } from "vue-i18n";
import TrashCan from "vue-material-design-icons/TrashCan.vue";
import Pencil from "vue-material-design-icons/Pencil.vue";
import Plus from "vue-material-design-icons/Plus.vue";
import { message } from "ant-design-vue";
const { t } = useI18n();

const columns = computed(() => [
    {
        title: t("revenues.table_nom"),
        dataIndex: "titre",
        key: "titre",
        sorter: {
            compare: (a, b) => a.titre.localeCompare(b.titre),
        },
        multipe: 1,
    },
    {
        title: t("revenues.table_montant"),
        dataIndex: "montant",
        key: "montant",
        sorter: {
            compare: (a, b) => a.montant.localeCompare(b.montant),
        },
        multipe: 1,
    },

    {
        title: t("revenues.table_type"),
        dataIndex: "type",
        key: "type",
        sorter: {
            compare: (a, b) => a.type.localeCompare(b.type),
        },
        multipe: 1,
    },

    {
        title: t("revenues.table_date"),
        dataIndex: "revenue_date",
        key: "revenue_date",
        sorter: {
            compare: (a, b) => a.revenue_date.localeCompare(b.revenue_date),
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
    Object.values(props.revenues).map((revenue) => ({
        id: revenue.id,
        titre: revenue.titre,
        montant: revenue.montant,
        revenue_date: revenue.revenue_date,
        reference_file: revenue.reference_file,
        type: revenue.revenue_type ? revenue.revenue_type.name : "--",
        revenue_type_id: revenue.revenue_type_id,
    })),
);

const pageSize = ref(10);

const form = useForm({
    id: null,
    titre: null,
    montant: null,
    revenue_date: null,
    reference_file: null,
    revenue_type_id: null,
});
let imagePreview = ref(null);
let image = ref(null);

let isModalOpen = ref(false);

const closeModal = () => {
    isModalOpen.value = false;
    imagePreview.value = null;
    image.value = null;
    form.clearErrors();
    form.reset();
};

const showImage = () => {
    return "/storage/";
};

const selectImage = (event) => {
    if (event.target.files[0]) {
        let file = event.target.files[0];
        form.reference_file = file;

        let reader = new FileReader();

        reader.onloadend = () => {
            imagePreview.value = reader.result;
        };

        reader.readAsDataURL(file);
    }
};

const openEditModal = (revenue) => {
    form.id = revenue.id;
    form.titre = revenue.titre;
    form.montant = revenue.montant;
    form.revenue_date = revenue.revenue_date;
    form.revenue_type_id = revenue.revenue_type_id;
    form.reference_file = revenue.reference_file;
    imagePreview.value = showImage() + revenue.reference_file;
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
            form.delete(route("revenues.destroy", id), {
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

const props = defineProps({
    revenues: {
        type: Object,
        default: () => ({}),
    },
    revenueTypes: {
        type: Object,
        default: () => ({}),
    },
});

const submit = () => {
    if (form.id) {
        router.post(
            `/revenues/${form.id}`,
            {
                _method: "put",
                headers: {
                    "Content-Type": "multipart/form-data",
                },
                id: form.id,
                titre: form.titre,
                montant: form.montant,
                revenue_date: form.revenue_date,
                reference_file: form.reference_file,
                revenue_type_id: form.revenue_type_id,

                // preserveScroll: true,
                // onFinish: (visit) => {
                //     closeModal();
                //     console.log(visit);
                // },
            },
            {
                onSuccess: () => {
                    closeModal();

                    message.success(t("toasts.modif_success"));
                },
                onError: () => {
                    message.error(t("toasts.modif_error"));
                },
            },
        );
    } else {
        form.post(route("revenues.store"), {
            forceFormData: true,
            preserveScroll: true,

            onSuccess: () => {
                closeModal();

                message.success(t("toasts.ajout_success"));
            },
        });
    }
};
</script>
