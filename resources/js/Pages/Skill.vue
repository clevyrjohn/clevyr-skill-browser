<script setup>
defineProps({
    skill: Object,
})
</script>

<template>
<div>
    {{ skill.name }}
    <div v-for="human in skill.humans">
        <div v-if="human.level > 0">
            {{ human.human.name }} {{ human.level }}
        </div>
    </div>
</div>
</template>