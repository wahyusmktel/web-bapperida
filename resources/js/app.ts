import { createInertiaApp } from '@inertiajs/vue3';
import { createApp, h } from 'vue';
import { Toaster } from 'vue-sonner';

const appName = import.meta.env.VITE_APP_NAME || 'BAPPERIDA Kabupaten Pringsewu';

void createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    progress: {
        color: '#0F766E',
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({
            render: () =>
                h('div', { id: 'app-root', class: 'min-h-screen flex flex-col font-sans selection:bg-teal-100 selection:text-teal-900' }, [
                    h(App, props),
                    h(Toaster, {
                        position: 'top-right',
                        richColors: true,
                        closeButton: true,
                        theme: 'light',
                    }),
                ]),
        }).use(plugin);

        if (el) {
            app.mount(el);
        }

        return app;
    },
});
