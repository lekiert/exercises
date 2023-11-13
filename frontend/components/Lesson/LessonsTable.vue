<script setup lang="ts">
defineProps(['lessons']);
</script>

<template>
  <table class="table" v-show="lessons.length">
    <tbody>
    <tr v-for="lesson in lessons">
      <td>
        <a :href="'/admin/lesson/' + lesson.id">{{ lesson.name }}</a></td>
      <td>{{ lesson.created_at }}</td>
    </tr>
    </tbody>
  </table>

  <p v-show="!lessons.length" class="text-muted">Brak danych</p>
</template>
