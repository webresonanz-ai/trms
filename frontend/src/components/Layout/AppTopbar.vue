<template>
    <header class="topbar-luxury sticky-top px-4 py-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <button class="btn btn-link text-white-50 d-md-none me-2 p-2" @click="toggleSidebar">
                <i class="bi bi-list fs-4"></i>
            </button>
            <h4 class="mb-0 brand-font text-gold animate-slide-in-left">{{ pageTitle }}</h4>
        </div>
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-link text-white-50 position-relative p-2">
                <i class="bi bi-bell fs-5"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-gold text-dark"
                    style="font-size: 0.6rem;">
                    3
                </span>
            </button>
            <button class="btn btn-link text-white-50 p-2">
                <i class="bi bi-gear fs-5"></i>
            </button>
        </div>
    </header>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const pageTitle = computed(() => {
    const titles = {
        '/': 'Dashboard',
        '/events': 'Events Calendar',
        '/about': 'About Our Institution',
        '/profile': 'My Profile'
    }
    return titles[route.path] || 'Dashboard'
})

function toggleSidebar() {
    const event = new CustomEvent('toggle-sidebar')
    window.dispatchEvent(event)
}
</script>