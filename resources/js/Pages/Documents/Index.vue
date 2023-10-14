<template>
    <!-- loading  -->
    <div
        v-if="loading"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30"
    >
        <a-spin size="large" />
    </div>

    <a-config-provider :direction="$i18n.locale === 'ar' ? 'rtl' : 'ltr'">
        <div class="px-2 pt-2">
            <h2
                class="text-xl font-semibold text-black-600 mb-4"
                :class="$i18n.locale === 'ar' ? 'text-right' : 'text-left'"
            >
                {{ $t("documents.titre") }}
            </h2>
            <div class="grid grid-cols-1 mt-5 xl:grid-cols-3 xl:gap-4">
                <div class="col-span-full xl:col-auto mb-4">
                    <ul
                        class="rounded-lg p-4 bg-white divide-y divide-gray-200"
                    >
                        <li class="pb-3 sm:pb-4">
                            <div
                                class="flex items-center justify-between space-x-4"
                            >
                                <div class="min-w-0">
                                    <p
                                        class="text-sm font-medium text-gray-900 truncate"
                                    >
                                        {{ $t("documents.rapport_financier") }}
                                    </p>
                                </div>
                                <div
                                    class="inline-flex items-center text-base font-semibold text-gray-900"
                                >
                                    <button
                                        @click="generateRapportFinancier"
                                        class="inline-flex items-center text-sm font-medium text-center text-blue-700 hover:text-blue-800"
                                    >
                                        <ArrowLeft
                                            v-if="$i18n.locale === 'ar'"
                                        />
                                        <ArrowRight v-else />
                                    </button>
                                </div>
                            </div>
                        </li>

                        <li class="py-3 sm:py-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-1 min-w-0">
                                    <p
                                        class="text-sm font-medium text-gray-900 truncate"
                                    >
                                        {{ $t("documents.rapport_litteraire") }}
                                    </p>
                                </div>
                                <div
                                    class="inline-flex items-center text-base font-semibold text-gray-900"
                                >
                                    <button
                                        @click="generateRapportLitteraire"
                                        class="inline-flex items-center text-sm font-medium text-center text-blue-700 hover:text-blue-800"
                                    >
                                        <ArrowLeft
                                            v-if="$i18n.locale === 'ar'"
                                        />
                                        <ArrowRight v-else />
                                    </button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div
                    class="col-span-2 p-2 bg-white rounded-t-lg overflow-y-auto"
                >
                    <h3
                        class="my-5 mx-2 text-md font-bold text-slate-800 uppercase"
                    >
                        {{ $t("documents.all_rapports") }}
                    </h3>

                    <a-config-provider
                        :direction="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
                    >
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
                                <a
                                    target="_blank"
                                    :href="record.file_path"
                                    class="inline-flex items-center text-sm font-medium text-center text-blue-700 hover:text-blue-800"
                                >
                                    <FileDownload />
                                </a>
                            </template>
                        </a-table>
                    </a-config-provider>
                </div>
            </div>
        </div>
    </a-config-provider>
</template>

<script setup>
import Swal from "sweetalert2";
import "vue-good-table-next/dist/vue-good-table-next.css";
import { usePage, router } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import { Modal } from "flowbite-vue";
import FileDownload from "vue-material-design-icons/FileDownload.vue";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue";
import ArrowRight from "vue-material-design-icons/ArrowRight.vue";
import { useI18n } from "vue-i18n";
const { t, availableLocales, locale } = useI18n();

const props = defineProps({
    rapports: {
        type: Object,
        default: () => ({}),
    },
});

const open = ref(false);

const showDrawer = () => {
    open.value = true;
};

const afterOpenChange = (bool) => {
    console.log("open", bool);
};

const pageSize = ref(10);

const columns = computed(() => [
    {
        title: "#",
        dataIndex: "id",
        key: "id",
        sorter: {
            // compare: (a, b) => a.id.localeCompare(b.id),
            compare: (a, b) => a.id - b.id,
        },
    },

    {
        title: t("documents.table_rapport"),
        dataIndex: "title",
        key: "title",
        sorter: {
            compare: (a, b) => a.title.localeCompare(b.title),
        },
        multipe: 1,
    },

    {
        title: t("documents.table_created_at"),
        dataIndex: "created_at",
        key: "created_at",
        sorter: {
            compare: (a, b) => a.created_at.localeCompare(b.created_at),
        },
        multipe: 1,
    },

    {
        title: t("adherents.table_actions"),
        dataIndex: "action",
        key: "action",
        slots: { customRender: "action" },
    },
]);

const rows = computed(() =>
    Object.values(props.rapports).map((rapport) => ({
        id: rapport.id,
        title: rapport.title,
        created_at: rapport.created_at,
        file_path: rapport.file_path,
    })),
);

const storage = () => {
    return "/storage/";
};

const loading = ref(false);

function generateRapportFinancier() {
    loading.value = true;

    axios
        .get("/e-document/rapport-financier")
        .then((response) => {
            loading.value = false;
            location.reload(); // Reload the page
        })
        .catch((error) => {
            loading.value = false;
            Swal.fire({
                icon: "error",
                title: error.response.status,
                text: error,
            });
        });
}

function generateRapportLitteraire() {
    loading.value = true;

    axios
        .get("/e-document/rapport-litteraire")
        .then((response) => {
            loading.value = false;
            location.reload(); // Reload the page
        })
        .catch((error) => {
            // Handle error
            loading.value = false;
            Swal.fire({
                icon: "error",
                title: error.response.status,
                text: error,
            });
        });
}
</script>

<script>
import RootLayout from "@/Layouts/RootLayout.vue";
export default {
    layout: RootLayout,
};
</script>

<style scoped></style>
