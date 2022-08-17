<script setup>
import { ref, inject, computed, onMounted } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import { ChevronRightIcon, ChevronUpIcon, ChevronDownIcon } from '@heroicons/vue/solid';
import {
	sortByNameDesc,
	sortByNameAsc,
	sortByCompanyTotalDesc,
	sortByCompanyTotalAsc,
} from '@/Composables/sortItems';
import stackedBarChart from './Charts/stackedBarChart.js';

const { skills } = inject('tableData');
const loaded = ref(false);

onMounted(() => loaded.value = true);

const sortingAlgorithm = ref(sortByNameAsc);

function sortByName() {
	sortingAlgorithm.value = sortingAlgorithm.value === sortByNameAsc ? sortByNameDesc : sortByNameAsc;
}

function sortByCompanyTotal() {
	sortingAlgorithm.value = sortingAlgorithm.value === sortByCompanyTotalDesc ? sortByCompanyTotalAsc : sortByCompanyTotalDesc;
}

const chartData = computed(() => {
	return {
		labels: skills.value.map((el) => el.name),
		datasets: [
			{
				label: 'Skills',
				backgroundColor: '#FF9100',
				data: skills.value.map((el) => el.companyTotal),
			},
		],
	};
});

</script>

<template>
	<stackedBarChart
		v-if="loaded"
		:chart-data="chartData"
		:height="200"
	/>
	<div
		v-else
		class="h-[200px]"
	/>
	<table class="relative z-40 w-full border-separate border-spacing-1">
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
				@click="sortByCompanyTotal"
			>
				<ChevronDownIcon
					v-show="sortingAlgorithm === sortByCompanyTotalDesc"
					class="inline h-7 w-7"
				/>
				<ChevronUpIcon
					v-show="sortingAlgorithm === sortByCompanyTotalAsc"
					class="inline h-7 w-7"
				/>
				Total Score
			</th>
		</thead>
		<template
			v-for="skill in skills.sort(sortingAlgorithm)"
			:key="skill.id"
			class="static"
		>
			<tr class="static z-40 text-lg">
				<td>
					<Link
						class="hover:underline"
						:href="`/s/${skill.id}`"
					>
						{{ skill.name }}
					</Link>
				</td>
				<td class="text-right">
					{{ skill.companyTotal }}
				</td>
			</tr>
		</template>
	</table>
</template>
