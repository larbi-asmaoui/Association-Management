<template>
    <div class="mb-4">
        <h1
            class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"
        >
            Gestion Évènements
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
                    placeholder="rechercher évènements..."
                />
            </div>
        </div>
        <button
            @click="isModalOpen = true"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
            type="button"
        >
            Ajouter un évènement
        </button>
    </div>

    <teleport to="body">
        <Modal size="xl" v-if="isModalOpen" @close="closeModal">
            <template #header>
                <div class="flex items-center text-lg">
                    Ajouter un évènement
                </div>
            </template>
            <template #body>
                <form
                    class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2"
                    @submit.prevent="submit"
                >
                    <div>
                        <label
                            for="title"
                            class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                            >Titre de l'évènement</label
                        >
                        <input
                            v-model="form.title"
                            type="text"
                            name="title"
                            id="title"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required
                        />
                    </div>
                    <div>
                        <label
                            for="description"
                            class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                            >Description</label
                        >
                        <textarea
                            v-model="form.description"
                            rows="3"
                            name="description"
                            id="description"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required
                        ></textarea>
                    </div>

                    <div>
                        <label
                            for="start"
                            class="block text-sm text-gray-700 font-medium dark:text-white"
                            >Date de début
                        </label>

                        <input
                            :min="new Date().toISOString().split('T')[0]"
                            v-model="form.start"
                            lang="fr-FR"
                            type="date"
                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                            placeholder="Select date"
                            name="start"
                        />
                    </div>
                    <!--  -->
                    <div>
                        <label
                            for="end"
                            class="block text-sm text-gray-700 font-medium dark:text-white"
                            >Date de Fin
                        </label>

                        <input
                            lang="fr-CA"
                            :min="new Date().toISOString().split('T')[0]"
                            v-model="form.end"
                            type="date"
                            class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                            placeholder="Select date"
                            name="end"
                        />
                    </div>

                    <div>
                        <label
                            for="location"
                            class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                            >Location</label
                        >
                        <input
                            v-model="form.location"
                            type="text"
                            name="location"
                            id="location"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required
                        />
                    </div>

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
            </template>
        </Modal>
    </teleport>

    <div class="mt-4">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="bg-white border-b border-gray-200">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table
                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                    >
                        <thead class="bg-gray-100 dark:bg-gray-700">
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
                                    Évènement
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Date début
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Date fin
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Location
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Budget
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody
                            class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"
                        >
                            <tr
                                v-for="evenement in evenements.data"
                                :key="evenement.id"
                            >
                                <td
                                    class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    {{ evenement.id }}
                                </td>
                                <td
                                    class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    {{ evenement.title }}
                                </td>
                                <td
                                    class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    {{ evenement.start }}
                                </td>
                                <td
                                    class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    {{ evenement.end }}
                                </td>
                                <td
                                    class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    {{ evenement.location }}
                                </td>
                                <td
                                    class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                >
                                    100DH
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
<script>
import MainLayout from "../../Layouts/MainLayout.vue";
export default {
    layout: MainLayout,
};
</script>

<script setup>
import { ref } from "vue";
import { Modal } from "flowbite-vue";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

const $toast = useToast();

const props = defineProps({
    evenements: {
        type: Object,
        default: () => ({}),
    },
    groupes: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    id: "",
    title: "",
    description: "",
    start: "",
    end: "",
    location: "",
});

const submit = () => {
    form.post(route("evenements.store"), {
        onError: () => {
            $toast.open({
                message: "Une erreur s'est produite",
                type: "error",
                dismissible: true,
                duration: 3000,
            });
        },
        onSuccess: () => {
            closeModal();
            $toast.open({
                message: "Évènement ajouté avec succès",
                type: "success",
                dismissible: true,
                duration: 3000,
            });
            // form.reset("title", "description", "start", "end", "location");
            // page.value.$inertia.$refresh(); // This will refresh the page
        },
    });
};

const isModalOpen = ref(false);
const isDropdownOpen = ref(false);

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

const closeModal = () => {
    isModalOpen.value = false;
};
</script>
