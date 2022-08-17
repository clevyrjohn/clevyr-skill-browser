<script setup>
import { ref, computed, inject, onMounted } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import { ChevronRightIcon, ChevronUpIcon, ChevronDownIcon } from '@heroicons/vue/solid';
import {
	sortByNameDesc,
	sortByNameAsc,
	sortByCompanyTotalDesc,
	sortByCompanyTotalAsc,
} from '@/Composables/sortItems';
import { hexToRgbA } from '@/Composables/hexToRgbA';
import PolarAreaChart from './Charts/PolarAreaChart.vue';

const { categories } = inject('tableData');
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
		labels: categories.value.map((el) => el.name),
		datasets: [
			{
				label: 'Company Skills by Category',
				backgroundColor: categories.value.map((el) => hexToRgbA('#'+el.color, 0.5)),
				data: categories.value.map((el) => el.companyTotal),
			},
		],
	};
});

</script>

<template>
	<PolarAreaChart
		v-if="loaded"
		:chart-data="chartData"
	/>
	<div
		v-else
		class="h-[250px]"
	/>
	<table class="relative z-40 mt-14 w-full border-separate border-spacing-1">
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
				Company Score
			</th>
		</thead>
		<template
			v-for="category in categories.sort(sortingAlgorithm)"
			:key="category.id"
		>
			<tr class="static z-40 text-lg">
				<td class="">
					<Link
						class="hover:underline"
						:href="`/c/${category.id}`"
					>
						{{ category.name }}
					</Link>
				</td>
				<td class="text-right">
					{{ category.companyTotal }}
				</td>
			</tr>
			<!-- <transition name="slide" class="static z-30">
            <tr v-if="displayRows.categories[category.id] === true">
                <td colspan="4">
                    <table class="w-full mb-2">
                        <tr v-for="skill in category.skills.sort(sortingAlgorithm)" :key="skill.id">
                            <td class="w-11"><ChevronDownIcon class="h-7 mr-[-11px] fill-transparent" /></td>
                            <td class="text-left">{{ skill.name }}</td>
                            <td class="text-right">{{ skill.companyTotal }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </transition> -->
		</template>
	</table>
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
