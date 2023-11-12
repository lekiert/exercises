<script setup lang="ts">
import {useApiFetch, useCookie, useRuntimeConfig, ref, definePageMeta, navigateTo} from "#imports";
import type {Lesson} from "~/types";

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
  <div class="row g-5">
    <div class="col-md-5 col-lg-4 mx-auto p-3">
      <form>
        <div class="mb-3">
          <label for="lesson-name-id" class="form-label">Nazwa</label>
          <input class="form-control" type="text" id="lesson-name-id" v-model="lesson.name" />
        </div>
        <div class="mb-3">
          <label for="lesson-description-id" class="form-label">Polecenie</label>
          <textarea class="form-control" name="lesson[description]" id="lesson-description-id"
                    v-model="lesson.description"></textarea>
        </div>
        <button class="btn btn-primary" type="submit" @click.prevent="submit">Dodaj</button>
      </form>
    </div>
  </div>
</template>
