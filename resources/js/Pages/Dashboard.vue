<script>
import RootLayout from "../Layouts/RootLayout.vue";

export default {
    layout: RootLayout,
};
</script>
<template>
    <div>
        <div class="mt-4">
            <div
                class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 xl:grid-cols-4 gap-6"
            >
                <div class="card transition duration-500 ease-in-out transform">
                    <div
                        class="flex items-center p-5 bg-white rounded shadow-lg"
                    >
                        <div
                            class="p-3 rounded-full bg-indigo-600 bg-opacity-75"
                        >
                            <AccountSupervisorOutline fillColor="#FFFFFF" />
                        </div>

                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">
                                {{ adherents_count }}
                            </h4>
                            <div class="text-gray-500">
                                {{ $t("dashboard.adherents") }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card transition duration-500 ease-in-out transform">
                    <div
                        class="flex items-center p-5 bg-white rounded shadow-lg"
                    >
                        <div class="p-3 rounded-full bg-blue-600 bg-opacity-75">
                            <AccountGroup fillColor="#FFFFFF" />
                        </div>

                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">
                                {{ groupes_count }}
                            </h4>
                            <div class="text-gray-500">
                                {{ $t("dashboard.groupes") }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card transition duration-500 ease-in-out transform">
                    <div
                        class="flex items-center p-5 bg-white rounded shadow-lg"
                    >
                        <div class="p-3 rounded-full bg-teal-600 bg-opacity-75">
                            <Calendar fillColor="#FFFFFF" />
                        </div>

                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">
                                {{ events_count }}
                            </h4>
                            <div class="text-gray-500">
                                {{ $t("dashboard.activites") }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card transition duration-500 ease-in-out transform">
                    <div
                        class="flex items-center p-5 bg-white rounded shadow-lg"
                    >
                        <div
                            class="p-3 rounded-full bg-green-600 bg-opacity-75"
                        >
                            <DotsGrid fillColor="#FFFFFF" />
                        </div>

                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">
                                {{ stock_count }}
                            </h4>
                            <div class="text-gray-500">
                                {{ $t("dashboard.biens") }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex text-right justify-start items-center">
                <select
                    v-model="selectedYear"
                    id="type"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                >
                    <option disabled value="">
                        {{ $t("dashboard.select_year") }}
                    </option>
                    <option v-for="year in yearsList" :value="year" :key="year">
                        {{ year }}
                    </option>
                </select>
            </div>

            <!-- APex chart -->
            <div class="mt-4 grid gap-4 xl:grid-cols-2">
                <div class="bg-white py-6 rounded-md">
                    <apexchart
                        type="bar"
                        :options="columnOptions"
                        :series="columnSeries"
                    ></apexchart>
                </div>
                <div class="bg-white p-4 rounded-md">
                    <!-- Adjusted column span and added flex classes -->
                    <apexchart
                        type="pie"
                        :options="revenuesPieOptions"
                        :series="revenuesPieSeries"
                    ></apexchart>
                </div>
            </div>

            <div class="mt-4 grid gap-4 xl:grid-cols-2">
                <div class="bg-white py-6 rounded-md">
                    <apexchart
                        type="bar"
                        :options="columnActivityOptions"
                        :series="seriesActivity"
                    ></apexchart>
                </div>
                <div class="bg-white p-4 rounded-md">
                    <apexchart
                        type="pie"
                        :options="depensesPieOptions"
                        :series="depensesPieSeries"
                    ></apexchart>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, watchEffect } from "vue";

import { usePage, router } from "@inertiajs/vue3";
import { useI18n } from "vue-i18n";
import Calendar from "vue-material-design-icons/Calendar.vue";
import AccountGroup from "vue-material-design-icons/AccountGroup.vue";
import DotsGrid from "vue-material-design-icons/DotsGrid.vue";
import AccountSupervisorOutline from "vue-material-design-icons/AccountSupervisorOutline.vue";

const { t, availableLocales, locale } = useI18n();

const props = defineProps({
    groupesData: {
        type: Object,
        default: () => ({}),
    },
    groupes_count: {
        type: Number,
    },
    adherents_count: {
        type: Number,
    },
    stock_count: {
        type: Number,
    },
    events_count: {
        type: Number,
    },
    calculateStockTotal: {
        type: Number,
    },
    totalMontant: {
        type: Number,
    },
    cotisation_count: {
        type: Number,
    },
    stocksGroupedByType: {
        type: Object,
        default: () => ({}),
    },
    evenementsGroupedByType: {
        type: Object,
        default: () => ({}),
    },
    totalAbonnementsSum: {
        type: Number,
    },
    autreDepense: {
        type: Number,
    },
    autreRevenue: {
        type: Number,
    },
    activityDepenses: {
        type: Number,
    },
    activityRevenue: {
        type: Number,
    },
    yearsList: {
        type: Array,
        default: () => [],
    },
    depenseGroupedByMonth: {
        type: Object,
        default: () => ({}),
    },
    revenueGroupedByMonth: {
        type: Object,
        default: () => ({}),
    },
});
let selectedYear = ref("");

watchEffect(() => {
    if (selectedYear.value) {
        router.get(
            route("dashboard", {
                year: selectedYear.value,
            }),
        );
    }
});

const pageProps = usePage().props;
const stocksGroupedByType = props.stocksGroupedByType;
const evenementsGroupedByType = props.evenementsGroupedByType;

const depensesPieSeries = ref([props.activityDepenses, props.autreDepense]);
const depensesPieOptions = ref({
    chart: {
        width: 380,
        type: "pie",
    },
    labels: [t("dashboard.activites"), t("dashboard.autres")],
    responsive: [
        {
            breakpoint: 480,
            options: {
                chart: {
                    width: 200,
                },
                legend: {
                    position: "bottom",
                },
            },
        },
    ],
    title: {
        text: t("dashboard.depenses_asso"),
        align: "center",
        style: {
            fontSize: "18px",
        },
    },
});

const revenuesPieSeries = ref([
    props.activityRevenue,
    props.totalAbonnementsSum,
    props.autreRevenue,
]);
const revenuesPieOptions = ref({
    chart: {
        width: 380,
        type: "pie",
    },
    labels: [
        t("dashboard.activites"),
        t("dashboard.frais_adhesion"),
        t("dashboard.autres"),
    ],
    responsive: [
        {
            // breakpoint: 480,
            options: {
                chart: {
                    // width: 200,
                },
                legend: {
                    position: "bottom",
                },
            },
        },
    ],
    title: {
        text: t("dashboard.revenus_asso"),
        align: "center",
        style: {
            fontSize: "18px",
        },
    },
});

const columnSeries = ref([
    {
        name: t("dashboard.depenses"),
        data: Object.values(props.depenseGroupedByMonth),
    },
    {
        name: t("dashboard.revenus"),
        data: Object.values(props.revenueGroupedByMonth),
    },
]);

const columnOptions = ref({
    chart: {
        type: "bar",
        height: 390,
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: "55%",
            endingShape: "rounded",
        },
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        show: true,
        width: 2,
        colors: ["transparent"],
    },
    xaxis: {
        categories: [
            t("dashboard.months.jan"),
            t("dashboard.months.feb"),
            t("dashboard.months.mar"),
            t("dashboard.months.apr"),
            t("dashboard.months.may"),
            t("dashboard.months.jun"),
            t("dashboard.months.jul"),
            t("dashboard.months.aug"),
            t("dashboard.months.sep"),
            t("dashboard.months.oct"),
            t("dashboard.months.nov"),
            t("dashboard.months.dec"),
        ],
    },
    yaxis: {
        title: {
            text: "(MAD)",
        },
    },
    fill: {
        opacity: 1,
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "DH " + val;
            },
        },
    },
    title: {
        text: t("dashboard.depenses_revenus_asso"),
        align: "center",
        style: {
            fontSize: "18px",
        },
    },
});

