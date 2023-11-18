import useApiFetch from "~/composables/useApiFetch";
import type { Exercise } from "~/types"

export default class ExerciseService {
    async getExercises(query: string, page: number, pageSize: number) {
        const { data, status, error } = await useApiFetch('/api/exercises', {
            query: {
                q: query,
                page,
                pageSize
            }
        })

        if (status?.value === 'success') {
            return {
                data: data.value.data as Array<Exercise>,
                total: data.value.total as number,
                pageCount: data.value.last_page as number
            }
        } else {
            console.log(data.value)
            throw 'Failed to fetch exercises'
        }
    }
}
