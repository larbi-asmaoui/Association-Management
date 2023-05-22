<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
};
</script>

<script setup>
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import { Modal } from "flowbite-vue";
import Pagination from "../../Components/Pagination.vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

const $toast = useToast();

const form = useForm({
    montant: null,
    depense_date: null,
    depense_type_id: null,
});

let isModalOpen = ref(false);

const closeModal = () => {
    isModalOpen.value = false;

    form.reset();
};

const destroy = (id) => {
    if (confirm("Are you sure?")) {
        form.delete(route("depenses.destroy", id), {
            onSuccess: () => {
                $toast.open({
                    message: "depense supprimé avec succès",
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
    form.get(route("depenses.show", id));
};
const props = defineProps({
    depenses: {
        type: Object,
        default: () => ({}),
    },
    depenseTypes: {
        type: Object,
        default: () => ({}),
    },
});

const submit = () => {
    form.post(route("depenses.store"), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            $toast.open({
                message: "depense ajouté avec succès",
                type: "success",
                duration: 3000,
                dismissible: true,
            });
        },
        onError: () => {
            console.log(form);
            // $toast.open({
            //     message: "Erreur lors de l'ajout",
            //     type: "error",
            //     duration: 3000,
            //     dismissible: true,
            // });
        },
    });
};

let search = ref("");
watch(search, (value) => {
    router.get(
        "/depenses",
        { search: value },
        {
            preserveState: true,
            replace: true,
        }
    );
});
</script>
<template>
    {{ depenseTypes }}
    <div class="bg-white px-4 py-6 shadow-md rounded-lg">
        <div class="mb-4">
            <h1
                class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"
            >
                Depenses
            </h1>
        </div>
        <div
            class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
        >
            <div class="flex items-center mb-4 sm:mb-0">
                <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
                    <input
                        type="text"
                        v-model="search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="rechercher..."
                    />
                </div>
            </div>
            <button
                @click="isModalOpen = true"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                type="button"
            >
                Ajouter Depense
            </button>
        </div>

        <teleport to="body">
            <Modal size="md" v-if="isModalOpen" @close="closeModal">
                <template #header>
                    <div class="flex items-center text-lg">Ajouter Depense</div>
                </template>
                <template #body>
                    <form
                        class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2"
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
                            <div>
                                <label
                                    for="depense_date"
                                    class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                    >Date d'ajout
                                </label>

                                <input
                                    v-model="form.depense_date"
                                    type="date"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="Select date"
                                    name="depense_date"
                                />
                                <span
                                    v-if="form.errors.depense_date"
                                    class="text-xs text-red-600 mt-1"
                                    id="hs-validation-name-error-helper"
                                >
                                    {{ form.errors.depense_date }}
                                </span>
                            </div>
                        </div>

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
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg"></div>
        </div>
    </div>
</template>
