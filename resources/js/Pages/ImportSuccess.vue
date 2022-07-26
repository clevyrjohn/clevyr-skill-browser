<script setup>
defineProps({
    request: {
        type: Object,
    }
});
</script>

<template>
<div>
    Request: {{ request }}
</div>
</template>