<script lang="ts" setup>
const props = defineProps(['to'])

const go = () => navigateTo(props.to || '/admin/dashboard')
</script>

<template>
  <div class="mb-6">
    <UButton @click="go">
      <UIcon class="i-heroicons-chevron-left" />
      Powrót
    </UButton>
  </div>
</template>