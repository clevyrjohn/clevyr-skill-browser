<script setup>

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
})
</script>

<template>
    <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
        <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-sm text-gray-700 underline">
        Dashboard
        </Link>

        <template v-else>
            <Link :href="route('login')" class="text-sm text-gray-700 dark:text-gray-300 underline">
            Log in
            </Link>

            <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 dark:text-gray-300 underline">
            Register
            </Link>
        </template>
    </div>
</template>