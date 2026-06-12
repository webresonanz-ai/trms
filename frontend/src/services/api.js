import api from '@/composables/useApi'

export async function fetchDashboard() {
  const { data } = await api.get('/dashboard')
  return data
}

export async function fetchEvents() {
  const { data } = await api.get('/events')
  return data
}

export async function fetchUpcomingEvents() {
  const { data } = await api.get('/events/upcoming')
  return data
}

export async function createEvent(payload) {
  const { data } = await api.post('/events', payload)
  return data
}

export async function updateEvent(id, payload) {
  const { data } = await api.put(`/events/${id}`, payload)
  return data
}

export async function deleteEvent(id) {
  const { data } = await api.delete(`/events/${id}`)
  return data
}

export async function fetchProfile() {
  const { data } = await api.get('/profile')
  return data
}

export async function updateProfile(payload) {
  const { data } = await api.put('/profile', payload)
  return data
}

export async function login(credentials) {
  const { data } = await api.post('/auth/login', credentials)
  return data
}

export async function register(credentials) {
  const { data } = await api.post('/auth/register', credentials)
  return data
}

export async function fetchMe() {
  const { data } = await api.get('/auth/me')
  return data
}
