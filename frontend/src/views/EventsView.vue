<template>
    <div class="animate-fade-in-up">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <p class="text-white-50 mb-0">Manage your institution's performances, classes, and meetings.</p>
            <button class="btn btn-luxury" @click="openAddEventModal">
                <i class="bi bi-plus-lg me-2"></i>Add Event
            </button>
        </div>

        <div v-if="eventStore.loading" class="text-center py-5">
            <div class="spinner-border text-gold" role="status"></div>
            <p class="text-white-50 mt-2">Loading events...</p>
        </div>
        <div v-else-if="eventStore.error" class="alert alert-danger">{{ eventStore.error }}</div>
        <template v-else>
            <div class="row g-4">
                <div class="col-lg-8">
                    <CalendarGrid />
                </div>
                <div class="col-lg-4">
                    <div class="card-luxury p-4">
                        <h6 class="brand-font text-gold mb-3">This Month's Events</h6>
                        <transition-group name="slide" tag="div">
                            <div v-for="event in eventStore.eventsByMonth" :key="event.id" class="p-3 mb-3 rounded animate-scale-in"
                                style="background: rgba(212, 175, 55, 0.05); border-left: 3px solid #d4af37; transition: all 0.3s ease;"
                                @mouseover="hoveredEvent = event.id"
                                @mouseleave="hoveredEvent = null">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1 small fw-bold">{{ event.title }}</h6>
                                        <p class="mb-0 text-white-50" style="font-size: 0.8rem;">
                                            {{ formatDate(event.date) }} at {{ event.time }}
                                        </p>
                                        <p class="mb-0 text-white-50" style="font-size: 0.75rem;">
                                            <i class="bi bi-geo-alt me-1"></i>{{ event.venue }}
                                        </p>
                                    </div>
                                    <transition name="scale" mode="out-in">
                                        <button v-if="hoveredEvent === event.id" class="btn btn-link text-danger p-0"
                                            @click="removeEvent(event.id)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </transition>
                                </div>
                            </div>
                            <div v-if="!eventStore.eventsByMonth.length" :key="'empty'" class="text-center py-4">
                                <i class="bi bi-calendar-x text-gold fs-1"></i>
                                <p class="text-white-50 small mt-2">No events scheduled this month</p>
                            </div>
                        </transition-group>
                    </div>
                </div>
            </div>
        </template>

        <EventModal
            :show="showModal"
            :saving="savingEvent"
            :error="eventError"
            :initial-form="eventForm"
            @close="closeModal"
            @submit="addEvent"
        />
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useEventStore } from '@/stores/events'
import CalendarGrid from '@/components/Events/CalendarGrid.vue'
import EventModal from '@/components/Events/EventModal.vue'

const eventStore = useEventStore()
const showModal = ref(false)
const hoveredEvent = ref(null)
const savingEvent = ref(false)
const eventError = ref(null)

const eventForm = ref({
    title: '',
    date: '',
    time: '',
    venue: '',
    type: 'concert'
})

const eventFormDefaults = {
    title: '',
    date: '',
    time: '',
    venue: '',
    type: 'concert'
}

onMounted(() => {
    eventStore.load()
})

function openAddEventModal() {
    resetEventForm()
    eventError.value = null
    showModal.value = true
}

function closeModal() {
    showModal.value = false
    resetEventForm()
    eventError.value = null
}

async function addEvent(form) {
    savingEvent.value = true
    eventError.value = null

    try {
        await eventStore.addEvent(normalizeEventPayload(form))
        await eventStore.load()
        closeModal()
    } catch (e) {
        eventError.value = e.response?.data?.message || e.message || 'Failed to create event'
    } finally {
        savingEvent.value = false
    }
}

async function removeEvent(id) {
    try {
        await eventStore.deleteEvent(id)
        await eventStore.load()
    } catch (e) {
        eventStore.error = e.response?.data?.message || e.message || 'Failed to delete event'
    }
}

function resetEventForm() {
    Object.assign(eventForm.value, eventFormDefaults)
}

function normalizeEventPayload(event) {
    return {
        ...event,
        time: event.time.length === 5 ? `${event.time}:00` : event.time
    }
}

function formatDate(dateStr) {
    return new Date(dateStr).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
}
</script>

<style scoped>
.scale-enter-active,
.scale-leave-active {
  transition: all 0.2s ease;
}

.scale-enter-from,
.scale-leave-to {
  opacity: 0;
  transform: scale(0.8);
}

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

.card-luxury:hover .rounded {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}
</style>
