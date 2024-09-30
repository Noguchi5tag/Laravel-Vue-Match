import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                baseColor: '#ededed', // ベースカラーを追加
            },
            boxShadow: {
                'tw-shadow-top': '0 -4px 6px -4px rgba(0, 0, 0, 0.3)', // カスタムシャドウを定義
            },
        },
    },

    plugins: [forms],
};
