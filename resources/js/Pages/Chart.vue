<template>
    <div class="w-25">
        <apexchart
            ref="chart"
            :options="chartOptions"
            :series="chartSeries"
            type="line"
            height="350"
        />
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import VueApexCharts from "vue3-apexcharts";
// import { Inertia } from "@inertiajs/inertia";
import { router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";

const chartOptions = ref({});
const chartSeries = ref([]);

onMounted(async () => {
    const { chartData } = usePage().props;

    chartOptions.value = chartData.options;
    chartSeries.value = chartData.series;
});
</script>
