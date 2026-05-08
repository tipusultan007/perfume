import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/jidox/scss/app.scss',
                'resources/jidox/scss/icons.scss',
                'resources/jidox/js/app.js',
                'resources/jidox/js/head.js',
                'resources/jidox/js/layout.js',
                // Dashboard Js
                'resources/jidox/js/pages/demo.dashboard.js',
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
