<template>
    <a-modal
        @cancel="closeModal"
        :footer="null"
        v-model:open="isModalOpen"
        :title="$t('reunions.modal_ajouter')"
    >
        <form
            :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
            class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2 overflow-y-auto max-h-[30rem]"
            @submit.prevent="submit"
        >
            <div>
                <label
                    for="title"
                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                    >{{ $t("reunions.input_nom") }}</label
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
                    >{{ $t("reunions.input_date") }}</label
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
                    >{{ $t("reunions.input_description") }}</label
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
                    >{{ $t("reunions.input_type") }}
                </label>

                <Multiselect
                    v-model="form.reunion_type_id"
                    :close-on-select="true"
                    :searchable="true"
                    :create-option="true"
                    :options="formattedReunionTypes"
                />
                <span
                    v-if="form.errors.reunion_type_id"
                    class="text-xs text-red-600 mt-1"
                    id="hs-validation-name-error-helper"
                >
                    {{ form.errors.reunion_type_id }}
                </span>
            </div>
            <div>
                <label
                    for="adherents"
                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                    >{{ $t("activities.input_adherents") }}</label
                >
                <Multiselect
                    v-model="form.adherents"
                    mode="tags"
                    :close-on-select="false"
                    :searchable="true"
                    :create-option="true"
                    :options="formattedAdherents"
                />
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
                    {{ $t("buttons.enregistrer") }}
                </button>
            </div>
        </form></a-modal
    >

    <div class="w-auto h-full py-4 px-2">
        <h2
            class="text-xl font-semibold text-black-600 mb-4"
            :class="$i18n.locale === 'ar' ? 'text-right' : 'text-left'"
        >
            {{ $t("reunions.titre") }}
        </h2>

        <div
            class="gap-2 py-1 mb-2 justify-between items-center block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
        >
            <el-button
                class="me-auto"
                type="primary"
                size="large"
                @click="isModalOpen = true"
            >
                <Plus />
            </el-button>
        </div>

        <a-config-provider :direction="$i18n.locale === 'ar' ? 'rtl' : 'ltr'">
            <a-table
                :columns="columns"
                :data-source="rows"
                :pagination="{
                    pageSize: pageSize.value,
                    showSizeChanger: true,
                    pageSizeOptions: ['10', '20', '30', '40'],
                }"
            >
                <template v-slot:action="{ record }">
                    <el-button
                        type="primary"
                        size="small"
                        @click="show(record.id)"
                        ><Eye />
                    </el-button>
                    <span class="me-2"></span>

                    <el-button
                        type="danger"
                        size="small"
                        @click="destroy(record)"
                        ><TrashCan
                    /></el-button>
                </template>
            </a-table>
        </a-config-provider>
    </div>
</template>

<script>
import RootLayout from "../../Layouts/RootLayout.vue";

export default {
    layout: RootLayout,
};
</script>

<script setup>
import Multiselect from "@vueform/multiselect";
import Swal from "sweetalert2";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
import { ref, computed } from "vue";
import { Modal } from "flowbite-vue";
import { router, usePage } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { useI18n } from "vue-i18n";
import TrashCan from "vue-material-design-icons/TrashCan.vue";
import Pencil from "vue-material-design-icons/Pencil.vue";
import Plus from "vue-material-design-icons/Plus.vue";
import Eye from "vue-material-design-icons/Eye.vue";
import Printer from "vue-material-design-icons/Printer.vue";
import { message } from "ant-design-vue";

const { t, availableLocales, locale } = useI18n();

const pageSize = ref(10);
const props = defineProps({
    reunions: {
        type: Object,
        default: () => ({}),
    },
    reunionTypes: {
        type: Object,
        default: () => ({}),
    },
    adherents: {
        type: Object,
        default: () => ({}),
    },
});

const page = usePage();

let isModalOpen = ref(false);

const form = useForm({
    id: null,
    name: null,
    description: null,
    reunion_type_id: null,
    date: null,
    adherents: [],
});

const columns = computed(() => [
    {
        title: t("reunions.table_nom"),
        dataIndex: "name",
        key: "name",
        sorter: {
            compare: (a, b) => a.name.localeCompare(b.name),
        },
        multipe: 1,
    },
    {
        title: t("reunions.table_type"),
        dataIndex: "type",
        key: "type",
        sorter: {
            compare: (a, b) => a.type.localeCompare(b.type),
        },
    },

    {
        title: t("reunions.table_date"),
        dataIndex: "date",
        key: "date",
        sorter: {
            compare: (a, b) => a.date.localeCompare(b.date),
        },
    },

    {
        title: t("adherents.table_actions"),
        dataIndex: "action",
        key: "action",
        slots: { customRender: "action" },
    },
]);
const rows = computed(() =>
    Object.values(props.reunions).map((reunion) => ({
        id: reunion.id,
        name: reunion.name,
        type: reunion.reunion_type ? reunion.reunion_type.name : "--",
        date: reunion.date,
        reunion_type_id: reunion.reunion_type_id,
        adherents: reunion.adherents,
    })),
);

