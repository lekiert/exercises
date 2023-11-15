<script setup lang="ts">
import { useApiFetch } from "#imports";
import {useRuntimeConfig, ref, useFetch, useCookie, useRouter, navigateTo} from '#imports'

const config = useRuntimeConfig()
const router = useRouter();

const errorMessage = ref(null)

const form = ref({
  username: '',
  password: '',
})

const login = async () => {
  errorMessage.value = null;

  await useFetch(config.public.apiUrl + '/sanctum/csrf-cookie', {
    credentials: 'include',
  });

  const { status, error } = await useApiFetch(config.public.apiUrl + '/login', {
    method: 'post',
    body: form.value,
  })

  if (status.value === 'error') {
    errorMessage.value = error.value?.data?.message;
  }

  if (status.value === 'success') {
    navigateTo('/admin/dashboard');
  }
}
</script>

<template>
  <div class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="form-signin w-full md:w-1/3 m-auto">
      <div class="alert alert-danger" v-show="errorMessage">
        {{ errorMessage }}
      </div>

      <UCard>
        <form @submit.prevent="login">
          <div>
            <UInput
                type="text"
                id="username"
                size="xl"
                placeholder="Login"
                v-model="form.username"
                icon="i-heroicons-user-circle"
            />
          </div>
          <div class="mt-6">
            <UInput
                type="password"
                id="password"
                size="xl"
                placeholder="Hasło"
                v-model="form.password"
                icon="i-heroicons-lock-closed"
            />
          </div>

          <div class="mt-6 text-right">
            <UButton type="submit">Zaloguj</UButton>
          </div>
        </form>
      </UCard>
    </main>
  </div>
</template>

<style lang="css">

</style>
