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

  <div class="bg-white py-6 shadow-md rounded-xl relative mt-5">
    <div
      class="shadow-lg bg-blue-600 p-4 absolute top-1.5 left-1/2 w-11/12 rounded-full transform -translate-x-1/2 -translate-y-1/2"
    >
      <h2 class="text-xl font-semibold text-white">
        Revenues de l'association
      </h2>
    </div>

    <div
      class="mt-7 items-center justify-between block sm:flex md:divide-x md:divide-gray-100"
    >
      <div class="px-2 flex items-center mb-4 sm:mb-0">
        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
          <input
            type="text"
            v-model="search"
            class="bg-slate-200 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-blue-500 :focus:border-blue-500"
            placeholder="rechercher..."
          />
        </div>
      </div>
    </div>

    <teleport to="body">
      <Modal size="md" v-if="isModalOpen" @close="closeModal">
        <template #header>
          <div class="flex items-center text-lg">
            {{ form.id ? "Mettre à jour une Revenue" : "Ajouter une Revenue" }}
          </div>
        </template>
        <template #body>
          <form
            class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2 overflow-y-auto max-h-[30rem]"
            @submit.prevent="submit"
            enctype="multipart/form-data"
          >
            <div>
              <label
                for="titre"
                class="text-sm font-medium text-gray-900 block mb-2 dark:text-gray-300"
                >Titre
              </label>
              <input
                v-model="form.titre"
                type="text"
                name="titre"
                id="titre"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
              />
              <span
                v-if="form.errors.titre"
                class="text-xs text-red-600 mt-1"
                id="hs-validation-name-error-helper"
              >
                {{ form.errors.titre }}
              </span>
            </div>
            <div>
              <label
                for="montant"
                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                >Montant
              </label>
              <input
                v-model="form.montant"
                min="1"
                step="0.01"
                type="number"
                name="montant"
                id="montant"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :placeholder-gray-400 :text-white"
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
                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                >Type
              </label>
              <select
                v-model="form.revenue_type_id"
                id="revenueTypes"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-blue-500 :focus:border-blue-500 appearance-none select-none relative z-10"
              >
                <option
                  v-for="revenueType in revenueTypes"
                  :key="revenueType.id"
                  :value="revenueType.id"
                  class="bg-white :bg-gray-800 py-2.5 px-4 cursor-pointer hover:bg-gray-200 :hover:bg-gray-700"
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
                  class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                  >Date d'opération
                </label>

                <input
                  v-model="form.revenue_date"
                  type="date"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :placeholder-gray-400 :text-white"
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
                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                for="file_input"
                >Réference
              </label>
              <input
                @change="selectImage"
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 :text-gray-400 focus:outline-none :bg-gray-700 :border-gray-600 :placeholder-gray-400"
                id="file_input"
                type="file"
                accept="image/*"
              />
              <p
                class="mt-1 text-sm text-gray-500 :text-gray-300"
                id="file_input_help"
              >
                SVG, PNG, JPG, PDF.
              </p>
              <span
                v-if="form.errors.reference_file"
                class="text-xs text-red-600 mt-1"
                id="hs-validation-name-error-helper"
              >
                {{ form.errors.reference_file }}
              </span>
            </div>
            <img v-if="imagePreview" :src="imagePreview" />

            <div class="mt-8 flex justify-end gap-x-2">
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
      <div class="overflow-hidden bg-white">
        <div class="bg-white">
          <div class="relative overflow-x-auto shadow-lg mb-5">
            <table class="w-full sm:rounded-lg text-sm text-left text-gray-500">
              <thead class="bg-gray-100 :bg-gray-700">
                <tr>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Titre
                  </th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Montant (DH)
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
                    Date d'opération
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
                <tr v-for="revenue in revenues.data" :key="revenue.id">
                  <td
                    scope="row"
                    class="px-6 py-3 text-base font-medium text-gray-900 whitespace-nowrap :text-white"
                  >
                    {{ revenue.titre }}
                  </td>
                  <td
                    class="px-6 py-3 text-base font-medium text-gray-900 whitespace-nowrap :text-white"
                  >
                    {{ revenue.montant }}
                  </td>
                  <td
                    class="px-6 py-3 text-base font-medium text-gray-900 whitespace-nowrap :text-white"
                  >
                    {{ revenue.revenue_type.name }}
                  </td>

                  <td
                    class="px-6 py-3 text-base font-medium text-gray-900 whitespace-nowrap :text-white"
                  >
                    {{ revenue.revenue_date }}
                  </td>
                  <td
                    class="px-6 py-3 text-base font-medium text-gray-900 whitespace-nowrap :text-white"
                  >
                    <div class="flex">
                      <!-- Eye -->
                      <!-- <div
                                            @click="show(revenue.id)"
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
                                        </div> -->

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
import { ref, watch, watchEffect } from "vue";
import { useForm, router, usePage } from "@inertiajs/vue3";
import { Modal } from "flowbite-vue";
import Pagination from "../../Components/Pagination.vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

const $toast = useToast();

const form = useForm({
  id: null,
  titre: null,
  montant: null,
  revenue_date: null,
  reference_file: null,
  revenue_type_id: null,
});
let imagePreview = ref(null);
let image = ref(null);

let isModalOpen = ref(false);

const closeModal = () => {
  isModalOpen.value = false;
  imagePreview.value = null;
  image.value = null;
  form.clearErrors();
  form.reset();
};

const showImage = () => {
  return "/storage/";
};

const selectImage = (event) => {
  if (event.target.files[0]) {
    let file = event.target.files[0];
    form.reference_file = file;

    let reader = new FileReader();

    reader.onloadend = () => {
      imagePreview.value = reader.result;
    };

    reader.readAsDataURL(file);
  }
};

const openEditModal = (revenue) => {
  form.id = revenue.id;
  form.titre = revenue.titre;
  form.montant = revenue.montant;
  form.revenue_date = revenue.revenue_date;
  form.revenue_type_id = revenue.revenue_type_id;
  form.reference_file = revenue.reference_file;
  imagePreview.value = showImage() + revenue.reference_file;
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
    router.post(
      `/revenues/${form.id}`,
      {
        _method: "put",
        headers: {
          "Content-Type": "multipart/form-data",
        },
        id: form.id,
        titre: form.titre,
        montant: form.montant,
        revenue_date: form.revenue_date,
        reference_file: form.reference_file,
        revenue_type_id: form.revenue_type_id,

        // preserveScroll: true,
        // onFinish: (visit) => {
        //     closeModal();
        //     console.log(visit);
        // },
      },
      {
        onSuccess: () => {
          closeModal();
          $toast.open({
            message: "Revenue modifié avec succès",
            type: "success",
            duration: 3000,
            dismissible: true,
          });
        },
        onError: () => {
          $toast.open({
            message: "Erreur lors de la modification",
            type: "error",
            duration: 3000,
            dismissible: true,
          });
        },
      }
    );
  } else {
    form.post(route("revenues.store"), {
      forceFormData: true,
      preserveScroll: true,
      onSuccess: () => {
        closeModal();
        $toast.open({
          message: "Revenue ajouté avec succès",
          type: "success",
          duration: 3000,
          dismissible: true,
        });
      },
      // onError: () => {
      //     $toast.open({
      //         message: "Erreur lors de l'ajout",
      //         type: "error",
      //         duration: 3000,
      //         dismissible: true,
      //     });
      // },
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
