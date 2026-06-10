import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useDashboardStore = defineStore('dashboard', () => {
  const stats = ref([
    { label: 'Total Students', value: 248, icon: 'bi-people', change: '+12%' },
    { label: 'Upcoming Events', value: 6, icon: 'bi-calendar-event', change: '+2' },
    { label: 'Active Courses', value: 18, icon: 'bi-book', change: '+3' },
    { label: 'Revenue', value: '$42.5k', icon: 'bi-cash-stack', change: '+8%' }
  ])

  const activities = ref([
    { id: 1, text: 'New student enrolled in Piano Advanced', time: '2 hours ago', icon: 'bi-person-plus' },
    { id: 2, text: 'Spring Concert venue confirmed', time: '4 hours ago', icon: 'bi-check-circle' },
    { id: 3, text: 'Monthly faculty report submitted', time: '6 hours ago', icon: 'bi-file-earmark-text' },
    { id: 4, text: 'New instrument donation received', time: '1 day ago', icon: 'bi-gift' },
    { id: 5, text: 'Summer camp registration opened', time: '1 day ago', icon: 'bi-sun' }
  ])

  return { stats, activities }
})