const seriesActivity = ref([
    {
        data: Object.values(evenementsGroupedByType).map((event) =>
            event == null ? 0 : event.length,
        ),
    },
]);

const columnActivityOptions = ref({
    chart: {
        height: 350,
        type: "bar",
        events: {
            click: function (chart, w, e) {
                // console.log(chart, w, e)
            },
        },
    },
    plotOptions: {
        bar: {
            columnWidth: "45%",
            distributed: true,
        },
    },
    dataLabels: {
        enabled: false,
    },
    legend: {
        show: false,
    },
    xaxis: {
        categories: Object.keys(evenementsGroupedByType),
        labels: {
            style: {
                fontSize: "12px",
            },
        },
    },
    title: {
        text: t("dashboard.activites_by_type"),
        align: "center",
        style: {
            fontSize: "18px",
        },
    },
});

// const dataBarStocks = ref({
//     labels: Object.keys(stocksGroupedByType),
//     datasets: [
//         {
//             label: "Stocks groupés par type",
//             data: Object.values(stocksGroupedByType).map(
//                 (stocks) => stocks.length
//             ),
//             backgroundColor: "#5A67D8",
//             borderColor: "transparent",
//             borderWidth: 1,
//         },
//     ],
// });

const dataBarEvent = ref({
    labels: Object.keys(evenementsGroupedByType),
    datasets: [
        {
            label: "Événements groupés par type",
            // data: Object.values(evenementsGroupedByType).map(
            //     (evenements) => evenements.length
            // ),
            data: null,
            backgroundColor: "#5A67D8",
            borderColor: "transparent",
            borderWidth: 1,
        },
    ],
});
</script>
