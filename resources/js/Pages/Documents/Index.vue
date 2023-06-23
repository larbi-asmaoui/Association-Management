<template>
    <Modal :size="md" v-if="isShowModal" @close="closeModal">
        <template #header>
            <div class="flex items-center text-lg">{{ modalTitle }}</div>
        </template>
        <template #body>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label
                        for="end"
                        class="block text-sm text-gray-700 font-medium dark:text-white"
                        >Date de Début
                    </label>

                    <input
                        lang="fr-CA"
                        :min="new Date().toISOString().split('T')[0]"
                        v-model="startDate"
                        type="date"
                        class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700"
                        placeholder="Select date"
                        name="end"
                    />
                </div>
                <div>
                    <label
                        for="end"
                        class="block text-sm text-gray-700 font-medium dark:text-white"
                        >Date de Fin
                    </label>

                    <input
                        lang="fr-CA"
                        :min="new Date().toISOString().split('T')[0]"
                        v-model="startDate"
                        type="date"
                        class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-900 dark:border-gray-700"
                        placeholder="Select date"
                        name="end"
                    />
                </div>
            </div>
        </template>
        <template #footer>
            <div class="flex justify-between">
                <button
                    @click="generateRapportLitteraire"
                    type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="icon icon-tabler icon-tabler-device-floppy"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path
                            stroke="none"
                            d="M0 0h24v24H0z"
                            fill="none"
                        ></path>
                        <path
                            d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"
                        ></path>
                        <path
                            d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"
                        ></path>
                        <path d="M14 4l0 4l-6 0l0 -4"></path>
                    </svg>
                </button>
            </div>
        </template>
    </Modal>

    <div class="px-2 pt-2">
        <div
            class="grid grid-cols-1 px-3 pt-2 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900"
        >
            <div class="col-span-full xl:col-auto mb-4">
                <ul
                    class="rounded-lg p-4 bg-white divide-y divide-gray-200 dark:divide-gray-700"
                >
                    <li class="pb-3 sm:pb-4">
                        <div
                            class="flex items-center justify-between space-x-4"
                        >
                            <div class="min-w-0">
                                <p
                                    class="text-sm font-medium text-gray-900 truncate dark:text-white"
                                >
                                    Rapport financier
                                </p>
                            </div>
                            <div
                                class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white"
                            >
                                <button
                                    @click="showModal('Rapport financier')"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-chevron-right"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path
                                            stroke="none"
                                            d="M0 0h24v24H0z"
                                            fill="none"
                                        ></path>
                                        <path d="M9 6l6 6l-6 6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </li>

                    <li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p
                                    class="text-sm font-medium text-gray-900 truncate dark:text-white"
                                >
                                    Rapport littéraire
                                </p>
                            </div>
                            <div
                                class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white"
                            >
                                <button
                                    @click="showModal('Rapport littéraire')"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-chevron-right"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path
                                            stroke="none"
                                            d="M0 0h24v24H0z"
                                            fill="none"
                                        ></path>
                                        <path d="M9 6l6 6l-6 6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div
                class="col-span-2 bg-white p-4 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 max-h-96 overflow-y-auto"
            >
                <h2 class="uppercase tet-gray-600 mb-4 italic">Rapports :</h2>
                <ul
                    v-for="rapport in rapports"
                    :key="rapport.id"
                    class="rounded-lg divide-y divide-gray-200 dark:divide-gray-700"
                >
                    <li class="pb-1 sm:pb-1">
                        <div
                            class="flex items-center justify-between space-x-4"
                        >
                            <div class="min-w-0">
                                <p
                                    class="text-sm font-medium text-gray-900 truncate dark:text-white"
                                >
                                    {{ rapport.title }}
                                </p>
                            </div>
                            <div class="min-w-0">
                                <p
                                    class="text-sm font-medium text-gray-900 truncate dark:text-white"
                                >
                                    {{ rapport.created_at }}
                                </p>
                            </div>
                            <div
                                class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white"
                            >
                                <a
                                    target="_blank"
                                    :href="/storage/ + rapport.file_path"
                                    class="inline-flex items-center p-2 text-sm text-center text-blue-700 focus:outline-none"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-chevron-right"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        fill="none"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path
                                            stroke="none"
                                            d="M0 0h24v24H0z"
                                            fill="none"
                                        ></path>
                                        <path
                                            d="M14 3v4a1 1 0 0 0 1 1h4"
                                        ></path>
                                        <path
                                            d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"
                                        ></path>
                                        <path d="M12 17v-6"></path>
                                        <path
                                            d="M9.5 14.5l2.5 2.5l2.5 -2.5"
                                        ></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <a
        class="inline-flex mt-6 items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        :href="route('e-documents.rapport_litteraire')"
        target="_blank"
        rel="noreferrer"
    >
        Generer rapport litteraire
    </a>
    <a
        class="inline-flex mt-6 items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        :href="route('e-documents.rapport_financier')"
        target="_blank"
        rel="noreferrer"
    >
        Generer rapport financier
    </a>
    <br />
    <!-- {{ evenements }} -->
    <p>
        {{ totalDepense ?? 0 }}
        {{ totalRevenue ?? 0 }}
        {{ totalDepense - totalRevenue }}
    </p>
    <br />
    <p>
        {{ depenses }}
    </p>
    <hr />
    <p>
        EVENT
        {{ evenements }}
    </p>
    <br />
    <br />
    <p>{{ frais_adhesions }}</p>
