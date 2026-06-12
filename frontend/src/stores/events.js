import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { fetchEvents, createEvent as apiCreateEvent, deleteEvent as apiDeleteEvent } from '@/services/api'

export const useEventStore = defineStore('events', () => {
  const events = ref([])
  const selectedDate = ref(new Date().toLocaleDateString('en-CA'))
  const loading = ref(false)
  const error = ref(null)

  const eventsForDate = computed(() => {
    return events.value.filter(e => e.date === selectedDate.value)
  })

  const eventsByMonth = computed(() => {
    const month = new Date().getMonth()
    return events.value.filter(e => new Date(e.date).getMonth() === month)
  })

  async function load() {
    loading.value = true
    error.value = null
    try {
      events.value = await fetchEvents()
    } catch (e) {
      error.value = e.response?.data?.message || 'Failed to load events'
    } finally {
      loading.value = false
    }
  }

  async function addEvent(event) {
    try {
      const created = await apiCreateEvent(event)
      events.value.push(created)
      return created
    } catch (e) {
      // Prefer detailed validation errors when available
      const resp = e.response?.data
      if (resp?.errors) {
        error.value = Object.values(resp.errors).join(', ')
      } else if (resp?.message) {
        error.value = resp.message
      } else {
        error.value = 'Failed to create event'
      }
      // log full response for easier debugging
      // eslint-disable-next-line no-console
      console.error('Create event failed:', e.response || e)
      throw e
    }
  }

  async function deleteEvent(id) {
    try {
      await apiDeleteEvent(id)
      events.value = events.value.filter(e => e.id !== id)
    } catch (e) {
      error.value = e.response?.data?.message || 'Failed to delete event'
      throw e
    }
  }

  function setSelectedDate(date) {
    selectedDate.value = date
  }

  return { events, selectedDate, eventsForDate, eventsByMonth, addEvent, deleteEvent, setSelectedDate, load }
})
