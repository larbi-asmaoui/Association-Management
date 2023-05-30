<script setup>
import { ref, withDefaults } from "vue";
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend,
} from "chart.js";
import { Line } from "vue-chartjs";
ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
);
const props = withDefaults(defineProps(), {
    chartData: {
        type: Object,
        required: true,
    },
    chartOptions: {
        type: Object,
        default: () => {},
    },
});
const chartData = ref(props.chartData);
const chartOptions = ref(props.chartOptions);
</script>
<template>
    <Line :data="chartData" :options="chartOptions" />
</template>
