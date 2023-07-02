<template>
    <button
        @click="isModalOpen = true"
        class="rounded-full z-50 fixed bottom-8 text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium text-sm p-5 focus:outline-none"
        type="button"
        :class="$i18n.locale === 'ar' ? 'left-5' : 'right-5'"
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
            <h2
                class="text-xl font-semibold text-white"
                :class="$i18n.locale === 'ar' ? 'text-right' : 'text-left'"
            >
                {{ $t("groupes.titre") }}
            </h2>
        </div>
        <div
            class="mt-7 items-center justify-between block sm:flex md:divide-x md:divide-gray-100"
        ></div>

        <teleport to="body">
            <Modal size="xl" v-if="isModalOpen" @close="closeModal">
                <template #header>
                    <div class="flex items-center text-lg">
                        {{ $t("groupes.modal_ajouter") }}
                    </div>
                </template>
                <template #body>
                    <form
                        :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
                        class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2 overflow-y-auto max-h-[30rem]"
                        @submit.prevent="submit"
                    >
                        <div>
                            <label
                                for="title"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >{{ $t("groupes.input_groupe") }}</label
                            >
                            <input
                                v-model="form.name"
                                type="text"
                                name="title"
                                id="title"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :placeholder-gray-400 :text-white"
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
                                for="description"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >{{ $t("groupes.input_description") }}</label
                            >
                            <textarea
                                v-model="form.description"
                                rows="5"
                                name="description"
                                id="description"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :placeholder-gray-400 :text-white"
                            ></textarea>
                            <span
                                v-if="form.errors.description"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.description }}
                            </span>
                        </div>

                        <div>
                            <label
                                for="adherents"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                >{{ $t("groupes.input_adherents") }}</label
                            >
                            <Multiselect
                                v-model="form.adherents"
                                mode="tags"
                                :close-on-select="false"
                                :searchable="true"
                                :create-option="true"
                                :options="formattedAdherents"
                            />
                        </div>

                        <div class="mt-5 flex justify-end gap-x-2">
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
                                {{ $t("buttons.ajouter") }}
                            </button>
                        </div>
                    </form>
                </template>
            </Modal>
        </teleport>

        <div class="mt-4">
            <div class="relative">
                <!-- vue table -->
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
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                    ></path>
                                </svg>
                            </div>

                            <!-- Delete -->

                            <div
                                v-if="row.nombre_de_membres == 0"
                                @click="destroy(row)"
                                class="cursor-pointer w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                        <div v-else>
                            {{ formattedRow[column.field] }}
                        </div>
                    </template>
                </vue-good-table>
                <!-- vue table -->
            </div>
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
import Multiselect from "@vueform/multiselect";
import { ref, computed } from "vue";
import { watch } from "vue";
import { Modal } from "flowbite-vue";
import { router } from "@inertiajs/vue3";
import Pagination from "../../Components/Pagination.vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { useForm } from "@inertiajs/vue3";
import { useI18n } from "vue-i18n";
const { t, availableLocales, locale } = useI18n();

const props = defineProps({
    groupes: {
        type: Object,
        default: () => ({}),
    },
    adherents: {
        type: Object,
        default: () => ({}),
    },
});

const $toast = useToast();

const form = useForm({
    id: null,
    name: null,
    description: null,
    adherents: [],
});

const columns = ref([
    {
        label: t("groupes.table_nom"),
        field: "name",
    },
    {
        label: t("groupes.table_description"),
        field: "description",
    },
    {
        label: t("groupes.table_nombre_adherents"),
        field: "nombre_de_membres",
    },

    {
        label: t("adherents.table_actions"),
        field: "actions",
    },
]);
const rows = computed(() =>
    Object.values(props.groupes).map((groupe) => ({
        id: groupe.id,
        name: groupe.name,
        description: groupe.description ?? "-",
        nombre_de_membres: groupe.adherents_count,
        adherents: groupe.adherents,
    }))
);

const submit = () => {
    if (form.id) {
        form.put(route("groupes.update", form.id), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
                $toast.open({
                    message: "Groupe modifié avec succès",
                    type: "success",
                    duration: 3000,
                    dismissible: true,
                });
            },
        });
    } else {
        form.post(route("groupes.store"), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
                $toast.open({
                    message: "Groupe ajouté avec succès",
                    type: "success",
                    duration: 3000,
                    dismissible: true,
                });
            },
        });
    }
};

let isModalOpen = ref(false);

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
};

const dropdownOpen = ref(false);

const show = (id) => {
    form.get(route("groupes.show", id));
};

const destroy = (id) => {
    if (confirm("Are you sure?")) {
        form.delete(route("groupes.destroy", id), {
            preserveScroll: true,
            onSuccess: () => {
                $toast.open({
                    message: "Groupe supprimé avec succès",
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

const openEditModal = (groupe) => {
    form.id = groupe.id;
    form.name = groupe.name;
    form.description = groupe.description;
    form.adherents = groupe.adherents.map((adherent) => adherent.id);
    isModalOpen.value = true;
};

const formattedAdherents = computed(() =>
    Object.values(props.adherents).map((adherent) => ({
        value: adherent.id,
        label: adherent.last_name + " " + adherent.first_name,
    }))
);
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
