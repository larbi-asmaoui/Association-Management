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

  <div class="bg-white px-2 py-6 shadow-md rounded-xl relative mt-5">
    <div
      class="shadow-lg bg-blue-600 p-4 absolute top-1.5 left-1/2 w-11/12 rounded-full transform -translate-x-1/2 -translate-y-1/2"
    >
      <h2 class="text-xl font-semibold text-white">
        Liste de propriétés de l'association
      </h2>
    </div>
    <div
      class="mt-7 items-center justify-between block sm:flex md:divide-x md:divide-gray-100"
    >
      <div class="w-full flex justify-between items-center mb-4 sm:mb-0">
        <div class="relative w-48 mt-1 sm:w-64 xl:w-96">
          <input
            type="text"
            v-model="search"
            class="bg-slate-200 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :text-white :focus:ring-blue-500 :focus:border-blue-500"
            placeholder="rechercher..."
          />
        </div>
        <div>
          <button
            @click="
              printJS({
                printable: stocks.data,
                properties: [
                  {
                    field: 'name',
                    displayName: 'Stock',
                  },
                  {
                    field: 'quantity',
                    displayName: 'Quantité',
                  },
                  {
                    field: 'price_per_unit',
                    displayName: 'Prix Unitaire',
                  },
                  {
                    field: 'purchase_date',
                    displayName: 'Date de l\'ajout',
                  },
                  {
                    field: 'stock_type.name',
                    displayName: 'Type',
                  },
                ],

                type: 'json',
              })
            "
            class="text-center mr-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium text-sm p-2 focus:outline-none"
            type="button"
          >
            PDF
          </button>
          <button
            class="text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium text-sm p-2 focus:outline-none"
            type="button"
          >
            CSV
          </button>
        </div>
      </div>
    </div>

    <teleport to="body">
      <Modal size="4xl" v-if="isModalOpen" @close="closeModal">
        <template #header>
          <div class="flex items-center text-lg">
            {{ form.id ? "Mettre à jour un stock" : "Ajouter un stock" }}
          </div>
        </template>
        <template #body>
          <form
            class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2"
            @submit.prevent="submit"
          >
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
              <div>
                <label
                  for="stock_name"
                  class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                  >Nom de stock
                </label>
                <input
                  v-model="form.name"
                  type="text"
                  name="stock_name"
                  id="stock_name"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :placeholder-gray-400"
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
                  for="type"
                  class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                  >Type
                </label>
                <select
                  v-model="form.stock_type_id"
                  id="stockTypes"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :focus:ring-blue-500 :focus:border-blue-500 appearance-none select-none relative z-10"
                >
                  <option
                    v-for="stockType in stockTypes"
                    :key="stockType.id"
                    :value="stockType.id"
                    class="bg-white :bg-gray-800 py-2.5 px-4 cursor-pointer hover:bg-gray-200 :hover:bg-gray-700"
                  >
                    {{ stockType.name }}
                  </option>
                </select>
                <span
                  v-if="form.errors.stock_type_id"
                  class="text-xs text-red-600 mt-1"
                  id="hs-validation-name-error-helper"
                >
                  {{ form.errors.stock_type_id }}
                </span>
              </div>
            </div>

            <div>
              <div>
                <label
                  for="dpurchase_date"
                  class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                  >Date d'achat
                </label>

                <input
                  v-model="form.purchase_date"
                  type="date"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :placeholder-gray-400"
                  placeholder="Select date"
                  name="purchase_date"
                />
                <span
                  v-if="form.errors.purchase_date"
                  class="text-xs text-red-600 mt-1"
                  id="hs-validation-name-error-helper"
                >
                  {{ form.errors.purchase_date }}
                </span>
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
              <div>
                <label
                  for="quantity"
                  class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                  >Quantité
                </label>
                <input
                  v-model="form.quantity"
                  min="1"
                  type="number"
                  name="quantity"
                  id="quantity"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :placeholder-gray-400"
                />
                <span
                  v-if="form.errors.quantity"
                  class="text-xs text-red-600 mt-1"
                  id="hs-validation-name-error-helper"
                >
                  {{ form.errors.quantity }}
                </span>
              </div>

              <div>
                <label
                  for=" price_per_unit"
                  class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                  >Prix unitaire d'achat
                </label>
                <input
                  v-model="form.price_per_unit"
                  min="0"
                  step="0.01"
                  type="number"
                  name=" price_per_unit"
                  id=" price_per_unit"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :placeholder-gray-400"
                />
                <span
                  v-if="form.errors.price_per_unit"
                  class="text-xs text-red-600 mt-1"
                  id="hs-validation-name-error-helper"
                >
                  {{ form.errors.price_per_unit }}
                </span>
              </div>
            </div>

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
                class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm :focus:ring-offset-gray-800"
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
            <table
              class="w-full text-sm text-left text-gray-500 border-collapse :text-gray-400"
            >
              <thead class="bg-gray-100">
                <tr>
                  <th
                    scope="col"
                    class="border border-slate-400 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    titre
                  </th>
                  <!-- <th
                                        scope="col"
                                        class="border border-slate-400 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Type
                                    </th> -->
                  <th
                    scope="col"
                    class="border border-slate-400 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Quantité
                  </th>
                  <th
                    scope="col"
                    class="border border-slate-400 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Prix unitaire (DH)
                  </th>
                  <th
                    scope="col"
                    class="border border-slate-400 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Prix Total (DH)
                  </th>
                  <th
                    scope="col"
                    class="border border-slate-400 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Date d'achat
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
                <tr v-for="stock in stocks.data" :key="stock.id">
                  <td
                    class="border border-slate-400 px-6 py-3 text-base font-medium text-gray-900 whitespace-nowrap"
                  >
                    {{ stock.name }}
                  </td>
                  <!-- <td
                                        class="border border-slate-400 px-6 py-3 text-base font-medium text-gray-900 whitespace-nowrap"
                                    >
                                        {{ stock.stock_type.name }}
                                    </td> -->

                  <td
                    class="border border-slate-400 px-6 py-3 text-base font-medium text-gray-900 whitespace-nowrap"
                  >
                    {{ stock.quantity }}
                  </td>

                  <td
                    class="border border-slate-400 px-6 py-3 text-base font-medium text-gray-900 whitespace-nowrap"
                  >
                    {{ stock.price_per_unit }}
                  </td>
                  <td
                    class="border border-slate-400 px-6 py-3 text-base font-medium text-gray-900 whitespace-nowrap"
                  >
                    {{ stock.price_per_unit * stock.quantity }}
                  </td>
                  <td
                    class="border border-slate-400 px-6 py-3 text-base font-medium text-gray-900 whitespace-nowrap"
                  >
                    {{ stock.purchase_date }}
                  </td>
                  <td
                    class="border border-slate-400 px-6 py-3 text-base font-medium text-gray-900 whitespace-nowrap"
                  >
                    <div class="flex item-center justify-center">
                      <!-- Eye -->
                      <!-- <div
                                                @click="show(stock.id)"
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
                        @click="openEditModal(stock)"
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
                        @click="destroy(stock.id)"
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
          <Pagination :data="stocks" />
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
import { ref, watch } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import { Modal } from "flowbite-vue";
import Pagination from "../../Components/Pagination.vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";
import printJS from "print-js";

