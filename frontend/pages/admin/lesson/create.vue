<script setup lang="ts">
import {useApiFetch, useCookie, useRuntimeConfig, ref, definePageMeta, navigateTo} from "#imports";
import type {Lesson} from "~/types";
import BackLink from "~/components/Admin/BackLink.vue";
import Container from "~/components/Admin/Container.vue";
import PageHeader from "~/components/PageHeader.vue";

const config = useRuntimeConfig()
const token = useCookie('XSRF-TOKEN')

definePageMeta({
  layout: 'admin',
});

const lesson = ref(<Lesson>{
  id: null,
  name: '',
  description: '',
});

const submit = async () => {
  try {
    const response: any = await useApiFetch(config.public.apiUrl + '/api/lessons', {
      method: 'POST',
      body: {
        lesson: lesson.value
      }
    })

    navigateTo('/admin/lesson/' + response.data.value.lesson.id);
  } catch (e) {
    console.error(e);
  }
};
</script>

<template>
  <Container>
    <BackLink />

    <UCard>
      <template #header>
        <PageHeader>Dodaj lekcję</PageHeader>
      </template>

      <form>
        <FormRow>
          <label for="lesson-name-id" class="form-label">Nazwa</label>
          <UInput id="lesson-name-id" v-model="lesson.name" />
        </FormRow>

        <FormRow>
          <label for="lesson-description-id" class="form-label">Polecenie</label>
          <UTextarea id="lesson-description-id" v-model="lesson.description" />
        </FormRow>

        <FormRow class="text-right">
          <UButton class="btn btn-primary" type="submit" @click.prevent="submit">Dodaj</UButton>
        </FormRow>
      </form>
    </UCard>
  </Container>
</template>
