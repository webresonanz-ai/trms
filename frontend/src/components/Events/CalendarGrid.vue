<template>
    <div class="card-luxury p-4 animate-fade-in-up">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="brand-font text-gold mb-0">
                <i class="bi bi-calendar3 me-2"></i>
                {{ currentMonthName }} {{ currentYear }}
            </h5>
            <div class="btn-group">
                <button class="btn btn-outline-luxury btn-sm" @click="prevMonth">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="btn btn-outline-luxury btn-sm" @click="nextMonth">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>

        <div class="row g-2 mb-2">
            <div v-for="day in weekDays" :key="day" class="col text-center text-white-50 small fw-bold py-2">
                {{ day }}
            </div>
        </div>

        <div class="row g-2">
            <transition-group name="calendar" tag="div" class="row g-2">
                <div v-for="date in calendarDays" :key="date.date" class="col-12 col-sm"
                    style="flex: 0 0 14.28%; max-width: 14.28%;">
                    <div class="calendar-day d-flex flex-column align-items-center justify-content-center p-2" :class="{
                        'today': date.isToday,
                        'has-event': date.hasEvent,
                        'text-white-50': !date.isCurrentMonth
                    }" @click="selectDate(date.date)">
                        <span class="small fw-medium">{{ date.day }}</span>
                    </div>
                </div>
            </transition-group>
        </div>

        <transition name="slide-fade">
            <div v-if="selectedEvents.length" class="mt-4 pt-3 border-top border-secondary">
                <h6 class="text-gold mb-3">Events on {{ selectedDate }}</h6>
                <div v-for="event in selectedEvents" :key="event.id" class="d-flex align-items-center p-2 mb-2 rounded"
                    style="background: rgba(212, 175, 55, 0.05);">
                    <div class="rounded-circle bg-gold p-1 me-3" style="width: 8px; height: 8px;"></div>
                    <div class="flex-grow-1">
                        <div class="small fw-medium">{{ event.title }}</div>
                        <div class="text-white-50" style="font-size: 0.75rem;">{{ event.time }} • {{ event.venue }}
                        </div>
                    </div>
                    <span class="badge bg-opacity-25 border" :class="eventTypeClass(event.type)">{{ event.type }}</span>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { computed, ref, unref } from 'vue'
import { useEventStore } from '@/stores/events'

const eventStore = useEventStore()
const currentDate = ref(new Date())

const weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']

const currentMonthName = computed(() => {
    return currentDate.value.toLocaleString('default', { month: 'long' })
})

const currentYear = computed(() => currentDate.value.getFullYear())

const selectedDate = computed(() => unref(eventStore.selectedDate))

const selectedEvents = computed(() => unref(eventStore.eventsForDate))

const allEvents = computed(() => {
    const events = unref(eventStore.events)
    return Array.isArray(events) ? events : []
})

const calendarDays = computed(() => {
    const year = currentDate.value.getFullYear()
    const month = currentDate.value.getMonth()

    const firstDay = new Date(year, month, 1)
    const startDate = new Date(year, month, 1 - firstDay.getDay())

    const days = []
    const today = new Date().toLocaleDateString('en-CA')

    for (let i = 0; i < 42; i++) {
        const date = new Date(startDate)
        date.setDate(startDate.getDate() + i)
        const dateStr = date.toLocaleDateString('en-CA')

        days.push({
            date: dateStr,
            day: date.getDate(),
            isCurrentMonth: date.getMonth() === month,
            isToday: dateStr === today,
            hasEvent: allEvents.value.some(e => e.date === dateStr)
        })
    }

    return days
})

function prevMonth() {
    currentDate.value = new Date(currentDate.value.getFullYear(), currentDate.value.getMonth() - 1, 1)
}

function nextMonth() {
    currentDate.value = new Date(currentDate.value.getFullYear(), currentDate.value.getMonth() + 1, 1)
}

function selectDate(date) {
    eventStore.setSelectedDate(date)
}

function eventTypeClass(type) {
    const classes = {
        concert: 'bg-danger text-danger',
        class: 'bg-info text-info',
        rehearsal: 'bg-warning text-warning',
        recital: 'bg-success text-success',
        meeting: 'bg-primary text-primary',
        workshop: 'bg-secondary text-secondary'
    }
    return classes[type] || 'bg-secondary text-secondary'
}
</script>

<style scoped>
.calendar-move {
    transition: transform 0.3s ease;
}

.calendar-enter-active,
.calendar-leave-active {
    transition: all 0.3s ease;
}

.calendar-enter-from,
.calendar-leave-to {
    opacity: 0;
    transform: scale(0.9);
}

.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.3s ease;
}

.calendar-day.has-event::after {
    content: '';
    display: block;
    width: 6px;
    height: 6px;
    background-color: #d4af37;
    border-radius: 50%;
    margin-top: 4px;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>