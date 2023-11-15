<script setup lang="ts">
import type {Lesson} from "~/types";
import useFormatDate from "~/composables/useFormatDate";
import TextLink from "~/components/TextLink.vue";

const props = defineProps(['lessons']);

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

const rows = computed(() => props.lessons.map((l: Lesson) => ({
  id: l.id,
  name: l.name,
  created_at: useFormatDate(l.created_at as string)
})))
</script>

<template>
  <UTable :rows="rows" :columns="columns">
    <template #name-data="{ row }">
      <TextLink :href="'/admin/lesson/' + row.id" active-class="text-primary">{{ row.name }}</TextLink>
    </template>
  </UTable>
</template>