</template>

<script setup>
import { usePage, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { Modal } from "flowbite-vue";
import jsPDF from "jspdf";
import fontFile from "../../../assets/fonts/NotoSansArabicCondensedMedium.ttf";

const startDate = ref(null);
const isShowModal = ref(false);
const modalTitle = ref("");
const closeModal = () => {
    isShowModal.value = false;
};
const showModal = (title) => {
    modalTitle.value = title;
    isShowModal.value = true;
};

const props = defineProps({
    evenements: {
        type: Object,
        default: () => ({}),
    },
    rapports: {
        type: Object,
        default: () => ({}),
    },
    depenses: {
        type: Object,
        default: () => ({}),
    },
    totalRevenue: {
        type: Number,
    },
    totalDepense: {
        type: Number,
    },
    totalBenefice: {
        type: Number,
    },
    frais_adhesions: {
        type: Number,
    },
});

const page = usePage();

const generateRapportLitteraire = () => {
    const doc = new jsPDF("p", "mm", "a4");
    const pageWidth =
        doc.internal.pageSize.getWidth() || doc.internal.pageSize.width();
    const distanceFromRight = 10;
    //   doc.addFileToVFS("NotoSansArabicCondensedMedium.ttf", fontFile);
    doc.addFont(fontFile, "NotoSansArabicCondensed", "normal", "Identity-H");

    doc.setFont("NotoSansArabicCondensed");
    // Add the image to the PDF
    const img = doc.addImage(
        `/storage/${page.props.auth.user.association.image}`,
        "JPEG",
        (pageWidth - 30) / 2,
        2,
        30,
        30
    );
    const txt = "التقرير الأدبي";
    doc.setFontSize(15);
    const title = `${page.props.auth.user.association.name}`;
    const titleWidth = doc.getTextWidth(title);
    const titleX = (pageWidth - titleWidth) / 2;
    const txtX = (pageWidth - doc.getTextWidth(txt)) / 2;
    doc.text(title, titleX, 34);

    doc.setFontSize(13);
    doc.text(txt, txtX, 43);
    //   doc.line(0, 45, 400, 45);
    //   const textWidth =
    //     (doc.getTextWidth(text) * fontSize) / doc.internal.scaleFactor;
    doc.setFontSize(10);
    const content = `لقد قطعت ${page.props.auth.user.association.name} أشواطا مهمة خلال مدة وجيزة وقصيرة لا تتعدى سنة واحدة من عمر هذه الجمعية، فقد تأسست جمعيتنا تحت اسم: الجمعية النسوية لتربية النحل بتاريخ 2000/01/01، ومنذ ذلك التاريخ وهي تحاول تحقيق الأهداف المتوخاة والمسطرة في القانون الأساسي للجمعية، فطبقا للمادة السابعة من القانون الأساسي للجمعية فإنها  تعقد جمعا سنويا لتقييم نشاطها ووضع برنامج للسنة التالية، وهكذا قامت الجمعية بمجموعة من الأنشطة بمبادرات فردية وتضحيات من طرف كافة العضوات والمنخرطات ونذكرها كما يلـــي:`;
    const lines = doc.splitTextToSize(content, pageWidth - distanceFromRight);
    doc.text(lines, distanceFromRight, 50);

    const headers = ["name", "Nom", "start"];
    const data = props.evenements.map((event) => [
        event.reference,
        event.description,
        event.start,
    ]);

    doc.autoTable({
        margin: { top: 150 },
        head: [headers],
        body: data,
    });
    // Save the PDF
    //   window.open(doc.output("dataurlnewwindow"));
    doc.save("rapport_litteraire_2022_2023.pdf");
};
</script>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
export default {
    layout: MainLayout,
};
</script>
