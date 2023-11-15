<script setup lang="ts">
import useApiCall from "~/composables/useApiCall"
import LessonsTable from "~/components/Lesson/LessonsTable.vue";
import ExercisesTable from "~/components/Admin/ExercisesTable.vue";
import Container from "~/components/Admin/Container.vue";
import SectionHeader from "~/components/SectionHeader.vue";

definePageMeta({
  layout: 'admin',
});

const lessons = ref([]);
const exercises = ref([]);

const getLessons = async () => {
  const { data, status, error } = await useApiCall('/api/lessons');

  if (status?.value === 'success') {
    lessons.value = data.value.data;
  }
}
const getExercises = async () => {
  const { data, status, error } = await useApiCall('/api/exercises');

  if (status?.value === 'success') {
    exercises.value = data.value.data;
  } else {
    console.log(data, status, error);
  }
}

onMounted(async () => {
  await getLessons();
  await getExercises();
});
</script>

<template>
  <Container>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
      <UCard>
        <template #header>
          <SectionHeader>
            Lekcje

            <UButton @click="navigateTo('/admin/lesson/create')" class="float-right">
              <UIcon class="i-heroicons-plus"></UIcon>
              Dodaj
            </UButton>
          </SectionHeader>
        </template>

        <div class="clear-both">
          <LessonsTable :lessons="lessons" />
        </div>
      </UCard>

      <UCard>
        <template #header>
          <SectionHeader>
            Ćwiczenia

            <UButton @click="navigateTo('/admin/exercise/create')" class="float-right">
              <UIcon class="i-heroicons-plus"></UIcon>
              Dodaj
            </UButton>
          </SectionHeader>
        </template>

        <div class="clear-both">
          <ExercisesTable :exercises="exercises" />
        </div>
      </UCard>
    </div>
  </Container>
</template>
