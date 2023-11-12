type Exercise = {
  id: number|null,
  name: string,
  description: string,
  definition: any,
  solution: any,
}

type Lesson = {
  id: number|null,
  name: string,
  type: string,
  description: string,
  exercises: Array<Exercise>
}

export { Exercise, Lesson }
