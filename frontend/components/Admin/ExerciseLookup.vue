<script lang="ts" setup>
import {ref, useApiFetch, watch} from '#imports'
import type {Exercise} from "~/types";

const $emit = defineEmits(['exercisePicked'])

const results = ref([]);

type exerciseRow = {
  id: number,
  label: string,
}

const search = async (query: string) => {
  try {
    if (!query) {
      results.value = [];
      return;
    }

    const response: any = await useApiFetch('/api/exercises?q=' + query)

    results.value = response.data.value.data
  } catch (e) {
    console.error(e);
  }
}

const foundExercises = computed(() => results.value.map((i: Exercise) => ({
  id: i.id,
  label: i.name,
} as exerciseRow)))

const groups = [{
  key: 'selected',
  search: async (q: string) => {
     await search(q);

     return foundExercises;
  }
}]

const pickExercise = (e: exerciseRow) => {
  const exercise = results.value.find((i: Exercise) => i.id === e.id)
  $emit('exercisePicked', { exercise })
  // selected.value = {};
}

const selected = ref([{}])
</script>

<template>
  <UCommandPalette
      :groups="groups"
      :autoselect="false"
      v-model="selected"
      @update:model-value="pickExercise"
  >
    <template #empty-state>
      <span></span>
    </template>
  </UCommandPalette>
</template>
