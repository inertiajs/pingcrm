import { createApp, h } from 'vue'
import { app, plugin } from '@inertiajs/inertia-vue3'
import { InertiaProgress as progress } from '@inertiajs/progress'

const el = document.getElementById('app')

progress.init()

createApp({
  render: () => h(app, {
    initialPage: JSON.parse(el.dataset.page),
    resolveComponent: name => import(`@/Pages/${name}`).then(m => m.default),
  })
})
.mixin({ methods: {
    route: window.route,
    title: title => `Ping CRM - ${title}`,
}})
.use(plugin)
.mount(el)
