<script lang="ts" setup>
import { computed } from '#imports'

const props = defineProps(['question', 'solution'])

const $emit = defineEmits(['answerSelected', 'answerRemoved', 'answerAdded', 'questionUpdated'])

const selectedAnswers = ref({
  correctAnswerIndexes: props.solution.correctAnswerIndexes || [] as Array<number>
})

const toggleAnswer = (index) => {
  if (selectedAnswers.value.correctAnswerIndexes.includes(index)) {
    selectedAnswers.value.correctAnswerIndexes = selectedAnswers.value.correctAnswerIndexes.filter(i => i !== index)
  } else {
    selectedAnswers.value.correctAnswerIndexes.push(index)
  }

  $emit('answerSelected', selectedAnswers.value)
}

const rows = computed(() => props.question.answers.map((a: any, i: number) => ({
  index: i,
  text: a.text,
  class: props.solution.correctAnswerIndexes === i ? 'bg-green-500/50 dark:bg-green-400/50' : '',
})))

const isSelected = (index) => {
  return props.solution.correctAnswerIndexes && props.solution.correctAnswerIndexes.includes(index)
}

const columns = [
  {
    key: 'index',
  }, {
    key: 'text',
  }, {
    key: 'delete',
  }
]
</script>

<template>
  <UCard class="mt-6">
    <div class="mb-3">
      <UInput type="text" id="exercise-question-id"
              :value="question.text"
              @input="$emit('questionUpdated', $event.target.value)"
              placeholder="Treść pytania" />
    </div>

    <div>
      <span class="text-gray-400">Odpowiedzi</span>

      <UTable :rows="rows" :columns="columns">
        <template #index-data="{ row }">
          <UButton
              v-if="solution"
              :color="isSelected(row.index) ? 'green' : 'gray'"
              @click="toggleAnswer(row.index)"
          >
            <UIcon name="i-heroicons-check" />
          </UButton>
        </template>

        <template #text-data="{ row }">
          <UInput type="text" class="form-control" v-model="question.answers[row.index].text" />
        </template>

        <template #delete-data="{ row }">
          <div class="text-right">
            <UButton @click="$emit('answerRemoved', row.index)" color="gray">
              <UIcon name="i-heroicons-x-mark"></UIcon>
            </UButton>
          </div>
        </template>
      </UTable>

      <div class="mt-3 text-right">
        <UButton @click="$emit('answerAdded')" size="xs">
          <UIcon name="i-heroicons-plus" />
          Dodaj odpowiedź
        </UButton>
      </div>
    </div>
  </UCard>
</template>