const $toast = useToast();

const form = useForm({
  id: null,
  name: "",
  quantity: null,
  price_per_unit: null,
  purchase_date: null,
  stock_type_id: null,
});

let isModalOpen = ref(false);

const closeModal = () => {
  isModalOpen.value = false;

  form.reset();
};

const openEditModal = (stock) => {
  form.id = stock.id;
  form.name = stock.name;
  form.quantity = stock.quantity;
  form.price_per_unit = stock.price_per_unit;
  form.purchase_date = stock.purchase_date;
  form.stock_type_id = stock.stock_type_id;
  isModalOpen.value = true;
};

const destroy = (id) => {
  if (confirm("Are you sure?")) {
    form.delete(route("stocks.destroy", id), {
      onSuccess: () => {
        $toast.open({
          message: "Stock supprimé avec succès",
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
  form.get(route("stocks.show", id));
};
const props = defineProps({
  stocks: {
    type: Object,
    default: () => ({}),
  },
  stockTypes: {
    type: Object,
    default: () => ({}),
  },
});

const submit = () => {
  if (form.id) {
    form.put(route("stocks.update", form.id), {
      preserveScroll: true,
      onSuccess: () => {
        closeModal();
        $toast.open({
          message: "Stock modifié avec succès",
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
    });
  } else {
    form.post(route("stocks.store"), {
      forceFormData: true,
      preserveScroll: true,
      onSuccess: () => {
        closeModal();
        $toast.open({
          message: "Stock ajouté avec succès",
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
  }
};

let search = ref("");
watch(search, (value) => {
  router.get(
    "/stocks",
    { search: value },
    {
      preserveState: true,
      replace: true,
    }
  );
});
</script>
