import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/test.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        port: 3000, // Change the port to something else, like 3000
      },
});
