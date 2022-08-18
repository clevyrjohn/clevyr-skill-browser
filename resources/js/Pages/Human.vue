<script setup>
import { ref, onMounted, computed } from 'vue';
import TheLayout from '@/Layouts/TheLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import {
	sortByLevelDesc,
	sortByLevelAsc,
	sortBySkillNameDesc,
	sortBySkillNameAsc,
} from '@/Composables/sortItems';
import { hexToRgbA } from '@/Composables/hexToRgbA';
import PolarAreaChart from '../Components/Charts/PolarAreaChart.vue';

const props = defineProps({
	human: Object,
});

const loaded = ref(false);
onMounted(() => {
	loaded.value = true;
});

const polarChartData = computed(() => {
	return {
		labels: props.human.categoryScores.map((el) => el.name),
		datasets: [
			{
				label: 'Skills by Category',
				backgroundColor: props.human.categoryScores.map((el) => hexToRgbA('#'+el.color, 0.5)),
				data: props.human.categoryScores.map((el) => el.total),
			},
		],
	};
});

const sortKey = ref('level');
const sortOrder = ref('desc');

const sortingAlgorithm = computed(() =>
	sortKey.value == 'level' ?
		sortOrder.value == 'desc' ?
			sortByLevelDesc :
			sortByLevelAsc :
		sortOrder.value == 'desc' ?
			sortBySkillNameDesc :
			sortBySkillNameAsc,
);

</script>

<template>
	<TheLayout>
		<div class="pt-4 pb-6 text-center font-serif text-5xl font-bold dark:font-normal dark:text-white">
			{{ human.name }}
		</div>
		<PolarAreaChart
			v-if="loaded"
			:chart-data="polarChartData"
			class="py-10"
		/>
		<div>
			<div class="flex items-center space-x-2 px-5 py-4 dark:text-white">
				<div>Sort by Skill</div>
				<select
					v-model="sortKey"
					name="sortKey"
					class="border-gray-500 hover:scale-[1.03] dark:bg-gray-800"
				>
					<option value="level">
						Level
					</option>
					<option value="name">
						Name
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
					checked
				><label
					for="desc"
				>Desc</label>
			</div>
			<div class="flex flex-row flex-wrap justify-around pb-8">
				<div
					v-for="humanSkill in human.skills.filter(hs => hs.level > 0).sort(sortingAlgorithm)"
					:key="humanSkill.id"
					class="duration-75 ease-in-out hover:scale-105 active:scale-100"
				>
					<Link :href="route('skill.show', humanSkill.skill.id)">
						<div class="m-1 h-[90%] w-[9rem] rounded-md bg-gray-100 p-2 dark:bg-gray-700">
							<div
								class="mx-auto max-w-fit rounded-full border-[1px] border-gray-200 bg-white p-2 px-4 text-xl font-bold dark:border-gray-700 dark:bg-gray-500 dark:text-gray-100"
							>
								{{ humanSkill.level }}
							</div>
							<div class="m-3 mt-2 max-w-[7rem] overflow-auto break-words font-bold dark:text-gray-100">
								{{ humanSkill.skill.name }}
							</div>
						</div>
					</Link>
				</div>
			</div>
		</div>
	</TheLayout>
</template>