const submit = () => {
    if (form.id) {
        // form.adherents = selectedAdherents.value;
        form.put(route("reunions.update", form.id), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();

                message.success(t("toasts.modif_success"));
            },
        });
    } else {
        // form.adherents = selectedAdherents.value;
        form.post(route("reunions.store"), {
            preserveScroll: true,
            onSuccess: () => {
                closeModal();

                message.success(t("toasts.ajout_success"));
            },
        });
    }
};

const closeModal = () => {
    isModalOpen.value = false;
    form.reset();
};

const show = (id) => {
    router.get(route("reunions.show", id));
};

const destroy = (id) => {
    Swal.fire({
        text: t("modals_questions.supprimer"),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: t("buttons.supprimer"),
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route("reunions.destroy", id), {
                onError: () => {
                    message.error(t("toasts.supp_error"));
                },
                onSuccess: () => {
                    message.success(t("toasts.supp_success"));
                },
            });
        }
    });
};

const printAttendanceList = (reunion) => {
    const doc = new jsPDF();

    // Step 1: Load the Arabic font file
    const arabicFontFile = "/fonts/Amiri-Regular.ttf";
    const arabicFontName = "Amiri";

    doc.addFont(arabicFontFile, arabicFontName, "normal");

    doc.setFont(arabicFontName);

    const pageWidth = doc.internal.pageSize.getWidth();
    // Add the image to the PDF
    doc.addImage(
        `/storage/${page.props.auth.association.image}`,
        "JPEG",
        (pageWidth - 20) / 2,
        2,
        20,
        20,
    );

    doc.setFontSize(14);
    const title = t("reunions.doc_title_adherents");
    const titleWidth = doc.getTextWidth(title);
    const titleX = (pageWidth - titleWidth) / 2;
    doc.text(title, titleX, 30);

    doc.setFontSize(25);
    const reunionName = reunion.name;
    const reunionNameWidth = doc.getTextWidth(reunionName);
    const reunionNameX = (pageWidth - reunionNameWidth) / 2;
    doc.text(reunionName, reunionNameX, 42);

    doc.setFontSize(12);
    const reunionType = reunion.reunion_type.name;
    const reunionTypeWidth = doc.getTextWidth(reunionType);
    const reunionTypeX = (pageWidth - reunionTypeWidth) / 2;
    doc.text(reunionType, reunionTypeX, 50);

    doc.setFontSize(12);
    const reunionDate = reunion.date;
    const reunionDateWidth = doc.getTextWidth(reunionDate);
    const reunionDateX = (pageWidth - reunionDateWidth) / 2;
    doc.text(reunionDate, reunionDateX, 58);
    doc.line(0, 65, 400, 65);

    const headers = [
        t("adherents.table_telephone"),
        t("adherents.table_cin"),
        t("adherents.table_nom_complete"),
        "#",
    ];

    const data = reunion.adherents.map((adherent, index) => [
        adherent.tel,
        adherent.cin,
        adherent.first_name + " " + adherent.last_name,
        index + 1,
    ]);

    doc.autoTable({
        margin: { top: 70 },
        theme: "grid",
        head: [headers],
        body: data,
        styles: {
            font: arabicFontName,
            halign: "center",
        },
        headStyles: {
            valign: "middle",
            halign: "center",
        },
    });
    doc.save("AttendanceList.pdf");
};

const openEditModal = (reunion) => {
    form.id = reunion.id;
    form.name = reunion.name;
    form.date = reunion.date;
    form.description = reunion.description;
    form.reunion_type_id = reunion.reunion_type_id;
    (form.adherents = reunion.adherents.map((adherent) => adherent.id)),
        (isModalOpen.value = true);
};

const formattedAdherents = computed(() =>
    Object.values(props.adherents).map((adherent) => ({
        value: adherent.id,
        label: adherent.last_name + " " + adherent.first_name,
    })),
);

const formattedReunionTypes = computed(() =>
    Object.values(props.reunionTypes).map((reunionType) => ({
        value: reunionType.id,
        label: reunionType.name,
    })),
);
</script>

<!-- <style src="@vueform/multiselect/themes/default.css"></style> -->
