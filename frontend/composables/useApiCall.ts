import useApiFetch from './useApiFetch'
import { navigateTo } from "#imports";

const useApiCall = async (request, opts?) => {
  const  { data, pending, error, refresh, status } = await useApiFetch(request, opts)

  const redirectToLoginCodes: Array<number> = [401, 429];

  if (redirectToLoginCodes.includes(error.value?.statusCode as number)) {
    navigateTo('/login');
    return { data, pending, error, refresh, status }
  }

  return { data, pending, error, refresh, status }
}

export default useApiCall;
