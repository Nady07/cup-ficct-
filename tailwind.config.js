import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Models/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                'ficct-blue': '#1a56db',
                'ficct-dark-blue': '#1e3a8a',
                'ficct-light-blue': '#3b82f6',
                'ficct-gold': '#f59e0b',
                'ficct-dark-gold': '#b45309',
                'dark-bg': '#0f172a',
                'dark-surface': '#1e293b',
                'dark-border': '#334155',
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [forms],
};