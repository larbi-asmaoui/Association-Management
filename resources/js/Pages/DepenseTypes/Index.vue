<script>
import RootLayout from "../../Layouts/RootLayout.vue";

export default {
    layout: RootLayout,
};
</script>

<template>
    <div
        class="mb-4 bg-white px-4 py-4 rounded-md shadow-md justify-between items-center block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
    >
        <h1
            class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"
        >
            {{ $t("types.depenses_types") }}
        </h1>
        <button
            @click="isModalOpen = true"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
            type="button"
        >
            {{ $t("types.ajouter_type") }}
        </button>
    </div>

    <a-modal
        @cancel="closeModal"
        :footer="null"
        v-model:open="isModalOpen"
        :title="form.id ? $t('types.modifier_type') : $t('types.ajouter_type')"
        ><form
            :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
            class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2"
            @submit.prevent="submit"
        >
            <div class="grid grid-cols-1 gap-4 lg:gap-6">
                <div>
                    <label
                        for="name"
                        class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                        >{{ $t("types.type_name") }}
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
                            ? $t("buttons.modifier")
                            : $t("buttons.enregistrer")
                    }}
                </button>
            </div>
        </form>
    </a-modal>

    <div class="mt-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <the-card v-for="depenseType in depenseTypes" :key="depenseType.id">
                <h5
                    class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
                >
                    {{ depenseType.name }}
                </h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">
                    {{ $t("date_ajout") }} {{ depenseType.created_at }}
                </p>
                <div class="flex justify-center mt-5 items-center">
                    <button
                        @click="openEditModal(depenseType)"
                        class="me-2 text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-lg font-medium px-4 py-2 inline-flex space-x-1 items-center"
                    >
                        <span
                            ><svg
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
                        </span>
                    </button>
                    <button
                        v-show="depenseType.depenses.length == 0"
                        @click="destroy(depenseType)"
                        class="text-slate-800 hover:text-white text-sm bg-white hover:bg-red-600 border border-slate-200 rounded-lg font-medium px-4 py-2 inline-flex space-x-1 items-center"
                    >
                        <span>
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
                        </span>
                    </button>
                </div>
            </the-card>
        </div>
    </div>
</template>

<script setup>
import Swal from "sweetalert2";
import { Modal } from "flowbite-vue";
import { ref } from "vue";
import { watch } from "vue";
import { router } from "@inertiajs/vue3";
import { TheCard } from "flowbite-vue";
import { useForm } from "@inertiajs/vue3";
import { useI18n } from "vue-i18n";
import Toast from "../../utils.js";
const { t } = useI18n();

const props = defineProps({
    depenseTypes: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    id: null,
    name: null,
});
let isModalOpen = ref(false);

const closeModal = () => {
    isModalOpen.value = false;

    form.reset();
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
            router.delete(route("depense-types.destroy", id), {
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

const openEditModal = (depenseType) => {
    form.id = depenseType.id;
    form.name = depenseType.name;
    isModalOpen.value = true;
};

const submit = () => {
    if (form.id) {
        form.put(route("depense-types.update", form.id), {
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
        form.post(route("depense-types.store"), {
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
</script>
