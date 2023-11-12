<script setup lang="ts">
import {
  onMounted,
  useApiFetch,
  useCookie,
  useRuntimeConfig,
  useRoute,
  ref,
  definePageMeta,
  useAlertsStore
} from "#imports";
import FormRow from "~/components/FormRow.vue";
import BracketsForm from "~/components/Admin/ExerciseForm/BracketsForm.vue";
import QuizForm from "~/components/Admin/ExerciseForm/QuizForm.vue";
import {useAppStore} from "~/stores/appStore";

const config = useRuntimeConfig()
const route = useRoute()
const alertStore = useAlertsStore()
const appStore = useAppStore()

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
    appStore.setInProgress()
    const response = await useApiFetch('/api/exercises/' + route.params.id)
    exercise.value = response.data.value.exercise as Exercise
  } catch (e) {
    console.error(e)
    alertStore.error('Failed to get exercise')
  } finally {
    appStore.clearInProgress()
  }
}

const updateExercise = async ($event) => {
  exercise.value.definition = $event.definition
  exercise.value.solution = $event.solution
}

const save = async () => {
  try {
    appStore.setInProgress()

    const { response, status } = await useApiFetch('/api/exercises/' + route.params.id, {
      method: 'PUT',
      body: {
        exercise: exercise.value
      }
    })

    if (status.value === 'error') {
      alertStore.error('Internal error')
    } else {
      alertStore.success('Exercise updated')
    }

  } catch (e) {
    console.error(e)

    alertStore.error('Internal error')
  } finally {
    appStore.clearInProgress();
  }
};

onMounted(async () => {
  await getExercise();
});

</script>

<template>
  <div class="row g-5 mb-5">
    <div class="col-lg-9 col-md-12 pt-5">
      <a href="/admin/dashboard">Powrót</a>
      <hr>
    </div>
  </div>

  <div class="row g-5 mb-5">
    <div class="col-lg-9 col-md-12">
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

        <button class="btn btn-primary" type="submit" @click.prevent="save"
          :disabled="appStore.inProgress">Zapisz</button>
      </form>
    </div>
  </div>
</template>
