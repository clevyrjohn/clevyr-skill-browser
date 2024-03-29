<script setup>
import { ref, onMounted, provide, computed } from 'vue';
import TheLayout from '@/Layouts/TheLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import CategoriesTable from '@/Components/CategoriesTable.vue';
import HumansTable from '../Components/HumansTable.vue';
import SkillsTable from '../Components/SkillsTable.vue';
import TransitionSlideFade from '@/Assets/TransitionSlideFade.vue';
import { ChevronDownIcon } from '@heroicons/vue/solid';

defineProps({
	canLogin: Boolean,
	canRegister: Boolean,
});

const categories = ref([{
	color: '000000',
	companyTotal: null,
	name: null,
	description: null,
	id: null,
}]);

const humans = ref({
	humans: [],
	categories: [],
});

const skills = ref([{
	category_id: null,
	category: {
		color: '000000',
	},
	companyTotal: null,
	description: null,
	id: null,
	name: null,
}]);

onMounted(async () => {
	let res;
	let resJson;
	try {
		res = await fetch(route('api.categories'));
		resJson = await res.json();
		categories.value = resJson.data;
	} catch (error) {
		console.error(error);
	};
	try {
		res = await fetch(route('api.humanstable'));
		resJson = await res.json();
		humans.value = resJson.data;
	} catch (error) {
		console.error(error);
	};
	try {
		res = await fetch(route('api.skills'));
		resJson = await res.json();
		skills.value = resJson.data;
	} catch (error) {
		console.error(error);
	};
});

const isDataLoaded = computed(() =>
	categories.value.length > 1 &&
		humans.value.humans.length > 0 &&
		skills.value.length > 1,
);

const sortKey = ref('id');
const sortOrder = ref('asc');

provide('tableData', {
	categories,
	humans,
	skills,
	isDataLoaded,
	sortKey,
	sortOrder,
});

</script>

<template>
	<Head title="Welcome" />
	<TheLayout>
		<div class="relative z-50 min-h-fit bg-white dark:bg-gray-700">
			<div class="mx-auto dark:text-white sm:px-[2.5%]">
				<div class="sticky top-0  flex flex-col space-y-2 p-2 text-xs dark:bg-gray-700 sm:w-fit sm:text-sm md:p-4 md:text-base">
					<div class="flex flex-nowrap items-center justify-between sm:justify-start sm:space-x-3 md:justify-around md:space-x-4">
						<div>
							Sort by
						</div>
						<select
							v-model="sortKey"
							class="rounded-md bg-white text-xs dark:bg-gray-700 sm:text-sm md:text-base"
						>
							<option value="id">
								Spreadsheet Order
							</option>
							<option value="name">
								Name
							</option>
							<option value="total">
								Total
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
					<div class="flex flex-row justify-between space-x-3">
						<div>Filter</div>
						<div>
							Categories
						</div>
						<div>Skills</div>
						<div>Humans</div>
					</div>
				</div>

				<TransitionSlideFade>
					<div class="flex flex-col space-y-0 px-[7.5%]">
						<div class="rounded-md pt-4 text-center font-serif text-2xl sm:text-3xl lg:text-4xl xl:text-5xl 2xl:text-6xl">
							Categories
						</div>
						<CategoriesTable />
						<div class="rounded-md pt-10 pb-4 text-center font-serif text-2xl sm:text-3xl lg:text-4xl xl:text-5xl 2xl:text-6xl">
							Skills
						</div>
						<SkillsTable />
						<div class="rounded-md pt-10 pb-4 text-center font-serif text-2xl sm:text-3xl lg:text-4xl xl:text-5xl 2xl:text-6xl">
							People
						</div>
						<HumansTable />
					</div>
				</TransitionSlideFade>
			</div>
		</div>
	</TheLayout>
</template>

