import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/newkirk/scss/app.scss',
                'resources/newkirk/scss/icons.scss',
                'resources/newkirk/js/app.js',
                'resources/newkirk/js/head.js',
                'resources/newkirk/js/layout.js',
                // Dashboard Js
                'resources/newkirk/js/pages/demo.dashboard.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            '~bootstrap': 'bootstrap',
            './locale': 'moment/locale',
        },
    },
    optimizeDeps: {
        include: ['jquery', 'bootstrap', 'moment'],
        exclude: ['daterangepicker'],
    },
});
