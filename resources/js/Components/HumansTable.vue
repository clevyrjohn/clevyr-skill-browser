<script setup>
import { ref, computed, inject, onMounted } from 'vue';
import {
	sortByIdAsc,
	sortByIdDesc,
	sortByNameDesc,
	sortByNameAsc,
	sortByTotalScoreDesc,
	sortByTotalScoreAsc,
} from '@/Composables/sortItems';
import StackedBarChart from './Charts/StackedBarChart.vue';
import TransitionSlideFade from '@/Assets/TransitionSlideFade.vue';
import ChartLoading from '@/Components/ChartLoading.vue';

const {
	humans,
	isDataLoaded,
	sortKey,
	sortOrder,
} = inject('tableData');

const isComponentMounted = ref(false);

onMounted(() => isComponentMounted.value = true);

const sortedHumans = computed(() => {
	return { ...humans.value }.humans.sort(sortingAlgorithm.value);
});

const chartData = computed(() => {
	return {
		labels: sortedHumans.value.map((i) => i.name),
		datasets: humans.value.categories.map((j) => {
			return {
				label: j.label,
				backgroundColor: j.backgroundColor,
				data: humans.value.humans.map((k) => {
					return k[j.label];
				}),
			};
		}),
	};
});

const sortingAlgorithm = computed(() =>
	sortKey.value == 'id' ?
		sortOrder.value == 'desc' ?
			sortByIdDesc :
			sortByIdAsc :
		sortKey.value == 'total' ?
			sortOrder.value == 'desc' ?
				sortByTotalScoreDesc :
				sortByTotalScoreAsc :
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
