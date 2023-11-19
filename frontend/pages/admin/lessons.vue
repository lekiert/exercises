
<script setup lang="ts">
import LessonsTable from "~/components/Admin/LessonsTable.vue";
import Container from "~/components/Admin/Container.vue";
import SectionHeader from "~/components/SectionHeader.vue";
import {useAlertsStore, useApiFetch} from "#imports";
import FormInput from "~/components/Form/FormInput.vue";
import Button from "~/components/Form/Button.vue";
import {debounce} from "@antfu/utils";
import Pagination from "~/components/UI/Pagination.vue";
import BackLink from "~/components/Admin/BackLink.vue";
import LessonService from "~/services/admin/LessonService";

definePageMeta({
  layout: 'admin',
});

const alertsStore = useAlertsStore();
const lessons = ref([]);
const selectedLessons = ref([])
const search = ref('')
const currentPage = ref(1)
const pageSize = ref(25)
const pageCount = ref(0)
const service = new LessonService()

const getLessons = debounce(1000, async () => {
  const response = await service.getLessons(search.value, currentPage.value, pageSize.value)
  lessons.value = response.data
  pageCount.value = response.pageCount
})

const deleteLessons = async () => {
  const removed: Array<string> = []

  await useApiFetch('/api/lessons/bulk-delete', {
    method: 'post',
    body: {
      ids: selectedLessons.value.map(e => e.id)
    }
  })

  for (const lesson of selectedLessons.value) {
    removed.push(lesson.name)
  }

  await getLessons()
  selectedLessons.value = [];

  alertsStore.success('Usunięto lekcje', removed.join(', '))
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
  await getLessons()
});

watch(currentPage, async () => await getLessons())
watch(pageSize, async () => await getLessons())
</script>

<template>
  <Container>
    <BackLink />

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

        <div class="mt-6">
          <FormInput placeholder="Szukaj..." v-model="search" @input="getLessons" @keyup="getLessons" />
        </div>
      </template>

      <div class="clear-both">
        <lessonsTable :lessons="lessons" v-model="selectedLessons" />
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
