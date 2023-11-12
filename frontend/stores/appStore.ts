import { defineStore } from 'pinia'

export const useAppStore = defineStore('app', {
  state: () => ({
    inProgress: false,
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
