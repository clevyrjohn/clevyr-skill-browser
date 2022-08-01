<script setup>
import { Inertia } from '@inertiajs/inertia';
import { reactive } from 'vue';

const props = defineProps({
    sheet: {
        type: Array,
        required: true,
    },
    colors: {
        type: Object,
        required: true,
    }
})

const categories = props.sheet[0].slice(1,(props.sheet[0].length-2));
categories.unshift("");

const justCategoryNames = categories.filter(category => category);

const skills = props.sheet[2].slice(0);
const humans = props.sheet.slice(4,props.sheet.length-21).map(arr => arr.slice(0,arr.length-2));

const form = reactive({
    categories: categories,
    skills: skills,
    humans: humans
});

function submit() {
    Inertia.post('/import', form);
}

</script>

<template>
<div>
    <form @submit.prevent="submit">
        <input id="categories" type="hidden" v-model="form.categories" />
        <input id="skills" type="hidden" v-model="form.skills" />
        <input id="humans" type="hidden" v-model="form.humans" />
        <button class="m-2 px-6 p-4 bg-blue-500 text-white font-bold border-2 border-gray-300 hover:bg-blue-400 active:bg-blue-900 rounded-md">Import?</button>
    </form>
    <table>
        <tr>
            <td></td>
            <td 
                v-for="category, index in categories.filter(category => category)" 
                :key="index"
                :style="colors[category] ? `background-color: #${colors[category]};` : ''"
                :colspan="(
                    categories.indexOf(justCategoryNames[index+1]) !== -1 ? categories.indexOf(justCategoryNames[index+1]) : categories.length) - categories.indexOf(justCategoryNames[index]
                )"
            >
                {{ `${category}` }}
            </td>
        </tr>
        <tr>
            <td v-for="skill, index in skills" :key="index">{{ `${skill}` }}</td>
        </tr>
        <tr v-for="human, humanIndex in humans" :key="humanIndex">
            <td v-for="value, index in human" :key="index" nowrap>                
                {{ `${value}` }}
            </td>
        </tr>
    </table>
</div>
</template>