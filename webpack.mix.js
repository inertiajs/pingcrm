/* eslint-disable no-undef */
const mix = require('laravel-mix')
require('vuetifyjs-mix-extension')

mix
  .js('resources/js/app.js', 'public/js')
  .vue({ version: 2 })
  .vuetify()
  .sass('resources/sass/app.sass', 'public/css')
  .webpackConfig(require('./webpack.config'))

if (mix.inProduction()) {
  mix.version()
}
