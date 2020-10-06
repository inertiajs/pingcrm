import { createApp, h } from 'vue'
import { InertiaApp, InertiaPlugin } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'

const el = document.getElementById('app')

InertiaProgress.init()

const app = createApp({
  render: () => h(InertiaApp, {
    initialPage: JSON.parse(el.dataset.page),
    resolveComponent: name => import(`@/Pages/${name}`).then(module => module.default),
  })
})
app.use(InertiaPlugin)
app.mixin({ methods: { route: window.route } })
app.mount(el)
