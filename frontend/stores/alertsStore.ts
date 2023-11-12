import { defineStore } from 'pinia'
import type { Alert } from '~/types.d.ts'
import { AlertType } from '~/types.d.ts'

export const useAlertsStore = defineStore('alerts', {
    state: () => ({
        message: null,
        description: null,
        type: null,
    }),
    actions: {
        display(alert: Alert) {
            this.message = alert.message;
            this.description = alert.description;
            this.type = alert.type;
        },

        success(message: string, description: string|null) {
            const alert = <Alert>{
                type: AlertType.success,
                message: message,
                description: description,
            }

            this.display(alert);
        },

        error(message: string, description: string|null) {
            const alert = <Alert>{
                type: AlertType.error,
                message: message,
                description: description,
            }

            this.display(alert);
        },

        hide() {
            this.type = null;
            this.message = null;
            this.description = null;
        }
    },
})
