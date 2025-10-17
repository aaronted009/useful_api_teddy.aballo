import { defineStore } from 'pinia'
import AuthModel from '@/services/AuthModel'
import { useToast } from 'vue-toastification'

const toast = useToast()

export const useAuthStore = defineStore('auth', {
  persist: true,
  state: () => ({
    token: '',
    model: new AuthModel(),
  }),

  getters: {
    getToken: (state) => state.token,
  },

  actions: {
    /**
     * Initialize the auth token on store load
     */
    initAuth() {
      if (this.token) {
        this.model.setAuthToken(this.token)
      }
    },

    /**
     * Register
     * @param {Object} ids
     * @returns {Object} data
     */
    async register(ids) {
      try {
        const data = await this.model.register(ids)
        toast.success('Votre compte a été créé avec succès', { timeout: 2000 })
        return data
      } catch (error) {
        console.error('Error: ', error)
        this.error = this.model.error
        toast.error(
          "Erreur dans l'enregistrement de vos informations. Veuillez réessayer s'il vous plaît",
          { timeout: 2000 },
        )
      }
    },

    /**
     * Login
     * @param {Object} ids
     * @returns {Object} data
     */
    async login(ids) {
      try {
        const data = await this.model.login(ids)
        this.token = data.token
        // Set the auth token for future requests
        this.model.setAuthToken(data.token)
        toast.success("You're logged in", { timeout: 2000 })
        return data
      } catch (error) {
        console.error('Error: ', error)
        this.error = this.model.error
        toast.error('Wrong ids', { timeout: 2000 })
      }
    },

    /**
     * Logout
     * @returns {Object} message
     */
    async logout() {
      try {
        // Set the token before making the logout request
        this.model.setAuthToken(this.token)
        const data = await this.model.logout()

        // Clear the token and user data after successful logout
        this.token = ''
        this.model.setAuthToken(null)

        return data
      } catch (error) {
        console.error('Error: ', error)
        this.error = this.model.error
      }
    },
  },
})
