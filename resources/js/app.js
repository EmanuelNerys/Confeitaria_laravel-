import '../css/app.css'; // Certifique-se que o caminho está correto
import './bootstrap'; // Certifique-se que o bootstrap está configurado corretamente
import 'leaflet/dist/leaflet.css'; // Importação do CSS do Leaflet, caso use mapas

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// Nome da aplicação (opcional: pode vir do arquivo .env)
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,

    // Usando o resolvePageComponent para facilitar a resolução de páginas Vue
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue', { eager: true })
        ),

    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin) // Usando o plugin do Inertia
            .use(ZiggyVue); // Usando Ziggy para facilitar as rotas no Vue

        // Configuração do tratamento de erros no Vue (opcional)
        app.config.errorHandler = (err, vm, info) => {
            console.error('Erro detectado:', err);
            console.error('Informações adicionais:', info);
            // Aqui você pode adicionar um tratamento de erro mais robusto, por exemplo, enviar para um serviço de log
        };

        // Montando o aplicativo Vue no elemento do DOM
        app.mount(el);
    },

    // Personalizando a barra de progresso do Inertia
    progress: {
        color: '#4B5563', // Cor da barra de progresso
    },
});
