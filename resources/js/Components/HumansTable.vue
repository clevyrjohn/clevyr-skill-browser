<script setup>
import { ref, computed, onMounted } from 'vue';
import { ChevronUpIcon, ChevronDownIcon } from '@heroicons/vue/solid';
import { Link } from '@inertiajs/inertia-vue3';
import {
    sortByNameDesc,
    sortByNameAsc,
    sortByTotalScoreDesc,
    sortByTotalScoreAsc
} from '@/Composables/sortItems';
import stackedBarChart from './Charts/stackedBarChart.js';

let empty = {
    labels: [],
    datasets: [
        { label: null, data: [], backgroundColor: null }
    ],
}

const humans = ref(empty);
const loaded = computed(() => humans.value != {});

onMounted(async () => {
    try {
        const res = await fetch(route('api.humanstable'));
        const resJson = await res.json();
        humans.value = resJson.data;
    } catch (error) {
        humans.value = empty;
    }
})

const getTotal = (prev, cur) => prev + cur;

const sortedHumans = computed(() => {
    return humans.value
})

const tableData = computed(() => {
    return sortedHumans.value.labels.map((i, index) => {
        let scores = sortedHumans.value.datasets.map((i) => i.data[index])
        return {
            name: i.name,
            id: i.id,
            totalScore: scores.reduce(getTotal)
        }
    })
})

const chartData = computed(() => {
    return {
        labels: sortedHumans.value.labels.map((i) => i.name),
        datasets: sortedHumans.value.datasets
    };
})

const sortingAlgorithm = ref(sortByNameAsc);

function sortByName() {
    sortingAlgorithm.value = sortingAlgorithm.value === sortByNameAsc ? sortByNameDesc : sortByNameAsc;
}

function sortByTotalScore() {
    sortingAlgorithm.value = sortingAlgorithm.value === sortByTotalScoreDesc ? sortByTotalScoreAsc : sortByTotalScoreDesc;
}

</script>

<template v-if="loaded">
    <stackedBarChart :chartData="chartData" />
    <table class="relative z-40 mt-12 border-separate border-spacing-1 w-full">
        <thead class="text-lg font-serif">
            <th class="text-left" @click="sortByName">
                Name
                <ChevronDownIcon v-show="sortingAlgorithm === sortByNameAsc" class="h-7 w-7 inline" />
                <ChevronUpIcon v-show="sortingAlgorithm === sortByNameDesc" class="h-7 w-7 inline" />
            </th>
            <th class="text-right" @click="sortByTotalScore">
                <ChevronDownIcon v-show="sortingAlgorithm === sortByTotalScoreDesc" class="h-7 w-7 inline" />
                <ChevronUpIcon v-show="sortingAlgorithm === sortByTotalScoreAsc" class="h-7 w-7 inline" />
                Total Score
            </th>
        </thead>
        <!-- <template v-for="(human, index) in humans.sort(sortingAlgorithm)" :key="human.id" class="static"> -->
        <template v-for="(human, index) in tableData" :key="index" class="static">
            <tr class="static z-40 text-lg">
                <td>
                    <Link class="hover:underline" :href="`/h/${human.id}`">
                    {{ human.name }}
                    </Link>
                </td>
                <td class="text-right">{{ human.totalScore }}</td>
            </tr>
        </template>
    </table>
</template>
