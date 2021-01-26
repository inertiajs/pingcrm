<template>
  <v-app id="inspire">
    <v-app-bar app>
      <v-btn icon href="/">
        <v-icon>mdi-backburger</v-icon>
      </v-btn>

      <v-toolbar-title>Titulo de Expediente</v-toolbar-title>
    </v-app-bar>

    <v-main class="grey lighten-2">
      <v-container>
        <v-row>
          <v-col v-for="j in 6" :key="`${j}`" cols="12" md="3">
            <v-hover v-slot="{ hover }">
              <v-card
                :elevation="hover ? 12 : 2"
                :class="{ 'on-hover': hover, orange: hover }"
                color="blue darken-2"
                @click="alert(j)"
              >
                <v-card-title class="title white--text">
                  <v-row
                    class="fill-height flex-column"
                    justify="space-between"
                  >
                    <div class="align-self-center mt-2">
                      <v-btn
                        v-for="(icon, index) in icons"
                        :key="index"
                        :class="{ 'show-btns': hover }"
                        :color="transparent"
                        icon
                      >
                        <v-icon class="show-btns" :color="transparent">
                          {{ icon }}
                        </v-icon>
                      </v-btn>
                    </div>

                    <div>
                      <p class="mt-2 subheading text-center">
                        Lorem ipsum, dolor sit amet consectetur adipisicing
                        elit. Lorem, ipsum dolor.
                      </p>
                    </div>
                    <div>
                      <p
                        class="caption font-weight-medium font-italic text-center"
                      >
                        Valido hasta: dddd DD-MM-YYYY
                      </p>
                    </div>
                  </v-row>
                </v-card-title>
              </v-card>
            </v-hover>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  data: () => ({
    icons: ['mdi-rewind', 'mdi-play', 'mdi-fast-forward'],
    transparent: 'rgba(255, 255, 255, 0)',
  }),
  methods: {
    alert(index) {
      alert(`CLICK EN CARD, ${index}`)
    },
  },
}
</script>

<style scoped>
.v-card {
  transition: opacity 0.4s ease-in-out;
}

.v-card:not(.on-hover) {
  opacity: 0.6;
}

.show-btns {
  color: rgba(255, 255, 255, 1) !important;
}
</style>
