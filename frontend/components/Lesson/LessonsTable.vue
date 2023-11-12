<script setup lang="ts">
defineProps(['lessons']);
</script>

<template>
  <table class="table">
    <tbody>
    <tr v-for="lesson in lessons">
      <td>
        <a :href="'/admin/lesson/' + lesson.id">{{ lesson.name }}</a></td>
      <td>{{ lesson.created_at }}</td>
    </tr>
    </tbody>
  </table>
</template>
