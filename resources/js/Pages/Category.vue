<script setup>
import { ref, computed, onMounted } from 'vue';
import TheLayout from '@/Layouts/TheLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { sortByLevelDesc } from '@/Composables/sortItems';
import stackedBarChart from '@/Components/Charts/stackedBarChart';
import { hexToRgbA } from '@/Composables/hexToRgbA.js';

const props = defineProps({
    category: Object,
})

const loaded = ref(false);
onMounted(() => {
    loaded.value = true;
})

const chartData = computed(() => {
    return {
        labels: props.category.skills.map(el => el.name),
        datasets: [
            {
                label: 'Skill',
                backgroundColor: hexToRgbA('#'+props.category.color,0.5),
                data: props.category.skills.map(el => el.level)
            }
        ]
    }
}, { immediate: false })

</script>

<template>
<TheLayout>
    <div class="text-center dark:text-white mb-4">
        <div class="text-5xl font-bold dark:font-normal font-serif pt-4 pb-6">{{ category.name }}</div>
        <div class="text-lg">Numbers Represent Company Totals</div>
    </div>
    <stackedBarChart v-if="loaded" :chartData="chartData" :height=200 />
    <div v-else class="h-[200px]"></div>
    <div class="flex flex-row flex-wrap justify-around pt-8 pb-0">
        <div v-for="categorySkill in category.skills.sort(sortByLevelDesc)" :key="categorySkill.id" class="hover:scale-105 ease-in-out duration-75 active:scale-100">
            <Link :href="route('skill.show', categorySkill.id)">
            <div class="bg-gray-100 dark:bg-gray-700 rounded-md m-1 h-[90%] w-[9rem] p-2">
                <div class="max-w-fit mx-auto bg-white dark:bg-gray-500 dark:text-gray-100 rounded-full p-2 px-4 font-bold text-xl border-gray-200 dark:border-gray-700 border-[1px]">
                    {{ categorySkill.level }}
                </div>
                <div class="max-w-[7rem] mt-2 m-3 font-bold dark:text-gray-100 overflow-auto break-words">{{ categorySkill.name }}</div>
            </div>
            </Link>
        </div>
    </div>    
</TheLayout>
</template>
