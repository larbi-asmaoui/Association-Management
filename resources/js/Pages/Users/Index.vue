<template>
    <div
        class="gap-2 pb-4 justify-between items-center block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
    >
        <h1
            class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"
        >
            {{ $t("users.titre") }}
        </h1>
        <!-- <button
            @click="isModalOpen = true"
            class="ms-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
            type="button"
        >
            {{ $t("users.modal_ajouter_role") }}
        </button> -->
        <button
            @click="isModalOpen = true"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
            type="button"
        >
            {{ $t("users.modal_ajouter") }}
        </button>
    </div>

    <teleport to="body">
        <Modal size="md" v-if="isModalOpen" @close="closeModal">
            <template #header>
                <div class="flex items-center text-lg">
                    {{
                        form.id
                            ? $t("users.modal_modifier")
                            : $t("users.modal_ajouter")
                    }}
                </div>
            </template>
            <template #body>
                <form
                    :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
                    class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2"
                    @submit.prevent="submit"
                >
                    <div class="grid grid-cols-1 gap-4 lg:gap-6">
                        <div>
                            <label
                                for="name"
                                class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                >{{ $t("users.input_nom") }}
                            </label>
                            <input
                                v-model="form.name"
                                type="text"
                                name="name"
                                id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            />
                            <span
                                v-if="form.errors.name"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.name }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 lg:gap-6">
                        <div>
                            <label
                                for="Email"
                                class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                >{{ $t("users.input_email") }}
                            </label>
                            <input
                                v-model="form.email"
                                type="text"
                                name="email"
                                id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
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

                    <div
                        class="grid grid-cols-1 gap-4 lg:gap-6"
                        v-show="!form.id"
                    >
                        <div>
                            <label
                                for="mot de passe"
                                class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                >{{ $t("users.input_mot_de_passe") }}
                            </label>
                            <input
                                v-model="form.password"
                                type="password"
                                name="password"
                                id="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            />
                            <span
                                v-if="form.errors.password"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.password }}
                            </span>
                        </div>
                    </div>

                    <!-- <div class="grid grid-cols-1 gap-4 lg:gap-6">
                        <div>
                            <label
                                for="role"
                                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                            >
                                {{ $t("users.input_role") }}</label
                            >
                            <select
                                v-model="form.role"
                                id="type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            >
                                <option disabled value="">
                                    {{ $t("users.input_role") }}
                                </option>
                                <option
                                    v-for="role in roles"
                                    :key="role.id"
                                    :value="role.name"
                                >
                                    {{ role.name }}
                                </option>
                            </select>
                            <span
                                v-if="form.errors.role"
                                class="text-xs text-red-600 mt-1"
                                id="hs-validation-name-error-helper"
                            >
                                {{ form.errors.role }}
                            </span>
                        </div>
                    </div> -->

                    <div class="grid grid-cols-1 gap lg:gap-6">
                        <div>
                            <label
                                for="permissions"
                                class="text-sm font-medium text-gray-900 block dark:text-gray-300"
                                >{{ $t("users.permissions") }}
                            </label>
                            <Multiselect
                                v-model="form.permissions"
                                mode="tags"
                                :close-on-select="false"
                                :searchable="true"
                                :create-option="true"
                                :options="formattedPermissions"
                            />
                        </div>
                    </div>

                    <div class="mt-5 flex justify-end gap-x-2">
                        <button
                            @click="isModalOpen = false"
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
                                form.id
                                    ? t("buttons.modifier")
                                    : t("buttons.enregistrer")
                            }}
                        </button>
                    </div>
                </form></template
            ></Modal
        >
    </teleport>

    <div class="bg-white w-auto rounded-md h-full">
        <tabs variant="underline" v-model="activeTab" class="pt-5">
            <tab name="first" :title="$t('users.titre')">
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
                                @click="openEditModal(row)"
                                class="cursor-pointer w-4 mr-2 transform hover:text-blue-500 hover:scale-110"
                            >
                                <Pencil :size="20" />
                            </div>

                            <!-- Delete -->

                            <div
                                @click="destroy(row.id)"
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
            </tab>
        </tabs>
    </div>

    {{ userPermissions }}
</template>
<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<script setup>
import Multiselect from "@vueform/multiselect";
import TrashCan from "vue-material-design-icons/TrashCan.vue";
import Pencil from "vue-material-design-icons/Pencil.vue";
import { VueGoodTable } from "vue-good-table-next";
import "vue-good-table-next/dist/vue-good-table-next.css";
import { Tabs, Tab } from "flowbite-vue";
import Swal from "sweetalert2";
import { usePage } from "@inertiajs/vue3";
import { Modal } from "flowbite-vue";
import { ref, computed } from "vue";
import { watch } from "vue";
import { router } from "@inertiajs/vue3";
import { TheCard } from "flowbite-vue";
import { useForm } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { useI18n } from "vue-i18n";
import Toast from "../../utils.js";
const { t, availableLocales, locale } = useI18n();

const $toast = useToast();

const props = defineProps({
    users: {
        type: Object,
        default: () => ({}),
    },
    roles: {
        type: Object,
        default: () => ({}),
    },
    permissions: {
        type: Object,
        default: () => ({}),
    },
});

const userPermissions = computed(() => {
    return usePage().props.auth.user.permissions;
});

const columns = ref([
    {
        label: t("users.table_username"),
        field: "name",
    },
    {
        label: t("users.table_email"),
        field: "email",
    },
    // {
    //     label: t("users.table_role"),
    //     field: "role",
    // },

    {
        label: t("adherents.table_actions"),
        field: "actions",
    },
]);

const rows = computed(() =>
    Object.values(props.users).map((user) => ({
        id: user.id,
        name: user.name,
        email: user.email,
        // role: user.role,
        permissions: user.permissions,
    })),
);

const activeTab = ref("first");

const form = useForm({
    id: null,
    name: null,
    email: null,
    password: null,
    permissions: [],
});

let isModalOpen = ref(false);

const closeModal = () => {
    isModalOpen.value = false;

    form.reset();
};

const openEditModal = (user) => {
    form.id = user.id;
    form.name = user.name;
    form.email = user.email;
    form.password = user.password;
    form.permissions = user.permissions
        ? user.permissions.map((permission) => permission.id)
        : [];
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
            router.delete(route("users.destroy", id), {
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
    if (form.id) {
        form.put(route("users.update", form.id), {
            // forceFormData: true,
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
                    icon: "success",
                    title: t("toasts.modif_error"),
                });
            },
        });
    } else {
        form.post(route("users.store"), {
            forceFormData: true,
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

const formattedPermissions = computed(() =>
    Object.values(props.permissions).map((permission) => ({
        value: permission.id,
        label: permission.name,
    })),
);
</script>
