<script setup>
import { reactive } from 'vue';
import { ChevronRightIcon, ChevronDownIcon } from '@heroicons/vue/solid';
import { Link } from '@inertiajs/inertia-vue3';

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

</script>

<template>
<table class="relative z-40 border-separate border-spacing-1 w-full">
    <thead class="text-lg font-serif">
        <!-- <th class=""></th> -->
        <th class="text-left">Name</th>
        <th class="text-right">Total Score</th>
    </thead>
    <template v-for="skill in skills" :key="skill.id" class="static">
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