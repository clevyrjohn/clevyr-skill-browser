<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import { ChevronUpIcon, ChevronDownIcon } from '@heroicons/vue/solid';
import { Link } from '@inertiajs/inertia-vue3';
import { 
    sortByNameDesc,
    sortByNameAsc,
    sortByTotalScoreDesc, 
    sortByTotalScoreAsc 
} from '@/Composables/sortItems';
import { hexToRgbA } from '@/Composables/hexToRgbA'
import stackedBarChart from './Charts/stackedBarChart.js';

const humans = ref([]);
const humans2 = ref([]);
const loaded = computed(() => humans.value.length != undefined);

onMounted(async () => {
    try {
        const res = await fetch(route('api.humans'));
        const resJson = await res.json();
        humans.value = resJson.data;
        const newRes = await fetch(route('api.hc'));
        const newResJson = await newRes.json();
        humans2.value = newResJson.data;
    } catch (error) {
        humans.value = [];
    }    
})

const sortingAlgorithm = ref(sortByNameAsc);

function sortByName() {
    sortingAlgorithm.value = sortingAlgorithm.value === sortByNameAsc ? sortByNameDesc : sortByNameAsc;
}

function sortByTotalScore() {
    sortingAlgorithm.value = sortingAlgorithm.value === sortByTotalScoreDesc ? sortByTotalScoreAsc : sortByTotalScoreDesc;
}



const chartData = computed(() => {
    return {
        labels: humans2.value[0]?.humanTotals.map(el => el.name),
        datasets: humans2.value.map(el => {
            return {
                label: el.name,
                data: el.humanTotals.map(el => el.total_score),
                backgroundColor: hexToRgbA('#'+el.color,0.9),
            }
        })
    }
})

const chartOptions = computed(() => {
    return {
        responsive: true,
        maintainAspectRatio: false,
        animation: true,
        scales: {
            x: {
                stacked: true,
            },                
            y: {
                stacked: true
            }
        },
    }
})

</script>

<template>
<stackedBarChart 
    v-if="loaded"
    :chartData="chartData" 
    :chartOptions="chartOptions"  
/>
<table class="relative z-40 mt-12 border-separate border-spacing-1 w-full">
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
        <th class="text-right" @click="sortByTotalScore">
            <ChevronDownIcon
                v-show="sortingAlgorithm === sortByTotalScoreDesc"
                class="h-7 w-7 inline" />
            <ChevronUpIcon
                v-show="sortingAlgorithm === sortByTotalScoreAsc"
                class="h-7 w-7 inline" />                
            Total Score
        </th>
    </thead>
    <template v-for="human in humans.sort(sortingAlgorithm)" :key="human.id" class="static">
        <tr class="static z-40 text-lg">
            <td><Link class="hover:underline" :href="`/h/${human.id}`">{{ human.name }}</Link></td>
            <td class="text-right">{{ human.totalScore }}</td>            
        </tr>
    </template>
</table>
</template>