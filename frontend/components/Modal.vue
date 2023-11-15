<script lang="ts" setup>
import {useAlertsStore, ref} from "#imports";

const alertsStore = useAlertsStore();

let isOpen = ref(false);

alertsStore.$subscribe((mutation, state) => {
  if (state.type) {
    isOpen.value = true;
  }
})
</script>

<template>
  <UModal v-model="isOpen" prevent-close>
    <UCard>
      <template #header>
        <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">
          {{ alertsStore.message }}
        </h3>
      </template>

      <div class="p-4" v-if="alertsStore.description">
        <p>{{ alertsStore.description }}</p>
      </div>

      <template #footer>
        <div class="text-right">
          <UButton @click="isOpen = false; alertsStore.hide()">
            <UIcon class="i-heroicons-x-mark" />
            Zamknij
          </UButton>
        </div>
      </template>
    </UCard>
  </UModal>
</template>