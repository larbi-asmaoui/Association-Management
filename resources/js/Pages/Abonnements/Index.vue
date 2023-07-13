<script>
import MainLayout from "../../Layouts/MainLayout.vue";
export default {
    layout: MainLayout,
};
</script>

<script setup>
import { VueGoodTable } from "vue-good-table-next";
import "vue-good-table-next/dist/vue-good-table-next.css";
import { ref, computed, reactive, watchEffect, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { Modal } from "flowbite-vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { useI18n } from "vue-i18n";
import TrashCan from "vue-material-design-icons/TrashCan.vue";
import Eye from "vue-material-design-icons/Eye.vue";
import Printer from "vue-material-design-icons/Printer.vue";
import Plus from "vue-material-design-icons/Plus.vue";
import Filter from "vue-material-design-icons/Filter.vue";

const { t, availableLocales, locale } = useI18n();
const $toast = useToast();

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
});

const selectedPayementDate = ref("");
const selectedEndDate = ref("");
const selectedAbonnements = ref(props.abonnements);

const showInfo = ref(false);
const filteredItems = reactive([]);

const form = useForm({
    montant: null,
    adherent_id: null,
    // : null,
});
const showFilterForm = ref(false);
let isModalOpen = ref(false);

const showInfoModal = () => {
    showInfo.value = !showInfo.value;
};
const clearFilters = () => {
    selectedPayementDate.value = "";
    selectedAbonnements.value = props.abonnements;
};

const applyFilters = () => {
    // filter selected adherents by birth date

    const abonnementArray = props.abonnements;
    filteredItems.value = abonnementArray.filter((item) => {
        let isMatch = true;

        if (
            selectedPayementDate.value &&
            item.date_payement <= selectedPayementDate.value
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
const columns = ref([
    {
        label: t("adherents.table_nom_complete"),
        field: "nom_complet",
    },
    {
        label: t("abonnements.table_montant"),
        field: "montant",
    },
    {
        label: t("abonnements.table_date"),
        field: "date_payement",
    },

    {
        label: t("adherents.table_actions"),
        field: "actions",
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
        adherent_id: abonnement.adherent_id,
        date_payement: abonnement.date_payement,
    }))
);

const showFilter = () => {
    showFilterForm.value = !showFilterForm.value;
};

const destroy = (id) => {
    if (confirm("Are you sure to delete?")) {
        form.delete(route("abonnements.destroy", id), {
            onSuccess: () => {
                $toast.open({
                    message: t("toasts.supp_success"),
                    type: "success",
                    duration: 3000,
                    dismissible: true,
                });
            },
            onError: () => {
                $toast.open({
                    message: t("toasts.supp_error"),
                    type: "error",
                    duration: 3000,
                    dismissible: true,
                });
            },
        });
    }
};

const submit = () => {
    form.post(route("abonnements.store"), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            $toast.open({
                message: t("toasts.ajout_success"),
                type: "success",
                duration: 3000,
                dismissible: true,
            });
        },
        onError: () => {
            $toast.open({
                message: t("toasts.ajout_error"),
                type: "error",
                duration: 3000,
                dismissible: true,
            });
        },
    });
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
};
</script>

<template>
    <button
        @click="isModalOpen = true"
        class="rounded-full fixed bottom-8 z-50 text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium text-sm p-5 focus:outline-none"
        type="button"
        :class="$i18n.locale === 'ar' ? 'left-5' : 'right-5'"
    >
        <Plus />
    </button>

    <div class="bg-white pt-6 shadow-md rounded-xl relative mt-5">
        <div
            class="shadow-lg bg-blue-600 p-4 absolute top-1.5 left-1/2 w-11/12 rounded-full transform -translate-x-1/2 -translate-y-1/2"
        >
            <h2
                class="text-xl font-semibold text-white"
                :class="$i18n.locale === 'ar' ? 'text-right' : 'text-left'"
            >
                {{ $t("abonnements.titre") }}
            </h2>
        </div>

        <div
            class="mt-7 items-center justify-between block sm:flex md:divide-x md:divide-gray-100"
        >
            <div class="px-2 w-full flex items-center mb-4 gap-4 sm:mb-0">
                <!--  -->
                <!-- <button
                    class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800"
                >
                    button
                </button> -->
                <button
                    @click="showFilter"
                    class="ms-auto relative text-white py-2 px-2 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 transition-all text-sm"
                >
                    <Filter />
                </button>
            </div>
        </div>

        <teleport to="body">
            <Modal size="xl" v-if="isModalOpen" @close="closeModal">
                <template #header>
                    <div class="flex items-center text-lg">
                        {{ $t("abonnements.modal_ajouter") }}
                    </div>
                </template>
                <template #body>
                    <form
                        :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
                        class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2"
                        @submit.prevent="submit"
                    >
                        <!-- Dropdown -->
                        <div>
                            <label
                                for="adherents"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >{{ $t("abonnements.choose_adherent") }}</label
                            >
                            <select
                                v-model="form.adherent_id"
                                id="adherents"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 appearance-none select-none relative z-10"
                            >
                                <option
                                    v-for="adherent in adherents"
                                    :key="adherent.id"
                                    :value="adherent.id"
                                    class="bg-white dark:bg-gray-800 py-2.5 px-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700"
                                >
                                    {{ adherent.first_name }}
                                    {{ adherent.last_name }}
                                </option>
                            </select>
                            <span
                                v-if="form.errors.adherent_id"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.adherent_id }}
                            </span>
                        </div>

                        <!-- end Dropdown -->

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
                    </form>
                </template>
                <!-- <template #footer>

                </template> -->
            </Modal>
        </teleport>

        <div class="mt-1 px-4 transition-all ease-in">
            <div
                class="w-full m-auto bg-gray-100 border border-gray-300 shadow-md p-4"
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
                                v-model="selectedPayementDate"
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
                                v-model="selectedEndDate"
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
        </div>
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
                :rtl="$i18n.locale === 'ar'"
                ><template v-slot:table-row="{ row, column, formattedRow }">
                    <div v-if="column.field === 'actions'" class="flex">
                        <div
                            @click="router.get(`/adherents/${row.adherent_id}`)"
                            class="cursor-pointer w-4 mr-2 transform hover:text-blue-500 hover:scale-110"
                        >
                            <Eye :size="20" />
                        </div>

                        <!-- Delete -->

                        <div
                            @click="destroy(row.id)"
                            class="cursor-pointer w-4 mr-2 transform hover:text-blue-500 hover:scale-110"
                        >
                            <TrashCan :size="20" />
                        </div>
                        <!-- print -->
                        <div
                            @click=""
                            class="cursor-pointer w-4 mr-2 transform hover:text-blue-500 hover:scale-110"
                        >
                            <Printer :size="20" />
                        </div>
                    </div>
                    <div v-else>
                        {{ formattedRow[column.field] }}
                    </div></template
                >
            </vue-good-table>
        </div>
    </div>
</template>
