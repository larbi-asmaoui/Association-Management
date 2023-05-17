<script setup>
import { ref, withDefaults } from "vue";
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from "chart.js";
import { Pie } from "vue-chartjs";
ChartJS.register(ArcElement, Tooltip, Legend);
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
    <Pie :data="chartData" :options="chartOptions" />
</template>
