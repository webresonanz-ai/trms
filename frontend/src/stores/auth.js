import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { login as apiLogin, register as apiRegister, fetchMe } from '@/services/api'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const initialized = ref(false)
  const error = ref(null)
  const loading = ref(false)

  const isLoggedIn = computed(() => !!user.value)

  async function init() {
    const token = localStorage.getItem('trms_token')
    const savedUser = localStorage.getItem('trms_user')

    if (token) {
      try {
        const freshUser = await fetchMe()
        user.value = freshUser
        if (savedUser) {
          localStorage.setItem('trms_user', JSON.stringify(freshUser))
        }
      } catch {
        clear()
      }
    }
    initialized.value = true
  }

  async function login(email, password) {
    loading.value = true
    error.value = null
    try {
      const { token, user: fetchedUser } = await apiLogin({ email, password })
      user.value = fetchedUser
      localStorage.setItem('trms_token', token)
      localStorage.setItem('trms_user', JSON.stringify(fetchedUser))
      return true
    } catch (e) {
      error.value = e.response?.data?.message || 'Login failed'
      return false
    } finally {
      loading.value = false
    }
  }

  async function register(payload) {
    loading.value = true
    error.value = null
    try {
      const { token, user: fetchedUser } = await apiRegister(payload)
      user.value = fetchedUser
      localStorage.setItem('trms_token', token)
      localStorage.setItem('trms_user', JSON.stringify(fetchedUser))
      return true
    } catch (e) {
      error.value = e.response?.data?.errors ? Object.values(e.response?.data?.errors).join(', ') : e.response?.data?.message || 'Registration failed'
      return false
    } finally {
      loading.value = false
    }
  }

  function updateProfile(data) {
    user.value = { ...user.value, ...data }
    localStorage.setItem('trms_user', JSON.stringify(user.value))
  }

  function clear() {
    user.value = null
    error.value = null
    localStorage.removeItem('trms_token')
    localStorage.removeItem('trms_user')
  }

  function logout() {
    clear()
  }

  return {
    user,
    error,
    loading,
    initialized,
    isLoggedIn,
    init,
    login,
    register,
    logout,
    clear,
    updateProfile,
  }
})
