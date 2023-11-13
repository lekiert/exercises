<script setup lang="ts">
import {onMounted, useApiFetch, useCookie, useRuntimeConfig, useRoute, ref, definePageMeta} from "#imports";
import FormRow from "~/components/FormRow.vue";
import BackLink from "~/components/Admin/BackLink.vue";
import Container from "~/components/Admin/Container.vue";
import ExerciseLookup from "~/components/Admin/ExerciseLookup.vue";

const config = useRuntimeConfig()
const route = useRoute()
const token = useCookie('XSRF-TOKEN')

definePageMeta({
  layout: 'admin',
});

const lesson = ref<Lesson>({
  id: null,
  name: '',
  description: '',
  exercises: [],
});

const getLesson = async () => {
  try {
    const response = await useApiFetch('/api/lessons/' + route.params.id)

    lesson.value = response.data.value.lesson as Lesson
  } catch (e) {
    console.error(e);
  }
};

const addExercise = (exercise: any) => {
  if (lesson.value.exercises.find(e => e.id === exercise.id)) {
    return;
  }

  lesson.value.exercises.push(exercise)
}

const removeExercise = (index) => {
  lesson.value.exercises.splice(index, 1)
}

const save = async () => {
  try {
    const response = await useApiFetch('/api/lessons/' + route.params.id, {
      method: 'PUT',
      body: {
        lesson: lesson.value
      }
    })
  } catch (e) {
    console.error(e);
  }
};

onMounted(async () => {
  await getLesson();
});

</script>

<template>
  <BackLink />

  <Container>
    <form>
      <FormRow>
        <label for="lesson-name-id" class="form-label">Nazwa</label>
        <input class="form-control" type="text" id="lesson-name-id" v-model="lesson.name" />
      </FormRow>

      <FormRow>
        <label for="lesson-description-id" class="form-label">Polecenie</label>
        <textarea class="form-control" name="lesson[description]" id="lesson-description-id"
                  v-model="lesson.description"></textarea>
      </FormRow>

      <FormRow>
        <label>Ćwiczenia</label>
        <table class="table" v-show="lesson.exercises.length">
          <tbody>
          <tr v-for="(exercise, index) in lesson.exercises">
            <td>
              {{ exercise.name }}
            </td>
            <td class="text-right">
              <a :href="'/admin/exercises/' + exercise.id" class="btn btn-primary mr-2">edytuj</a>
              <a href="#" @click="removeExercise(index)" class="btn btn-danger">usuń</a>
            </td>
          </tr>
          </tbody>
        </table>

        <p class="text-muted" v-show="!lesson.exercises.length">Brak przypisanych ćwiczeń</p>
      </FormRow>

      <FormRow>
        <label>Dodaj ćwiczenie</label>
        <ExerciseLookup @exercisePicked="addExercise($event.exercise)" />
      </FormRow>

      <FormRow class="text-right">
        <button class="btn btn-primary" type="submit" @click.prevent="save">Zapisz</button>
      </FormRow>
    </form>
  </Container>
</template>
