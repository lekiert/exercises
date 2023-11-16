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
import BackLink from "~/components/Admin/BackLink.vue";
import Container from "~/components/Admin/Container.vue";
import type {Exercise, Lesson} from "~/types";

const config = useRuntimeConfig()
const route = useRoute()
const alertStore = useAlertsStore()
const appStore = useAppStore()

definePageMeta({
  layout: 'admin',
});

const exercise = ref<Exercise>({
  id: null,
  type: '',
  name: '',
  description: '',
  definition: {},
  solution: {},
} as Exercise)

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

const updateExercise = async ($event: any) => {
  exercise.value.definition = $event.definition
  exercise.value.solution = $event.solution
}

const save = async () => {
  try {
    appStore.setInProgress()

    const { data, status } = await useApiFetch('/api/exercises/' + route.params.id, {
      method: 'PUT',
      body: {
        exercise: exercise.value
      }
    })

    console.log(data);

    exercise.value = data.value.exercise as Exercise

    if (status.value === 'error') {
      alertStore.error('Błąd wewnętrzny')
    } else {
      alertStore.success('Zaktualizowano ćwiczenie')
    }

  } catch (e) {
    console.error(e)

    alertStore.error('Internal error')
  } finally {
    appStore.clearInProgress();
  }
};

const deleteExercise = async () => {
  const { status } = await useApiFetch('/api/exercises/' + exercise.value.id, {
    method: 'delete',
  })

  if (status.value === 'error') {
    alertStore.error('Błąd wewnętrzny')
  } else {
    navigateTo('/admin/dashboard')
  }
}

onMounted(async () => {
  await getExercise();
});

</script>

<template>
  <Container>
    <UCard>
      <BackLink />

      <template #header>
        <SectionHeader>
          Edytuj ćwiczenie
        </SectionHeader>
      </template>

      <form>
        <FormRow>
          <label for="exercise-name-id" class="form-label">Nazwa</label>
          <UInput type="text" id="exercise-name-id" v-model="exercise.name" />
        </FormRow>

        <FormRow>
          <label for="exercise-description-id" class="form-label">Polecenie</label>
          <UTextarea name="exercise[description]" id="exercise-description-id"
                    v-model="exercise.description"></UTextarea>
        </FormRow>

        <FormRow>
          <label for="exercise-type-id" class="form-label">Typ</label>
          <UInput type="text" id="exercise-name-id" :value="exercise.type" disabled />
        </FormRow>

        <FormRow>
          <BracketsForm :exercise="exercise" v-if="exercise.type === 'brackets'"
                        @exerciseUpdated="updateExercise($event)"></BracketsForm>
          <QuizForm :exercise="exercise" v-if="exercise.type === 'quiz'"
                    @exerciseUpdated="updateExercise($event)"></QuizForm>
        </FormRow>

        <FormRow class="text-right">
          <UButton @click="deleteExercise" color="red">
            <UIcon name="i-heroicons-trash"></UIcon>
            Usuń
          </UButton>

          <UButton type="submit" @click.prevent="save" class="ml-3"
                  :disabled="appStore.inProgress">Zapisz</UButton>
        </FormRow>
      </form>
    </UCard>
  </Container>
</template>
