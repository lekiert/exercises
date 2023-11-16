<script setup lang="ts">
import {
  onMounted,
  useApiFetch,
  useCookie,
  useRuntimeConfig,
  useRoute,
  ref,
  definePageMeta,
  useAlertsStore, useAppStore
} from "#imports";
import FormRow from "~/components/FormRow.vue";
import BackLink from "~/components/Admin/BackLink.vue";
import Container from "~/components/Admin/Container.vue";
import ExerciseLookup from "~/components/Admin/ExerciseLookup.vue";
import type {Exercise, Lesson} from "~/types";

const config = useRuntimeConfig()
const appStore = useAppStore()
const alertStore = useAlertsStore()
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
} as Lesson);

const getLesson = async () => {
  try {
    appStore.setInProgress()

    const response = await useApiFetch('/api/lessons/' + route.params.id)

    lesson.value = response.data.value.lesson as Lesson
  } catch (e) {
    console.error(e);
    alertStore.error('Nie udało się wyświetlić ćwiczenia')
  } finally {
    appStore.clearInProgress()
  }
};

const addExercise = (exercise: any) => {
  if (lesson.value.exercises.find((e: Exercise) => e.id === exercise.id)) {
    return;
  }

  lesson.value.exercises.push(exercise)
}

const removeExercise = (row: any) => {
  const index = lesson.value.exercises.findIndex((i) => i.id === row.id)
  if (index > -1) {
    lesson.value.exercises.splice(index, 1)
  }
}

const save = async () => {
  try {
    appStore.setInProgress()

    const { response, status } = await useApiFetch('/api/lessons/' + route.params.id, {
      method: 'PUT',
      body: {
        lesson: lesson.value
      }
    })

    if (status.value === 'error') {
      alertStore.error('Błąd wewnętrzny')
    } else {
      alertStore.success('Zaktualizowano dane')
    }
  } catch (e) {
    console.error(e);
  } finally {
    appStore.clearInProgress()
  }
}

const lessonExercises = computed(() => lesson.value.exercises.map((e: Exercise) => ({
  id: e.id,
  name: e.name,
})))

const lessonExerciseColumns = [
  {
    key: 'id',
    label: 'ID',
  }, {
    key: 'name',
    label: 'Nazwa',
  }, {
    key: 'actions',
  }
]

const exerciseActions = (row: any) => [
  [{
    label: 'Usuń',
    icon: 'i-heroicons-remove',
    click: () => removeExercise(row)
  }]
];

const deleteLesson = async () => {
  const { status } = await useApiFetch('/api/lessons/' + lesson.value.id, {
    method: 'delete',
  })

  if (status.value === 'error') {
    alertStore.error('Błąd wewnętrzny')
  } else {
    navigateTo('/admin/dashboard')
  }
}

onMounted(async () => {
  await getLesson();
});
</script>

<template>
  <Container>
    <BackLink />

    <UCard>
      <template #header>
        <SectionHeader>
          Edytuj lekcję
        </SectionHeader>
      </template>

      <form>
        <FormRow>
          <label for="lesson-name-id" class="form-label">Nazwa</label>
          <UInput type="text" id="lesson-name-id" v-model="lesson.name" />
        </FormRow>

        <FormRow>
          <label for="lesson-description-id" class="form-label">Polecenie</label>
          <UTextarea name="lesson[description]" id="lesson-description-id"
                    v-model="lesson.description"></UTextarea>
        </FormRow>

        <FormRow>
          <label>Ćwiczenia</label>

          <UTable :rows="lessonExercises" :columns="lessonExerciseColumns">
            <template #name-data="{ row }">
              <TextLink :href="'/admin/exercise/' + row.id">{{ row.name }}</TextLink>
            </template>

            <template #actions-data="{ row }">
              <UDropdown :items="exerciseActions(row)">
                <UButton color="gray" variant="ghost" icon="i-heroicons-ellipsis-horizontal-20-solid" />
              </UDropdown>
            </template>
          </UTable>
        </FormRow>

        <FormRow>
          <label>Dodaj ćwiczenie</label>
          <ExerciseLookup @exercisePicked="addExercise($event.exercise)" />
        </FormRow>

        <FormRow class="text-right">
          <UButton @click="deleteLesson" color="red">
            <UIcon name="i-heroicons-trash"></UIcon>
            Usuń
          </UButton>

          <UButton type="submit" @click.prevent="save" class="ml-3">
            <UIcon class="i-heroicons-check" />
            Zapisz
          </UButton>
        </FormRow>
      </form>
    </UCard>
  </Container>
</template>
