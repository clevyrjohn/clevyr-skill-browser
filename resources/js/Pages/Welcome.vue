<script setup>
import TheLayout from '@/Layouts/TheLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    categories: Array,
    skills: Array,
    humans: Array,
})
</script>

<template>
<Head title="Welcome" />
<TheLayout>
    <div
        class="relative flex items-top justify-center min-h-screen bg-white dark:bg-gray-700 sm:items-center sm:pt-0">        
        <div class="p-4 dark:text-white">
            <div class="flex justify-around mt-14">
                <div>
                    <div class="font-bold text-xl">Browse by Human:</div>
                    <ul class="columns-2 mt-4">                                            
                        <li v-for="human in humans">
                        <Link class="hover:underline" :href="`/h/${human.id}`">{{ human.name }}</Link>
                        </li>
                    </ul>
                </div>                
                <div>
                    <div class="font-bold text-xl">Browse by Category:</div>
                    <ul class="mt-4">
                        <li v-for="category in categories">
                            <Link class="hover:underline" :href="`/c/${category.id}`">{{ category.name }}</Link>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="font-bold text-center text-xl mt-10 mb-10">Browse by Skill:</div>
            <ul class="columns-5 mt-4 mb-20 pb-4">
                <li v-for="skill in skills">
                <Link class="hover:underline" :href="`/s/${skill.id}`">{{ skill.name }}</Link>
                </li>
            </ul>
        </div>
    </div>
</TheLayout>
</template>