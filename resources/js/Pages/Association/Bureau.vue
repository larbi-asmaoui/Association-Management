<template>
    <div class="w-auto h-full py-4 px-2">
        <div class="flex justify-between items-center mb-5 w-full">
            <h3 class="text-xl font-bold text-slate-800 uppercase me-auto">
                {{ $t("a-propos.bureau") }}
            </h3>
            <button
                @click="generatePdf"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full mr-auto"
            >
                <Printer :size="22" />
            </button>
        </div>

        <div
            class="bg-white shadow-md rounded-xl mt-4"
            :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
        >
            <!-- table -->

            <div
                class="relative overflow-x-auto shadow-md sm:rounded-lg"
                id="bureau"
            >
                <table
                    class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center">
                                المنصب
                            </th>

                            <th scope="col" class="px-6 py-3 text-center">
                                الاسم &nbsp;الكامل
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                الهاتف
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                ر.ب.و
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                المهنة
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-center"
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
                            <td class="px-6 py-4 text-center">
                                {{ statut.name }}
                            </td>
                            <!-- <td class="px-6 py-4 text-center">الرئيس</td> -->
                            <td class="px-6 py-4 text-center">
                                {{
                                    statut.adherent
                                        ? statut.adherent.first_name +
                                          " " +
                                          statut.adherent.last_name
                                        : "-"
                                }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{
                                    statut.adherent ? statut.adherent.tel : "-"
                                }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{
                                    statut.adherent ? statut.adherent.cin : "-"
                                }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{
                                    statut.adherent
                                        ? statut.adherent.profession
                                        : "-"
                                }}
                            </td>
                            <td
                                class="px-6 py-4 text-center"
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
                        v-if="posteForm.errors.name"
                        class="text-xs text-red-600 mt-1"
                        id="hs-validation-name-error-helper"
                    >
                        {{ posteForm.errors.name }}
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
    </div>
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
    adherents: {
        type: Object,
        default: () => ({}),
    },
    status: {
        type: Object,
    },
});

const isModalOpen = ref(false);

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
import RootLayout from "../../Layouts/RootLayout.vue";

export default {
    layout: RootLayout,
};
</script>
<style></style>
