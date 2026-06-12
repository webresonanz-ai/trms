<template>
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.7);" v-if="show">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content card-luxury">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title brand-font text-gold">Add New Event</h5>
                    <button type="button" class="btn-close btn-close-white" @click="emit('close')"></button>
                </div>
                <div class="modal-body">
                    <div v-if="error" class="alert alert-danger small py-2 mb-3">{{ error }}</div>
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
                            <button type="button" class="btn btn-outline-luxury" :disabled="saving" @click="emit('close')">Cancel</button>
                            <button type="submit" class="btn btn-luxury" :disabled="saving">
                                <span v-if="saving" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                Save Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, watch } from 'vue'

const props = defineProps({
    show: { type: Boolean, default: false },
    saving: { type: Boolean, default: false },
    error: { type: String, default: null },
    initialForm: { type: Object, default: () => ({}) }
})

const emit = defineEmits(['close', 'submit'])

const formDefaults = {
    title: '',
    date: '',
    time: '',
    venue: '',
    type: 'concert'
}

const form = reactive({ ...formDefaults })

watch(() => props.initialForm, (value) => {
    Object.assign(form, formDefaults, value || {})
}, { immediate: true })

function submit() {
    if (props.saving) return
    emit('submit', form)
}
</script>