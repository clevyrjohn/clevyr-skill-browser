<script setup>
import { ref, reactive } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import { ChevronRightIcon, ChevronUpIcon, ChevronDownIcon } from '@heroicons/vue/solid';
import { 
    sortByNameDesc,
    sortByNameAsc,
    sortByCompanyTotalDesc,
    sortByCompanyTotalAsc 
} from '@/Composables/sortItems';


const props = defineProps({
    skills: Array,
})

let displayRows = {
    skills: {},
};

for (const category of props.skills) {
    displayRows.skills[category.id] = false;
}

displayRows = reactive(displayRows);

const sortingAlgorithm = ref(sortByNameAsc);

function sortByName() {
    sortingAlgorithm.value = sortingAlgorithm.value === sortByNameAsc ? sortByNameDesc : sortByNameAsc;
}

function sortByCompanyTotal() {
    sortingAlgorithm.value = sortingAlgorithm.value === sortByCompanyTotalDesc ? sortByCompanyTotalAsc : sortByCompanyTotalDesc;
}

</script>

<template>
<table class="relative z-40 border-separate border-spacing-1 w-full">
    <thead class="text-lg font-serif">
        <!-- <th class=""></th> -->
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
            <!-- <td class="cursor-pointer" @click="displayRows.skills[skill.id] = !displayRows.skills[skill.id]">
                <ChevronRightIcon class="h-7 mr-[-11px]" v-if="displayRows.skills[skill.id] === false" />
                <ChevronDownIcon class="h-7 mr-[-11px]" v-else />
            </td> -->
            <td><Link class="hover:underline" :href="`/s/${skill.id}`">{{ skill.name }}</Link></td>
            <td class="text-right">{{ skill.companyTotal }}</td>            
        </tr>
        <!-- <transition name="slide" class="static z-30">
            <tr v-if="displayRows.skills[skill.id] === true">
                <td colspan="4">
                    <table class="w-full mb-2">
                        <tr v-for="human in skill.humans.filter(h => h.level > 0)" :key="human.id">
                            <td class="w-11"><ChevronDownIcon class="h-7 mr-[-11px] fill-transparent" /></td>
                            <td class="text-left">{{ human.human.name }}</td>
                            <td class="text-right">{{ human.level }}</td>                            
                        </tr>
                    </table>
                </td>
            </tr>
        </transition> -->
    </template>
</table>
</template>