import { useFetch, useRuntimeConfig } from '#app'
import {navigateTo, useCookie} from "#build/imports";

const useApiFetch: typeof useFetch = async (request, opts?) => {
  const config = useRuntimeConfig()

  const token = useCookie('XSRF-TOKEN')

  const headers = {
    'X-XSRF-TOKEN': token.value as string,
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  }

  opts = opts || {};
  opts.credentials = opts.credentials || 'include';

  if (opts) {
    opts.headers = { ...headers, ...opts.headers };
  } else {
    opts = { headers }
  }

  const  { data, pending, error, refresh, status } = await useFetch(request, { ...opts, baseURL: config.public.apiUrl as string })

  const redirectToLoginCodes: Array<number> = [401, 429];

  if (redirectToLoginCodes.includes(error.value?.statusCode as number)) {
    navigateTo('/login');
    return { data, pending, error, refresh, status }
  }

  return { data, pending, error, refresh, status };
}

export default useApiFetch;
