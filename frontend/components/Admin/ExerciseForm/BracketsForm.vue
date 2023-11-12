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
    <textarea name="definition[text]" id="definition-text-id" rows="7"
              class="form-control" v-model="definitionText"></textarea>
  </div>

  <div class="mb-3">
    <label>Odpowiedzi</label>
    <div class="card p-3">
      <p class="lh-lg">
        <template v-for="(el, index) in newDefinition">
          <span v-if="el.type === 'text'">{{ el.value }}</span>
          <div v-if="el.type === 'bracket'" style="display: inline-block">
            <div class="input-group input-group-sm mx-3 mb-2">
              <span class="input-group-text">
                <button type="button" class="btn btn-sm" @click="decreaseFieldSize(index)">-</button>
              </span>
              <input type="text" class="form-control-sm" :style="{ width: (el.size + 'em') }"
                     v-model="newSolution[index]">
              <span class="input-group-text">
                <button type="button" class="btn btn-sm" @click="increaseFieldSize(index)">+</button>
              </span>
            </div>
          </div>
        </template>
      </p>
    </div>
  </div>
</template>
