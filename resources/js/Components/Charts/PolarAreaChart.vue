<script>
import { defineComponent, ref } from 'vue';
import { PolarArea } from 'vue-chartjs';
import {
	Chart as ChartJS,
	Title,
	Tooltip,
	Legend,
	ArcElement,
	RadialLinearScale,
} from 'chart.js';
import { chartJsClickableLabels } from '@/Composables/chartJsClickableLabels';
import ChartDataLabels from 'chartjs-plugin-datalabels';

ChartJS.register(Title, Tooltip, Legend, ArcElement, RadialLinearScale);

export default defineComponent({
	name: 'PolarAreaChart',
	components: {
		PolarArea,
	},
	props: {
		chartId: {
			type: String,
			default: 'polar-chart',
		},
		chartData: {
			type: Object,
			default: () => {},
		},
		width: {
			type: Number,
			default: 300,
		},
		height: {
			type: Number,
			default: 300,
		},
		cssClasses: {
			default: '',
			type: String,
		},
		styles: {
			default: () => {},
			type: Object,
		},
		labels: {
			default: () => [],
			type: Array,
		},
		data: {
			default: () => [],
			type: Array,
		},
		backgroundColor: {
			default: () => [],
			type: Array,
		},
		chartOptions: {
			default: () => {},
		},
		plugins: {
			default: () => [],
		},
	},
	setup() {
		const polarArea = ref(null);

		return {
			polarArea,
			chartJsClickableLabels,
			ChartDataLabels,
		};
	},
});
</script>

<template>
	<PolarArea
		ref="polarArea"
		:chart-data="chartData"
		:chart-options="chartOptions"
		:chart-id="chartId"
		:width="width"
		:height="height"
		:styles="styles"
		:css-classes="cssClasses"
		:plugins="[chartJsClickableLabels, ChartDataLabels, ...plugins]"
	/>
</template>
