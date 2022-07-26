<script setup>
defineProps({
    category: Object,
})
</script>

<template>
<div>
    {{ category.name }}
    <div class="">
        <div v-for="categorySkill in category.skills" :key="categorySkill.id">
            <div>
                {{ categorySkill.name }}
            </div>
        </div>
    </div>    
</div>
</template>
