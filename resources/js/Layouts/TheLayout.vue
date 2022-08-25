<script setup>
import { provide, computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import ClevyrLogo from '@/Assets/ClevyrLogo.svg';
import TransitionSlideFade from '@/Assets/TransitionSlideFade.vue';
import { useWindowSize } from '@vueuse/core';
import { usePreferredColorScheme } from '@vueuse/core';

const preferredColor = usePreferredColorScheme();

const { width: viewportWidth, height: viewportHeight } = useWindowSize();
const currentBreakpoint = computed(() =>
	viewportWidth.value < 640 ?
		'xs' :
		viewportWidth.value < 768 ?
			'sm' :
			viewportWidth.value < 1024 ?
				'md' :
				viewportWidth.value < 1280 ?
					'lg' :
					viewportWidth.value < 1536 ?
						'xl' :
						'2xl',
);

provide('windowInfo', {
	viewportWidth,
	viewportHeight,
	currentBreakpoint,
	preferredColor,
});

</script>

<template>
	<div class="min-h-[100vh] bg-gray-200 p-6 dark:bg-gray-900">
		<div class="mx-auto">
			<Link
				href="/"
				class="mb-4 flex max-w-fit flex-row items-center rounded-lg bg-gray-100 p-2 pr-4 duration-75 ease-in-out hover:scale-105 active:scale-100 dark:bg-gray-900"
			>
				<ClevyrLogo class="m-4 mr-[0.8rem] h-10" />
				<div class="mb-[0.1rem] font-serif text-[2.6rem] tracking-[-.005rem] text-blue-light">
					skill browser
				</div>
			</Link>
			<div class="rounded-md bg-white shadow-lg dark:bg-gray-800">
				<TransitionSlideFade>
					<div
						v-if="$slots.default"
						class="divide-y divide-blue p-4 dark:divide-blue-light"
					>
						<slot />
					</div>
				</TransitionSlideFade>
			</div>
		</div>
	</div>
</template>
