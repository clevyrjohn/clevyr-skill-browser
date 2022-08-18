<script setup>
import { ref, onMounted, provide } from 'vue';
import TheLayout from '@/Layouts/TheLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import CategoriesTable from '@/Components/CategoriesTable.vue';
import HumansTable from '../Components/HumansTable.vue';
import SkillsTable from '../Components/SkillsTable.vue';

defineProps({
	canLogin: Boolean,
	canRegister: Boolean,
});

const activeTab = ref('category');

const changeTab = (value) => activeTab.value = value;

const categories = ref([
	{
		color: '000000',
		companyTotal: null,
		name: null,
		description: null,
		id: null,
	},
]);
const humans = ref({
	humans: [],
	categories: [],
});
const emptySkill = {
	category_id: null,
	companyTotal: null,
	description: null,
	id: null,
	name: null,
};
const skills = ref({
	skills: [emptySkill],
	skills2: [emptySkill],
	// categories: [],
});

onMounted(async () => {
	let res;
	let resJson;
	try {
		res = await fetch(route('api.categories'));
		resJson = await res.json();
		categories.value = resJson.data;
	} catch (error) {
		console.log('Could not load catgories');
	};
	try {
		res = await fetch(route('api.humanstable'));
		resJson = await res.json();
		humans.value = resJson.data;
	} catch (error) {
		console.log('Could not load humans');
	}
	try {
		res = await fetch(route('api.skills'));
		resJson = await res.json();
		skills.value = resJson.data;
	} catch (error) {
		console.log('Could not load skills');
	}
});

provide('tableData', {
	categories,
	humans,
	skills,
});

</script>

<template>
	<Head title="Welcome" />
	<TheLayout>
		<div class="relative z-50 pt-4 pb-6 text-center font-serif text-5xl font-bold dark:font-normal dark:text-white">
			Browse by...
		</div>

		<div class="relative z-50 flex flex-row justify-around divide-x divide-blue-light rounded-t-md border-x-[1px] bg-gray-500 font-bold text-white">
			<div
				class="basis-1/3 cursor-pointer rounded-tl-md p-5 text-center duration-75 ease-in-out hover:scale-105 hover:bg-blue-light active:scale-100"
				:class="activeTab === 'category' ? 'bg-blue-light' : ''"
				@click="changeTab('category')"
			>
				Category
			</div>
			<div
				class="basis-1/3 cursor-pointer p-5 text-center duration-75 ease-in-out hover:scale-105 hover:bg-blue-light active:scale-100"
				:class="activeTab === 'human' ? 'bg-blue-light' : ''"
				@click="changeTab('human')"
			>
				Human
			</div>
			<div
				class="basis-1/3 cursor-pointer rounded-tr-md p-5 text-center duration-75 ease-in-out hover:scale-105 hover:bg-blue-light active:scale-100"
				:class="activeTab === 'skill' ? 'bg-blue-light' : ''"
				@click="activeTab = 'skill'"
			>
				Skill
			</div>
		</div>

		<div
			class="relative z-50 min-h-fit bg-white dark:bg-gray-700"
		>
			<div class="mx-auto py-10 px-[10%] dark:text-white">
				<div v-if="activeTab === 'category'">
					<CategoriesTable />
				</div>
				<div v-if="activeTab === 'human'">
					<HumansTable />
				</div>
				<div v-if="activeTab === 'skill'">
					<SkillsTable />
				</div>
			</div>
		</div>
	</TheLayout>
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
