<template>
    <div class="mb-4 bg-blue-600 px-4 py-4 shadow-md">
        <h1 class="text-xl font-semibold text-white sm:text-2xl">
            Revenues de l'association
        </h1>
    </div>
    <div class="bg-white px-4 py-6 shadow-md">
        <div
            class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
        >
            <div class="flex items-center mb-4 sm:mb-0">
                <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                    <input
                        type="text"
                        v-model="search"
                        class="bg-slate-200 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="rechercher..."
                    />
                </div>
            </div>
            <button
                @click="isModalOpen = true"
                class="inline-flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                type="button"
            >
                <svg
                    class="w-5 h-5 mr-2 -ml-1"
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
                Ajouter revenue
            </button>
        </div>

        <teleport to="body">
            <Modal size="xl" v-if="isModalOpen" @close="closeModal">
                <template #header>
                    <div class="flex items-center text-lg">
                        {{
                            form.id
                                ? "Mettre à jour un revenue"
                                : "Ajouter un revenue"
                        }}
                    </div>
                </template>
                <template #body>
                    <form
                        class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2 h-[32rem] overflow-y-auto"
                        @submit.prevent="submit"
                    >
                        <div>
                            <label
                                for="montant"
                                class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                >Montant
                            </label>
                            <input
                                v-model="form.montant"
                                min="1"
                                step="0.01"
                                type="number"
                                name="montant"
                                id="montant"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
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
                                class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                >Type
                            </label>
                            <select
                                v-model="form.revenue_type_id"
                                id="revenueTypes"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 appearance-none select-none relative z-10"
                            >
                                <option
                                    v-for="revenueType in revenueTypes"
                                    :key="revenueType.id"
                                    :value="revenueType.id"
                                    class="bg-white dark:bg-gray-800 py-2.5 px-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700"
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
                                    class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                    >Date d'opération
                                </label>

                                <input
                                    v-model="form.revenue_date"
                                    type="date"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
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
                                class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                for="file_input"
                                >Reference
                            </label>

                            <input
                                @change="onFileChange"
                                @input="
                                    form.reference_file = $event.target.files[0]
                                "
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                id="file_input"
                                type="file"
                                required
                            />
                            <p
                                class="mt-1 text-sm text-gray-500 dark:text-gray-300"
                                id="file_input_help"
                            >
                                SVG, PNG, JPG, GIF
                            </p>
                        </div>
                        <img v-if="previewUrl" :src="previewUrl" />
                        <img
                            v-else-if="form.reference_file"
                            :src="showImage() + form.reference_file"
                        />
                        <div class="mt-8 flex justify-end gap-x-2">
                            <button
                                @click="isModalOpen = false"
                                type="button"
                                class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800"
                            >
                                Annuler
                            </button>
                            <button
                                type="submit"
                                class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm dark:focus:ring-offset-gray-800"
                            >
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </template>
            </Modal>
        </teleport>

        <div class="mt-4">
            <div class="overflow-hidden bg-white">
                <div class="bg-white">
                    <div class="relative shadow-lg mb-5">
                        <table
                            class="w-full sm:rounded-lg text-sm text-left text-gray-500 border-collapse dark:text-gray-400"
                        >
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th
                                        scope="col"
                                        class="border border-slate-400 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        #
                                    </th>
                                    <th
                                        scope="col"
                                        class="border border-slate-400 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Montant (DH)
                                    </th>
                                    <th
                                        scope="col"
                                        class="border border-slate-400 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Type
                                    </th>

                                    <th
                                        scope="col"
                                        class="border border-slate-400 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Date d'operation
                                    </th>
                                    <th
                                        scope="col"
                                        class="border border-slate-400 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="revenue in revenues.data"
                                    :key="revenue.id"
                                >
                                    <td
                                        scope="row"
                                        class="border border-slate-400 px-6 py-3 text-base font-medium text-gray-900 whitespace-normal dark:text-white"
                                    >
                                        {{ revenue.id }}
                                    </td>
                                    <td
                                        class="border border-slate-400 px-6 py-3 text-base font-medium text-gray-900 whitespace-normal dark:text-white"
                                    >
                                        {{ revenue.montant }}
                                    </td>
                                    <td
                                        class="border border-slate-400 px-6 py-3 text-base font-medium text-gray-900 whitespace-normal dark:text-white"
                                    >
                                        {{ revenue.revenue_type.name }}
                                    </td>

                                    <td
                                        class="border border-slate-400 px-6 py-3 text-base font-medium text-gray-900 whitespace-normal dark:text-white"
                                    >
                                        {{ revenue.revenue_date }}
                                    </td>

                                    <Modal
                                        size="md"
                                        v-if="isModalOpenApercu"
                                        @close="closeModal"
                                    >
                                        <template #header>
                                            <div
                                                class="flex items-center text-lg"
                                            >
                                                Aperçu
                                            </div>
                                        </template>
                                        <template #body>
                                            <div class="flex justify-center">
                                                <img
                                                    :src="
                                                        showImage() +
                                                        revenue.reference_file
                                                    "
                                                />
                                            </div>
                                        </template>
                                        <template #footer>
                                            <button
                                                @click="
                                                    isModalOpenApercu = false
                                                "
                                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                                type="button"
                                            >
                                                Fermer
                                            </button>
                                        </template>
                                    </Modal>

                                    <td
                                        class="border border-slate-400 px-6 py-3 text-base font-medium text-gray-900 whitespace-normal dark:text-white"
                                    >
                                        <div class="flex">
                                            <!-- Eye -->
                                            <div
                                                @click="
                                                    isModalOpenApercu = true
                                                "
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
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                    ></path>
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                    ></path>
                                                </svg>
                                            </div>

                                            <!-- Edit -->
                                            <div
                                                @click="openEditModal(revenue)"
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
                                                @click="destroy(revenue.id)"
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
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Pagination :data="revenues" />
                </div>
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
import { ref, watch, onMounted, onBeforeUnmount } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Modal } from "flowbite-vue";
import Pagination from "../../Components/Pagination.vue";
import { useToast } from "vue-toast-notification";
import "viewerjs/dist/viewer.css";
import "vue-toast-notification/dist/theme-sugar.css";

