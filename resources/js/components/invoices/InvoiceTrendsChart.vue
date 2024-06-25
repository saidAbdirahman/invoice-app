<template>
    <h1>hi</h1>
</template>
<!-- <template>

    <div>
        <canvas ref="chartCanvas"></canvas>
    </div>
</template>

<script>
import { onMounted, ref } from 'vue';
import Chart from 'chart.js/auto'; // Adjust based on your Chart.js setup

export default {
    props: {
        chartData: {
            type: Object,
            required: true
        },
        chartOptions: {
            type: Object,
            required: true
        }
    },
    setup(props) {
        const chartCanvas = ref(null);

        onMounted(() => {
            const ctx = chartCanvas.value.getContext('2d');
            new Chart(ctx, {
                type: 'bar', // Replace with your chart type
                data: props.chartData,
                options: props.chartOptions
            });
        });

        return {
            chartCanvas
        };
    }
};
</script>

<style scoped>
/* Add any component-specific styles here */
</style> -->
