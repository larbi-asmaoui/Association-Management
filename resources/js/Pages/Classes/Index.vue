<template>
    <teleport to="body">
        <Modal size="xl" v-if="isModalOpen" @close="closeModal">
            <template #header>
                <div class="flex items-center text-lg">
                    {{ $t("classes.modal_ajouter") }}
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
                            >{{ $t("classes.classe") }}</label
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
                            >{{ $t("classes.input_description") }}</label
                        >
                        <textarea
                            v-model="form.description"
                            rows="2"
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
                    <!-- category -->
                    <div>
                        <label
                            for="title"
                            class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                            >{{ $t("classes.category") }}</label
                        >
                        <Multiselect
                            v-model="form.category_id"
                            :close-on-select="true"
                            :searchable="true"
                            :create-option="true"
                            :options="formattedCategories"
                        />
                        <span
                            v-if="form.errors.category_id"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.category_id }}
                        </span>
                    </div>

                    <div>
                        <label
                            for="title"
                            class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                            >{{ $t("classes.supervisor") }}</label
                        >
                        <Multiselect
                            v-model="form.supervisors"
                            mode="tags"
                            :close-on-select="false"
                            :searchable="true"
                            :create-option="true"
                            :options="formattedSupervisors"
                        />
                        <span
                            v-if="form.errors.supervisor_id"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ form.errors.supervisor_id }}
                        </span>
                    </div>

                    <!-- Membre -->
                    <div>
                        <label
                            for="adherents"
                            class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                            >{{ $t("classes.input_adherents") }}</label
                        >
                        <Multiselect
                            v-model="form.adherents"
                            mode="tags"
                            :close-on-select="false"
                            :searchable="true"
                            :create-option="true"
                            :options="formattedAdherents"
                        />

                        <span
                            v-if="form.errors.adherents"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        ></span>
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

    <!-- Category Modal -->
    <Modal size="md" v-if="isCatModalOpen" @close="closeCatMoadal">
        <template #header>
            <div class="flex items-center text-lg">
                {{
                    catForm.id
                        ? $t("types.modifier_type")
                        : $t("types.ajouter_type")
                }}
            </div>
        </template>

        <template #body>
            <form
                :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
                class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2 overflow-y-auto max-h-[30rem]"
                @submit.prevent="submitCat"
            >
                <div class="grid grid-cols-1 gap-4 lg:gap-6">
                    <div>
                        <label
                            for="name"
                            class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                            >{{ $t("types.type_name") }}
                        </label>
                        <input
                            v-model="catForm.name"
                            type="text"
                            name="name"
                            id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                        />
                        <span
                            v-if="catForm.errors.name"
                            class="text-xs text-red-600 mt-1"
                            id="hs-validation-name-error-helper"
                        >
                            {{ catForm.errors.name }}
                        </span>
                    </div>
                </div>

                <div class="mt-5 flex justify-end gap-x-2">
                    <button
                        @click="isCatModalOpen = false"
                        type="button"
                        class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800"
                    >
                        {{ $t("buttons.annuler") }}
                    </button>
                    <button
                        type="submit"
                        class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800"
                    >
                        {{
                            catForm.id
                                ? $t("buttons.modifier")
                                : $t("buttons.enregistrer")
                        }}
                    </button>
                </div>
            </form>
        </template>
    </Modal>

    <div class="w-auto h-full py-4 px-2">
        <tabs variant="underline" v-model="activeTab" class="pt-5">
            <tab name="first" :title="$t('classes.classes')">
                <div class="relative bg-white rounded-md">
                    <div
                        class="gap-2 p-4 justify-between items-center block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
                    >
                        <button
                            @click="isModalOpen = true"
                            class="me-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                            type="button"
                        >
                            <Plus />
                        </button>
                    </div>
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
                        <template
                            v-slot:table-row="{ row, column, formattedRow }"
                        >
                            <div
                                v-if="column.field === 'actions'"
                                class="flex justify-center items-center"
                            >
                                <div
                                    @click="openEditModal(row)"
                                    class="cursor-pointer w-4 mr-2 transform hover:text-blue-500 hover:scale-110"
                                >
                                    <Pencil :size="20" />
                                </div>

                                <!-- Delete -->

                                <div
                                    @click="destroy(row)"
                                    class="cursor-pointer w-4 mr-2 transform hover:text-blue-500 hover:scale-110"
                                >
                                    <TrashCan :size="20" />
                                </div>
                            </div>
                            <div v-else>
                                {{ formattedRow[column.field] }}
                            </div>
                        </template>
                    </vue-good-table>
                    <!-- vue table -->
                </div>
            </tab>
            <tab name="second" :title="$t('classes.categories')">
                <div
                    class="gap-2 p-2 justify-between items-center block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
                >
                    <button
                        @click="isCatModalOpen = true"
                        class="me-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                        type="button"
                    >
                        <Plus />
                    </button>
                </div>
                <div class="mt-4">
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4"
                    >
                        <the-card
                            v-for="category in categories"
                            :key="category.id"
                        >
                            <div
                                class="flex justify-between items-center gap-2"
                            >
                                <h5
                                    class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                                >
                                    {{ category.name }}
                                </h5>
                                <button
                                    @click="openCatEditModal(category)"
                                    class="ms-auto text-slate-800 hover:text-blue-600 text-sm inline-flex space-x-1 items-center"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-4 h-4"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"
                                        />
                                    </svg>
                                </button>
                                <button
                                    v-if="category.classes.length === 0"
                                    @click="destroyCat(category.id)"
                                    class="text-slate-800 hover:text-blue-600 text-sm inline-flex space-x-1 items-center"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-4 h-4"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                                        />
                                    </svg>
                                </button>
                            </div>

                            <p
                                class="font-normal text-gray-700 dark:text-gray-400"
                            >
                                {{ $t("classes.classes_count") }}
                                {{ classes.length }}
                            </p>

                            <p
                                class="font-normal text-gray-700 dark:text-gray-400"
                            >
                                {{ $t("date_ajout") }}
                                {{
                                    moment(category.created_at).format(
                                        "DD/MM/YYYY",
                                    )
                                }}
                            </p>
                        </the-card>
                    </div>
                </div>
            </tab>
        </tabs>
    </div>
