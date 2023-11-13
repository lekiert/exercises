<script lang="ts" setup>
import {ref, useApiFetch, watch} from '#imports'
import {debounce} from "@antfu/utils";

const $emit = defineEmits(['exercisePicked'])

const query = ref('');
const results = ref([]);

const search = async () => {
  try {
    if (!query.value) {
      results.value = [];
      return;
    }

    const response = await useApiFetch('/api/exercises?q=' + query.value)

    results.value = response.data.value.data
  } catch (e) {
    console.error(e);
  }
}

watch(query, debounce(1000, search))
</script>

<template>
  <input type="text" class="form-control" v-model="query" />

  <ul>
    <li v-for="exercise in results">
      <a href="#" @click="$emit('exercisePicked', { exercise })">{{ exercise.name }}</a>
    </li>
  </ul>
</template>