const $toast = useToast();

const form = useForm({
    id: null,
    montant: null,
    revenue_date: null,
    reference_file: null,
    revenue_type_id: null,
});

let isModalOpen = ref(false);
let isModalOpenApercu = ref(false);

const closeModal = () => {
    isModalOpenApercu.value = false;
    isModalOpen.value = false;

    form.reset();
};
const showImage = () => {
    return "/storage/";
};

const selectedFile = ref(null);
const previewUrl = ref(null);

const onFileChange = (e) => {
    selectedFile.value = e.target.files[0];
    previewUrl.value = URL.createObjectURL(selectedFile.value);
};

const openEditModal = (revenue) => {
    form.id = revenue.id;
    form.montant = revenue.montant;
    form.revenue_date = revenue.revenue_date;
    form.reference_file = revenue.reference_file;
    form.revenue_type_id = revenue.revenue_type_id;
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

const show = (id) => {
    form.get(route("revenues.show", id));
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
        form.put(route("revenues.update", form.id), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
                $toast.open({
                    message: "revenue modifié avec succès",
                    type: "success",
                    duration: 3000,
                    dismissible: true,
                });
                selectedFile.value = null;
                previewUrl.value = null;
            },
            onError: () => {
                $toast.open({
                    message: "Erreur lors de la modification",
                    type: "error",
                    duration: 3000,
                    dismissible: true,
                });
            },
        });
    } else {
        form.post(route("revenues.store"), {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                closeModal();
                $toast.open({
                    message: "revenue ajouté avec succès",
                    type: "success",
                    duration: 3000,
                    dismissible: true,
                });
                selectedFile.value = null;
                previewUrl.value = null;
            },
            onError: () => {
                console.log(form.errors.revenue_date);
                console.log(form.errors.montant);
                console.log(form.errors.revenue_type_id);
                $toast.open({
                    message: "Erreur lors de l'ajout",
                    type: "error",
                    duration: 3000,
                    dismissible: true,
                });
            },
        });
    }
};

let search = ref("");
watch(search, (value) => {
    router.get(
        "/revenues",
        { search: value },
        {
            preserveState: true,
            replace: true,
        }
    );
});
</script>
