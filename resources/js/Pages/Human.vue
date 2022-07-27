<script setup>
import TheLayout from '@/Layouts/TheLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { sortByLevelDesc } from '@/Composables/sortItems';
defineProps({
    human: Object,
})
</script>

<template>
<TheLayout>
    <div class="text-5xl font-bold dark:font-normal text-center font-serif pt-4 pb-6 dark:text-white">{{ human.name }}</div>        
    <div class="flex flex-row flex-wrap justify-around py-8">
        <div v-for="humanSkill in human.skills.filter(hs => hs.level > 0).sort(sortByLevelDesc)" :key="humanSkill.id" class="hover:scale-105 ease-in-out duration-75 active:scale-100">
            <Link :href="route('skill.show', humanSkill.skill.id)">
                <div class="bg-gray-100 dark:bg-gray-700 rounded-md m-1 h-[90%] w-[9rem] p-2">
                    <div class="max-w-fit mx-auto bg-white dark:bg-gray-500 dark:text-gray-100 rounded-full p-2 px-4 font-bold text-xl border-gray-200 dark:border-gray-700 border-[1px]">{{ humanSkill.level }}</div>
                    <div class="max-w-[7rem] mt-2 m-3 font-bold dark:text-gray-100 overflow-auto break-words">{{ humanSkill.skill.name }}</div>
                </div>
            </Link>
        </div>
    </div>
</TheLayout>
</template>
