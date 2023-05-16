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
                                    <!-- <multiselect></multiselect> -->

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
                    <table
                        class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">#</th>
                                <th scope="col" class="px-6 py-3">Évènement</th>
                                <th scope="col" class="px-6 py-3">
                                    Date début
                                </th>
                                <th scope="col" class="px-6 py-3">Date fin</th>
                                <th scope="col" class="px-6 py-3">Location</th>
                                <th scope="col" class="px-6 py-3">Budget</th>
                                <th scope="col" class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                v-for="evenement in evenements.data"
                                :key="evenement.id"
                            >
                                <th
                                    scope="row"
                                    class="px-3 py-3 font-medium whitespace-nowrap"
                                >
                                    {{ evenement.id }}
                                </th>
                                <th
                                    scope="row"
                                    class="px-3 py-3 font-medium whitespace-nowrap"
                                >
                                    {{ evenement.title }}
                                </th>
                                <th
                                    scope="row"
                                    class="px-3 py-3 font-medium whitespace-nowrap"
                                >
                                    {{ evenement.start }}
                                </th>
                                <th
                                    scope="row"
                                    class="px-3 py-3 font-medium whitespace-nowrap"
                                >
                                    {{ evenement.end }}
                                </th>
                                <th
                                    scope="row"
                                    class="px-3 py-3 font-medium whitespace-nowrap"
                                >
                                    {{ evenement.location }}
                                </th>
                                <th
                                    scope="row"
                                    class="px-3 py-3 font-medium whitespace-nowrap"
                                >
                                    100DH
                                </th>
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
        onSuccess: () => {
            closeModal();
            form.reset("title", "description", "start", "end", "location");
            page.value.$inertia.$refresh(); // This will refresh the page
        },
    });
};

const isModalOpen = ref(false);
const isDropdownOpen = ref(false);

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

const toggleModal = () => {
    isModalOpen.value = !isModalOpen.value;
};

const closeModal = () => {
    isModalOpen.value = false;
};
</script>
