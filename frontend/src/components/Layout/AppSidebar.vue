<template>
    <aside class="sidebar-luxury position-fixed d-flex flex-column p-3" style="width: 260px; z-index: 1000;" :class="{ show: isOpen }">
        <div class="mb-4 px-2">
            <h3 class="brand-font text-gold mb-0 animate-fade-in-up">
                <i class="bi bi-music-note-beamed me-2"></i>TRMS
            </h3>
            <small class="text-white-50 animate-fade-in-up delay-100">The Royal Music School</small>
        </div>

        <nav class="nav flex-column flex-grow-1">
            <router-link v-for="(item, index) in menuItems" :key="item.path" :to="item.path" class="nav-link"
                :class="{ active: $route.path === item.path }" :style="{ transitionDelay: `${index * 50}ms` }">
                <i :class="item.icon"></i>
                {{ item.name }}
            </router-link>
        </nav>

        <div class="mt-auto pt-3 border-top border-secondary">
            <div class="d-flex align-items-center px-2">
                <img :src="user?.avatar || defaultAvatar" class="rounded-circle me-2 animate-float" width="35" height="35" alt="User">
                <div class="overflow-hidden">
                    <div class="text-white small text-truncate">{{ auth.user?.name || 'User' }}</div>
                    <div class="text-white-50 smaller text-truncate" style="font-size: 0.75rem;">{{ auth.user?.role || '' }}
                    </div>
                </div>
            </div>
        </div>
    </aside>
</template>

<script setup>
import { useAuthStore } from '@/stores/auth'
import { ref, onMounted, onUnmounted, computed } from 'vue'

const auth = useAuthStore()
const isOpen = ref(false)
const defaultAvatar = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="%23d4af37"%3E%3Cpath d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/%3E%3C/svg%3E'
const user = computed(() => auth.user)

const menuItems = [
    { name: 'Dashboard', path: '/', icon: 'bi bi-grid' },
    { name: 'Events', path: '/events', icon: 'bi bi-calendar3' },
    { name: 'About Us', path: '/about', icon: 'bi bi-info-circle' },
    { name: 'Profile', path: '/profile', icon: 'bi bi-person' }
]

function checkScreen() {
    isOpen.value = window.innerWidth > 768
}

onMounted(() => {
    checkScreen()
    window.addEventListener('resize', checkScreen)
})

onUnmounted(() => {
    window.removeEventListener('resize', checkScreen)
})
</script>