<script setup lang="ts">
import useApiCall from "~/composables/useApiCall"
import LessonsTable from "~/components/Lesson/LessonsTable.vue";
import ExercisesTable from "~/components/Admin/ExercisesTable.vue";
import Container from "~/components/Admin/Container.vue";
import SectionHeader from "~/components/SectionHeader.vue";
import {useAlertsStore, useApiFetch} from "#imports";

definePageMeta({
  layout: 'admin',
  middleware: [
      'auth',
  ]
});

const alertsStore = useAlertsStore();
const lessons = ref([]);
const exercises = ref([]);

const getLessons = async () => {
  const { data, status, error } = await useApiCall('/api/lessons');

  if (status?.value === 'success') {
    lessons.value = data.value.data;
  }
}
const getExercises = async () => {
  const { data, status, error } = await useApiCall('/api/exercises', {
    query: {
      perPage: 10,
    }
  });

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

const selectedLessons = ref([])
const selectedExercises = ref([])

const deleteExercises = async () => {
  const removed: any = []

  for (const exercise of selectedExercises.value) {
    await useApiFetch('/api/exercises/' + exercise.id, {
      method: 'delete'
    })

    removed.push(exercise.name)
  }

  await getExercises()
  selectedExercises.value = [];

  alertsStore.success('Usunięto ćwiczenia', removed.join(', '))
}

const deleteLessons = async () => {
  const removed = [];

  for (const lesson of selectedLessons.value) {
    await useApiFetch('/api/lessons/' + lesson.id, {
      method: 'delete'
    })

    removed.push(lesson.name)
  }

  await getLessons()
  selectedLessons.value = [];

  alertsStore.success('Usunięto lekcje', removed.join(', '))
}
</script>

<template>
  <Container>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
      <UCard>
        <template #header>
          <SectionHeader>
            Lekcje

            <UButton @click="navigateTo('/admin/lesson/create')" class="float-right">
              <UIcon class="i-heroicons-plus"></UIcon>
              Dodaj
            </UButton>

            <UButton
                v-if="selectedLessons.length"
                @click="deleteLessons"
                color="red"
                class="float-right mr-3"
            >
              <UIcon class="i-heroicons-trash"></UIcon>
              Usuń zaznaczone
            </UButton>
          </SectionHeader>
        </template>

        <div class="clear-both">
          <LessonsTable :lessons="lessons" v-model="selectedLessons" />
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

            <UButton
                v-if="selectedExercises.length"
                @click="deleteExercises"
                color="red"
                class="float-right mr-3"
            >
              <UIcon class="i-heroicons-trash"></UIcon>
              Usuń zaznaczone
            </UButton>
          </SectionHeader>
        </template>

        <div class="clear-both">
          <ExercisesTable :exercises="exercises" v-model="selectedExercises" />
        </div>
      </UCard>
    </div>
  </Container>
</template>
