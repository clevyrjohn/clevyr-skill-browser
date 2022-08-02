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
import stackedBarChart from './Charts/stackedBarChart.js';

const props = defineProps({
    humans: Array,
})

const loaded = ref(false);
onMounted(() => {
    loaded.value = true;
})

let displayRows = {
    humans: {},
};

for (const human of props.humans) {
    displayRows.humans[human.id] = false;
}

displayRows = reactive(displayRows);

const sortingAlgorithm = ref(sortByNameAsc);

function sortByName() {
    sortingAlgorithm.value = sortingAlgorithm.value === sortByNameAsc ? sortByNameDesc : sortByNameAsc;
}

function sortByTotalScore() {
    sortingAlgorithm.value = sortingAlgorithm.value === sortByTotalScoreDesc ? sortByTotalScoreAsc : sortByTotalScoreDesc;
}

// let chartData = { labels: [], datasets: [], data: [] };

// onMounted(() => {
    const chartData = computed(() => {
        return {
            labels: props.humans.map(el => el.name),
            datasets: [
                {
                    label: 'Skills',
                    backgroundColor: '#FF9100',
                    data: props.humans.map(el => el.totalScore)
                }
            ]
        }
    }, { immediate: false })
// })


</script>

<template>
<stackedBarChart 
    v-if="loaded"
    :chartData="chartData" 
/>
<table class="relative z-40 mt-12 border-separate border-spacing-1 w-full">
    <thead class="text-lg font-serif">
        <th class=""></th>
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
            <td class="cursor-pointer"><!-- @click="displayRows.humans[human.id] = !displayRows.humans[human.id]">-->
                <!-- <ChevronRightIcon class="h-7 mr-[-17px]" v-if="displayRows.humans[human.id] === false" /> -->
                <!-- <ChevronDownIcon class="h-7 mr-[-17px]" v-else /> -->
            </td>
            <td><Link class="hover:underline" :href="`/h/${human.id}`">{{ human.name }}</Link></td>
            <td class="text-right">{{ human.totalScore }}</td>            
        </tr>
        <!-- <transition name="slide" class="static z-30">
            <tr v-if="displayRows.humans[human.id] === true">
                <td colspan="4">
                    <table class="w-full mb-2">
                        <tr v-for="skill in human.skills.filter(s => s.level > 0)" :key="skill.id">
                            <td class="w-11"><ChevronDownIcon class="h-7 fill-transparent" /></td>
                            <td class="text-left">{{ skill.skill.name }}</td>
                            <td class="text-right">{{ skill.level }}</td>                            
                        </tr>
                    </table>
                </td>
            </tr>
        </transition> -->
    </template>
</table>
</template>