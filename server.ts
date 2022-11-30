import path from 'node:path'
import { readFileSync } from 'node:fs'
import { CompatibilityEvent, createApp } from 'h3'
import { listen } from 'listhen'
import type { ViteDevServer } from 'vite'

const root = process.cwd()
const isTest = process.env.NODE_ENV === 'test' || !!process.env.VITE_TEST_BUILD
const isProd = process.env.NODE_ENV === 'production'

async function createServer() {
  let vite: ViteDevServer
  const app = createApp({
    debug: isTest || !isProd,
  })
  const resolve = (p: string) => path.resolve(__dirname, p)

  const manifest = isProd ? require('./dist/client/ssr-manifest.json') : {}
  const indexProd = isProd ? readFileSync(resolve('dist/client/index.html'), 'utf-8') : ''

  if (!isProd) {
    vite = await require('vite').createServer({
      root,
      appType: 'custom',
      server: {
        middlewareMode: true,
        watch: {
          usePolling: true,
          interval: 100,
        },
      },
    })

    app.use(vite.middlewares)
  } else {
    app.use(require('compression')())
    app.use(
      require('serve-static')(resolve('dist/client'), {
        index: false,
        fallthrough: true,
      }),
    )
  }

  app.use('*', async (event: CompatibilityEvent) => {
    try {
      const url = event.req.url

      // send empty error 404 if it's a static file
      const [pathname] = url.split('?')
      const ext = pathname.split('.')
      if (ext.length > 1) {
        if (!event.res.headersSent) {
          event.res.setHeader('Cache-Control', 'no-cache, no-store, must-revalidate')
        }
        return null
      }

      let template: string
      let init: (event: CompatibilityEvent) => void | Promise<void>
      let render: (
        url: string,
        manifest: any,
      ) => Promise<{
        found: boolean
        appHtml: string
        headTags: string
        htmlAttrs: string
        bodyAttrs: string
        preloadLinks: string
        initialState: string
      }>

      if (!isProd) {
        // always read fresh template in dev
        template = readFileSync(resolve('index.html'), 'utf-8')
        template = await vite.transformIndexHtml(url, template)
        render = (await vite.ssrLoadModule('/src/entry-server.ts')).render
        init = (await vite.ssrLoadModule('/src/entry-server.ts')).init
      } else {
        template = indexProd
        render = require('./dist/server/entry-server.mjs').render
        init = require('./dist/server/entry-server.mjs').init
      }

      init(event)
      const { found, appHtml, headTags, htmlAttrs, bodyAttrs, preloadLinks, initialState } = await render(url, manifest)

      const html = template
        .replace(`<html>`, `<html${htmlAttrs}>`)
        .replace(`<head>`, `<head><meta charset="UTF-8" />${headTags}`)
        .replace(`</head>`, `${preloadLinks}</head>`)
        .replace(`<body>`, `<body${bodyAttrs}>`)
        .replace(/<div id="app"([\s\w\-"'=[\]]*)><\/div>/, `<div id="app" data-server-rendered="true"$1>${appHtml}</div><script>window.__pingCrm__=${initialState}</script>`)

      // send error 404 page
      if (!found) {
        if (!event.res.headersSent) {
          event.res.setHeader('Content-Type', 'text/html')
          event.res.setHeader('Cache-Control', 'no-cache, no-store, must-revalidate')
          event.res.writeHead(404)
        }
        return html
      }

      // send page
      return html
    } catch (e) {
      // send error 500 page
      vite?.ssrFixStacktrace(e)
      console.error(e)

      if (!isProd) {
        if (!event.res.headersSent) {
          event.res.setHeader('Cache-Control', 'no-cache, no-store, must-revalidate')
          event.res.writeHead(500)
          event.res.end(e.message)
        }
        return
      } else {
        if (!event.res.headersSent) {
          event.res.setHeader('Cache-Control', 'no-cache, no-store, must-revalidate')
          event.res.writeHead(500)
          event.res.end('Internal Server Error')
        }
        return
      }
    }
  })

  return { app, vite }
}

if (!isTest) {
  createServer()
    .then(({ app }) => listen(app))
    .catch(console.error)
}
