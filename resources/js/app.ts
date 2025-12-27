import '@vuepic/vue-datepicker/dist/main.css';
import 'vue-toastification/dist/index.css';
import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { VueDatePicker } from '@vuepic/vue-datepicker';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, defineAsyncComponent, DefineComponent, h } from 'vue';
import Toast, { POSITION } from 'vue-toastification';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';
const AppLayout = defineAsyncComponent(() => import('@/layouts/AppLayout.vue'));
const Notifications = defineAsyncComponent(
    () => import('@/custom-components/notifications/notifications.vue'),
);

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: async (name) => {
        const page: DefineComponent = await resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./pages/**/*.vue'),
        );

        const pages_without_layout = ['auth/Login'];
        console.log(name);
        if (!pages_without_layout.includes(name)) {
            page.default.layout = page.default.layout || AppLayout;
        }

        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => [h(App, props)] });

        // Plugins
        app.use(plugin);
        app.use(ZiggyVue);
        app.use(Toast, {
            position: POSITION.TOP_RIGHT,
            timeout: 5000,
            closeOnClick: true,
            pauseOnHover: true,
            hideProgressBar: false,
        });

        // Components
        app.component('VueDatePicker', VueDatePicker);
        app.component('Notifications', Notifications);

        app.mount(el);
    },

    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
