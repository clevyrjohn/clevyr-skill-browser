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

onMounted(() => isComponentMounted.value = true);

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
		labels: sortedCategories.value.map((el) => el.name),
		datasets: [
			{
				label: 'Company Skills by Category',
				backgroundColor: sortedCategories.value.map((el) => hexToRgbA('#'+el.color, 0.5)),
				data: sortedCategories.value.map((el) => el.companyTotal),
			},
		],
	};
});

const chartHeight = 375;

</script>

<template>
	<TransitionSlideFade>
		<PolarAreaChart
			v-if="isComponentMounted && isDataLoaded"
			:chart-data="chartData"
			:height="chartHeight"
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
