import type { Plugin } from 'vite'

const PLUGIN_NAME = 'vite:inertia:layout'
const TEMPLATE_LAYOUT_REGEX = /<template +layout(?: *= *['"]([-_\w/]+)['"] *)?>/

/**
 * A basic Vite plugin that adds a <template layout="name"> syntax to Vite SFCs.
 * It must be used before the Vue plugin.
 */
export default (layouts: string = '@/Layouts/'): Plugin => ({
	name: PLUGIN_NAME,
	transform: (code: string) => {
		if (!TEMPLATE_LAYOUT_REGEX.test(code)) {
			return
		}

		const isTypeScript = /lang=['"]ts['"]/.test(code)

		return code.replace(TEMPLATE_LAYOUT_REGEX, (_, layoutName) => `
			<script${isTypeScript ? ' lang="ts"' : ''}>
			import layout from '${layouts}${layoutName ?? 'default'}.vue'
			export default { layout }
			</script>
			<template>
		`)
	},
})
