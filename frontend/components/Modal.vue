<script lang="ts" setup>
import {Modal} from 'bootstrap';
import {useAlertsStore, watch, onMounted, ref} from "#imports";

const alertsStore = useAlertsStore();

let modal = ref(null);

onMounted(() => {
  modal.value = new Modal('#alert-modal-id', { backdrop: true });
})

alertsStore.$subscribe((mutation, state) => {
  if (state.type) {
    modal.value.show()
  }
})
</script>

<template>
  <div class="modal fade" tabindex="-1" id="alert-modal-id">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ alertsStore.message }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" v-if="alertsStore.description">
          <p>{{ alertsStore.description }}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="alertsStore.hide()">Close</button>
<!--          <button type="button" class="btn btn-primary">Save changes</button>-->
        </div>
      </div>
    </div>
  </div>
</template>