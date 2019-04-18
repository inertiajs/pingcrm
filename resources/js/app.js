import Inertia from 'inertia-vue'
import PortalVue from 'portal-vue'
import Vue from 'vue'

Vue.config.productionTip = false
Vue.mixin({ methods: { route: (...args) => window.route(...args).url() } })
Vue.use(PortalVue)

let app = document.getElementById('app')

new Vue({
  render: h => h(Inertia, {
    props: {
      initialPage: JSON.parse(app.dataset.page),
      resolveComponent: (component) => {
        return import(`@/Pages/${component}`).then(module => module.default)
      },
    },
  }),
}).$mount(app)
