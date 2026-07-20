import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './storage/framework/views/*.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Tajawal', ...defaultTheme.fontFamily.sans],
                display: ['"Playfair Display"', 'serif'],
            },
            colors: {
                canvas: '#F8F5F0',
                sand: '#EFE7DA',
                ink: '#2C3A5A',
                muted: '#8B8578',
                line: '#E5DCCB',
                clay: {
                    DEFAULT: '#B0854F',
                    dark: '#93683A',
                    soft: '#F3EADA',
                },
                pine: {
                    DEFAULT: '#4C7A63',
                    soft: '#E1EDE6',
                },
                ochre: {
                    DEFAULT: '#C79B6D',
                    soft: '#F5ECDD',
                },
            },
            borderRadius: {
                xl: '1rem',
                '2xl': '1.5rem',
                '3xl': '2rem',
            },
            boxShadow: {
                soft: '0 18px 50px -24px rgba(74, 54, 38, 0.35)',
                card: '0 12px 34px -20px rgba(74, 54, 38, 0.30)',
            },
            keyframes: {
                'fade-up': {
                    '0%': { opacity: '0', transform: 'translateY(10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
            },
            animation: {
                'fade-up': 'fade-up .5s ease both',
            },
        },
    },
    plugins: [forms],
};
