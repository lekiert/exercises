<script setup lang="ts">
import useApiCall from "~/composables/useApiCall"
import LessonsTable from "~/components/Lesson/LessonsTable.vue";

definePageMeta({
  layout: 'admin',
});

const lessons = ref([]);

const getLessons = async () => {
  const { data, status, error } = await useApiCall('/api/lessons');

  if (status?.value === 'success') {
    lessons.value = data.value.data;
  }
}

onMounted(async () => {
  await getLessons();
});
</script>

<template>
    <LessonsTable :lessons="lessons" />
</template>
