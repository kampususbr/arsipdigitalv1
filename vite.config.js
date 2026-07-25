import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel(['resources/css/app.css', 'resources/js/app.js']),
    vue()
  ],
  server: {
    hmr: {
      host: 'localhost',
      port: 5173,
    },
  },
})