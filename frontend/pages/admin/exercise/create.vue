<script setup lang="ts">
import {useApiFetch, useCookie, useRuntimeConfig, ref, definePageMeta, navigateTo} from "#imports";
import FormRow from "~/components/FormRow.vue";
import type {Exercise} from "~/types";
import Container from "~/components/Admin/Container.vue";
import BackLink from "~/components/Admin/BackLink.vue";
import PageHeader from "~/components/PageHeader.vue";

const config = useRuntimeConfig()
const token = useCookie('XSRF-TOKEN')

definePageMeta({
  layout: 'admin',
});

const exercise = ref(<Exercise>{
  name: '',
  description: '',
  type: '',
  definition: {},
  solution: {},
});

const submit = async () => {
  try {
    const response = await useApiFetch(config.public.apiUrl + '/api/exercises', {
      method: 'POST',
      body: {
        exercise: exercise.value
      }
    })

    navigateTo('/admin/exercise/' + response.data.value.exercise.id);
  } catch (e) {
    console.error(e);
  }
};

const types = [
  {
    name: 'Luki',
    value: 'brackets'
  }, {
    name: 'Quiz',
    value: 'quiz'
  }
];
</script>

<template>
  <Container>
    <BackLink />

    <UCard>
      <template #header>
        <PageHeader>Dodaj ćwiczenie</PageHeader>
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
          <USelect id="form-type-id" v-model="exercise.type" :options="types" option-attribute="name" />
        </FormRow>

        <FormRow class="text-right">
          <UButton type="submit" @click.prevent="submit">Dodaj</UButton>
        </FormRow>
      </form>
    </UCard>
  </Container>
</template>
