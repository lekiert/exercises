<script setup lang="ts">
import {useApiFetch, useCookie, useRuntimeConfig, ref, definePageMeta, navigateTo} from "#imports";
import type {Lesson} from "~/types";
import BackLink from "~/components/Admin/BackLink.vue";
import Container from "~/components/Admin/Container.vue";

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
    const response = await useApiFetch(config.public.apiUrl + '/api/lessons', {
      method: 'POST',
      body: {
        lesson: lesson.value
      }
    })

    navigateTo('/admin/lesson/' + response.data.value.lesson.id);
  } catch (e) {
    debugger;
    console.error(e);
    alert('boom');
  }

};
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

      <FormRow class="text-right">
        <button class="btn btn-primary" type="submit" @click.prevent="submit">Dodaj</button>
      </FormRow>
    </form>
  </Container>
</template>
