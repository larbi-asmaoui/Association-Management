<script>
import MainLayout from "../../Layouts/MainLayout.vue";
export default {
    layout: MainLayout,
};
</script>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    adherants: {
        type: Object,
        default: () => ({}),
    },
    cotisations: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    montant: null,
    type: "",
    adherant_id: null,
    cotisation_date: null,
});

const show = (id) => {
    form.get(route("cotisations.show", id));
};

const destroy = (id) => {
    if (confirm("Are you sure to delete?")) {
        form.delete(route("cotisations.destroy", id));
    }
};

const submit = () => {
    form.post(route("cotisations.store"), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
};

let isModalOpen = ref(false);

const closeModal = () => {
    isModalOpen.value = false;

    form.reset();
};
</script>

<template>
    <h3 class="text-gray-700 text-3xl font-medium">Gestion Cotisations</h3>

    <div class="mt-4">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-2 py-4 flex justify-between content-center">
                    <input
                        type="text"
                        v-model="search"
                        placeholder="Search..."
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5"
                    />
                    <button
                        @click="isModalOpen = true"
                        class="px-6 py-3 font-medium tracking-wide text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none"
                    >
                        Ajouter cotisation
                    </button>

                    <!-- Main -->
                    <div
                        v-if="isModalOpen"
                        id="authentication-modal"
                        class="overflow-x-hidden overflow-y-auto fixed h-modal md:h-full top-4 mt-4 left-0 right-0 md:inset-0 z-50 flex justify-center items-start"
                    >
                        <!-- Backdrop -->
                        <div
                            @click="isModalOpen = false"
                            class="fixed inset-0 bg-black opacity-50"
                        ></div>
                        <div
                            class="relative w-full max-w-md px-4 h-full md:h-auto"
                        >
                            <!-- Modal content -->
                            <div
                                class="bg-white rounded-lg shadow relative dark:bg-gray-700"
                            >
                                <div class="flex justify-end p-2">
                                    <button
                                        @click="isModalOpen = false"
                                        type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                                        data-modal-toggle="authentication-modal"
                                    >
                                        <svg
                                            class="w-5 h-5"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            ></path>
                                        </svg>
                                    </button>
                                </div>
                                <form
                                    class="space-y-6 px-6 lg:px-6 pb-4 sm:pb-6 xl:pb-8"
                                    @submit.prevent="submit"
                                >
                                    <h3
                                        class="text-xl font-medium text-gray-900 dark:text-white"
                                    >
                                        Ajouter une cotisation
                                    </h3>

                                    <div
                                        class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6"
                                    >
                                        <div>
                                            <label
                                                for="montant"
                                                class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                                >Montant
                                            </label>
                                            <input
                                                step="any"
                                                v-model="form.montant"
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
                                            <input
                                                v-model="form.type"
                                                type="text"
                                                name="type"
                                                id="type"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                            />
                                            <span
                                                v-if="form.errors.type"
                                                class="text-xs text-red-600 mt-1"
                                                id="hs-validation-name-error-helper"
                                            >
                                                {{ form.errors.type }}
                                            </span>
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            for="date"
                                            class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                                            >Date
                                        </label>

                                        <input
                                            v-model="form.date"
                                            type="date"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                            placeholder="Select date"
                                            name="date"
                                        />
                                        <span
                                            v-if="form.errors.date"
                                            class="text-xs text-red-600 mt-1"
                                            id="hs-validation-name-error-helper"
                                        >
                                            {{ form.errors.date }}
                                        </span>
                                    </div>

                                    <!-- Dropdown -->
                                    <div>
                                        <label
                                            for="adherants"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                            >Select an option</label
                                        >
                                        <select
                                            v-model="form.adherant_id"
                                            id="adherants"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 appearance-none select-none relative z-10"
                                        >
                                            <option
                                                v-for="adherant in adherants"
                                                :key="adherant.id"
                                                :value="adherant.id"
                                                class="bg-white dark:bg-gray-800 py-2.5 px-4 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700"
                                            >
                                                {{ adherant.first_name }}
                                                {{ adherant.last_name }}
                                            </option>
                                        </select>
                                        <span
                                            v-if="form.errors.adherant_id"
                                            class="text-xs text-red-600 mt-1"
                                            id="hs-validation-name-error-helper"
                                        >
                                            {{ form.errors.adherant_id }}
                                        </span>
                                    </div>

                                    <!-- end Dropdown -->

                                    <div class="mt-5 flex justify-end gap-x-2">
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
                            </div>
                        </div>
                    </div>
                    <!-- End -->
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    #
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Adherant
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Type
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Date
                                </th>

                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Montant
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr
                                v-for="cotisation in cotisations"
                                :key="cotisation.id"
                                class="hover:bg-gray-100 transition-colors duration-200"
                            >
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ cotisation.id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{
                                        cotisation.adherant.first_name +
                                        " " +
                                        cotisation.adherant.last_name
                                    }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ cotisation.type }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ cotisation.created_at }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ cotisation.montant }}
                                </td>

                                <td
                                    class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                                >
                                    <div
                                        class="flex items-center justify-end space-x-2"
                                    >
                                        <!-- Eye -->
                                        <button
                                            class="text-gray-400 hover:text-purple-500 transition-colors duration-200"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
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
                                        </button>

                                        <!-- Edit -->
                                        <button
                                            class="text-gray-400 hover:text-purple-500 transition-colors duration-200"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
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
                                        </button>

                                        <!-- Delete -->
                                        <button
                                            @click="destroy(cotisation.id)"
                                            class="text-gray-400 hover:text-purple-500 transition-colors duration-200"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
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
                                        </button>

                                        <!-- Print -->
                                        <button
                                            class="text-gray-400 hover:text-purple-500 transition-colors duration-200"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke="none"
                                                    d="M0 0h24v24H0z"
                                                    fill="none"
                                                />
                                                <path
                                                    d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"
                                                />
                                                <path
                                                    d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"
                                                />
                                                <rect
                                                    x="7"
                                                    y="13"
                                                    width="10"
                                                    height="8"
                                                    rx="2"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
