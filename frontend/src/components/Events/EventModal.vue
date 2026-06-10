<template>
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.7);" v-if="show">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content card-luxury">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title brand-font text-gold">Add New Event</h5>
                    <button type="button" class="btn-close btn-close-white" @click="emit('close')"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="submit">
                        <div class="mb-3">
                            <label class="form-label text-white-50 small">Event Title</label>
                            <input v-model="form.title" type="text" class="form-control form-control-luxury" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white-50 small">Date</label>
                                <input v-model="form.date" type="date" class="form-control form-control-luxury"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-white-50 small">Time</label>
                                <input v-model="form.time" type="time" class="form-control form-control-luxury"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white-50 small">Venue</label>
                            <input v-model="form.venue" type="text" class="form-control form-control-luxury" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white-50 small">Type</label>
                            <select v-model="form.type" class="form-control form-control-luxury">
                                <option value="concert">Concert</option>
                                <option value="class">Class</option>
                                <option value="rehearsal">Rehearsal</option>
                                <option value="recital">Recital</option>
                                <option value="meeting">Meeting</option>
                                <option value="workshop">Workshop</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-luxury" @click="emit('close')">Cancel</button>
                            <button type="submit" class="btn btn-luxury">Save Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive } from 'vue'
import { useEventStore } from '@/stores/events'

const emit = defineEmits(['close'])

const eventStore = useEventStore()

const form = reactive({
    title: '',
    date: '',
    time: '',
    venue: '',
    type: 'concert'
})

function submit() {
    eventStore.addEvent({ ...form })
    emit('close')
    Object.assign(form, { title: '', date: '', time: '', venue: '', type: 'concert' })
}
</script>