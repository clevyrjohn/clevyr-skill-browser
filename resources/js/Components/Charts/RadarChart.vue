<script>
import { defineComponent, h } from 'vue';
import { Radar } from 'vue-chartjs';
import {
	Chart as ChartJS,
	Title,
	Tooltip,
	Legend,
	PointElement,
	RadialLinearScale,
	LineElement,
} from 'chart.js';

ChartJS.register(
	Title,
	Tooltip,
	Legend,
	PointElement,
	RadialLinearScale,
	LineElement,
);

export default defineComponent({
	name: 'RadarChart',
	components: {
		Radar,
	},
	props: {
		chartId: {
			type: String,
			default: 'radar-chart',
		},
		chartData: {
			type: Object,
			default: () => {},
		},
		chartOptions: {
			type: Object,
			default: () => {
				return {
					responsive: true,
					maintainAspectRatio: false,
				};
			},
		},
		width: {
			type: Number,
			default: 400,
		},
		height: {
			type: Number,
			default: 400,
		},
		cssClasses: {
			default: '',
			type: String,
		},
		styles: {
			type: Object,
			default: () => {},
		},
		plugins: {
			type: Array,
			default: () => [],
		},
	},
	setup(props) {
		return () =>
			h(Radar, {
				chartData: props.chartData,
				chartOptions: props.chartOptions,
				chartId: props.chartId,
				width: props.width,
				height: props.height,
				cssClasses: props.cssClasses,
				styles: props.styles,
				plugins: props.plugins,
			});
	},
});

</script>
