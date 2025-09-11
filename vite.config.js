import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        hmr: {
            overlay: false // Disable the error overlay
        }
    },
    resolve: {
        alias: {
            'laravel-echo': 'laravel-echo/dist/echo.js',
        },
    },
});
