<template>
    <div class="px-2 pt-2">
        <h3 class="mb-5 text-2xl font-bold text-slate-800 uppercase">
            {{ $t("documents.titre") }}
        </h3>
        <div class="grid grid-cols-1 mt-5 xl:grid-cols-3 xl:gap-4">
            <div class="col-span-full xl:col-auto mb-4">
                <ul class="rounded-lg p-4 bg-white divide-y divide-gray-200">
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
                                <a
                                    target="_blank"
                                    :href="
                                        route('e-documents.rapport_financier')
                                    "
                                    class="inline-flex items-center text-sm font-medium text-center text-blue-700 hover:text-blue-800"
                                >
                                    <ArrowLeft v-if="$i18n.locale === 'ar'" />
                                    <ArrowRight v-else />
                                </a>
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
                                <a
                                    :href="
                                        route('e-documents.rapport_litteraire')
                                    "
                                    target="_blank"
                                    rel="noreferrer"
                                    class="inline-flex items-center text-sm font-medium text-center text-blue-700 hover:text-blue-800"
                                >
                                    <ArrowLeft v-if="$i18n.locale === 'ar'" />
                                    <ArrowRight v-else />
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="col-span-2 bg-white rounded-t-lg overflow-y-auto">
                <h3
                    class="my-5 mx-2 text-md font-bold text-slate-800 uppercase"
                >
                    {{ $t("documents.all_rapports") }}
                </h3>

                <vue-good-table
                    :rtl="true"
                    :columns="columns"
                    :rows="rows"
                    :pagination-options="{
                        enabled: true,
                        mode: 'records',
                        perPage: 5,
                        perPageDropdown: [5, 10, 20],
                    }"
                    :search-options="{
                        enabled: true,
                        placeholder: $t('adherents.table_search'),
                    }"
                >
                    <template v-slot:table-row="{ row, column, formattedRow }">
                        <div v-if="column.field === 'file_path'" class="flex">
                            <a
                                target="_blank"
                                :href="row.file_path"
                                class="inline-flex items-center text-sm font-medium text-center text-blue-700 hover:text-blue-800"
                            >
                                <FileDownload />
                            </a>
                        </div>
                        <!-- <div v-else>
                            {{ formattedRow[column.field] }}
                        </div> -->
                    </template>
                </vue-good-table>
            </div>
        </div>
    </div>
</template>

<script setup>
import { VueGoodTable } from "vue-good-table-next";
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
    data: {
        type: Object,
        default: () => ({}),
    },
});

const columns = ref([
    {
        label: "#",
        field: "id",
    },
    {
        label: t("documents.table_rapport"),
        field: "title",
    },
    {
        label: t("documents.table_created_at"),
        field: "created_at",
    },
    {
        label: t("documents.table_actions"),
        field: "file_path",
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
</script>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
export default {
    layout: MainLayout,
};
</script>

<style scoped></style>
```
