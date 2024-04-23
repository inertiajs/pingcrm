import '../css/app.css'
import { createApp, h, resolveComponent } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import layout from '@/Shared/Layout.vue'

createInertiaApp({
    resolve: async (name) => {
        const page = await resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'))
        const pageWithoutLayout = ['Auth/Login', 'Auth/TwoFactor']
        if (!pageWithoutLayout.includes(name)) {
            page.default.layout ??= layout
        }
        return page
    },
    title: title => title ? `${title} - Ping CRM` : 'Ping CRM',
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
})
