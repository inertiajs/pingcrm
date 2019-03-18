<template>
  <button type="button" @click="toggle">
    <slot />
    <portal v-if="show" to="dropdown">
      <div>
        <div style="position: fixed; top: 0; right: 0; left: 0; bottom: 0; z-index: 99998; background: black; opacity: .2" @click="toggle" />
        <div ref="dropdown" style="position: absolute; z-index: 99999;" @click.stop>
          <slot name="dropdown" />
        </div>
      </div>
    </portal>
  </button>
</template>

<script>
import Popper from 'popper.js'

export default {
  props: {
    placement: {
      type: String,
      default: 'bottom-end',
    },
    boundary: {
      type: String,
      default: 'scrollParent',
    },
  },
  data() {
    return {
      show: false,
    }
  },
  watch: {
    show(show) {
      if (show) {
        this.$nextTick(() => {
          this.popper = new Popper(this.$el, this.$refs.dropdown, {
            placement: this.placement,
            modifiers: {
              preventOverflow: { boundariesElement: this.boundary },
            },
          })
        })
      } else if (this.popper) {
        setTimeout(() => this.popper.destroy(), 100)
      }
    },
  },
  mounted() {
    document.addEventListener('keydown', (e) => {
      if (e.keyCode === 27) {
        this.close()
      }
    })
  },
  methods: {
    close() {
      this.show = false
    },
    toggle() {
      this.show = !this.show
    },
  },
}
</script>
