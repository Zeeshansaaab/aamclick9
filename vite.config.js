import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/app.js',
                'resources//theme/css/dashlite.css',
                'resources//theme/css/theme.css',
                'resources//theme/js/bundle.js',
                'resources//theme/js/scripts.js',
            ],
            refresh: true,
        }),
    ],
});
