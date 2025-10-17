import axios from 'axios'

export default class Auth {
  /**
   * instantiate axios including token for authorization
   * @param {string} baseURL
   */
  constructor(baseURL = `${import.meta.env.VITE_API_BASE_URL}`) {
    this.api = axios.create({
      baseURL,
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
    })
    // this.api.defaults.withCredentials = true
  }

  /**
   * Set authorization token for authenticated requests
   * @param {string} token
   */
  setAuthToken(token) {
    if (token) {
      this.api.defaults.headers.common['Authorization'] = `Bearer ${token}`
    } else {
      delete this.api.defaults.headers.common['Authorization']
    }
  }

  /**
   * Register
   * @param {Object} new_user_infos
   * @returns {Object} data
   */
  async register(new_user_infos) {
    try {
      const registerIds = {
        name: new_user_infos.name.trim(),
        email: new_user_infos.email.trim(),
        password: new_user_infos.password,
      }
      const response = await this.api.post('/api/register', registerIds)
      const data = response.data
      return data
    } catch (e) {
      console.error(e)
      this.error = 'Failed to register'
    }
  }

  /**
   * Login
   * @param {Object} ids
   * @returns {Object} data
   */
  async login(ids) {
    try {
      const loginIds = {
        email: ids.email.trim(),
        password: ids.password,
      }
      const response = await this.api.post('/api/login', loginIds)
      const data = response.data
      console.log(data)
      return data
    } catch (e) {
      console.error(e)
      this.error = 'Failed to login'
    }
  }

  /**
   * Logout
   * @returns {Object} message
   */
  async logout() {
    try {
      const response = await this.api.post('/logout')
      const data = response.data
      console.log(data)
      return data
    } catch (e) {
      console.error(e)
      this.error = 'Failed to logout'
    }
  }
}
