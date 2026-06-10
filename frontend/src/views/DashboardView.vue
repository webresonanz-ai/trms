<template>
    <div class="animate-fade-in-up">
        <transition-group name="stagger" tag="div" class="row g-4 mb-4">
            <div v-for="stat in dashboard.stats" :key="stat.label" class="col-md-6 col-lg-3">
                <StatCard :label="stat.label" :value="stat.value" :icon="stat.icon" :change="stat.change" />
            </div>
        </transition-group>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card-luxury p-4 h-100 animate-scale-in">
                    <h5 class="brand-font text-gold mb-4">Upcoming Events</h5>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover" style="background: transparent;">
                            <thead>
                                <tr class="text-white-50">
                                    <th class="border-secondary">Event</th>
                                    <th class="border-secondary">Date</th>
                                    <th class="border-secondary">Time</th>
                                    <th class="border-secondary">Venue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="event in upcomingEvents" :key="event.id"
                                    style="border-color: rgba(255,255,255,0.05); transition: all 0.2s ease;">
                                    <td class="d-flex align-items-center">
                                        <div class="rounded-circle p-1 me-2"
                                            style="background: rgba(212, 175, 55, 0.2); width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-music-note text-gold small"></i>
                                        </div>
                                        <span class="small">{{ event.title }}</span>
                                    </td>
                                    <td class="text-white-50 small">{{ formatDate(event.date) }}</td>
                                    <td class="text-white-50 small">{{ event.time }}</td>
                                    <td class="text-white-50 small">{{ event.venue }}</td>
                                </tr>
                                <tr v-if="!upcomingEvents.length">
                                    <td colspan="4" class="text-center py-4">
                                        <i class="bi bi-calendar-x text-gold fs-1"></i>
                                        <p class="text-white-50 small mt-2 mb-0">No upcoming events</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <ActivityFeed :activities="dashboard.activities" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { useDashboardStore } from '@/stores/dashboard'
import { useEventStore } from '@/stores/events'
import StatCard from '@/components/Dashboard/StatCard.vue'
import ActivityFeed from '@/components/Dashboard/ActivityFeed.vue'

const dashboard = useDashboardStore()
const eventStore = useEventStore()

const upcomingEvents = computed(() => {
    return [...eventStore.events]
        .sort((a, b) => new Date(a.date) - new Date(b.date))
        .slice(0, 5)
})

function formatDate(dateStr) {
    return new Date(dateStr).toLocaleDateString('en-US', { month: 'short', day: 'numeric' })
}
</script>

<style scoped>
.stagger-enter-active,
.stagger-leave-active {
  transition: all 0.3s ease;
}

.stagger-enter-from {
  opacity: 0;
  transform: translateY(20px);
}

@media (max-width: 768px) {
  .table-responsive {
    font-size: 0.875rem;
  }
}
</style>