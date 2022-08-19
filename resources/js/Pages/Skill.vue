<script setup>
import { ref, computed, onMounted } from 'vue';
import TheLayout from '@/Layouts/TheLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import {
	sortByHumanNameAsc,
	sortByHumanNameDesc,
	sortByLevelAsc,
	sortByLevelDesc,
} from '@/Composables/sortItems';
import stackedBarChart from '@/Components/Charts/stackedBarChart.js';
import { hexToRgbA } from '@/Composables/hexToRgbA';

const props = defineProps({
	skill: Object,
});

const loaded = ref(false);

onMounted(() => loaded.value = true);

const data = computed(() => {
	return {
		labels: props.skill.humans.map((h) => h.human.name),
		datasets: [
			{
				label: props.skill.name,
				data: props.skill.humans.map((i) => i.level),
				borderColor: hexToRgbA(`#${props.skill.category.color}`, .75),
				backgroundColor: hexToRgbA(`#${props.skill.category.color}`, 0.3),
			},
		],
	};
});

const options = {
	indexAxis: 'y',
	// Elements options apply to all of the options unless overridden in a dataset
	// In this case, we are setting the border of each horizontal bar to be 2px wide
	elements: {
		bar: {
			borderWidth: 1,
		},
	},
	responsive: true,
	plugins: {
		legend: {
			position: 'none',
		},
		title: {
			display: false,
		},
	},
};

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
			><label for="asc">Asc</label>
			<input
				v-model="sortOrder"
				type="radio"
				name="sortOrder"
				value="desc"
			><label
				for="desc"
			>Desc</label>
		</div>
		<stackedBarChart
			v-if="loaded"
			:chart-data="data"
			:chart-options="options"
		/>
		<div class="flex flex-row flex-wrap justify-around py-8">
			<div
				v-for="human in skill.humans.sort(sortingAlgorithm)"
				:key="human.id"
				class="duration-75 ease-in-out hover:scale-105 active:scale-100"
			>
				<Link :href="route('human.show', human.human.id)">
					<div class="m-1 h-[90%] w-[9rem] rounded-md bg-gray-100 p-2 dark:bg-gray-700">
						<div class="mx-auto max-w-fit rounded-full border-[1px] border-gray-200 bg-white p-2 px-4 text-xl font-bold dark:border-gray-700 dark:bg-gray-500 dark:text-gray-100">
							{{ human.level }}
						</div>
						<div class="m-3 mt-2 max-w-[7rem] overflow-auto break-words font-bold dark:text-gray-100">
							{{ human.human.name }}
						</div>
					</div>
				</Link>
			</div>
		</div>
	</TheLayout>
</template>
