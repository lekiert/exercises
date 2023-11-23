import {useApiFetch} from "#imports"

export default defineNuxtRouteMiddleware(async (to, from) => {
  if (to.path.endsWith('admin')) {
    return navigateTo('/admin/dashboard')
  }
})