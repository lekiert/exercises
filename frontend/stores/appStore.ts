import { defineStore } from 'pinia'

export const useAppStore = defineStore('app', {
  state: () => ({
    inProgress: false,
    isDarkMode: false,
  }),
  actions: {
    setInProgress() {
      this.inProgress = true;
    },

    clearInProgress() {
      this.inProgress = false;
    }
  },
})
