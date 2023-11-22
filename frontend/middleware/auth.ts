import {useApiFetch} from "#imports"
import {useAuthStore} from "~/stores/authStore"
import {User} from "@/types"

const authStore = useAuthStore()

export default defineNuxtRouteMiddleware(async (to, from) => {
  if (authStore.user) {
    return;
  }

  const response = await useApiFetch('/api/user')

  if (response.status.value === 'error') {
    return navigateTo('/login');
  }

  authStore.user = response.data.value.user as User
})