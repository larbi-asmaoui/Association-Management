<template>
  {{ startDate }}

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
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path
              d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"
            ></path>
            <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
            <path d="M14 4l0 4l-6 0l0 -4"></path>
          </svg>
        </button>
      </div>
    </template>
  </Modal>

  <div class="px-2 pt-2">
    <ul
      class="max-w-md bg-white rounded-lg p-4 divide-y divide-gray-200 dark:divide-gray-700"
    >
      <li class="pb-3 sm:pb-4">
        <div class="flex items-center space-x-4">
          <div class="flex-1 min-w-0">
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
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
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
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M9 6l6 6l-6 6"></path>
              </svg>
            </button>
          </div>
        </div>
      </li>
    </ul>
  </div>
  <div>
    <!-- :pagination-options="{
    enabled: true,
    nextLabel: 'next',
    prevLabel: 'prev',
    rowsPerPageLabel: 'Rows per page',
    ofLabel: 'of',
    pageLabel: 'page', // for 'pages' mode
    allLabel: 'All',
  }"> -->
    <vue-good-table
      :columns="columns"
      :rows="rows"
      :pagination-options="{
        enabled: true,
      }"
    >
      <template v-slot:table-row="{ row, column, formattedRow }">
        <span v-if="column.field === 'actions'">
          <button @click="editRow(row)">Edit</button>
          <button @click="deleteRow(row)">Delete</button>
        </span>
        <span v-else>
          {{ formattedRow[column.field] }}
        </span>
      </template>
    </vue-good-table>
  </div>
  <Link :href="route('e-documents.rapport_litteraire')">
    Generer rapport litteraire
  </Link>
</template>

<script setup>
// import { VueEditor, Quill } from "@vue2-editor";
import { VueGoodTable } from "vue-good-table-next";
import "vue-good-table-next/dist/vue-good-table-next.css";
import { usePage, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { Modal } from "flowbite-vue";
import autoTable from "jspdf-autotable";
import jsPDF from "jspdf";
import fontFile from "../../../assets/fonts/NotoSansArabicCondensedMedium.ttf";

const startDate = ref(null);
const isShowModal = ref(false);
const modalTitle = ref("");
const closeModal = (title) => {
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
  methods: {
    editRow(row) {
      // Handle the edit action
    },
    deleteRow(row) {
      // Handle the delete action
    },
  },
  data() {
    return {
      columns: [
        {
          label: "Name",
          field: "name",
        },
        {
          label: "Age",
          field: "age",
          type: "number",
        },
        {
          label: "Created On",
          field: "createdAt",
          type: "date",
          dateInputFormat: "yyyy-MM-dd",
          dateOutputFormat: "MMM do yy",
        },
        {
          label: "Percent",
          field: "score",
          type: "percentage",
        },
        {
          label: "Actions",
          field: "actions",
        },
      ],
      rows: [
        {
          id: 1,
          name: "John",
          age: 20,
          createdAt: "2011-10-31",
          score: 0.03343,
        },
        {
          id: 2,
          name: "Jane",
          age: 24,
          createdAt: "2011-10-31",
          score: 0.03343,
        },
        {
          id: 3,
          name: "Susan",
          age: 16,
          createdAt: "2011-10-30",
          score: 0.03343,
        },
        {
          id: 4,
          name: "Chris",
          age: 55,
          createdAt: "2011-10-11",
          score: 0.03343,
        },
        {
          id: 5,
          name: "Dan",
          age: 40,
          createdAt: "2011-10-21",
          score: 0.03343,
        },
        {
          id: 6,
          name: "John",
          age: 20,
          createdAt: "2011-10-31",
          score: 0.03343,
        },
      ],
    };
  },
};
</script>
