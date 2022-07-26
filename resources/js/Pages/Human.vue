<script setup>
defineProps({
    human: Object,
})
</script>

<template>
<div>
    <div>{{ human.name }}</div>
    <div class="">
        <div v-for="humanSkill in human.skills" :key="humanSkill.id">
            <div v-if="humanSkill.level > 0">
                {{ humanSkill.skill.name }} {{ humanSkill.level }}
            </div>
        </div>
    </div>
</div>
</template>