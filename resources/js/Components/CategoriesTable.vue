<script setup>
import { ref, computed, inject, onMounted } from 'vue';
import {
	sortByIdAsc,
	sortByIdDesc,
	sortByNameDesc,
	sortByNameAsc,
	sortByCompanyTotalDesc,
	sortByCompanyTotalAsc,
} from '@/Composables/sortItems';
import { hexToRgbA } from '@/Composables/hexToRgbA';
import PolarAreaChart from './Charts/PolarAreaChart.vue';
import TransitionSlideFade from '@/Assets/TransitionSlideFade.vue';
import ChartLoading from '@/Components/ChartLoading.vue';

const {
	categories,
	isDataLoaded,
	sortKey,
	sortOrder,
} = inject('tableData');
const isComponentMounted = ref(false);

onMounted(() => {
	isComponentMounted.value = true;
});

const sortingAlgorithm = computed(() =>
	sortKey.value == 'id' ?
		sortOrder.value == 'desc' ?
			sortByIdDesc :
			sortByIdAsc :
		sortKey.value == 'total' ?
			sortOrder.value == 'desc' ?
				sortByCompanyTotalDesc :
				sortByCompanyTotalAsc :
			sortOrder.value == 'desc' ?
				sortByNameDesc :
				sortByNameAsc,
);

const sortedCategories = computed(() => [...categories.value].sort(sortingAlgorithm.value));

const { currentBreakpoint, preferredColor } = inject('windowInfo');

const chartFontColor = computed(() =>
	preferredColor.value == 'dark' ?
		'#ABABAB' :
		'#454545',
);
const chartHoverColor = computed(() =>
	preferredColor.value == 'dark' ?
		'#FFFFFF' :
		'#F9A340',
);

const chartMarginTop = computed(() =>
	currentBreakpoint.value == 'xs' ?
		20 :
		currentBreakpoint.value == 'sm' ?
			30 :
			currentBreakpoint.value == 'md' ?
				40 :
				currentBreakpoint.value == 'lg' ?
					50 :
					currentBreakpoint.value == 'xl' ?
						60 :
						70,
);

const chartFontSize = computed(() =>
	currentBreakpoint.value == 'xs' ?
		8 :
		currentBreakpoint.value == 'sm' ?
			10 :
			currentBreakpoint.value == 'md' ?
				13 :
				currentBreakpoint.value == 'lg' ?
					17 :
					currentBreakpoint.value == 'xl' ?
						24 :
						29,
);

const chartLabelPadding = computed(() =>
	currentBreakpoint.value == 'xs' ?
		14 :
		currentBreakpoint.value == 'sm' ?
			25 :
			currentBreakpoint.value == 'md' ?
				30 :
				currentBreakpoint.value == 'lg' ?
					39 :
					currentBreakpoint.value == 'xl' ?
						40 :
						55,
);

const styles = computed(() => {
	return {
		marginTop: `${chartMarginTop.value}px`,
		marginBottom: '20px',
	};
});

const chartData = computed(() => {
	return {
		labels: sortedCategories.value.map((el) => el.name.match(/\b[\w']+(?:[^\w\n]+[\w']+){0,1}\b/g)),
		datasets: [
			{
				label: 'Company Skills by Category',
				backgroundColor: sortedCategories.value.map((el) => hexToRgbA('#'+el.color, 0.65)),
				hoverBackgroundColor: sortedCategories.value.map((el) => hexToRgbA('#'+el.color, 1)),
				data: sortedCategories.value.map((el) => el.companyTotal),
				datalabels: {
					anchor: 'end',
					align: 'end',
				},
			},
		],
	};
});

const chartOptions = computed(() => {
	return {
		responsive: true,
		maintainAspectRatio: true,
		aspectRatio: 19.5/9,
		onHover: (context) => {
			context.chart.update();
		},
		scales: {
			r: {
				ticks: {
					display: false,
					backdropColor: 'rgba(0,0,0,0)',
					color: [chartFontColor.value],
				},
				pointLabels: {
					padding: chartLabelPadding.value,
					display: true,
					centerPointLabels: true,
					color: chartFontColor.value,
					font: {
						size: chartFontSize.value,
						family: 'Arial',
					},
				},
			},
		},
		plugins: {
			legend: {
				display: false,
			},
			tooltip: {
				enabled: true,
			},
			chartJsClickableLabels: {
				routeName: 'category.show',
				tickColor: chartFontColor.value,
				hoverColor: chartHoverColor.value,
			},
			datalabels: {
				display: false,
				backgroundColor: function(context) {
					return context.dataset.backgroundColor;
				},
				borderRadius: 10,
				// color: chartFontColor.value,
				borderColor: '#FFF',
				color: '#FFF',
				borderWidth: 1,
				offset: 25,
				font: {
					family: 'Arial',
					size: chartFontSize.value - 4,
				},
			},
		},
	};
});

</script>

<template>
	<TransitionSlideFade>
		<PolarAreaChart
			v-if="isComponentMounted && isDataLoaded"
			:chart-data="chartData"
			:chart-options="chartOptions"
			:styles="styles"
		/>
		<div
			v-else
			class="flex h-[375px] items-center justify-center"
		>
			<ChartLoading />
		</div>
	</TransitionSlideFade>
</template>

<style scoped>
.slide-enter-active {
    transition: all 0.15s ease-out;
}
.slide-leave-active {
    transition: all 0.15s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-enter-from,
.slide-leave-to {
    transform: translateY(-2%);
    opacity: 0;
}
</style>
