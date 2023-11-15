<script setup lang="ts">
import type {Exercise} from "~/types";
import useFormatDate from "~/composables/useFormatDate";
import TextLink from "~/components/TextLink.vue";

const props = defineProps(['exercises'])

const columns = [{
  key: 'id',
  label: 'ID'
}, {
  key: 'name',
  label: 'Nazwa'
}, {
  key: 'created_at',
  label: 'Utworzone'
}]

const rows = computed(() => props.exercises.map((e: Exercise) => ({
  id: e.id,
  name: e.name,
  created_at: useFormatDate(e.created_at as string)
})))
</script>

<template>
  <UTable :rows="rows" :columns="columns">
    <template #name-data="{ row }">
      <TextLink :href="'/admin/exercise/' + row.id" active-class="text-primary">{{ row.name }}</TextLink>
    </template>
  </UTable>
</template>
