import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary01: '#387CBD',
                primary02: '#F4A45F',
                primary03: '#ACD9D1',
                primary04: {
                    100: '#EAD6CB', 
                    500: '#D29CB6',
                },
                cream: '#F2EEC9',
                base: '#F5F5F5',
            },
        },
    },

    plugins: [forms],
};
