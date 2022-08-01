<script setup>
import { ref, reactive,computed } from 'vue';
import TheLayout from '@/Layouts/TheLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import CategoriesTable from '@/Components/CategoriesTable.vue';
import { ChevronRightIcon, ChevronDownIcon } from '@heroicons/vue/solid';
import HumansTable from '../Components/HumansTable.vue';
import SkillsTable from '../Components/SkillsTable.vue';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    categories: Array,
    skills: Array,
    humans: Array,
})

const activeTab = ref('category');

let displayRows = {
    categories: {},
    humans: {},
    skills: {}    
};

for (const category of props.categories) {
    displayRows.categories[category.id] = false;
}
for (const human of props.humans) {
    displayRows.humans[human.id] = false;
}
for (const skill of props.skills) {
    displayRows.skills[skill.id] = false;
}

displayRows = reactive(displayRows);

</script>



<template>
<Head title="Welcome" />
<TheLayout>
    <div class="relative z-50 text-5xl font-bold dark:font-normal text-center font-serif pt-4 pb-6 dark:text-white">Browse by...</div>
    
    <div class="relative z-50 bg-gray-500 flex flex-row justify-around divide-x divide-blue-light border-x-[1px] rounded-t-md text-white font-bold">
        <div 
            class="active:scale-100 hover:bg-blue-light basis-1/3 p-5 text-center cursor-pointer hover:scale-105 ease-in-out duration-75 rounded-tl-md"
            :class="activeTab === 'category' ? 'bg-blue-light' : ''"
            @click="activeTab = 'category'">Category</div>
        <div 
            class="active:scale-100 hover:bg-blue-light basis-1/3 p-5 text-center cursor-pointer hover:scale-105 ease-in-out duration-75"
            :class="activeTab === 'human' ? 'bg-blue-light' : ''"
            @click="activeTab = 'human'">Human</div>
        <div 
            class="active:scale-100 hover:bg-blue-light basis-1/3 p-5 text-center cursor-pointer hover:scale-105 ease-in-out duration-75 rounded-tr-md"
            :class="activeTab === 'skill' ? 'bg-blue-light' : ''"
            @click="activeTab = 'skill'">Skill</div>
    </div>
    
    <div
        class="relative z-50 items-top min-h-fit bg-white dark:bg-gray-700">        
        <div class="py-10 px-[10%] mx-auto dark:text-white">
            <div v-show="activeTab === 'category'">                    
                <CategoriesTable :categories="categories" />
            </div>            
            <div v-show="activeTab === 'human'">
                <HumansTable :humans="humans" />
            </div>                
            <div v-show="activeTab === 'skill'">                
                <SkillsTable :skills="skills" />
            </div>
        </div>
    </div>
</TheLayout>
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