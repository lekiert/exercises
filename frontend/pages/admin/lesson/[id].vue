<script setup lang="ts">
import {onMounted, useApiFetch, useCookie, useRuntimeConfig, useRoute, ref, definePageMeta} from "#imports";
import FormRow from "~/components/FormRow.vue";

const config = useRuntimeConfig()
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
});

const getLesson = async () => {
  try {
    const response = await useApiFetch('/api/lessons/' + route.params.id)

    lesson.value = response.data.value.lesson as Lesson
  } catch (e) {
    console.error(e);
  }
};

const save = async () => {
  try {
    const response = await useApiFetch('/api/lessons/' + route.params.id, {
      method: 'PUT',
      body: {
        lesson: lesson.value
      }
    })
  } catch (e) {
    console.error(e);
  }
};

onMounted(async () => {
  await getLesson();
});

</script>

<template>
  <div class="row g-5">
    <div class="col-md-5 col-lg-4 mx-auto p-3">
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

        <button class="btn btn-primary" type="submit" @click.prevent="save">Zapisz</button>
      </form>
    </div>
  </div>
</template>