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
                <img :src="auth.user.avatar" class="rounded-circle me-2 animate-float" width="35" height="35" alt="User">
                <div class="overflow-hidden">
                    <div class="text-white small text-truncate">{{ auth.user.name }}</div>
                    <div class="text-white-50 smaller text-truncate" style="font-size: 0.75rem;">{{ auth.user.role }}
                    </div>
                </div>
            </div>
        </div>
    </aside>
</template>

<script setup>
import { useAuthStore } from '@/stores/auth'
import { ref, onMounted, onUnmounted } from 'vue'

const auth = useAuthStore()
const isOpen = ref(false)

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