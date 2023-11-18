<script setup lang="ts">
import ExercisesTable from "~/components/Admin/ExercisesTable.vue";
import Container from "~/components/Admin/Container.vue";
import SectionHeader from "~/components/SectionHeader.vue";
import {useAlertsStore, useApiFetch} from "#imports";
import FormInput from "~/components/Form/FormInput.vue";
import Button from "~/components/Form/Button.vue";
import {debounce} from "@antfu/utils";
import ExerciseService from "~/services/admin/ExerciseService";
import Pagination from "~/components/UI/Pagination.vue";
import BackLink from "~/components/Admin/BackLink.vue";

definePageMeta({
  layout: 'admin',
});

const alertsStore = useAlertsStore();
const exercises = ref([]);
const selectedExercises = ref([])
const search = ref('')
const currentPage = ref(1)
const pageSize = ref(25)
const pageCount = ref(0)
const service = new ExerciseService()

const getExercises = debounce(1000, async () => {
  const response = await service.getExercises(search.value, currentPage.value, pageSize.value)
  exercises.value = response.data
  pageCount.value = response.pageCount
})

const deleteExercises = async () => {
  const removed: Array<string> = []

  await useApiFetch('/api/exercises/bulk-delete', {
    method: 'post',
    body: {
      ids: selectedExercises.value.map(e => e.id)
    }
  })

  for (const exercise of selectedExercises.value) {
    removed.push(exercise.name)
  }

  await getExercises()
  selectedExercises.value = [];

  alertsStore.success('Usunięto ćwiczenia', removed.join(', '))
}

const onPageChanged = (page: number) => {
  currentPage.value = page
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

const makePageSize = (size: number) => [{ label: size, click: () => { pageSize.value = size } }]

const pageSizes = [
  makePageSize(25),
  makePageSize(50),
  makePageSize(100),
]

onMounted(async () => {
  await getExercises()
});

watch(currentPage, async () => await getExercises())
watch(pageSize, async () => await getExercises())
</script>

<template>
  <Container>
    <BackLink />

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

        <div class="mt-6">
          <FormInput placeholder="Szukaj..." v-model="search" @input="getExercises" @keyup="getExercises" />
        </div>
      </template>

      <div class="clear-both">
        <ExercisesTable :exercises="exercises" v-model="selectedExercises" />
      </div>

      <div class="mt-3 flex space-x-6">
        <Pagination
            class="grow"
            :current-page="currentPage"
            :page-count="pageCount"
            @pageChanged="onPageChanged"
        />

        <div class="w-32 flex-none text-right">
          <UDropdown :items="pageSizes">
            <UButton color="white">
              {{ pageSize }} <UIcon name="i-heroicons-chevron-down" />
            </UButton>
          </UDropdown>
        </div>
      </div>
    </UCard>
  </Container>
</template>
