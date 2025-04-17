import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],  // Certifique-se de que 'app.css' e 'app.js' estão listados aqui
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        outDir: 'public/build',
    },
});
