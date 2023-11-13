<script setup>
import {useApiFetch} from "#imports";

await useApiFetch('/logout', {
  method: 'POST',
})

const sessionCookie = useCookie('laravel_session');
sessionCookie.value = null;

const tokenCookie = useCookie('XSRF-TOKEN');
tokenCookie.value = null;

navigateTo('/login');
</script>