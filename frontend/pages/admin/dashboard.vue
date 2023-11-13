<script setup lang="ts">
import useApiCall from "~/composables/useApiCall"
import LessonsTable from "~/components/Lesson/LessonsTable.vue";
import ExercisesTable from "~/components/Admin/ExercisesTable.vue";
import Container from "~/components/Admin/Container.vue";

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
    <div class="row">
      <div class="col-xl-6 col-md-12">
        <div class="mb-3">
          <h4>
            Ostatnie lekcje
            <a href="/admin/lesson/create" class="btn btn-primary float-end">dodaj</a>
          </h4>
        </div>

        <LessonsTable :lessons="lessons" />
      </div>

      <div class="col-lg-6 col-md-12">
        <div class="mb-3">
          <h4>
            Ćwiczenia
            <a href="/admin/exercise/create" class="btn btn-primary float-end">dodaj</a>
          </h4>
        </div>

        <ExercisesTable :exercises="exercises" />
      </div>
    </div>
  </Container>
</template>
