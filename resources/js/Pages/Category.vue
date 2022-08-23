<script setup>
import { ref, computed, onMounted } from 'vue';
import TheLayout from '@/Layouts/TheLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import {
	sortByLevelAsc,
	sortByLevelDesc,
	sortByNameAsc,
	sortByNameDesc,
} from '@/Composables/sortItems';
import stackedBarChart from '@/Components/Charts/StackedBarChart.vue';
import RadarChart from '@/Components/Charts/RadarChart.vue';
import { hexToRgbA } from '@/Composables/hexToRgbA.js';

const sortKey = ref('level');
const sortOrder = ref('desc');

const sortingAlgorithm = computed(() =>
	sortKey.value == 'level' ?
		sortOrder.value == 'desc' ?
			sortByLevelDesc :
			sortByLevelAsc :
		sortOrder.value == 'desc' ?
			sortByNameDesc :
			sortByNameAsc,
);

const props = defineProps({
	category: Object,
});

const category = computed(() => props.category);
// eslint-disable-next-line vue/no-side-effects-in-computed-properties
const skills = computed(() => category.value.skills.sort(sortingAlgorithm.value));

const loaded = ref(false);
onMounted(() => loaded.value = true);

const barChartData = computed(() => {
	return {
		labels: skills.value.map((el) => el.name),
		datasets: [
			{
				label: 'Skill',
				backgroundColor: hexToRgbA('#'+category.value.color, 0.5),
				data: skills.value.map((el) => el.level),
			},
		],
	};
}, { immediate: false });

const radarChartData = {
	labels: props.category.skills.map((el) => el.name),
	datasets: [
		{
			backgroundColor: hexToRgbA('#'+props.category.color, 0.7),
			borderColor: hexToRgbA('#'+props.category.color, 0.8),
			pointBackgroundColor: hexToRgbA('#'+props.category.color, .9),
			pointHoverBorderColor: hexToRgbA('#'+props.category.color, 1),
			data: props.category.skills.map((el) => el.level),
		},
	],
};

const radarChartOptions = {
	responsive: true,
	maintainAspectRatio: false,
	plugins: {
		legend: {
			display: false,
		},
		title: {
			display: false,
		},
	},
	scales: {
		r: {
			ticks: {
				display: false,
				backdropColor: 'rgba(0,0,0,0)',
				color: '#737373',
			},
			pointLabels: {
				display: true,
				centerPointLabels: true,
				color: '#737373',
				font: {
					size: 16,
					family: 'Nunito',
				},
			},
		},
	},
};

</script>

<template>
	<TheLayout>
		<div class="mb-4 text-center dark:text-white">
			<div class="pt-4 pb-6 font-serif text-5xl font-bold dark:font-normal">
				{{ category.name }}
			</div>
			<div class="text-lg">
				Numbers Represent Company Totals
			</div>
		</div>
		<div class="flex flex-col py-4">
			<RadarChart
				v-if="loaded"
				:chart-data="radarChartData"
				:chart-options="radarChartOptions"
			/>
			<stackedBarChart
				v-if="loaded"
				:chart-data="barChartData"
			/>
			<div
				v-else
				class="h-[200px]"
			/>
		</div>
		<div class="flex items-center space-x-2 px-5 py-4 dark:text-white">
			<div>Sort by skill </div>
			<select
				v-model="sortKey"
				name="sortKey"
				class="border-gray-500 hover:scale-[1.03] dark:bg-gray-800"
			>
				<option value="level">
					level
				</option>
				<option value="name">
					name
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
		<div class="flex flex-row flex-wrap justify-around pt-8 pb-0">
			<div
				v-for="categorySkill in skills"
				:key="categorySkill.id"
				class="duration-75 ease-in-out hover:scale-105 active:scale-100"
			>
				<Link :href="route('skill.show', categorySkill.id)">
					<div class="m-1 h-[90%] w-[9rem] rounded-md bg-gray-100 p-2 dark:bg-gray-700">
						<div class="mx-auto max-w-fit rounded-full border-[1px] border-gray-200 bg-white p-2 px-4 text-xl font-bold dark:border-gray-700 dark:bg-gray-500 dark:text-gray-100">
							{{ categorySkill.level }}
						</div>
						<div class="m-3 mt-2 max-w-[7rem] overflow-auto break-words font-bold dark:text-gray-100">
							{{ categorySkill.name }}
						</div>
					</div>
				</Link>
			</div>
		</div>
	</TheLayout>
</template>
