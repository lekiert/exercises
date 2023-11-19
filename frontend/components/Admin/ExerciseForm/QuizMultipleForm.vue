<script lang="ts" setup>
import {ref, watch} from "#imports"
import QuizMultipleFormQuestion from "~/components/Admin/ExerciseForm/QuizMultipleFormQuestion.vue";

const $emit = defineEmits(['exerciseUpdated'])

const props = defineProps(['exercise']);

const definition = ref({
  questions: props.exercise.definition.questions || [{
    text: '',
    answers: [{ 'text': '' }],
  }],
})

const solution = ref(props.exercise.solution || [{
  correctAnswerIndexes: props.exercise.solution.correctAnswerIndexes as Array<number>,
}])

if (!solution.value.length) {
  solution.value = [{
    correctAnswerIndexes: props.exercise.solution.correctAnswerIndexes as Array<number>,
  }]
}

const addAnswer = (questionIndex: number) => {
  definition.value.questions[questionIndex].answers.push({ text: '' });
}

const removeAnswer = (questionIndex: number, answerIndex: number) => {
  definition.value.questions[questionIndex].answers.splice(answerIndex, 1);
};

const addQuestion = () => {
  definition.value.questions.push({
    text: '',
    answers: [{ 'text': '' }],
  })
  solution.value.push({ correctAnswerIndexes: [] })
}

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
</script>

<template>
  <QuizMultipleFormQuestion
      v-for="(question, index) in definition.questions"
      :question="question"
      :solution="solution[index]"
      @questionUpdated="definition.questions[index].text = $event"
      @answerSelected="solution[index] = $event"
      @answerAdded="addAnswer(index)"
      @answerRemoved="removeAnswer(index, $event.answerIndex)"
  />

  <div class="mt-6">
    <UButton @click="addQuestion">
      <UIcon name="i-heroicons-plus" />
      Dodaj pytanie
    </UButton>
  </div>
</template>