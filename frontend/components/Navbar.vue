<script lang="ts" setup>
const colorMode = useColorMode()

const isDark = computed({
  get () {
    return colorMode.value === 'dark'
  },
  set () {
    colorMode.preference = colorMode.value === 'dark' ? 'light' : 'dark'
  }
})
</script>

<template>
  <nav class="w-full p-5 text-right flex flex-row-reverse">
    <UButton to="/logout" size="sm" class="ml-3">
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
  </nav>
</template>