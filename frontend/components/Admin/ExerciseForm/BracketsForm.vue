<script setup lang="ts">
import {ref, watch} from "#imports"

const $emit = defineEmits(['exerciseUpdated'])

const props = defineProps(['exercise']);

const solution = ref({
  answers: props.exercise.solution.answers || [],
})

const newDefinition = ref(props.exercise.definition || []);
const newSolution = ref(props.exercise.solution as object || {});
const definitionText = ref(newDefinition.value.map(i => (i && i.type === 'bracket') ? ' _ ' : i?.value).join(' '))

const count = ref(0);

const setupAnswers = () => {
  const num = (definitionText.value.match(/\s(_+)\s/gm) || []).length

  const standardized = (definitionText.value.replace(/\s(_+)\s/gm, ' _ '))

  const split = standardized.split(' _ ');

  const prevValues = newDefinition.value;
  const _newDefinition = []

  for (let i = 0; i < split.length - 1; i++) {
    if (split[i] === '') {
      continue;
    }
    _newDefinition.push({ type: 'text', value: split[i] })
    _newDefinition.push({ type: 'bracket'})
  }
  _newDefinition.push({ type: 'text', value: split[split.length - 1] })

  for (let i = 0; i < _newDefinition.length; i++) {
    if (_newDefinition[i].type === 'bracket') {
      _newDefinition[i].size = prevValues[i]?.size || 3;
      _newDefinition[i].value = prevValues[i]?.value || '';
    }
  }

  newDefinition.value = _newDefinition;
}

const increaseFieldSize = (index) => {
  newDefinition.value[index].size = newDefinition.value[index].size + 1;
}

const decreaseFieldSize = (index) => {
  const currentSize = newDefinition.value[index].size;
  const newSize = currentSize - 1;

  newDefinition.value[index].size = Math.max(3, newSize);
}

watch(definitionText, () => {
    setupAnswers();
}, { deep: true })

watch(newDefinition, () => {
  const _solution = {};

  for (const i in newSolution.value) {
    if (newSolution.value[i] !== null) {
      _solution[i] = newSolution.value[i];
    }
  }

  $emit('exerciseUpdated', {
    definition: newDefinition,
    solution: _solution,
  })
}, { deep: true })

</script>

<template>
  <div class="mb-3">
    <label for="definition-text-id">Treść</label>
    <UTextarea name="definition[text]" id="definition-text-id" rows="7"
              class="form-control" v-model="definitionText"></UTextarea>
  </div>

  <div class="mb-3">
    <label>Odpowiedzi <small>(gdy jest ich kilka, oddziel znakiem <code>|</code>)</small></label>

    <UCard>
      <template v-for="(el, index) in newDefinition">
        <span v-if="el.type === 'text'" v-html="el.value.replaceAll('\n', '<br>')"></span>
        <div v-if="el.type === 'bracket'" style="display: inline-block">
          <UButtonGroup size="sm" class="mx-4 my-2">
            <UButton type="button" size="sm" @click="decreaseFieldSize(index)" color="gray">
              <span class="i-heroicons-minus"></span>
            </UButton>
            <UInput type="text" :style="{ width: (el.size + 'em') }"
                   v-model="newSolution[index]" />
            <UButton type="button" size="sm" @click="increaseFieldSize(index)" color="gray">
              <span class="i-heroicons-plus"></span>
            </UButton>
          </UButtonGroup>
        </div>
      </template>
    </UCard>
  </div>
</template>

<style scoped>
  .bracket {
    background: transparent;
    border-bottom: 2px solid #fff;
  }
</style>
