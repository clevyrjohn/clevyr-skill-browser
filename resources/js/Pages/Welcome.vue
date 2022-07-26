<script setup>
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

    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-sm text-gray-700 underline">
            Dashboard
            </Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700 underline">
                Log in
                </Link>

                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                Register
                </Link>
            </template>
        </div>
        <div class="dark:text-white">
            <div class="flex justify-around mt-20">
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
</template>