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

const chartData = computed(() => {
	return {
		labels: sortedCategories.value.map((el) => el.name.match(/\b[\w']+(?:[^\w\n]+[\w']+){0,1}\b/g)),
		datasets: [
			{
				label: 'Company Skills by Category',
				backgroundColor: sortedCategories.value.map((el) => hexToRgbA('#'+el.color, 0.5)),
				data: sortedCategories.value.map((el) => el.companyTotal),
			},
		],
	};
});

// const chartHeight = 'auto';

const { currentBreakpoint, preferredColor } = inject('windowInfo');

const chartFontSize = computed(() =>
	currentBreakpoint.value == 'xs' ?
		9 :
		currentBreakpoint.value == 'sm' ?
			12 :
			currentBreakpoint.value == 'md' ?
				15 :
				currentBreakpoint.value == 'lg' ?
					22 :
					currentBreakpoint.value == 'xl' ?
						28 :
						34,
);

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
		'-50px' :
		currentBreakpoint.value == 'sm' ?
			'-55px' :
			currentBreakpoint.value == 'md' ?
				'-65px' :
				currentBreakpoint.value == 'lg' ?
					'-90px' :
					currentBreakpoint.value == 'xl' ?
						'-125px' :
						'-155px',
);

const styles = computed(() => {
	return {
		marginTop: chartMarginTop.value,
	};
});

const chartOptions = computed(() => {
	return {
		responsive: true,
		maintainAspectRatio: true,
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
					display: true,
					centerPointLabels: true,
					color: chartFontColor.value,
					font: {
						size: chartFontSize.value,
						family: 'Nunito',
					},
				},
			},
		},
		plugins: {
			legend: {
				display: false,
			},
			chartJsClickableLabels: {
				routeName: 'category.show',
				tickColor: chartFontColor.value,
				hoverColor: chartHoverColor.value,
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
