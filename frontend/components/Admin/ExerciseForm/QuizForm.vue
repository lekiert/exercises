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

const removeAnswer = (index) => {
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

</script>

<template>
  <div class="mb-3">
    <label for="exercise-question-id">Pytanie</label>
    <input type="text" class="form-control" id="exercise-question-id" v-model="definition.question">
  </div>

  <div>
    <label>Odpowiedzi</label>

    <table class="table table-borderless w-100">
      <tbody>
      <tr v-for="(answer, index) in definition.answers">
        <td>
          <input type="checkbox" class="form-checkbox"
                 @click="solution.correctAnswerIndex = index"
                 :checked="solution.correctAnswerIndex === index">
        </td>

        <td>
          <input type="text" class="form-control" v-model="answer.text">
        </td>

        <td class="text-right">
          <button type="button" class="btn btn-danger inline-block" @click="removeAnswer(index)">usuń</button>
        </td>
      </tr>
      </tbody>
    </table>
    <button type="button" class="btn btn-primary" @click="addAnswer">Dodaj</button>
  </div>
</template>