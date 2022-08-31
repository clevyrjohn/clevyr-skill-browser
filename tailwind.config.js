const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./vendor/laravel/jetstream/**/*.blade.php',
		'./storage/framework/views/*.php',
		'./resources/views/**/*.blade.php',
		'./resources/js/**/*.vue',
	],

	theme: {
		fontFamily: {
			serif: ['Museo', 'serif'],
			sans: ['Source Sans Pro', ...defaultTheme.fontFamily.sans],
			mono: ['SFMono-Regular', 'ui-monospace'],
		},
		extend: {
			colors: {
				orange: {
					light: '#F9A340',
					DEFAULT: '#FF9100',
					dark: '#E97724',
				},
				blue: {
					light: '#0072BC',
					DEFAULT: '#162C47',
				},
				red: {
					DEFAULT: '#FF3333',
				},
				gray: {
					100: '#E3E3E3',
					200: '#C7C7C7',
					300: '#ABABAB',
					400: '#8F8F8F',
					DEFAULT: '#737373',
					500: '#737373',
					600: '#5C5C5C',
					700: '#454545',
					800: '#2E2E2E',
					900: '#171717',

				},
			},
		},
	},

	plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
