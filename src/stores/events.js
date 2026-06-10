import { defineStore } from 'pinia'
import { ref, computed } from 'vue'

export const useEventStore = defineStore('events', () => {
  const events = ref([
    { id: 1, title: 'Spring Concert', date: '2026-06-15', type: 'concert', time: '19:00', venue: 'Grand Hall' },
    { id: 2, title: 'Piano Masterclass', date: '2026-06-18', type: 'class', time: '14:00', venue: 'Studio A' },
    { id: 3, title: 'Orchestra Rehearsal', date: '2026-06-20', type: 'rehearsal', time: '10:00', venue: 'Rehearsal Room' },
    { id: 4, title: 'Student Recital', date: '2026-06-22', type: 'recital', time: '16:00', venue: 'Concert Hall' },
    { id: 5, title: 'Faculty Meeting', date: '2026-06-25', type: 'meeting', time: '09:00', venue: 'Conference Room' },
    { id: 6, title: 'Violin Workshop', date: '2026-06-28', type: 'workshop', time: '13:00', venue: 'Studio B' }
  ])

  const selectedDate = ref(new Date().toISOString().split('T')[0])

  const eventsForDate = computed(() => {
    return events.value.filter(e => e.date === selectedDate.value)
  })

  const eventsByMonth = computed(() => {
    const month = new Date().getMonth()
    return events.value.filter(e => new Date(e.date).getMonth() === month)
  })

  function addEvent(event) {
    events.value.push({ ...event, id: Date.now() })
  }

  function deleteEvent(id) {
    events.value = events.value.filter(e => e.id !== id)
  }

  function setSelectedDate(date) {
    selectedDate.value = date
  }

  return { events, selectedDate, eventsForDate, eventsByMonth, addEvent, deleteEvent, setSelectedDate }
})