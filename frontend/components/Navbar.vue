<script lang="ts" setup>
import Button from "~/components/Form/Button.vue";
import Container from "~/components/Admin/Container.vue";
import {useAuthStore} from "~/stores/authStore"

const authStore = useAuthStore()
const colorMode = useColorMode()

const isDark = computed({
  get () {
    return colorMode.value === 'dark'
  },
  set () {
    colorMode.preference = colorMode.value === 'dark' ? 'light' : 'dark'
  }
})

const logout = () => navigateTo('/logout')
</script>

<template>
  <Container v-if="authStore.user">
    <nav class="w-full py-5 text-right flex flex-row-reverse">
      <UButton type="button" @click="logout" size="sm" class="ml-3" color="green">
        <UIcon name="i-heroicons-bolt-slash"></UIcon>
        Wyloguj
      </UButton>

      <UButton
          :icon="isDark ? 'i-heroicons-moon-solid' : 'i-heroicons-sun-solid'"
          color="gray"
          variant="ghost"
          @click="isDark = !isDark"
      >
        Zmień motyw
      </UButton>

      <div class="flex space-x-4 grow text-left">
        <UButton to="/admin/lessons" color="white">Lekcje</UButton>
        <UButton to="/admin/exercises" color="white">Ćwiczenia</UButton>
      </div>
    </nav>
  </Container>
</template>