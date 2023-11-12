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
    '@pinia/nuxt',
  ],
  ssr: false,
  css: [
    'bootstrap/dist/css/bootstrap.css',
    '~/assets/scss/main.css'
  ],
})
