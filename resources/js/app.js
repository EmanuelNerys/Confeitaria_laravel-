import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { ZiggyVue } from 'ziggy-js';

// Criar a aplicação Inertia
createInertiaApp({
    resolve: name => import(`./Pages/${name}.vue`), // Corrigido: uso de import() dinâmico
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin) // Usar o plugin Inertia
            .use(ZiggyVue, Ziggy) // Usar Ziggy para roteamento Laravel
            .mount(el); // Montar o app no elemento do DOM
    },
});
