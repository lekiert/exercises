<script lang="ts" setup>
const props = defineProps(['currentPage', 'pageCount'])
const $emit = defineEmits(['pageChanged'])

const pages = computed(() => Array.from(Array(props.pageCount).keys()).map(k => k + 1))
</script>

<template>
<div class="flex space-x-2">
  <UButton
      v-for="page in pages" :color="page !== currentPage ? 'white' : undefined"
      @click="$emit('pageChanged', page)"
  >
    {{ page }}
  </UButton>
</div>
</template>