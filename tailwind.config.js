/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            colors:{
                'terquoise': {
                    '100': '#e6f5ff',
                    '200': '#b2ebf2',
                    '300': '#80deea',
                    '400': '#4dd0e1',
                    '500': '#26c6da',
                    '600': '#00bcd4',
                    '700': '#00acc1',
                    '800': '#0097a7',
                    '900': '#00838f',
                },
                'primary': {
                    'dark': '#167280',
                    'light': '#00bcd4',
                },
                'secondary': {
                    'dark': '#dc8037',
                    'light': '#ffb300',
                },
            },
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('flowbite/plugin')

    ],
};
