enum AlertType {
  success = 'success',
  error = 'error',
  info = 'info',
  warning = 'warning',
}

type Alert = {
  type: AlertType,
  message: string,
  description: string|null,
}

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

export { AlertType, Alert, Exercise, Lesson }
