<script lang="ts" setup>
import {ref, watch} from "#imports"
import QuizFormQuestion from "~/components/Admin/ExerciseForm/QuizFormQuestion.vue";

const $emit = defineEmits(['exerciseUpdated'])

const props = defineProps(['exercise']);

const definition = ref({
  questions: props.exercise.definition.questions || [{
      text: '',
      answers: [{ 'text': '' }],
  }],
})

const solution = ref(props.exercise.solution || [{
  correctAnswerIndex: props.exercise.solution.correctAnswerIndex as number,
}])

if (!solution.value.length) {
  solution.value = [{
    correctAnswerIndex: props.exercise.solution.correctAnswerIndex as number,
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
  solution.value.push({ correctAnswerIndex: -1 })
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
  <QuizFormQuestion
      v-for="(question, index) in definition.questions"
      :question="question"
      :solution="solution[index]"
      @questionUpdated="definition.questions[index].text = $event"
      @answerSelected="solution[index].correctAnswerIndex = $event.answerIndex"
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