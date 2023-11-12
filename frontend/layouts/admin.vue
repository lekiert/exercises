<script setup lang="ts">
import {useAlertsStore} from "#imports";
import {Modal} from "#components";

const alertsStore = useAlertsStore();
</script>

<template>
  <Navbar />

  <div class="container">
    <main>
      <slot/>
    </main>
  </div>

  <Modal />
</template>
