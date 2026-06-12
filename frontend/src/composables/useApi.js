import axios from 'axios'

// Read base URL from Vite environment variable `VITE_API_URL`.
// Fall back to '/api' for local dev when the env var is not set.
const rawBase = import.meta.env.VITE_API_URL || '/api'
// Normalize: remove trailing slash to avoid double-slash when building paths
const baseURL = rawBase.replace(/\/$/, '')

const api = axios.create({
  baseURL,
  headers: {
    'Content-Type': 'application/json',
  },
})

api.interceptors.request.use((config) => {
  const token = localStorage.getItem('trms_token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
})

api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('trms_token')
      localStorage.removeItem('trms_user')
    }
    // Log validation and server errors for easier debugging in dev
    if (error.response?.status === 422 || error.response?.status >= 500) {
      // eslint-disable-next-line no-console
      console.error('API error response:', error.response)
    }
    return Promise.reject(error)
  }
)

export default api
