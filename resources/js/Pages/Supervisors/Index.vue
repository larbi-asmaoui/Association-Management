<template>
    <div class="w-auto h-full py-4 px-2">
        <h2
            class="text-xl font-semibold text-black-600 mb-4"
            :class="$i18n.locale === 'ar' ? 'text-right' : 'text-left'"
        >
            {{ $t("supervisors.titre") }}
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
                <template v-slot:image="{ record }">
                    <a-avatar :size="64" :src="showImage(record)"> </a-avatar>
                </template>
                <template v-slot:action="{ record }">
                    <el-button
                        type="primary"
                        size="small"
                        @click="show(record.id)"
                        ><Eye />
                    </el-button>
                    <span class="me-2"></span>

                    <el-button
                        type="danger"
                        size="small"
                        @click="destroy(record)"
                        ><TrashCan
                    /></el-button>
                </template> </a-table
        ></a-config-provider>
    </div>

    <a-modal
        width="80%"
        @cancel="closeModal"
        :footer="null"
        v-model:open="isModalOpen"
        :title="
            form.id
                ? $t('supervisors.modal_modifier')
                : $t('supervisors.modal_ajouter')
        "
    >
        <form
            :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
            class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2 overflow-y-auto max-h-[30rem]"
            @submit.prevent="submit"
        >
            <div>
                <label
                    for="avatar"
                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                    >{{ $t("adherents.input_image") }}
                </label>
                <ImageUpload v-model="form.image" :default-src="defaultImg" />
                <span
                    v-if="form.errors.image"
                    class="text-xs text-red-600 mt-1"
                    id="hs-validation-name-error-helper"
                >
                    {{ form.errors.image }}
                </span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 lg:gap-2">
                <div>
                    <label
                        for="title"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("supervisors.first_name")
                        }}<span class="text-red-600">*</span></label
                    >
                    <input
                        v-model="form.first_name"
                        type="text"
                        name="title"
                        id="title"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :placeholder-gray-400 :text-white"
                    />
                    <span
                        v-if="form.errors.first_name"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.first_name }}
                    </span>
                </div>
                <div>
                    <label
                        for="title"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("supervisors.last_name")
                        }}<span class="text-red-600">*</span></label
                    >
                    <input
                        v-model="form.last_name"
                        type="text"
                        name="title"
                        id="title"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :placeholder-gray-400 :text-white"
                    />
                    <span
                        v-if="form.errors.last_name"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.last_name }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 lg:gap-2">
                <div>
                    <label
                        for="cin"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("adherents.input_cin")
                        }}<span class="text-red-600">*</span></label
                    >
                    <input
                        v-model="form.cin"
                        type="text"
                        name="cin"
                        id="cin"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                    />
                    <span
                        v-if="form.errors.cin"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.cin }}
                    </span>
                </div>
                <div>
                    <label
                        for="date_of_birth"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("adherents.input_date_naissance")
                        }}<span class="text-red-600">*</span>
                    </label>

                    <input
                        v-model="form.date_of_birth"
                        type="date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                        placeholder="Select date"
                        name="date_of_birth"
                    />
                    <span
                        v-if="form.errors.date_of_birth"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.date_of_birth }}
                    </span>
                </div>
            </div>
            <div>
                <label
                    for="hs-about-hire-us-1"
                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                    >{{ $t("adherents.input_addresse")
                    }}<span class="text-red-600">*</span></label
                >
                <textarea
                    v-model="form.address"
                    id="address"
                    name="address"
                    rows="2"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                ></textarea>
                <span
                    v-if="form.errors.address"
                    class="text-xs text-red-600 mt-1"
                    id="hs-validation-name-error-helper"
                >
                    {{ form.errors.address }}
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 lg:gap-2">
                <div>
                    <label
                        for="tel"
                        class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                        >{{ $t("adherents.input_telephone") }}
                    </label>
                    <input
                        v-model="form.tel"
                        type="text"
                        name="tel"
                        id="tel"
                        autocomplete="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :text-white"
                    />
                    <span
                        v-if="form.errors.tel"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ form.errors.tel }}
                    </span>
                </div>
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
</template>

<script>
import RootLayout from "../../Layouts/RootLayout.vue";

export default {
    layout: RootLayout,
};
</script>

<script setup>
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
import Eye from "vue-material-design-icons/Eye.vue";
import Toast from "../../utils.js";
import ImageUpload from "../../Components/ImageUpload.vue";

const { t, availableLocales, locale } = useI18n();

const props = defineProps({
    supervisors: {
        type: Object,
        default: () => ({}),
    },
});
const pageSize = ref(10);
const form = useForm({
    id: null,
    first_name: null,
    last_name: null,
    cin: null,
    tel: null,
    address: null,
    date_of_birth: null,
    image: null,
});

const rows = computed(() =>
    Object.values(props.supervisors).map((supervisor) => ({
        id: supervisor.id,
        first_name: supervisor.first_name,
        last_name: supervisor.last_name,
        image: supervisor.image,
        tel: supervisor.tel,
        address: supervisor.address,
        date_of_birth: supervisor.date_of_birth,
        cin: supervisor.cin,
    })),
);

const columns = computed(() => [
    {
        title: "#",
        dataIndex: "image",
        key: "image",
        slots: { customRender: "image" },
    },
    {
        title: t("supervisors.first_name"),
        dataIndex: "first_name",
        key: "first_name",
        sorter: {
            compare: (a, b) => a.first_name.localeCompare(b.first_name),
        },
    },
    {
        title: t("supervisors.last_name"),
        dataIndex: "last_name",
        key: "last_name",
        sorter: {
            compare: (a, b) => a.last_name.localeCompare(b.last_name),
        },
    },
    // {
    //     title: t("supervisors.date_of_birth"),
    //     dataIndex: "date_of_birth",
    //     key: "date_of_birth",
    // },
    // {
    //     title: t("supervisors.address"),
    //     dataIndex: "address",
    //     key: "address",
    // },
    {
        title: t("supervisors.cin"),
        dataIndex: "cin",
        key: "cin",
        sorter: {
            compare: (a, b) => a.cin.localeCompare(b.cin),
        },
    },
    {
        title: t("supervisors.telephone"),
        dataIndex: "tel",
        key: "tel",
        sorter: {
            compare: (a, b) => a.tel.localeCompare(b.tel),
        },
    },
    {
        title: "Action",
        key: "action",
        slots: { customRender: "action" },
    },
]);

const submit = () => {
    if (form.id) {
        form.put(route("supervisors.update", form.id), {
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
        form.post(route("supervisors.store"), {
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

// const dropdownOpen = ref(false);

const show = (id) => {
    form.get(route("supervisors.show", id));
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
            form.delete(route("supervisors.destroy", id), {
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
const openEditModal = (supervisor) => {
    form.id = supervisor.id;
    form.first_name = supervisor.first_name;
    form.last_name = supervisor.last_name;
    form.cin = supervisor.cin;
    form.tel = supervisor.tel;
    form.address = supervisor.address;
    form.date_of_birth = supervisor.date_of_birth;
    form.image = supervisor.image;
    isModalOpen.value = true;
};

const showImage = (supervisor) => {
    return "/storage/" + supervisor.image;
};
</script>

<!-- <style src="@vueform/multiselect/themes/default.css"></style> -->
