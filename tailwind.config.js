/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                forest: {
                    100: '#dbe8e0',
                    500: '#2b805c',
                    600: '#1e6446',
                    700: '#164d37',
                    800: '#123f2c',
                    900: '#0c3122',
                },
                gold: {
                    100: '#f0e8d3',
                    300: '#dcc88d',
                    500: '#bd9542',
                    600: '#9f7c2b',
                },
                brick: {
                    100: '#f3e0da',
                    500: '#bf4838',
                    600: '#a63a2b',
                    700: '#8c3122',
                },
            },
            fontFamily: {
                serif: ['Fraunces', 'Georgia', 'serif'],
                sans: ['Inter', 'system-ui', 'sans-serif'],
            },
            maxWidth: {
                wrap: '1440px',
            },
        },
    },
    plugins: [],
};
