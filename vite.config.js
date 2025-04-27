import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path'; // Adicionar o path para configurar o alias

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',  // Certifique-se de que esse é o ponto de entrada correto
                'resources/css/app.css' // Arquivo CSS (se houver)
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'), // Defina o alias @ apontando para resources/js
        },
    },
});
