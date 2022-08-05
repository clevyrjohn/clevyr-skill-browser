<script setup>
import { ref, reactive, computed, onMounted, watch } from 'vue';
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
import { flattenDeep } from 'lodash';

const chartData = ref({});
// const humans2 = ref([]);
const loaded = computed(() => chartData.value != {});

onMounted(async () => {
    try {
        const res = await fetch(route('api.humanstable'));
        const resJson = await res.json();
        chartData.value = resJson.data;        
        // const res = await fetch(route('api.humans'));
        // const resJson = await res.json();
        // humans.value = resJson.data;
        // const newRes = await fetch(route('api.hc'));
        // const newResJson = await newRes.json();
        // humans2.value = newResJson.data;
        // console.log(humans.value.map(el => el.categoryScores))
        // console.log(humans.value.map(el => {
        //     return {
        //         label: el.name,
        //         data: el.categoryScores.map(el => el.total)
        //     }}));
        // console.log(humans2.value.map(el => el.humanTotals.map(el => {
        //     return {
        //         name: el.name,
        //         totalScore: el.total_score,
        //     }})));
    } catch (error) {
        chartData.value = {};
    }    
})

const sortingAlgorithm = ref(sortByNameAsc);

function sortByName() {
    sortingAlgorithm.value = sortingAlgorithm.value === sortByNameAsc ? sortByNameDesc : sortByNameAsc;
}

function sortByTotalScore() {
    sortingAlgorithm.value = sortingAlgorithm.value === sortByTotalScoreDesc ? sortByTotalScoreAsc : sortByTotalScoreDesc;
}

// const chartData = computed(() => {
//     return {
//         labels: humans2.value[0]?.humanTotals.map(el => el.name),
//         datasets: humans2.value.map(el => {
//             return {
//                 label: el.name,
//                 data: el.humanTotals.map(el => el.total_score),
//                 backgroundColor: hexToRgbA('#'+el.color,0.9),
//             }
//         })
//     }
// })

// const desiredFormat = computed(() => {
//     return {
//         labels: ['Human 1', 'Human 2'],
//         datasets: [
//             { label: 'Category 1', data: [10,15], backgroundColor: hexToRgbA('#'+'FFF',0.9), },
//             { label: 'Category 2', data: [15,10], backgroundColor: hexToRgbA('#'+'CCC',0.9), },
//         ],
//     }
// })

// const datasets = computed(() => {
//     // return [
//     //     { label: 'Category 1', data: [10,15], backgroundColor: hexToRgbA('#'+'FFF',0.9), },
//     // ];
//     // return flattenDeep(humans.value.map(el => el.categoryScores))
//     return flattenDeep(
//         humans.value.map(
//             el => el.categoryScores.map(el => {
//                 return {
//                     label: el.name,
//                     data: [el.total],
//                     backgroundColor: hexToRgbA('#'+el.color,0.9)
//                 }
//             })
//         )
//     )
// })

// const chartData = computed(() => {
//     return {
//         labels: humans.value.map(el => el.name),
//         datasets: datasets.value,
//     }
// })

// const chartData = computed(() => {
//     return {
//         labels: humans.value.map(el => el.name),
//         datasets: humans2.value.map((el,index) => {            
//             return {
//                 label: el.name,
//                 data: el.humanTotals.map(el => el.total_score),
//                 backgroundColor: hexToRgbA('#'+el.color,0.9),
//             }
//         })
//     }
// })

// watch(chartData, ()=> {
//     console.log(chartData.value)
// })

</script>

<template>
<stackedBarChart 
    v-if="loaded"
    :chartData="chartData" 
/>
<!-- <stackedBarChart 
    v-if="loaded"
    :chartData="desiredFormat" 
/> -->
<!-- {{ desiredFormat }}<br />
{{ humans }} -->
<!-- {{ chartData }} -->
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
    <!-- <template v-for="(human, index) in humans.sort(sortingAlgorithm)" :key="human.id" class="static">
        <tr class="static z-40 text-lg">
            <td><Link class="hover:underline" :href="`/h/${human.id}`">{{ human.name }}</Link></td>
            <td class="text-right">{{ human.totalScore }}</td>            
        </tr>
    </template> -->
</table>
</template>