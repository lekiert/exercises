import useApiFetch from "~/composables/useApiFetch";
import type { Lesson } from "~/types"

export default class LessonService {
  async getLessons(query: string, page: number, pageSize: number) {
    const { data, status, error } = await useApiFetch('/api/lessons', {
      query: {
        query,
        page,
        pageSize
      }
    })

    if (status?.value === 'success') {
      return {
        data: data.value.data as Array<Lesson>,
        total: data.value.total as number,
        pageCount: data.value.last_page as number
      }
    } else {
      console.log(data.value)
      throw 'Failed to fetch lessons'
    }
  }
}
