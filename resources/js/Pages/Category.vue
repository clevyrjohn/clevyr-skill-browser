<script setup>
import { ref, computed, onMounted } from 'vue';
import TheLayout from '@/Layouts/TheLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { sortByLevelDesc } from '@/Composables/sortItems';
import stackedBarChart from '@/Components/Charts/StackedBarChart.vue';
import { hexToRgbA } from '@/Composables/hexToRgbA.js';

const props = defineProps({
	category: Object,
});

const loaded = ref(false);
onMounted(() => {
	loaded.value = true;
});

const chartData = computed(() => {
	return {
		labels: props.category.skills.map((el) => el.name),
		datasets: [
			{
				label: 'Skill',
				backgroundColor: hexToRgbA('#'+props.category.color, 0.5),
				data: props.category.skills.map((el) => el.level),
			},
		],
	};
}, { immediate: false });

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
		<stackedBarChart
			v-if="loaded"
			:chart-data="chartData"
			:height="200"
		/>
		<div
			v-else
			class="h-[200px]"
		/>
		<div class="flex flex-row flex-wrap justify-around pt-8 pb-0">
			<div
				v-for="categorySkill in category.skills.sort(sortByLevelDesc)"
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
