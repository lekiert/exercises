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
    navigateTo('admin');
  }
}
</script>

<template>
  <div class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="form-signin w-100 m-auto">
      <div class="alert alert-danger" v-show="errorMessage">
        {{ errorMessage }}
      </div>

      <form @submit.prevent="login">
        <div class="form-floating">
          <input type="text" class="form-control" id="username" v-model="form.username">
          <label for="username">Login</label>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control" id="password" v-model="form.password">
          <label for="password">Hasło</label>
        </div>
        <button class="btn btn-primary w-100 py-2" type="submit">Zaloguj</button>
      </form>
    </main>
  </div>
</template>

<style lang="css">
.form-signin {
  max-width: 330px;
  padding: 1rem;
}

.form-signin .form-floating:focus-within {
  z-index: 2;
}

.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
</style>
