import { defineConfig } from 'vite';
import laravel    from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/dashboard.css', 'resources/css/emerald.css', 'resources/js/book-reader.js'],
            refresh: true,
        }),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
