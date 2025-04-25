import '../css/app.css';
import './bootstrap';
import 'leaflet/dist/leaflet.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,

    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue', { eager: true })
        ),

    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue);

        // Aqui você pode adicionar um tratamento global de erro
        app.config.errorHandler = (err, vm, info) => {
            console.error('Erro detectado:', err);
            console.error('Informações adicionais:', info);

            // Aqui, você pode manipular como deseja tratar o erro, por exemplo, 
            // mostrar uma notificação, enviar para um serviço de log, etc.
        };

        app.mount(el);
    },

    progress: {
        color: '#4B5563',
    },
});
