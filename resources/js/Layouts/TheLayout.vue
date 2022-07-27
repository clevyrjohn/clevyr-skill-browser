<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import ClevyrLogo from '@/Assets/ClevyrLogo.svg';
import TransitionSlideFade from '@/Assets/TransitionSlideFade.vue';
</script>

<template>
<div class="bg-gray-200 dark:bg-gray-900 p-6 min-h-[100vh]">
    <Link href="/" class="flex flex-row items-center mb-4 p-2 bg-gray-100 dark:bg-gray-900 max-w-fit pr-4 rounded-lg hover:scale-105 ease-in-out duration-75 active:scale-100">
        <ClevyrLogo class="h-10 m-4 mr-[0.8rem]" />
        <div class="text-blue-light tracking-[-.005rem] text-[2.6rem] mb-[0.1rem] font-serif">skill browser</div>
    </Link>
    <div class="bg-white dark:bg-gray-800 container max-w-7xl mx-auto rounded-md shadow-lg">
        <TransitionSlideFade>
            <div v-if="$slots.default" class="p-4 divide-y divide-blue dark:divide-blue-light">
                <slot />
            </div>
        </TransitionSlideFade>
    </div>
</div>
</template>
