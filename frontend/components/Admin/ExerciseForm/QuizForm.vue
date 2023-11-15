<script lang="ts" setup>
import {ref, watch} from "#imports"

const $emit = defineEmits(['exerciseUpdated'])

const props = defineProps(['exercise']);

const definition = ref({
  question: props.exercise.definition.question || '',
  answers: props.exercise.definition.answers || [],
})

const solution = ref({
  correctAnswerIndex: props.exercise.solution.correctAnswerIndex as number,
})

const addAnswer = () => {
  definition.value.answers.push({ text: '' });
}

const removeAnswer = (index: number) => {
  definition.value.answers.splice(index, 1);
};

watch(definition, (newVal) => {
  $emit('exerciseUpdated', {
    definition: definition.value,
    solution: solution.value
  })
}, { deep: true })

watch(solution, (newVal) => {
  $emit('exerciseUpdated', {
    definition: definition.value,
    solution: solution.value
  })
}, { deep: true })

const columns = [
  {
    key: 'index',
  }, {
    key: 'text',
  }, {
    key: 'delete',
  }
]

const rows = computed(() => definition.value.answers.map((a: any, i: number) => ({
  index: i,
  text: a.text,
  class: solution.value.correctAnswerIndex === i ? 'bg-green-500/50 dark:bg-green-400/50' : '',
})))
</script>

<template>
  <div class="mb-3">
    <label for="exercise-question-id">Pytanie</label>
    <UInput type="text" id="exercise-question-id" v-model="definition.question" />
  </div>

  <div>
    <label>Odpowiedzi</label>

    <UTable :rows="rows" :columns="columns">
      <template #index-data="{ row }">
        <UButton
          :color="solution.correctAnswerIndex === row.index ? 'green' : 'gray'"
          @click="solution.correctAnswerIndex = row.index"
        >
          <UIcon name="i-heroicons-check" />
        </UButton>
      </template>

      <template #text-data="{ row }">
        <UInput type="text" class="form-control" v-model="definition.answers[row.index].text" />
      </template>

      <template #delete-data="{ row }">
        <div class="text-right">
          <UButton @click="removeAnswer(index)" color="gray">
            <UIcon name="i-heroicons-x-mark"></UIcon>
          </UButton>
        </div>
      </template>
    </UTable>

    <div class="mt-3">
      <UButton @click="addAnswer">
        <UIcon name="i-heroicons-plus" />
        Dodaj odpowiedź
      </UButton>
    </div>
  </div>
</template>