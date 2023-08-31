<template>
    <a-modal
        @cancel="closeModal"
        :footer="null"
        v-model:open="isModalOpen"
        :title="
            form.id ? $t('classes.modal_modifier') : $t('classes.modal_ajouter')
        "
    >
        <form
            :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
            class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2 overflow-y-auto max-h-[30rem]"
            @submit.prevent="submit"
        >
            <div>
                <label
                    for="title"
                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                    >{{ $t("classes.table_nom") }}</label
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
                    v-if="form.errors.supervisors"
                    class="text-xs text-red-600 mt-1"
                    id="hs-validation-name-error-helper"
                >
                    {{ form.errors.supervisors }}
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
    </a-modal>

    <!-- Category -->
    <a-modal
        @cancel="closeCatMoadal"
        :footer="null"
        v-model:open="isCatModalOpen"
        :title="
            catForm.id
                ? $t('classes.modal_modifier_category')
                : $t('classes.modal_ajouter_category')
        "
    >
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
                        >{{ $t("classes.category") }}
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
    </a-modal>

    <div class="w-auto h-full py-4 px-2">
        <tabs variant="underline" v-model="activeTab" class="pt-5">
            <tab name="first" :title="$t('classes.classes')">
                <div class="relative">
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
                    <a-config-provider
                        :direction="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
                    >
                        <!-- <a-input
                            placeholder="Search"
                            style="margin-bottom: 20px"
                        /> -->

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
                                    @click="destroy(record.id)"
                                    ><TrashCan
                                /></el-button>
                            </template>
                        </a-table>
                    </a-config-provider>
                </div>
            </tab>
            <tab name="second" :title="$t('classes.categories')">
                <div class="relative">
                    <div
                        class="gap-2 py-1 mb-2 justify-between items-center block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
                    >
                        <el-button
                            class="me-auto"
                            type="primary"
                            size="large"
                            @click="isCatModalOpen = true"
                        >
                            <Plus />
                        </el-button>
                    </div>

                    <a-config-provider
                        :direction="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
                    >
                        <!-- <a-input
                            placeholder="Search"
                            style="margin-bottom: 20px"
                        /> -->

                        <a-table
                            :columns="categoryColumns"
                            :data-source="categoryRows"
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
                                    @click="openCatEditModal(record)"
                                    ><Pencil />
                                </el-button>
                                <span class="me-2"></span>

                                <el-button
                                    v-if="record.classes_count === 0"
                                    type="danger"
                                    size="small"
                                    @click="destroyCat(record.id)"
                                    ><TrashCan
                                /></el-button>
                            </template>
                        </a-table>
                    </a-config-provider>
                </div>
            </tab>
        </tabs>
    </div>
</template>

<script>
import RootLayout from "../../Layouts/RootLayout.vue";

export default {
    layout: RootLayout,
};
</script>

<script setup>
// import Table from "../../Components/Table.vue";
import moment from "moment";
import { Tabs, Tab, TheCard } from "flowbite-vue";
import Swal from "sweetalert2";
import Multiselect from "@vueform/multiselect";
import { ref, computed } from "vue";
import "vue-toast-notification/dist/theme-sugar.css";
import { router, useForm } from "@inertiajs/vue3";
import { useI18n } from "vue-i18n";
import Plus from "vue-material-design-icons/Plus.vue";
import TrashCan from "vue-material-design-icons/TrashCan.vue";
import Pencil from "vue-material-design-icons/Pencil.vue";
import Toast from "../../utils.js";

const { t, availableLocales, locale } = useI18n();
const pageSize = ref(10);
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
const columns = computed(() => [
    {
        title: t("classes.table_nom"),
        dataIndex: "name",
        key: "name",
        sorter: {
            compare: (a, b) => a.name.localeCompare(b.name),
        },
        multipe: 1,
    },
    {
        title: t("classes.category"),
        dataIndex: "category",
        key: "category",
        sorter: {
            compare: (a, b) => a.category.localeCompare(b.category),
        },
    },
    {
        title: t("classes.supervisor_count"),
        dataIndex: "supervisor_count",
        key: "supervisor_count",
        sorter: {
            compare: (a, b) => a.supervisor_count - b.supervisor_count,
        },
    },

    {
        title: t("classes.adherent_count"),
        key: "adherents_count",
        dataIndex: "adherents_count",
        sorter: {
            compare: (a, b) => a.adherents_count - b.adherents_count,
        },
    },

    {
        title: "Action",
        key: "action",
        slots: { customRender: "action" },
    },
]);

const rows = computed(() =>
    Object.values(props.classes).map((classe) => ({
        id: classe.id,
        name: classe.name,
        description: classe.description ?? "-",
        category_id: classe.category_id,
        category: classe.category.name,
        adherents: classe.adherents,
        adherents_count: classe.adherents.length,
        supervisor_count: classe.supervisors.length,
        supervisors: classe.supervisors,
    })),
);

const categoryColumns = computed(() => [
    {
        title: t("classes.category"),
        dataIndex: "name",
        key: "name",
        sorter: {
            compare: (a, b) => a.name.localeCompare(b.name),
        },
        multipe: 1,
    },
    {
        title: t("classes.classes_count"),
        dataIndex: "classes_count",
        key: "classes_count",
        sorter: {
            compare: (a, b) => a.classes_count - b.classes_count,
        },
    },

    {
        title: "Action",
        key: "action",
        slots: { customRender: "action" },
    },
]);

const categoryRows = computed(() =>
    Object.values(props.categories).map((category) => ({
        id: category.id,
        name: category.name,
        classes_count: category.classes.length,
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
            onError: () => {
                Toast.fire({
                    icon: "error",
                    title: t("toasts.modif_error"),
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
const openEditModal = (classe) => {
    form.id = classe.id;
    form.name = classe.name;
    form.description = classe.description;
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

<!-- <style src="@vueform/multiselect/themes/default.css"></style> -->
