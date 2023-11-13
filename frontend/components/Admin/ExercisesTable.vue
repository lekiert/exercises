<script setup lang="ts">
defineProps(['exercises']);
</script>

<template>
  <table class="table" v-show="exercises.length">
    <tbody>
    <tr v-for="exercise in exercises">
      <td>
        <a :href="'/admin/exercise/' + exercise.id">{{ exercise.name }}</a></td>
      <td>{{ exercise.created_at }}</td>
    </tr>
    </tbody>
  </table>

  <p v-show="!exercises.length" class="text-muted">Brak danych</p>
</template>
