<script>
import { defineComponent, ref, onMounted } from 'vue';
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
		onMounted(() => {
			// console.log(polarArea.value.chart);
			// console.log(polarArea.value.helpers); // undefined
		});
		return {
			polarArea,
			chartJsClickableLabels,
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
		:plugins="[chartJsClickableLabels, ...plugins]"
	/>
</template>
