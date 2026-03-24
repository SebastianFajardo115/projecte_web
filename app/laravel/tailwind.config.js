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
                primary: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    900: '#082f49',
                },
                slate: {
                    800: '#1e293b',
                    900: '#0f172a',
                },
                emerald: {
                    500: '#10b981',
                    600: '#059669',
                    700: '#047857',
                },
                amber: {
                    500: '#f59e0b',
                    600: '#d97706',
                    700: '#b45309',
                },
                red: {
                    500: '#ef4444',
                    600: '#dc2626',
                    700: '#b91c1c',
                },
            },
            backgroundImage: {
                'gradient-primary': 'linear-gradient(135deg, #0284c7 0%, #0369a1 100%)',
                'gradient-alt': 'linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%)',
            },
            boxShadow: {
                'sm': '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
                'md': '0 4px 6px -1px rgba(0, 0, 0, 0.1)',
                'lg': '0 10px 15px -3px rgba(0, 0, 0, 0.1)',
                'xl': '0 20px 25px -5px rgba(0, 0, 0, 0.1)',
            },
        },
    },

    plugins: [forms],
};
