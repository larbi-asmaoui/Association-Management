<template>
  <form @submit.prevent="submit">
    <input type="hidden" name="_token" :value="$page.props.csrf_token" />
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
              <!-- <ImageUpload v-model="form.image" /> -->

              <label
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                for="file_input"
                >Changer une image</label
              >
              <input
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                id="file_input"
                type="file"
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
          </div>
        </div>
      </div>
    </div>
  </form>
</template>


<script setup>
import ImageUpload from "../../Components/ImageUpload.vue";
import axios from "axios";
// import vueFilePond from "vue-filepond";
// import "filepond/dist/filepond.min.css";
// import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
// import FilePondPluginFilePoster from "filepond-plugin-file-poster";
// import "filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css";
// import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
// import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import regionsFile from "../../regions.json";
import { ref, nextTick, computed, onMounted } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

const props = defineProps({
  association: {
    type: Object,
  },
});

const $toast = useToast();

// const FilePond = vueFilePond(
//   FilePondPluginFileValidateType,
//   FilePondPluginImagePreview
// );

const pond = ref(null);
const page = usePage();
const files = ref([]);
const csrf_token = page.props.csrf_token;
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
  form.put(route("association.update", form.id), {
    onSuccess: () => {
      $toast.open({
        message: "Association ajoutée avec succès",
        type: "success",
      });
    },
  });
};

const showImage = () => {
  return "/storage/";
};
</script>

<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
  layout: MainLayout,
  components: {},
};
</script>


<style >
.filepond--credits {
  display: none;
}
</style>
