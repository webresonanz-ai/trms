import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useAuthStore = defineStore('auth', () => {
  const user = ref({
    name: 'Maestro Alexander',
    email: 'alexander@trms.edu',
    role: 'Music Director',
    avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop',
    bio: 'Classical pianist and conductor with 20+ years of experience in music education.',
    phone: '+1 (555) 123-4567',
    department: 'Orchestra & Piano',
    joined: '2018-09-01'
  })

  function updateProfile(data) {
    user.value = { ...user.value, ...data }
  }

  return { user, updateProfile }
})