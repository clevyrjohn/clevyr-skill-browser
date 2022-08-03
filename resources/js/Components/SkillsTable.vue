<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import { ChevronRightIcon, ChevronUpIcon, ChevronDownIcon } from '@heroicons/vue/solid';
import { 
    sortByNameDesc,
    sortByNameAsc,
    sortByCompanyTotalDesc,
    sortByCompanyTotalAsc 
} from '@/Composables/sortItems';
import stackedBarChart from './Charts/stackedBarChart.js';

const skills = ref([]);
const loaded = computed(() => skills.value.length != undefined);

onMounted(async () => {
    try {
        const res = await fetch(route('api.skills'));
        const resJson = await res.json();
        skills.value = resJson.data;
    } catch (error) {
        skills.value = [];
    }    
})

const sortingAlgorithm = ref(sortByNameAsc);

function sortByName() {
    sortingAlgorithm.value = sortingAlgorithm.value === sortByNameAsc ? sortByNameDesc : sortByNameAsc;
}

function sortByCompanyTotal() {
    sortingAlgorithm.value = sortingAlgorithm.value === sortByCompanyTotalDesc ? sortByCompanyTotalAsc : sortByCompanyTotalDesc;
}

const chartData = computed(() => {
    return {
        labels: skills.value.map(el => el.name),
        datasets: [
            {
                label: 'Skills',
                backgroundColor: '#FF9100',
                data: skills.value.map(el => el.companyTotal)
            }
        ]
    }
})

</script>

<template>
<stackedBarChart
    v-if="loaded"
    :chartData="chartData" 
    :height=200
/>
<table class="relative z-40 border-separate border-spacing-1 w-full">
    <thead class="text-lg font-serif">
        <th class="text-left" @click="sortByName">
            Name
            <ChevronDownIcon
                v-show="sortingAlgorithm === sortByNameAsc"
                class="h-7 w-7 inline" />
            <ChevronUpIcon
                v-show="sortingAlgorithm === sortByNameDesc"
                class="h-7 w-7 inline" />
        </th>
        <th class="text-right" @click="sortByCompanyTotal">
            <ChevronDownIcon
                v-show="sortingAlgorithm === sortByCompanyTotalDesc"
                class="h-7 w-7 inline" />
            <ChevronUpIcon
                v-show="sortingAlgorithm === sortByCompanyTotalAsc"
                class="h-7 w-7 inline" />
            Total Score
        </th>
    </thead>
    <template v-for="skill in skills.sort(sortingAlgorithm)" :key="skill.id" class="static">
        <tr class="static z-40 text-lg">

            <td><Link class="hover:underline" :href="`/s/${skill.id}`">{{ skill.name }}</Link></td>
            <td class="text-right">{{ skill.companyTotal }}</td>            
        </tr>
    </template>
</table>
</template>
