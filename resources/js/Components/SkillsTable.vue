<script setup>
import { ref, inject, computed, onMounted } from 'vue';
import {
	sortByIdAsc,
	sortByIdDesc,
	sortByNameDesc,
	sortByNameAsc,
	sortByCompanyTotalDesc,
	sortByCompanyTotalAsc,
} from '@/Composables/sortItems';
import StackedBarChart from './Charts/StackedBarChart.vue';
import { hexToRgbA } from '@/Composables/hexToRgbA';
import TransitionSlideFade from '@/Assets/TransitionSlideFade.vue';
import ChartLoading from '@/Components/ChartLoading.vue';

const {
	skills,
	isDataLoaded,
	sortKey,
	sortOrder,
} = inject('tableData');

const isComponentMounted = ref(false);

onMounted(() => isComponentMounted.value = true);

const sortedSkills = computed(() => [...skills.value].sort(sortingAlgorithm.value));

const chartData = computed(() => {
	return {
		labels: sortedSkills.value.map((el) => el.name),
		datasets: [
			{
				backgroundColor: sortedSkills.value.map((el) => hexToRgbA('#'+el.category.color, .85)),
				borderColor: sortedSkills.value.map((el) => hexToRgbA('#'+el.category.color, 1.0)),
				data: sortedSkills.value.map((el) => el.companyTotal),
			},
		],
	};
});

const chartOptions = {
	responsive: true,
	maintainAspectRatio: false,
	animation: true,
	plugins: {
		legend: {
			display: false,
		},
		title: {
			display: false,
		},
	},
	scales: {
		x: {
			stacked: false,
		},
		y: {
			stacked: false,
		},
	},
};

// const cChartOptions = {
// 		zoom: {
// 			limits: {
// 				y: { min: 0, max: 6 },
// 			},
// 			pan: {
// 				enabled: true,
// 				threshhold: 6,
// 				mode: 'xy',
// 			},
// 			zoom: {
// 				wheel: {
// 					enabled: false,
// 					speed: '0.01',
// 				},
// 				pinch: {
// 					enabled: false,
// 				},
// 				drag: {
// 					enabled: false,
// 				},
// 				mode: 'x',
// 			},
// 		},
// 	},
// 	transitions: {
// 		zoom: {
// 			animation: {
// 				duration: 1000,
// 				easing: 'easeOutCubic',
// 			},
// 		},
// 	},
// };

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

const chartHeight = 500;

</script>

<template>
	<TransitionSlideFade>
		<StackedBarChart
			v-if="isComponentMounted && isDataLoaded"
			:chart-data="chartData"
			:chart-options="chartOptions"
			:height="chartHeight"
		/>
		<div
			v-else
			class="flex h-[500px] items-center justify-center"
		>
			<ChartLoading />
		</div>
	</TransitionSlideFade>
</template>
