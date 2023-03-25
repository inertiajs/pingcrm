import Vue from 'vue'
import VueMeta from 'vue-meta'
import PortalVue from 'portal-vue'
import { App, plugin } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress/src'
import vuetify from '@/Plugins/vuetify'

Vue.config.productionTip = false
Vue.mixin({ methods: { route: window.route } })
Vue.use(plugin)
Vue.use(PortalVue)
Vue.use(VueMeta)

InertiaProgress.init()

let app = document.getElementById('app')
const page = JSON.parse(app.dataset.page)

new Vue({
  vuetify,
  metaInfo: {
    titleTemplate: title => (title ? `${title} - Rentas` : 'Rentas'),
  },
  render: h =>
    h(App, {
      props: {
        initialPage: page,
        resolveComponent: name =>
          import(`@/Pages/${name}`).then(module => module.default),
      },
    }),
}).$mount(app)
