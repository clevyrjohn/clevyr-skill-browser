<script setup>
import { ref, computed, inject, onMounted } from 'vue';
import { ChevronUpIcon, ChevronDownIcon } from '@heroicons/vue/solid';
import { Link } from '@inertiajs/inertia-vue3';
import {
	sortByNameDesc,
	sortByNameAsc,
	sortByTotalScoreDesc,
	sortByTotalScoreAsc,
} from '@/Composables/sortItems';
import stackedBarChart from './Charts/stackedBarChart.js';

const { humans } = inject('tableData');
const loaded = ref(false);

onMounted(() => loaded.value = true);

const chartData = computed(() => {
	return {
		labels: humans.value.humans.map((i) => i.name),
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

const sortingAlgorithm = ref(sortByNameAsc);

function sortByName() {
	sortingAlgorithm.value = sortingAlgorithm.value === sortByNameAsc ? sortByNameDesc : sortByNameAsc;
}

function sortByTotalScore() {
	sortingAlgorithm.value = sortingAlgorithm.value === sortByTotalScoreDesc ? sortByTotalScoreAsc : sortByTotalScoreDesc;
}

</script>

<template>
	<stackedBarChart
		v-if="loaded"
		:chart-data="chartData"
	/>
	<div
		v-else
		class="h-[250px]"
	/>
	<table class="relative z-40 mt-12 w-full border-separate border-spacing-1">
		<thead class="font-serif text-lg">
			<th
				class="text-left"
				@click="sortByName"
			>
				Name
				<ChevronDownIcon
					v-show="sortingAlgorithm === sortByNameAsc"
					class="inline h-7 w-7"
				/>
				<ChevronUpIcon
					v-show="sortingAlgorithm === sortByNameDesc"
					class="inline h-7 w-7"
				/>
			</th>
			<th
				class="text-right"
				@click="sortByTotalScore"
			>
				<ChevronDownIcon
					v-show="sortingAlgorithm === sortByTotalScoreDesc"
					class="inline h-7 w-7"
				/>
				<ChevronUpIcon
					v-show="sortingAlgorithm === sortByTotalScoreAsc"
					class="inline h-7 w-7"
				/>
				Total Score
			</th>
		</thead>
		<template
			v-for="human in humans.humans.sort(sortingAlgorithm)"
			:key="human.id"
		>
			<tr class="static z-40 text-lg">
				<td>
					<Link
						class="hover:underline"
						:href="`/h/${human.id}`"
					>
						{{ human.name }}
					</Link>
				</td>
				<td class="text-right">
					{{ human.totalScore }}
				</td>
			</tr>
		</template>
	</table>
</template>
