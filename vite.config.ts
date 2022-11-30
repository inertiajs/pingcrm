import { defineConfig } from 'vite'
import laravel from 'vite-plugin-laravel'
import vue from '@vitejs/plugin-vue'
import inertia from './resources/scripts/vite/inertia-layout'

export default defineConfig({
	plugins: [
		inertia(),
		vue(),
		laravel(),
	],
})
