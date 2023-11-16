<script lang="ts" setup>
import {ref, watch} from "#imports"

const $emit = defineEmits(['exerciseUpdated'])

const props = defineProps(['exercise']);

const definition = ref({
  questions: props.exercise.definition.questions || [''],
  answers: props.exercise.definition.answers || [[{ 'text': '' }]] as Array<any>,
})

const solution = ref(props.exercise.solution || [{
  correctAnswerIndex: props.exercise.solution.correctAnswerIndex as number,
}])

const addAnswer = (questionIndex: number) => {
  definition.value.answers[questionIndex].push({ text: '' });
}

const addQuestion = () => {
  definition.value.questions.push('')
  const index = definition.value.questions.length - 1;
  definition.value.answers[index] = []
  definition.value.answers[index].push({ text: '' });
  solution.value.push({ correctAnswerIndex: -1 })
}

const removeAnswer = (questionIndex: number, answerIndex: number) => {
  definition.value.answers[questionIndex].splice(answerIndex, 1);
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

const getRows = (questionIndex: number) => (definition.value.answers[questionIndex] || []).map((a: any, i: number) => ({
  index: i,
  text: a.text,
  class: (solution.value[questionIndex] || {}).correctAnswerIndex === i ? 'bg-green-500/50 dark:bg-green-400/50' : '',
}))
</script>

<template>
  <UCard class="mt-6" v-for="(question, questionIndex) in definition.questions">
    <div class="mb-3">
      <UInput type="text" id="exercise-question-id" v-model="definition.questions[questionIndex]"
              placeholder="Treść pytania" />
    </div>

    <div>
      <span class="text-gray-400">Odpowiedzi</span>

      <UTable :rows="getRows(questionIndex)" :columns="columns">
        <template #index-data="{ row }">
          <UButton
              v-if="solution[questionIndex]"
              :color="solution[questionIndex].correctAnswerIndex === row.index ? 'green' : 'gray'"
              @click="solution[questionIndex].correctAnswerIndex = row.index"
          >
            <UIcon name="i-heroicons-check" />
          </UButton>
        </template>

        <template #text-data="{ row }">
          <UInput type="text" class="form-control" v-model="definition.answers[questionIndex][row.index].text" />
        </template>

        <template #delete-data="{ row }">
          <div class="text-right">
            <UButton @click="removeAnswer(questionIndex, row.index)" color="gray">
              <UIcon name="i-heroicons-x-mark"></UIcon>
            </UButton>
          </div>
        </template>
      </UTable>

      <div class="mt-3 text-right">
        <UButton @click="addAnswer(questionIndex)" size="xs">
          <UIcon name="i-heroicons-plus" />
          Dodaj odpowiedź
        </UButton>
      </div>
    </div>
  </UCard>

  <div class="mt-6">
    <UButton @click="addQuestion">
      <UIcon name="i-heroicons-plus" />
      Dodaj pytanie
    </UButton>
  </div>
</template>