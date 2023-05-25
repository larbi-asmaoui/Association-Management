<script>
import MainLayout from "../Layouts/MainLayout.vue";

export default {
    layout: MainLayout,
};
</script>

<script setup>
import { ref } from "vue";

import { usePage } from "@inertiajs/vue3";
import ChartBar from "../Components/ChartBar.vue";
import ChartPie from "../Components/ChartPie.vue";
// import { Inertia } from "@inertiajs/vue3";

const props = defineProps({
    groupesData: {
        type: Object,
        default: () => ({}),
    },
    groupes_count: {
        type: Number,
    },
    adherants_count: {
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
    totalStockValue: {
        type: Number,
    },
    totalCotisationValue: {
        type: Number,
    },
    autreDepense: {
        type: Number,
    },
});

const pageProps = usePage().props;
const stocksGroupedByType = props.stocksGroupedByType;

const revenueOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        title: {
            display: true,
            text: "Revenues de l'association",
        },
    },
});

const depenseOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        title: {
            display: true,
            text: "Dépenses de l'association",
        },
    },
});

const barOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        y: {
            ticks: {
                stepSize: 1,
                beginAtZero: true,
            },
        },
    },
});

const data = ref({
    labels: ["Stocks (DH)", "Cotisations (DH)"],
    datasets: [
        {
            backgroundColor: ["#247BA0", "#70C1B3"],
            data: [props.totalStockValue, props.totalCotisationValue],
        },
    ],
});

const dataDepense = ref({
    labels: ["Stocks (DH)", "Autres dépenses (DH)"],
    datasets: [
        {
            backgroundColor: ["#247BA0", "#70C1B3"],
            data: [props.totalStockValue, props.autreDepense],
        },
    ],
});

