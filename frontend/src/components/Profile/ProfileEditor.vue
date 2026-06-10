<template>
    <div class="card-luxury p-4 animate-fade-in-up">
        <div class="text-center mb-4">
            <div class="position-relative d-inline-block">
                <img :src="user.avatar" class="rounded-circle mb-3" width="120" height="120"
                    style="border: 3px solid #d4af37; transition: all 0.3s ease;"
                    :class="{ 'animate-pulse': hoveringAvatar }">
                <button class="btn btn-luxury btn-sm position-absolute bottom-0 end-0 rounded-circle avatar-upload"
                    style="width: 36px; height: 36px; padding: 0;"
                    @mouseenter="hoveringAvatar = true"
                    @mouseleave="hoveringAvatar = false">
                    <i class="bi bi-camera"></i>
                </button>
            </div>
            <h4 class="brand-font mb-1">{{ user.name }}</h4>
            <p class="text-gold mb-0">{{ user.role }}</p>
        </div>

        <form @submit.prevent="save">
            <div class="row">
                <div v-for="field in fields" :key="field.key" class="col-md-6 mb-3">
                    <label class="form-label text-white-50 small">{{ field.label }}</label>
                    <input v-model="form[field.key]" :type="field.type" class="form-control form-control-luxury">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label text-white-50 small">Bio</label>
                    <textarea v-model="form.bio" rows="3" class="form-control form-control-luxury"
                        placeholder="Tell us about yourself..."></textarea>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-luxury" :disabled="saving">
                    <i class="bi bi-check-lg me-2"></i>
                    {{ saving ? 'Saving...' : 'Save Changes' }}
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { reactive, watch, ref } from 'vue'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const saving = ref(false)
const hoveringAvatar = ref(false)

const fields = [
    { key: 'name', label: 'Full Name', type: 'text' },
    { key: 'email', label: 'Email', type: 'email' },
    { key: 'phone', label: 'Phone', type: 'tel' },
    { key: 'department', label: 'Department', type: 'text' }
]

const user = auth.user
const form = reactive({ ...auth.user })

watch(() => auth.user, (newUser) => {
    Object.assign(form, newUser)
}, { deep: true })

async function save() {
    saving.value = true
    await new Promise(resolve => setTimeout(resolve, 500))
    auth.updateProfile({ ...form })
    saving.value = false
}
</script>

<style scoped>
.avatar-upload {
  transition: all 0.3s ease;
}

.avatar-upload:hover {
  transform: scale(1.1) rotate(15deg);
}
</style>