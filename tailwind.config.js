import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Colores Académicos UAGRM FICCT
                'ficct-blue': '#003DA5',
                'ficct-dark-blue': '#002A7A',
                'ficct-light-blue': '#005FD1',
                'ficct-gold': '#D4AF37',
                'ficct-dark-gold': '#A68428',
                'ficct-light-gold': '#E8C547',
                // Grises para tema oscuro
                'dark-bg': '#0f172a',
                'dark-surface': '#1e293b',
                'dark-border': '#334155',
            },
            backgroundColor: {
                'dark': '#0f172a',
                'dark-surface': '#1e293b',
            },
            textColor: {
                'dark': '#e2e8f0',
            },
        },
    },

    plugins: [forms],
};
