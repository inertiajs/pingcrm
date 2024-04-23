import { createSSRApp, h } from 'vue'
import { renderToString } from '@vue/server-renderer'
import { createInertiaApp } from '@inertiajs/vue3'
import createServer from '@inertiajs/vue3/server'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import layout from '@/Shared/Layout.vue'

createServer((page) => createInertiaApp({
    page,
    render: renderToString,
    resolve: async (name) => {
        const page = await resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'))
        const pageWithoutLayout = ['Auth/Login', 'Auth/TwoFactor']
        if (!pageWithoutLayout.includes(name)) {
            page.default.layout ??= layout
        }
        return page
    },
    title: title => title ? `${title} - Ping CRM` : 'Ping CRM',
    setup({ app, props, plugin }) {
        return createSSRApp({
            render: () => h(app, props),
        }).use(plugin)
    },
}))
