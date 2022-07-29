<script setup>
import { ref, reactive } from 'vue';
// import { ChevronRightIcon, ChevronDownIcon } from '@heroicons/vue/solid';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    humans: Array,
})

let displayRows = {
    humans: {},
};

for (const human of props.humans) {
    displayRows.humans[human.id] = false;
}

displayRows = reactive(displayRows);



</script>

<template>
<table class="relative z-40 border-separate border-spacing-1 w-full">
    <thead class="text-lg font-serif">
        <th class=""></th>
        <th class="text-left">Name</th>
        <th class="text-right">Total Score</th>
    </thead>
    <template v-for="human in humans" :key="human.id" class="static">
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