<script setup>
/* global route */
import { ref, computed, onMounted } from 'vue';
import TheLayout from '@/Layouts/TheLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import {
	sortByHumanNameAsc,
	sortByHumanNameDesc,
	sortByLevelAsc,
	sortByLevelDesc,
} from '@/Composables/sortItems';
import stackedBarChart from '@/Components/Charts/StackedBarChart.vue';
import { hexToRgbA } from '@/Composables/hexToRgbA';
import ChartDataLabels from 'chartjs-plugin-datalabels';

const sortKey = ref('level');
const sortOrder = ref('desc');

const sortingAlgorithm = computed(() =>
	sortKey.value == 'level' ?
		sortOrder.value == 'desc' ?
			sortByLevelDesc :
			sortByLevelAsc :
		sortOrder.value == 'desc' ?
			sortByHumanNameDesc :
			sortByHumanNameAsc,
);

const props = defineProps({
	skill: Object,
});

const loaded = ref(false);
onMounted(async () => loaded.value = true);

const skill = computed(() => props.skill);
// eslint-disable-next-line vue/no-side-effects-in-computed-properties
const humans = computed(() => skill.value.humans.sort(sortingAlgorithm.value));
const labels = computed(() => humans.value.map((h) => h.human.name));

const data = computed(() => {
	return {
		labels: labels.value,
		datasets: [
			{
				label: skill.value.name,
				data: humans.value.map((i) => i.level),
				borderColor: hexToRgbA(`#${skill.value.category.color}`, 1),
				backgroundColor: hexToRgbA(`#${skill.value.category.color}`, 0.75),
				hoverBorderWidth: 2,
			},
		],
	};
});

const plugins = [ChartDataLabels];

const options = {
	onClick: (e, activeels, chart) => {
		try {
			const clicked = chart.getElementsAtEventForMode(e, 'nearest', { intersect: true }, true)[0];
			const human = humans.value[clicked.index].human;
			Inertia.get(route('human.show', human));
		} catch {}
	},
	indexAxis: 'y',
	// Elements options apply to all of the options unless overridden in a dataset
	// In this case, we are setting the border of each horizontal bar to be 2px wide
	elements: {
		bar: {
			borderWidth: 1,
		},
	},
	scales: {
		y: {
			ticks: {
				display: false,
			},
		},
	},
	responsive: true,
	plugins: {
		datalabels: {
			color: '#FFFFFF',
			font: {
				family: 'Source Sans Pro',
				weight: 'bold',
			},
			formatter: function(value, context) {
				return `  ${context.chart.data.labels[context.dataIndex]}: ${value}`;
			},
			align: 'right',
			anchor: 'start',
		},
		legend: {
			display: false,
		},
		title: {
			display: false,
		},
	},
};

</script>

<template>
	<TheLayout>
		<div class="pt-4 pb-6 text-center font-serif font-bold dark:font-normal dark:text-white">
			<div
				class=" text-5xl"
			>
				{{ skill.name }}
			</div>
			<div class="pt-4">
				<Link :href="route('category.show', skill.category)">
					{{ skill.category.name }}
				</Link>
			</div>
		</div>
		<div class="flex items-center space-x-2 px-5 py-4 dark:text-white">
			<div>Sort by</div>
			<select
				v-model="sortKey"
				name="sortKey"
				class="border-gray-500 hover:scale-[1.03] dark:bg-gray-800"
			>
				<option value="level">
					Skill Level
				</option>
				<option value="name">
					Human Name
				</option>
			</select>
			<input
				v-model="sortOrder"
				type="radio"
				name="sortOrder"
				value="asc"
			>
			<label for="asc">
				Asc
			</label>
			<input
				v-model="sortOrder"
				type="radio"
				name="sortOrder"
				value="desc"
			>
			<label
				for="desc"
			>
				Desc
			</label>
		</div>
		<stackedBarChart
			v-if="loaded"
			class="p-8"
			:chart-data="data"
			:chart-options="options"
			:plugins="plugins"
		/>
	</TheLayout>
</template>
