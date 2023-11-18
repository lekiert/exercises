<script lang="ts" setup>
import Button from "~/components/Form/Button.vue";

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
  <nav class="w-full p-5 text-right flex flex-row-reverse">
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

    <div class="grow text-left">
      <ULink to="/admin/exercises">Ćwiczenia</ULink>
    </div>
  </nav>
</template>