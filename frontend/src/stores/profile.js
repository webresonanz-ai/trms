import { defineStore } from 'pinia'
import { ref } from 'vue'
import { fetchProfile, updateProfile as apiUpdateProfile } from '@/services/api'

export const useProfileStore = defineStore('profile', () => {
  const user = ref(null)
  const loading = ref(false)
  const error = ref(null)
  const saving = ref(false)

  async function load() {
    loading.value = true
    error.value = null
    try {
      user.value = await fetchProfile()
    } catch (e) {
      error.value = e.response?.data?.message || 'Failed to load profile'
    } finally {
      loading.value = false
    }
  }

  async function save(formData) {
    saving.value = true
    try {
      const updated = await apiUpdateProfile(formData)
      user.value = updated
    } catch (e) {
      error.value = e.response?.data?.message || 'Failed to update profile'
      throw e
    } finally {
      saving.value = false
    }
  }

  return { user, loading, error, saving, load, save }
})
