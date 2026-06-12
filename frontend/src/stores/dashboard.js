import { defineStore } from 'pinia'
import { ref } from 'vue'
import { fetchDashboard } from '@/services/api'

export const useDashboardStore = defineStore('dashboard', () => {
  const stats = ref([])
  const activities = ref([])
  const loading = ref(false)
  const error = ref(null)

  async function load() {
    loading.value = true
    error.value = null
    try {
      const data = await fetchDashboard()
      stats.value = data.stats || []
      activities.value = data.activities || []
    } catch (e) {
      error.value = e.response?.data?.message || 'Failed to load dashboard'
    } finally {
      loading.value = false
    }
  }

  return { stats, activities, loading, error, load }
})
