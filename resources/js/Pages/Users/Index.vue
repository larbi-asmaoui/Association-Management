<template>
    <a-modal
        @cancel="closeModal"
        :footer="null"
        v-model:open="isModalOpen"
        :title="
            form.id ? $t('users.modal_modifier') : $t('users.modal_ajouter')
        "
    >
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

            <div class="grid grid-cols-1 gap-4 lg:gap-6" v-show="!form.id">
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
                    <span
                        v-if="form.errors.permissions"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.permissions }}
                    </span>
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
        </form>
    </a-modal>

    <div class="w-auto h-full py-4 px-2">
        <h2
            class="text-xl font-semibold text-black-600 mb-4"
            :class="$i18n.locale === 'ar' ? 'text-right' : 'text-left'"
        >
            {{ $t("users.titre") }}
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
                        @click="destroy(record.id)"
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
<style src="@vueform/multiselect/themes/default.css"></style>
<script setup>
import Multiselect from "@vueform/multiselect";
import TrashCan from "vue-material-design-icons/TrashCan.vue";
import Pencil from "vue-material-design-icons/Pencil.vue";
import Plus from "vue-material-design-icons/Plus.vue";
import Swal from "sweetalert2";
import { usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
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

const pageSize = ref(10);

const columns = computed(() => [
    {
        title: t("users.table_username"),
        dataIndex: "name",
        key: "name",
        sorter: {
            compare: (a, b) => a.name.localeCompare(b.name),
        },
        multipe: 1,
    },
    {
        title: t("users.table_email"),
        dataIndex: "email",
        key: "email",
        sorter: {
            compare: (a, b) => a.email.localeCompare(b.email),
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
    Object.values(props.users).map((user) => ({
        id: user.id,
        name: user.name,
        email: user.email,
        // role: user.role,
        permissions: user.permissions,
    })),
);

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
    form.clearErrors();
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
        label: t(`permissions.${permission.name}`),
    })),
);
</script>
