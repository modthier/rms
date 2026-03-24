const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: 'class',
    corePlugins: {
        preflight: false,
    },
    theme: {
        fontFamily: {
            outfit: ['Outfit', 'sans-serif'],
        },
        screens: {
            '2xsm': '375px',
            xsm: '425px',
            '3xl': '2000px',
            ...defaultTheme.screens,
        },
        extend: {
            fontSize: {
                'title-2xl': ['72px', '90px'],
                'title-xl': ['60px', '72px'],
                'title-lg': ['48px', '60px'],
                'title-md': ['36px', '44px'],
                'title-sm': ['30px', '38px'],
                'theme-xl': ['20px', '30px'],
                'theme-sm': ['14px', '20px'],
                'theme-xs': ['12px', '18px'],
            },
            colors: {
                brand: {
                    25: '#F2F7FF',
                    50: '#ECF3FF',
                    100: '#DDE9FF',
                    200: '#C2D6FF',
                    300: '#9CB9FF',
                    400: '#7592FF',
                    500: '#465FFF',
                    600: '#3641F5',
                    700: '#2A31D8',
                    800: '#252DAE',
                    900: '#262E89',
                    950: '#161950',
                },
                gray: {
                    dark: '#1A2231',
                    25: '#FCFCFD',
                    50: '#F9FAFB',
                    100: '#F2F4F7',
                    200: '#E4E7EC',
                    300: '#D0D5DD',
                    400: '#98A2B3',
                    500: '#667085',
                    600: '#475467',
                    700: '#344054',
                    800: '#1D2939',
                    900: '#101828',
                    950: '#0C111D',
                },
                success: {
                    500: '#12B76A',
                    600: '#039855',
                },
                error: {
                    500: '#F04438',
                    600: '#D92D20',
                },
            },
            boxShadow: {
                'theme-md':
                    '0px 4px 8px -2px rgba(16, 24, 40, 0.10), 0px 2px 4px -2px rgba(16, 24, 40, 0.06)',
                'theme-lg':
                    '0px 12px 16px -4px rgba(16, 24, 40, 0.08), 0px 4px 6px -2px rgba(16, 24, 40, 0.03)',
                'theme-sm':
                    '0px 1px 3px 0px rgba(16, 24, 40, 0.10), 0px 1px 2px 0px rgba(16, 24, 40, 0.06)',
                'theme-xs': '0px 1px 2px 0px rgba(16, 24, 40, 0.05)',
                'theme-xl':
                    '0px 20px 24px -4px rgba(16, 24, 40, 0.08), 0px 8px 8px -4px rgba(16, 24, 40, 0.03)',
            },
            zIndex: {
                999999: '999999',
                99999: '99999',
                9999: '9999',
                999: '999',
                99: '99',
                9: '9',
                1: '1',
            },
        },
    },
    plugins: [require('@tailwindcss/forms')],
};
