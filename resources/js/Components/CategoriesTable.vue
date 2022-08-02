<script setup>
import { ref, reactive, computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import { ChevronRightIcon, ChevronUpIcon, ChevronDownIcon } from '@heroicons/vue/solid';
import { 
    sortByNameDesc,
    sortByNameAsc,
    sortByCompanyTotalDesc, 
    sortByCompanyTotalAsc 
} from '@/Composables/sortItems';
import { hexToRgbA } from '@/Composables/hexToRgbA'
import PolarAreaChart from './Charts/polarAreaChart';

const props = defineProps({
    categories: Array,
})

let displayRows = {
    categories: {},
};

for (const category of props.categories) {
    displayRows.categories[category.id] = false;
}

displayRows = reactive(displayRows);

const sortingAlgorithm = ref(sortByNameAsc);

function sortByName() {
    sortingAlgorithm.value = sortingAlgorithm.value === sortByNameAsc ? sortByNameDesc : sortByNameAsc;
}

function sortByCompanyTotal() {
    sortingAlgorithm.value = sortingAlgorithm.value === sortByCompanyTotalDesc ? sortByCompanyTotalAsc : sortByCompanyTotalDesc;
}

const chartData = computed(() => {
    return {
        labels: props.categories.map(el => el.name),
        datasets: [
            {
                label: 'Company Skills by Category',
                backgroundColor: props.categories.map(el => hexToRgbA('#'+el.color,0.5)),
                data: props.categories.map(el => el.companyTotal)
            }
        ]
    }
})

</script>

<template>
<PolarAreaChart
    :chartData="chartData"
/>
<table class="relative mt-14 z-40 border-separate border-spacing-1 w-full">
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
        <th class="text-right" @click="sortByCompanyTotal">
            <ChevronDownIcon
                v-show="sortingAlgorithm === sortByCompanyTotalDesc"
                class="h-7 w-7 inline" />
            <ChevronUpIcon
                v-show="sortingAlgorithm === sortByCompanyTotalAsc"
                class="h-7 w-7 inline" />            
            Company Score            
        </th>
    </thead>
    <template v-for="category in categories.sort(sortingAlgorithm)" :key="category.id" class="static">
        <tr class="static z-40 text-lg">
            <td class="cursor-pointer" @click="displayRows.categories[category.id] = !displayRows.categories[category.id]">
                <ChevronRightIcon class="h-7 mr-[-11px]" v-if="displayRows.categories[category.id] === false" />
                <ChevronDownIcon class="h-7 mr-[-11px]" v-else />
            </td>
            <td class=""><Link class="hover:underline" :href="`/c/${category.id}`">{{ category.name }}</Link></td>
            <td class="text-right">{{ category.companyTotal }}</td>            
        </tr>
        <transition name="slide" class="static z-30">
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
        </transition>
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