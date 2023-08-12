<template>
    <form @submit.prevent="submit">
        <div
            :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
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
                        <h3
                            class="mb-2 text-xl font-bold text-slate-800 uppercase"
                        >
                            {{ $t("a-propos.logo") }}
                        </h3>
                        <div class="flex-shrink-0">
                            <div
                                class="h-24 w-24 border-2 border-gray-300 rounded-full object-cover mb-4"
                            >
                                <img
                                    :src="showImage() + props.association.image"
                                    class="rounded-full object-cover h-full w-full"
                                />
                            </div>

                            <div v-show="isEnabled">
                                <label
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="file_input"
                                >
                                    {{ $t("a-propos.choisir_logo") }}</label
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
            </div>
            <div class="col-span-2">
                <div
                    class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800"
                >
                    <h3
                        class="mb-4 text-xl font-semibold uppercase text-slate-800"
                    >
                        {{ $t("a-propos.titre") }}
                    </h3>

                    <div class="col-span-6 sm:col-span-3 mb-3">
                        <label
                            for="name"
                            class="block mb-2 text-sm font-medium text-gray-900"
                            >{{ $t("a-propos.input_nom") }}</label
                        >
                        <input
                            :disabled="!isEnabled"
                            :class="{
                                'bg-slate-100 cursor-not-allowed': !isEnabled,
                            }"
                            v-model="form.name"
                            type="text"
                            name="name"
                            id="name"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                    </div>
                    <div class="col-span-6 sm:col-span-3 mb-3">
                        <label
                            for="objectifs"
                            class="block mb-2 text-sm font-medium text-gray-900"
                            >{{ $t("a-propos.input_objectifs") }}</label
                        >
                        <textarea
                            :disabled="!isEnabled"
                            :class="{
                                'bg-slate-100 cursor-not-allowed': !isEnabled,
                            }"
                            v-model="form.objectifs"
                            name="objectifs"
                            id="objectifs"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        ></textarea>
                    </div>
                    <div class="col-span-6 sm:col-span-3 mb-3">
                        <label
                            for="date"
                            class="block mb-2 text-sm font-medium text-gray-900"
                            >{{ $t("a-propos.input_date_creation") }}</label
                        >
                        <input
                            :disabled="!isEnabled"
                            :class="{
                                'bg-slate-100 cursor-not-allowed': !isEnabled,
                            }"
                            v-model="form.date_creation"
                            type="date"
                            name="date"
                            id="date"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        />
                    </div>

                    <div class="col-span-6 sm:col-span-3 mb-3">
                        <label
                            for="Addresse"
                            class="block mb-2 text-sm font-medium text-gray-900"
                            >{{ $t("a-propos.input_addresse") }}</label
                        >
                        <textarea
                            :disabled="!isEnabled"
                            :class="{
                                'bg-slate-100 cursor-not-allowed': !isEnabled,
                            }"
                            v-model="form.address"
                            name="Addresse"
                            id="Addresse"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        ></textarea>
                    </div>
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6 mb-3"
                    >
                        <div>
                            <label
                                for="Region"
                                class="block mb-2 text-sm font-medium text-gray-900"
                                >{{ $t("a-propos.input_region") }}</label
                            >

                            <select
                                :disabled="!isEnabled"
                                :class="{
                                    'bg-slate-100 cursor-not-allowed':
                                        !isEnabled,
                                }"
                                v-model="form.region"
                                name=""
                                id=""
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option disabled value="">
                                    Séléctionner région
                                </option>
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
                                >{{ $t("a-propos.input_ville") }}</label
                            >
                            <select
                                :disabled="!isEnabled"
                                :class="{
                                    'bg-slate-100 cursor-not-allowed':
                                        !isEnabled,
                                }"
                                v-model="form.city"
                                id="type"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            >
                                <option disabled selected value="">
                                    Séléctionner ville
                                </option>
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

                    <div
                        class="col-span-6 sm:col-full flex gap-2 justify-start"
                    >
                        <button
                            v-show="isEnabled"
                            class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="submit"
                        >
                            {{ $t("buttons.enregistrer") }}
                        </button>
                        <button
                            @click="toggleEnabled"
                            class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button"
                        >
                            <Pencil :size="20" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- ------------- -->
    <div class="bg-white shadow-md rounded-xl mt-4 pt-4">
        <div class="flex px-4 mb-5">
            <h3 class="mb-5 text-xl font-bold text-slate-800 uppercase">
                {{ $t("a-propos.bureau") }}
            </h3>
            <button
                @click="generatePdf"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full mr-auto"
            >
                <Printer :size="22" />
            </button>
        </div>

        <!-- table -->

        <div
            class="relative overflow-x-auto shadow-md sm:rounded-lg"
            id="bureau"
        >
            <table
                :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
                class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3 text-right">المنصب</th>

                        <th scope="col" class="px-6 py-3 text-right">
                            الاسم &nbsp;الكامل
                        </th>
                        <th scope="col" class="px-6 py-3 text-right">الهاتف</th>
                        <th scope="col" class="px-6 py-3 text-right">ر.ب.و</th>
                        <th scope="col" class="px-6 py-3 text-right">المهنة</th>
                        <th
                            scope="col"
                            class="px-6 py-3 text-right"
                            id="element-to-hide"
                            data-html2canvas-ignore="true"
                        >
                            العمليات
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="statut in status"
                        :key="statut.id"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                    >
                        <td class="px-6 py-4 text-right">{{ statut.name }}</td>
                        <!-- <td class="px-6 py-4 text-right">الرئيس</td> -->
                        <td class="px-6 py-4 text-right">
                            {{
                                statut.adherent
                                    ? statut.adherent.first_name +
                                      " " +
                                      statut.adherent.last_name
                                    : "-"
                            }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            {{ statut.adherent ? statut.adherent.tel : "-" }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            {{ statut.adherent ? statut.adherent.cin : "-" }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            {{
                                statut.adherent
                                    ? statut.adherent.profession
                                    : "-"
                            }}
                        </td>
                        <td
                            class="px-6 py-4 text-right"
                            id="element-to-hide"
                            data-html2canvas-ignore="true"
                        >
                            <button
                                class="text-blue-600 hover:text-blue-900"
                                @click="openModal(statut)"
                            >
                                <Pencil />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <a-modal
        :title="$t('a-propos.assign_poste_member')"
        @cancel="closeModal"
        :footer="null"
        v-model:open="isModalOpen"
    >
        <a-divider />
        <form
            :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
            class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2 overflow-y-auto max-h-[30rem]"
            @submit.prevent="associatePosteWithAdherent"
        >
            <div>
                <div class="flex justify-between items-center w-1/2 mb-8">
                    <div>{{ $t("a-propos.input_poste") }}</div>
                    <h3 class="text-lg font-bold text-slate-800 uppercase">
                        {{ posteForm.name }}
                    </h3>
                </div>
            </div>
            <div class="mb-5">
                <label
                    for="title"
                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                    >{{ $t("a-propos.input_membre") }}</label
                >
                <!-- <Multiselect
                            v-model="posteForm.adherent_id"
                            :close-on-select="false"
                            :searchable="true"
                            :create-option="true"
                            :options="formattedAdherents"
                        /> -->
                <select
                    v-model="posteForm.adherent_id"
                    id="type"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                >
                    <option disabled value="">اختر عضو</option>
                    <option
                        v-for="adherent in adherents"
                        :key="adherent.id"
                        :value="adherent.id"
                    >
                        {{ adherent.first_name + " " + adherent.last_name }}
                    </option>
                </select>
                <span
                    v-if="form.errors.name"
                    class="text-xs text-red-600 mt-1"
                    id="hs-validation-name-error-helper"
                >
                    {{ form.errors.name }}
                </span>
            </div>

            <div class="mt-5 flex justify-end gap-x-2">
                <button
                    @click="isModalOpen = false"
                    type="button"
                    class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm :bg-slate-900 :hover:bg-slate-800 :border-gray-700 :text-gray-400 :hover:text-white :focus:ring-offset-gray-800"
                >
                    {{ $t("buttons.annuler") }}
                </button>
                <button
                    type="submit"
                    class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm :focus:ring-offset-gray-800"
                >
                    {{ $t("buttons.ajouter") }}
                </button>
            </div>
        </form>
    </a-modal>

    <!-- ------------- -->
</template>

<script setup>
import Swal from "sweetalert2";
import Multiselect from "@vueform/multiselect";
import { Modal } from "flowbite-vue";
import regionsFile from "../../regions.json";
import { ref, computed } from "vue";
import { useForm, usePage, router } from "@inertiajs/vue3";
import "vue-toast-notification/dist/theme-sugar.css";
import Pencil from "vue-material-design-icons/Pencil.vue";
import { useI18n } from "vue-i18n";
import html2pdf from "html2pdf.js";
import Printer from "vue-material-design-icons/Printer.vue";
import Toast from "../../utils.js";

const { t } = useI18n();

const props = defineProps({
    association: {
        type: Object,
    },
    adherents: {
        type: Object,
        default: () => ({}),
    },
    status: {
        type: Object,
    },
});

const isModalOpen = ref(false);
const isEnabled = ref(false);

const toggleEnabled = () => {
    isEnabled.value = !isEnabled.value;
};

const regions = ref(regionsFile);

const form = useForm({
    id: props.association.id,
    name: props.association.name,
    objectifs: props.association.objectifs,
    address: props.association.address,
    region: props.association.region,
    city: props.association.city,
    image: props.association.image,
    date_creation: props.association.date_creation,
});

const posteForm = useForm({
    id: null,
    name: null,
    adherent_id: null,
});

const generatePdf = () => {
    const element = document.getElementById("bureau");
    const opt = {
        margin: 0.5,
        filename: "bureau_association.pdf",
        image: { type: "jpeg", quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: "in", format: "letter", orientation: "landscape" },
    };
    html2pdf().set(opt).from(element).save();
};

const selectImage = (event) => {
    if (event.target.files[0]) {
        let file = event.target.files[0];
        form.image = file;
    }
};

const filteredCities = computed(() => {
    if (form.region) {
        const regionData = regions.value.find(
            (region) => region.name === form.region,
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
    if (form.id) {
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
                date_creation: form.date_creation,
            },
            {
                onSuccess: () => {
                    Toast.fire({
                        icon: "success",
                        title: t("toasts.modif_success"),
                    });
                },
                onError: () => {
                    Toast.fire({
                        icon: "error",
                        title: t("toasts.modif_error"),
                    });
                },
            },
        );
    } else {
        router.post(
            `/association`,
            {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
                name: form.name,
                objectifs: form.objectifs,
                address: form.address,
                region: form.region,
                city: form.city,
                image: form.image,
                date_creation: form.date_creation,
            },
            {
                onSuccess: () => {
                    Toast.fire({
                        icon: "success",
                        title: t("toasts.modif_success"),
                    });
                },
                onError: () => {
                    Toast.fire({
                        icon: "error",
                        title: t("toasts.modif_error"),
                    });
                },
            },
        );
    }
};

const showImage = () => {
    return "/storage/";
};

const closeModal = () => {
    isModalOpen.value = false;

    posteForm.reset();
};

const openModal = (statut) => {
    isModalOpen.value = true;

    posteForm.id = statut.id;
    posteForm.name = statut.name;
    posteForm.adherent_id = statut.adherent.id ?? null;
};

const associatePosteWithAdherent = () => {
    posteForm.put(route("status.associate", posteForm.id), {
        onSuccess: () => {
            closeModal();
            Toast.fire({
                icon: "success",
                title: t("toasts.modif_success"),
            });
        },
        onError: () => {
            Toast.fire({
                icon: "error",
                title: t("toasts.modif_error"),
            });
        },
    });
};
</script>

<script>
import MainLayout from "../../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
    components: {},
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
