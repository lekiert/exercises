// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  imports: {
    dirs: [
      // Scan top-level modules
      'composables',
    ],
  },
  include: [
    'types.d.ts',
  ],
  runtimeConfig: {
    public: {
      apiUrl: process.env.API_URL,
    }
  },
  modules: [
    '@nuxt/ui',
    '@nuxtjs/color-mode',
    '@pinia/nuxt',
  ],
  ssr: false,
  css: [
    '~/assets/scss/main.scss',
  ],
  vite: {
    css: {
      preprocessorOptions: {
        scss: {
          additionalData: '@use "@/assets/_colors.scss" as *;'
        }
      }
    }
  }
})
