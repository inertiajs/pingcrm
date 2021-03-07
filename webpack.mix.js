const path = require('path')
const mix = require('laravel-mix')
const cssImport = require('postcss-import')
const cssNesting = require('postcss-nesting')

// adding a constant for the @ path since it can't be resolved
// from aliases during output.
const componentPath = 'resources/js'

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
  .js('resources/js/app.js', 'public/js')
  .vue()
  .postCss('resources/css/app.css', 'public/css', [
    // prettier-ignore
    cssImport(),
    cssNesting(),
    require('tailwindcss'),
  ])
  .webpackConfig({
    output: {
      chunkFilename: (pathData) => {
        // first replace / with _ in component path
        let path = componentPath.replace('/', '_')
        // next replace this in our pathData ids
        let name = pathData.chunk.id.replace(path + '_Pages_', '').toLowerCase().replace(/_/g, '-')
        // set our chunk name to the proper name value
        pathData.chunk.name = name

        return 'js/[name].js?id=[chunkhash]'
      }
    },
    resolve: {
      alias: {
        vue$: 'vue/dist/vue.runtime.esm.js',
        '@': path.resolve(componentPath),
      },
    },
  })
  .version()
  .sourceMaps()
