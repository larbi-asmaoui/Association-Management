<template>
    <h3 class="text-gray-700 text-3xl font-medium">Gestion Évènements</h3>

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
                        Ajouter un évènement
                    </button>

                    <!-- Main -->
                    <div
                        v-if="isModalOpen"
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
                                        Ajouter un évènement
                                    </h3>
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
                                            rows="5"
                                            name="description"
                                            id="description"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                            required
                                        ></textarea>
                                    </div>

                                    <div class="flex justify-between">
                                        <div>
                                            <label
                                                for="start"
                                                class="block text-sm text-gray-700 font-medium dark:text-white"
                                                >Date de début
                                            </label>

                                            <input
                                                :min="
                                                    new Date()
                                                        .toISOString()
                                                        .split('T')[0]
                                                "
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
                                                :min="
                                                    new Date()
                                                        .toISOString()
                                                        .split('T')[0]
                                                "
                                                v-model="form.end"
                                                type="date"
                                                class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400"
                                                placeholder="Select date"
                                                name="end"
                                            />
                                        </div>
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

                                    <!-- DropDown -->
                                    <div
                                        class="mt-1 sm:mt-1 hs-dropdown relative sm:inline-flex z-20 [--auto-close:inside]"
                                    >
                                        <button
                                            @click="toggleDropdown"
                                            type="button"
                                            class="hs-dropdown-toggle py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800"
                                        >
                                            Sélectionner groupe
                                            <svg
                                                :class="{
                                                    'hs-dropdown-open:rotate-180':
                                                        isDropdownOpen,
                                                }"
                                                class="w-2.5 h-2.5 text-gray-600"
                                                width="16"
                                                height="16"
                                                viewBox="0 0 16 16"
                                                fill="none"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                />
                                            </svg>
                                        </button>

                                        <div
                                            v-if="isDropdownOpen"
                                            class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden mt-2 bg-white shadow-md rounded-lg p-2 mt-2 dark:bg-gray-800 dark:border dark:border-gray-700"
                                        >
                                            <div
                                                class="relative flex items-start py-2 px-3 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700"
                                            >
                                                <div
                                                    class="flex items-center h-5 mt-1"
                                                >
                                                    <input
                                                        id="hs-dropdown-item-checkbox-delete"
                                                        name="hs-dropdown-item-checkbox-delete"
                                                        type="checkbox"
                                                        class="border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                                        checked
                                                    />
                                                </div>
                                                <label
                                                    for="hs-dropdown-item-checkbox-delete"
                                                    class="ml-3.5"
                                                >
                                                    <span
                                                        class="mt-1 block text-sm font-semibold text-gray-800 dark:text-gray-300"
                                                        >Delete</span
                                                    >
                                                </label>
                                            </div>
                                            <div
                                                class="relative flex items-start py-2 px-3 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700"
                                            >
                                                <div
                                                    class="flex items-center h-5 mt-1"
                                                >
                                                    <input
                                                        id="hs-dropdown-item-checkbox-archive"
                                                        name="hs-dropdown-item-checkbox-archive"
                                                        type="checkbox"
                                                        class="border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                                    />
                                                </div>
                                                <label
                                                    for="hs-dropdown-item-checkbox-archive"
                                                    class="ml-3.5"
                                                >
                                                    <span
                                                        class="mt-1 block text-sm font-semibold text-gray-800 dark:text-gray-300"
                                                        >Archive</span
                                                    >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Dropdown -->

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
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr
                                v-for="evenement in evenements.data"
                                :key="evenement.id"
                                class="hover:bg-gray-100 transition-colors duration-200"
                            >
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ evenement.id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ evenement.title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ evenement.start }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ evenement.end }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ evenement.location }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
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
