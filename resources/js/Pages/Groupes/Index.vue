<template>
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

    <div class="w-auto h-full py-4 px-2">
        <h2
            class="text-xl font-semibold text-black-600 mb-4"
            :class="$i18n.locale === 'ar' ? 'text-right' : 'text-left'"
        >
            {{ $t("groupes.titre") }}
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
    groupes: {
        type: Object,
        default: () => ({}),
    },
    adherents: {
        type: Object,
        default: () => ({}),
    },
});
const pageSize = ref(10);
const form = useForm({
    id: null,
    name: null,
    description: null,
    adherents: [],
});

const columns = computed(() => [
    {
        title: t("groupes.table_nom"),
        dataIndex: "name",
        key: "name",
        sorter: {
            compare: (a, b) => a.name.localeCompare(b.name),
        },
        multipe: 1,
    },

    {
        title: t("groupes.table_description"),
        dataIndex: "description",
        key: "description",
        sorter: {
            compare: (a, b) => a.description.localeCompare(b.description),
        },
        multipe: 1,
    },
    {
        title: t("groupes.table_nombre_adherents"),
        dataIndex: "nombre_de_membres",
        key: "nombre_de_membres",
        sorter: {
            compare: (a, b) =>
                a.nombre_de_membres.localeCompare(b.nombre_de_membres),
        },
        multipe: 1,
    },

    {
        title: t("adherents.table_actions"),
        dataIndex: "actions",
        key: "actions",
        slots: { customRender: "action" },
    },
]);
const rows = computed(() =>
    Object.values(props.groupes).map((groupe) => ({
        id: groupe.id,
        name: groupe.name,
        description: groupe.description ?? "-",
        nombre_de_membres: groupe.adherents_count,
        adherents: groupe.adherents,
    })),
);

const submit = () => {
    if (form.id) {
        form.put(route("groupes.update", form.id), {
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
        form.post(route("groupes.store"), {
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
    Swal.fire({
        text: t("modals_questions.supprimer"),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: t("buttons.supprimer"),
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route("groupes.destroy", id), {
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
    })),
);
</script>

<!-- <style src="@vueform/multiselect/themes/default.css"></style> -->
