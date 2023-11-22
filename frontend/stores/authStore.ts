import { defineStore } from 'pinia'

export const useAuthStore = defineStore('user', {
  state: () => ({
    user: null,
  }),
})
