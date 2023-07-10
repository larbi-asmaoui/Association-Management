<template>
    <button
        @click="isModalOpen = true"
        :class="$i18n.locale === 'ar' ? 'left-5' : 'right-5'"
        class="rounded-full z-50 fixed bottom-8 text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium text-sm p-5 focus:outline-none"
        type="button"
    >
        <svg
            class="w-5 h-5"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                fill-rule="evenodd"
                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                clip-rule="evenodd"
            ></path>
        </svg>
    </button>

    <div class="bg-white pt-6 shadow-md rounded-xl relative mt-5">
        <div
            class="shadow-lg bg-blue-600 p-4 absolute top-1.5 left-1/2 w-11/12 rounded-full transform -translate-x-1/2 -translate-y-1/2"
        >
            <h2 class="text-xl font-semibold text-white">
                {{ $t("revenues.titre") }}
            </h2>
        </div>

        <div
            class="mt-7 items-center justify-between block sm:flex md:divide-x md:divide-gray-100"
        >
            <div class="px-2 flex items-center mb-4 sm:mb-0"></div>
        </div>

        <teleport to="body">
            <Modal size="md" v-if="isModalOpen" @close="closeModal">
                <template #header>
                    <div class="flex items-center text-lg">
                        {{
                            form.id
                                ? $t("revenues.modal_modifier")
                                : $t("revenues.modal_ajouter")
                        }}
                    </div>
                </template>
                <template #body>
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
                        <img v-if="imagePreview" :src="imagePreview" />

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
                </template>
            </Modal>
        </teleport>

        <div class="mt-4">
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
            >
                <template v-slot:table-row="{ row, column, formattedRow }">
                    <div
                        v-if="column.field === 'actions'"
                        class="flex justify-center items-center"
                    >
                        <div
                            @click="openEditModal(row)"
                            class="cursor-pointer w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                        >
                            <Pencil :size="20" />
                        </div>

                        <!-- Delete -->

                        <div
                            @click="destroy(row)"
                            class="cursor-pointer w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                        >
                            <TrashCan :size="20" />
                        </div>
                    </div>
                    <!-- <div v-else>
                        {{ formattedRow[column.field] }}
                    </div> -->
                </template>
            </vue-good-table>
        </div>
    </div>
</template>
<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
};
</script>

<script setup>
import { VueGoodTable } from "vue-good-table-next";
import "vue-good-table-next/dist/vue-good-table-next.css";
import { ref, computed } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import { Modal } from "flowbite-vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { useI18n } from "vue-i18n";
import TrashCan from "vue-material-design-icons/TrashCan.vue";
import Pencil from "vue-material-design-icons/Pencil.vue";

const { t } = useI18n();

const $toast = useToast();

const columns = ref([
    {
        label: t("revenues.table_nom"),
        field: "titre",
    },
    {
        label: t("revenues.table_montant"),
        field: "montant",
    },
    {
        label: t("revenues.table_type"),
        field: "type",
    },
    {
        label: t("revenues.table_date"),
        field: "revenue_date",
    },

    {
        label: t("revenues.table_actions"),
        field: "actions",
    },
]);
const rows = computed(() =>
    Object.values(props.revenues).map((revenue) => ({
        id: revenue.id,
        titre: revenue.titre,
        montant: revenue.montant,
        revenue_date: revenue.revenue_date,
        reference_file: revenue.reference_file,
        type: revenue.revenue_type.name,
        revenue_type_id: revenue.revenue_type_id,
    }))
);

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
    if (confirm("Are you sure?")) {
        form.delete(route("revenues.destroy", id), {
            onSuccess: () => {
                $toast.open({
                    message: "revenue supprimé avec succès",
                    type: "success",
                    duration: 3000,
                    dismissible: true,
                });
            },
            onError: () => {
                $toast.open({
                    message: "Erreur lors de la suppression",
                    type: "error",
                    duration: 3000,
                    dismissible: true,
                });
            },
        });
    }
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
                    $toast.open({
                        message: "Revenue modifié avec succès",
                        type: "success",
                        duration: 3000,
                        dismissible: true,
                    });
                },
                onError: () => {
                    $toast.open({
                        message: "Erreur lors de la modification",
                        type: "error",
                        duration: 3000,
                        dismissible: true,
                    });
                },
            }
        );
    } else {
        form.post(route("revenues.store"), {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
                $toast.open({
                    message: "dépense ajouté avec succès",
                    type: "success",
                    duration: 3000,
                    dismissible: true,
                });
            },
            // onError: () => {
            //     $toast.open({
            //         message: "Erreur lors de l'ajout",
            //         type: "error",
            //         duration: 3000,
            //         dismissible: true,
            //     });
            // },
        });
    }
};
</script>
