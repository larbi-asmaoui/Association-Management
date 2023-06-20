<template>
  <button
    @click="isModalOpen = true"
    class="rounded-full z-50 fixed bottom-8 right-5 text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium text-sm p-5 focus:outline-none"
    type="button"
  >
    <svg
      class="w-5 h-5"
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
  </button>

  <div class="bg-white pt-6 shadow-md rounded-md relative mt-5">
    <div
      class="shadow-lg bg-blue-600 p-4 absolute top-1.5 left-1/2 w-11/12 rounded-full transform -translate-x-1/2 -translate-y-1/2"
    >
      <h2 class="text-xl font-semibold text-white">Gestion Réunions</h2>
    </div>
    <div
      class="mt-7 items-center justify-between block sm:flex md:divide-x md:divide-gray-100"
    ></div>

    <teleport to="body">
      <Modal size="xl" v-if="isModalOpen" @close="closeModal">
        <template #header>
          <div class="flex items-center text-lg">Ajouter un Réunion</div>
        </template>
        <template #body>
          <form
            class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2 overflow-y-auto max-h-[30rem]"
            @submit.prevent="submit"
          >
            <div>
              <label
                for="title"
                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                >Titre du Réunion</label
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
                for="title"
                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                >Date du Réunion</label
              >
              <input
                v-model="form.date"
                type="date"
                name="date"
                id="date"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :placeholder-gray-400 :text-white"
              />
              <span
                v-if="form.errors.date"
                class="text-xs text-red-600 mt-1"
                id="hs-validation-date-error-helper"
              >
                {{ form.errors.date }}
              </span>
            </div>
            <div>
              <label
                for="description"
                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                >Description</label
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
                for="type"
                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                >Type
              </label>
              <select
                v-model="form.reunion_type_id"
                id="reunionTypes"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-blue-500 :focus:border-blue-500 appearance-none select-none relative z-10"
              >
                <option
                  v-for="reunionType in reunionTypes"
                  :key="reunionType.id"
                  :value="reunionType.id"
                  class="bg-white :bg-gray-800 py-2.5 px-4 cursor-pointer hover:bg-gray-200 :hover:bg-gray-700"
                >
                  {{ reunionType.name }}
                </option>
              </select>
              <span
                v-if="form.errors.reunion_type_id"
                class="text-xs text-red-600 mt-1"
                id="hs-validation-name-error-helper"
              >
                {{ form.errors.reunion_type_id }}
              </span>
            </div>

            <div class="mt-5 flex justify-end gap-x-2">
              <button
                @click="isModalOpen = false"
                type="button"
                class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm :bg-slate-900 :hover:bg-slate-800 :border-gray-700 :text-gray-400 :hover:text-white :focus:ring-offset-gray-800"
              >
                Annuler
              </button>
              <button
                type="submit"
                class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm :focus:ring-offset-gray-800"
              >
                Enregistrer
              </button>
            </div>
          </form>
        </template>
      </Modal>
    </teleport>

    <div class="mt-4">
      <div class="relative">
        <!-- vue table -->
        <vue-good-table
          :columns="columns"
          :rows="rows"
          :pagination-options="{
            enabled: true,
          }"
          :search-options="{
            enabled: true,
            placeholder: 'Rechercher...',
          }"
        >
          <template v-slot:table-row="{ row, column, formattedRow }">
            <div v-if="column.field === 'actions'" class="flex">
              <div
                @click="openEditModal(row)"
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
                @click="destroy(row)"
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
            <div v-else>
              {{ formattedRow[column.field] }}
            </div>
          </template>
        </vue-good-table>
        <!-- vue table -->
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
import { VueGoodTable } from "vue-good-table-next";
import "vue-good-table-next/dist/vue-good-table-next.css";
import Multiselect from "@vueform/multiselect";
import { ref, computed } from "vue";
import { watch } from "vue";
import { Modal } from "flowbite-vue";
import { router } from "@inertiajs/vue3";
import Pagination from "../../Components/Pagination.vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  reunions: {
    type: Object,
    default: () => ({}),
  },
  reunionTypes: {
    type: Object,
    default: () => ({}),
  },
});

const $toast = useToast();

const form = useForm({
  id: null,
  name: null,
  description: null,
  reunion_type_id: null,
  date: null,
});

const columns = ref([
  {
    label: "#",
    field: "id",
  },
  {
    label: "Réunion",
    field: "name",
  },
  {
    label: "Type",
    field: "type",
  },
  {
    label: "Date",
    field: "date",
  },

  {
    label: "Actions",
    field: "actions",
  },
]);
const rows = computed(() =>
  Object.values(props.reunions).map((reunion) => ({
    id: reunion.id,
    name: reunion.name,
    type: reunion.reunion_type.name,
    date: reunion.date,
    reunion_type_id: reunion.reunion_type_id,
  }))
);

const submit = () => {
  if (form.id) {
    // form.adherents = selectedAdherents.value;
    form.put(route("reunions.update", form.id), {
      preserveScroll: true,
      onSuccess: () => {
        closeModal();
        $toast.open({
          message: "reunion modifié avec succès",
          type: "success",
          duration: 3000,
          dismissible: true,
        });
      },
    });
  } else {
    // form.adherents = selectedAdherents.value;
    form.post(route("reunions.store"), {
      preserveScroll: true,
      onSuccess: () => {
        closeModal();
        $toast.open({
          message: "reunion ajouté avec succès",
          type: "success",
          duration: 3000,
          dismissible: true,
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
  form.get(route("reunions.show", id));
};

const destroy = (id) => {
  if (confirm("Are you sure?")) {
    form.delete(route("reunions.destroy", id), {
      preserveScroll: true,
      onSuccess: () => {
        $toast.open({
          message: "reunion supprimé avec succès",
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

const openEditModal = (reunion) => {
  form.id = reunion.id;
  form.name = reunion.name;
  form.date = reunion.date;
  form.description = reunion.description;
  form.reunion_type_id = reunion.reunion_type_id;
  isModalOpen.value = true;
};
</script>

<style src="@vueform/multiselect/themes/default.css">
</style>
