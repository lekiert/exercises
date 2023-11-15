<script lang="ts" setup>
import {onMounted, useApiFetch, useCookie, useRuntimeConfig, useRoute, ref, definePageMeta} from "#imports";

const router = useRoute()

</script>

<template>
 {{ router.params.id }} {{ router.params.slug }}
</template>