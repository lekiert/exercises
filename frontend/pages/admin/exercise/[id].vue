<script setup lang="ts">
import {onMounted, useApiFetch, useCookie, useRuntimeConfig, useRoute, ref, definePageMeta} from "#imports";
import FormRow from "~/components/FormRow.vue";
import BracketsForm from "~/components/Admin/ExerciseForm/BracketsForm.vue";
import QuizForm from "~/components/Admin/ExerciseForm/QuizForm.vue";

const config = useRuntimeConfig()
const route = useRoute()

definePageMeta({
  layout: 'admin',
});

const exercise = ref<Exercise>({
  id: null,
  name: '',
  description: '',
  definition: {},
  solution: {},
})

const getExercise = async () => {
  try {
    const response = await useApiFetch('/api/exercises/' + route.params.id)

    exercise.value = response.data.value.exercise as Exercise
  } catch (e) {
    console.error(e)
  }
}

const updateExercise = async ($event) => {
  exercise.value.definition = $event.definition
  exercise.value.solution = $event.solution
}

const save = async () => {
  try {
    const response = await useApiFetch('/api/exercises/' + route.params.id, {
      method: 'PUT',
      body: {
        exercise: exercise.value
      }
    })
  } catch (e) {
    console.error(e)
  }
};

onMounted(async () => {
  await getExercise();
});

</script>

<template>
  <div class="row g-5">
    <div class="col-lg-9 col-md-12 mx-auto p-3">
      <form>
        <FormRow>
          <label for="exercise-name-id" class="form-label">Nazwa</label>
          <input class="form-control" type="text" id="exercise-name-id" v-model="exercise.name" />
        </FormRow>

        <FormRow>
          <label for="exercise-description-id" class="form-label">Polecenie</label>
          <textarea class="form-control" name="exercise[description]" id="exercise-description-id"
                    v-model="exercise.description"></textarea>
        </FormRow>

        <FormRow>
          <label for="exercise-type-id" class="form-label">Typ</label>
          <input class="form-control" type="text" id="exercise-name-id" :value="exercise.type" disabled />
        </FormRow>

        <FormRow>
          <BracketsForm :exercise="exercise" v-if="exercise.type === 'brackets'"
                        @exerciseUpdated="updateExercise($event)"></BracketsForm>
          <QuizForm :exercise="exercise" v-if="exercise.type === 'quiz'"
                    @exerciseUpdated="updateExercise($event)"></QuizForm>
        </FormRow>

        <button class="btn btn-primary" type="submit" @click.prevent="save">Zapisz</button>
      </form>
    </div>
  </div>
</template>
