<template>
  <form @submit.prevent="submit">
    <div
      class="grid grid-cols-1 px-3 pt-2 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900"
    >
      <!-- Right Content -->

      <div class="col-span-full xl:col-auto">
        <div
          class="mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800"
        >
          <div
            class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4"
          >
            <h3 class="mb-2 text-xl font-bold text-slate-800 uppercase">
              Logo de l'organisme
            </h3>
            <div class="flex-shrink-0">
              <img
                :src="showImage() + props.association.image"
                class="h-24 w-24 rounded-full object-cover mb-4"
              />

              <label
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                for="file_input"
                >Choisir une image</label
              >
              <input
                @change="selectImage"
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                id="file_input"
                type="file"
                accept="image/*"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="col-span-2">
        <div
          class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800"
        >
          <h3 class="mb-4 text-xl font-semibold uppercase text-slate-800">
            Informations générales
          </h3>

          <div class="col-span-6 sm:col-span-3 mb-3">
            <label
              for="name"
              class="block mb-2 text-sm font-medium text-gray-900"
              >Nom de l'association</label
            >
            <input
              v-model="form.name"
              type="text"
              name="name"
              id="name"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
              placeholder="Nom de l'association"
            />
          </div>
          <div class="col-span-6 sm:col-span-3 mb-3">
            <label
              for="objectifs"
              class="block mb-2 text-sm font-medium text-gray-900"
              >Objectifs</label
            >
            <textarea
              v-model="form.objectifs"
              name="objectifs"
              id="objectifs"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
              placeholder="Objectifs de l'association"
            ></textarea>
          </div>
          <div class="col-span-6 sm:col-span-3 mb-3">
            <label
              for="Addresse"
              class="block mb-2 text-sm font-medium text-gray-900"
              >Addresse</label
            >
            <textarea
              v-model="form.address"
              name="Addresse"
              id="Addresse"
              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
              placeholder="Addresse"
            ></textarea>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6 mb-3">
            <div>
              <label
                for="Region"
                class="block mb-2 text-sm font-medium text-gray-900"
                >Région</label
              >

              <select
                v-model="form.region"
                name=""
                id=""
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
              >
                <option disabled value="">Séléctionner région</option>
                <option
                  v-for="region in regions"
                  @change="filterCities"
                  :key="region.id"
                  :value="region.name"
                >
                  {{ region.name }}
                </option>
              </select>
            </div>
            <div>
              <label
                for="Ville"
                class="block mb-2 text-sm font-medium text-gray-900"
                >Ville</label
              >
              <select
                v-model="form.city"
                id="type"
                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
              >
                <option disabled selected value="">Séléctionner ville</option>
                <option
                  v-for="city in filteredCities"
                  :key="city.id"
                  :value="city"
                >
                  {{ city }}
                </option>
              </select>
            </div>
          </div>

          <div class="col-span-6 sm:col-full">
            <button
              class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
              type="submit"
            >
              Enregistrer
            </button>
            <span class="ml-4"></span>
            <button
              @click="toggleDisabled"
              class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
              type="button"
            >
              Modifier
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <div id="my-doc">hello</div>
  <button @click="generatePdf">print me</button>
</template>


<script setup>
import regionsFile from "../../regions.json";
import { ref, nextTick, computed, onMounted } from "vue";
import { useForm, usePage, router } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

const props = defineProps({
  association: {
    type: Object,
  },
});

const isDisabled = ref(true);

const toggleDisabled = () => {
  isDisabled.value = !isDisabled.value;
};

const $toast = useToast();

const regions = ref(regionsFile);

const form = useForm({
  id: props.association.id,
  name: props.association.name,
  objectifs: props.association.objectifs,
  address: props.association.address,
  region: props.association.region,
  city: props.association.city,
  image: props.association.image,
});

const selectImage = (event) => {
  if (event.target.files[0]) {
    let file = event.target.files[0];
    form.image = file;
  }
};

const filteredCities = computed(() => {
  if (form.region) {
    const regionData = regions.value.find(
      (region) => region.name === form.region
    );
    if (regionData) {
      return regionData.cities_list;
    }
  }
  return [];
});

const filterCities = () => {
  form.city = "";
};

const submit = (e) => {
  e.preventDefault();
  router.post(
    `/association/${form.id}`,
    {
      _method: "put",
      headers: {
        "Content-Type": "multipart/form-data",
      },
      id: form.id,
      name: form.name,
      objectifs: form.objectifs,
      address: form.address,
      region: form.region,
      city: form.city,
      image: form.image,
    },
    {
      onSuccess: () => {
        $toast.open({
          message: "Association modifié avec succès",
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
};

const showImage = () => {
  return "/storage/";
};
</script>

<script>
import MainLayout from "../../Layouts/MainLayout.vue";
import printJS from "print-js";
import jsPDF from "jspdf";

export default {
  layout: MainLayout,
  components: {},
  methods: {
    generatePdf() {
      // Create a new jsPDF instance
      const doc = new jsPDF();

      // Add content to the PDF
      doc.text("Hello, this is a PDF generated with jsPDF!", 10, 10);

      // Save the PDF
      doc.save("generated.pdf");
    },
    print() {
      printJS({
        printable: "my-doc", // ID, class, or HTML element of the content you want to print
        type: "html",
        onPrintDialogClose: () => {
          console.log("Print dialog closed");
        },
      });
    },
  },
};
</script>


<style>
.filepond--credits {
  display: none;
}

@media print {
  #my-doc {
    visibility: hidden;
  }
}
</style>