</template>

<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
};
</script>

<script setup>
import moment from "moment";
import { Tabs, Tab, TheCard, StackedAvatars, Avatar } from "flowbite-vue";
import Swal from "sweetalert2";
import { VueGoodTable } from "vue-good-table-next";
import "vue-good-table-next/dist/vue-good-table-next.css";
import Multiselect from "@vueform/multiselect";
import { ref, computed } from "vue";
import { Modal } from "flowbite-vue";
import "vue-toast-notification/dist/theme-sugar.css";
import { useForm } from "@inertiajs/vue3";
import { useI18n } from "vue-i18n";
import Plus from "vue-material-design-icons/Plus.vue";
import TrashCan from "vue-material-design-icons/TrashCan.vue";
import Pencil from "vue-material-design-icons/Pencil.vue";
import Toast from "../../utils.js";

const { t, availableLocales, locale } = useI18n();

const props = defineProps({
    classes: {
        type: Object,
        default: () => ({}),
    },
    adherents: {
        type: Object,
        default: () => ({}),
    },
    supervisors: {
        type: Object,
        default: () => ({}),
    },
    categories: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    id: null,
    name: null,
    description: null,
    // supervisor_id: null,
    category_id: null,
    supervisors: [],
    adherents: [],
});

const catForm = useForm({
    id: null,
    name: null,
});

let isModalOpen = ref(false);
const isCatModalOpen = ref(false);

const closeCatMoadal = () => {
    isCatModalOpen.value = false;
    catForm.reset();
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
};

const openCatEditModal = (category) => {
    catForm.id = category.id;
    catForm.name = category.name;
    isCatModalOpen.value = true;
};

const activeTab = ref("first");

const columns = ref([
    {
        label: t("classes.table_nom"),
        field: "name",
    },
    {
        label: t("classes.table_description"),
        field: "description",
    },
    // {
    //     label: t("classes.supervisor"),
    //     field: "supervisor",
    // },
    {
        label: t("classes.adherent_count"),
        field: "adherents_count",
    },

    {
        label: t("adherents.table_actions"),
        field: "actions",
    },
]);
const rows = computed(() =>
    Object.values(props.classes).map((classe) => ({
        id: classe.id,
        name: classe.name,
        description: classe.description ?? "-",
        // supervisor:
        //     classe.supervisor.first_name + " " + classe.supervisor.last_name,
        // supervisor_id: classe.supervisor_id,
        adherents: classe.adherents,
        adherents_count: classe.adherents.length,
    })),
);

const submit = () => {
    if (form.id) {
        form.put(route("classes.update", form.id), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();

                Toast.fire({
                    icon: "success",
                    title: t("toasts.modif_success"),
                });
            },
        });
    } else {
        form.post(route("classes.store"), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();

                Toast.fire({
                    icon: "success",
                    title: t("toasts.ajout_success"),
                });
            },
        });
    }
};

const submitCat = () => {
    if (catForm.id) {
        catForm.put(route("categories.update", catForm.id), {
            // forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                closeCatMoadal();
                Toast.fire({
                    icon: "success",
                    title: t("toasts.modif_success"),
                });
            },
            onError: () => {
                Toast.fire({
                    icon: "success",
                    title: t("toasts.modif_error"),
                });
            },
        });
    } else {
        catForm.post(route("categories.store"), {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                closeCatMoadal();
                Toast.fire({
                    icon: "success",
                    title: t("toasts.ajout_success"),
                });
            },
        });
    }
};

const destroyCat = (id) => {
    Swal.fire({
        text: t("modals_questions.supprimer"),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: t("buttons.supprimer"),
    }).then((result) => {
        if (result.isConfirmed) {
            catForm.delete(route("categories.destroy", id), {
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
            form.delete(route("classes.destroy", id), {
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
const openEditModal = (classe) => {
    form.id = classe.id;
    form.name = classe.name;
    form.description = classe.description;
    // form.supervisor_id = classe.supervisor_id;
    form.category_id = classe.category_id;
    form.adherents = classe.adherents.map((adherent) => adherent.id);
    form.supervisors = classe.supervisors.map((supervisor) => supervisor.id);
    isModalOpen.value = true;
};

const formattedAdherents = computed(() =>
    Object.values(props.adherents).map((adherent) => ({
        value: adherent.id,
        label: adherent.last_name + " " + adherent.first_name,
    })),
);

const formattedSupervisors = computed(() =>
    Object.values(props.supervisors).map((supervisor) => ({
        value: supervisor.id,
        label: supervisor.last_name + " " + supervisor.first_name,
    })),
);

const formattedCategories = computed(() =>
    Object.values(props.categories).map((category) => ({
        value: category.id,
        label: category.name,
    })),
);
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