const dataBar = ref({
    labels: Object.keys(stocksGroupedByType),
    datasets: [
        {
            label: "Stocks groupés par type",
            data: Object.values(stocksGroupedByType).map(
                (stocks) => stocks.length
            ),
            backgroundColor: "#5A67D8",
            borderColor: "transparent",
            borderWidth: 1,
        },
    ],
});
</script>
<template>
    <div>
        {{ autreDepense }}
        <div class="mb-4">
            <h1
                class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white"
            >
                Tableau de board
            </h1>
        </div>
        <div class="mt-4">
            <div
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-6"
            >
                <div class="card transition duration-500 ease-in-out transform">
                    <div
                        class="flex items-center p-5 bg-white rounded shadow-lg"
                    >
                        <div
                            class="p-3 rounded-full bg-indigo-600 bg-opacity-75"
                        >
                            <svg
                                class="w-8 h-8 text-white"
                                viewBox="0 0 28 30"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6"
                                >
                                    <path
                                        fill="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"
                                    />
                                </svg>
                            </svg>
                        </div>

                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">
                                {{ adherants_count }}
                            </h4>
                            <div class="text-gray-500">Adhérents</div>
                        </div>
                    </div>
                </div>

                <div class="card transition duration-500 ease-in-out transform">
                    <div
                        class="flex items-center p-5 bg-white rounded shadow-lg"
                    >
                        <div class="p-3 rounded-full bg-blue-600 bg-opacity-75">
                            <svg
                                class="w-8 h-8 text-white"
                                viewBox="0 0 28 30"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M18.2 9.08889C18.2 11.5373 16.3196 13.5222 14 13.5222C11.6804 13.5222 9.79999 11.5373 9.79999 9.08889C9.79999 6.64043 11.6804 4.65556 14 4.65556C16.3196 4.65556 18.2 6.64043 18.2 9.08889Z"
                                    fill="currentColor"
                                />
                                <path
                                    d="M25.2 12.0444C25.2 13.6768 23.9464 15 22.4 15C20.8536 15 19.6 13.6768 19.6 12.0444C19.6 10.4121 20.8536 9.08889 22.4 9.08889C23.9464 9.08889 25.2 10.4121 25.2 12.0444Z"
                                    fill="currentColor"
                                />
                                <path
                                    d="M19.6 22.3889C19.6 19.1243 17.0927 16.4778 14 16.4778C10.9072 16.4778 8.39999 19.1243 8.39999 22.3889V26.8222H19.6V22.3889Z"
                                    fill="currentColor"
                                />
                                <path
                                    d="M8.39999 12.0444C8.39999 13.6768 7.14639 15 5.59999 15C4.05359 15 2.79999 13.6768 2.79999 12.0444C2.79999 10.4121 4.05359 9.08889 5.59999 9.08889C7.14639 9.08889 8.39999 10.4121 8.39999 12.0444Z"
                                    fill="currentColor"
                                />
                                <path
                                    d="M22.4 26.8222V22.3889C22.4 20.8312 22.0195 19.3671 21.351 18.0949C21.6863 18.0039 22.0378 17.9556 22.4 17.9556C24.7197 17.9556 26.6 19.9404 26.6 22.3889V26.8222H22.4Z"
                                    fill="currentColor"
                                />
                                <path
                                    d="M6.64896 18.0949C5.98058 19.3671 5.59999 20.8312 5.59999 22.3889V26.8222H1.39999V22.3889C1.39999 19.9404 3.2804 17.9556 5.59999 17.9556C5.96219 17.9556 6.31367 18.0039 6.64896 18.0949Z"
                                    fill="currentColor"
                                />
                            </svg>
                        </div>

                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">
                                {{ groupes_count }}
                            </h4>
                            <div class="text-gray-500">Groupes</div>
                        </div>
                    </div>
                </div>

                <!-- ------------------- -->
                <div class="card transition duration-500 ease-in-out transform">
                    <div
                        class="flex items-center p-5 bg-white rounded shadow-lg"
                    >
                        <div class="p-3 rounded-full bg-teal-600 bg-opacity-75">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-8 h-8 text-white icon icon-tabler icon-tabler-calendar-event"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="#ffffff"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                />
                                <rect
                                    x="4"
                                    y="5"
                                    width="16"
                                    height="16"
                                    rx="2"
                                />
                                <line x1="16" y1="3" x2="16" y2="7" />
                                <line x1="8" y1="3" x2="8" y2="7" />
                                <line x1="4" y1="11" x2="20" y2="11" />
                                <rect x="8" y="15" width="2" height="2" />
                            </svg>
                        </div>

                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">
                                {{ events_count }}
                            </h4>
                            <div class="text-gray-500">Evenements</div>
                        </div>
                    </div>
                </div>
                <!-- ----------------------- -->
                <div class="card transition duration-500 ease-in-out transform">
                    <div
                        class="flex items-center p-5 bg-white rounded shadow-lg"
                    >
                        <div
                            class="p-3 rounded-full bg-green-600 bg-opacity-75"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-8 h-8 text-white icon icon-tabler icon-tabler-components"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="#ffffff"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                />
                                <path d="M3 12l3 3l3 -3l-3 -3z" />
                                <path d="M15 12l3 3l3 -3l-3 -3z" />
                                <path d="M9 6l3 3l3 -3l-3 -3z" />
                                <path d="M9 18l3 3l3 -3l-3 -3z" />
                            </svg>
                        </div>

                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">
                                {{ stock_count }}
                            </h4>
                            <div class="text-gray-500">Stocks</div>
                        </div>
                    </div>
                </div>
                <!-- --------------------- -->
                <div class="card transition duration-500 ease-in-out transform">
                    <div
                        class="flex items-center p-5 bg-white rounded shadow-lg"
                    >
                        <div class="p-3 rounded-full bg-rose-600 bg-opacity-75">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-8 h-8 text-white icon icon-tabler icon-tabler-components"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="#ffffff"
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
                                    d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"
                                ></path>
                                <path
                                    d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1 -1.8 -1"
                                ></path>
                                <path d="M12 7v10"></path>
                            </svg>
                        </div>

                        <div class="mx-5">
                            <h4 class="text-2xl font-semibold text-gray-700">
                                {{ cotisation_count }}
                            </h4>
                            <div class="text-gray-500">Cotisations</div>
                        </div>
                    </div>
                </div>
                <!-- --------------------- -->
            </div>

            <div class="mt-4">
                <div class="grid gap-6 xl:grid-cols-4">
                    <div
                        class="bg-white p-4 shadow-2xl rounded-md xl:col-span-2"
                    >
                        <ChartBar :data="dataBar" :options="barOptions" />
                    </div>
                    <div
                        class="bg-white p-4 shadow-2xl rounded-md xl:col-span-1"
                    >
                        <ChartPie :data="data" :options="revenueOptions" />
                    </div>
                    <div
                        class="bg-white p-4 shadow-2xl rounded-md xl:col-span-1"
                    >
                        <ChartPie
                            :data="dataDepense"
                            :options="depenseOptions"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
