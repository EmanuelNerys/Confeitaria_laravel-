import '../css/app.css'; // Certifique-se de que o caminho para o CSS está correto
import './bootstrap'; // Carrega o bootstrap se necessário

import { createInertiaApp } from '@inertiajs/vue3'; // Inertia.js
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'; // Helper do Vite para resolver as páginas
import { createApp, h } from 'vue'; // Vue 3
import { ZiggyVue } from '../../vendor/tightenco/ziggy'; // Ziggy para geração de URLs

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'; // Obtém o nome da aplicação do .env

createInertiaApp({
    title: (title) => `${title} - ${appName}`, // Definir o título dinâmico das páginas

    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`, // Caminho das páginas Vue (ajustado para a pasta Pages)
            import.meta.glob('./Pages/**/*.vue', { eager: true }) // Carrega todas as páginas dinamicamente da pasta Pages
        ),

    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) }) // Cria o app Vue e o monta no elemento
            .use(plugin) // Usa o plugin do Inertia
            .use(ZiggyVue) // Usa o Ziggy para lidar com as rotas no Vue
            .mount(el); // Monta a aplicação no DOM
    },

    progress: {
        color: '#4B5563', // Cor da barra de progresso
    },
});
