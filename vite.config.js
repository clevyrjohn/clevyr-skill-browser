import path from 'path';
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import svgLoader from 'vite-svg-loader';

export default defineConfig({
	server: {
		host: true,
		strictPort: true,
		hmr: {
			host: 'hot.clevyr.run',
			clientPort: 443,
			protocol: 'wss',
		},
	},
	plugins: [
		laravel({
			input: 'resources/js/app.js',
			refresh: true,
		}),
		vue({
			template: {
				transformAssetUrls: {
					base: null,
					includeAbsolute: false,
				},
			},
		}),
		svgLoader({
			svgo: true,
			svgoConfig: {
				plugins: ['removeDimensions', 'sortAttrs'],
			},
		}),
	],
	resolve: {
		alias: {
			ziggy: path.resolve('vendor/tightenco/ziggy/dist/vue.m'),
		},
	},
});
