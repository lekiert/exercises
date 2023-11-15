<script setup lang="ts">
import {useAlertsStore} from "#imports";
import {Modal} from "#components";

const alertsStore = useAlertsStore();
</script>

<template>
  <Navbar />

  <main>
    <slot/>
  </main>

  <Modal />
</template>
