<template>
    <div class="card-luxury p-4 h-100 animate-fade-in-up">
        <h5 class="brand-font text-gold mb-4">Recent Activity</h5>
        <div class="activity-list">
            <transition-group name="slide" tag="div">
                <div v-for="activity in activities" :key="activity.id" class="d-flex align-items-start mb-3 pb-3"
                    style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <div class="rounded-circle p-2 me-3 flex-shrink-0" style="background: rgba(212, 175, 55, 0.1);">
                        <i :class="`bi ${activity.icon} text-gold`"></i>
                    </div>
                    <div>
                        <p class="mb-1 small">{{ activity.text }}</p>
                        <small class="text-white-50" style="font-size: 0.75rem;">{{ activity.time }}</small>
                    </div>
                </div>
            </transition-group>
        </div>
    </div>
</template>

<script setup>
defineProps({
    activities: Array
})
</script>

<style scoped>
.slide-enter-active,
.slide-leave-active {
  transition: all 0.3s ease;
}

.slide-enter-from {
  opacity: 0;
  transform: translateX(-20px);
}

.slide-leave-to {
  opacity: 0;
  transform: translateX(20px);
}
</style>