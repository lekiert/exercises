<script setup lang="ts">
import {useApiFetch, useCookie, useRuntimeConfig, ref, definePageMeta, navigateTo} from "#imports";
import FormRow from "~/components/FormRow.vue";
import type {Exercise} from "~/types";

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
          <select class="form-control" id="form-type-id" v-model="exercise.type">
            <option value="brackets">Luki</option>
            <option value="quiz">Quiz</option>
          </select>
        </FormRow>

        <button class="btn btn-primary" type="submit" @click.prevent="submit">Dodaj</button>
      </form>
    </div>
  </div>
</template>
