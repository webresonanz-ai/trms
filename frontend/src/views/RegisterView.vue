<template>
    <div class="auth-page d-flex align-items-center justify-content-center min-vh-100 px-3">
        <div class="card card-dark p-4 shadow-lg" style="max-width: 500px; width: 100%;">
            <h2 class="text-gold mb-3">Create Account</h2>
            <p class="text-white-50 small mb-4">Register securely to manage events, profile, and dashboard access.</p>

            <div v-if="auth.error" class="alert alert-danger">{{ auth.error }}</div>

            <form @submit.prevent="submit">
                <div class="mb-3">
                    <label class="form-label text-white">Full Name</label>
                    <input v-model="name" type="text" class="form-control form-control-dark" placeholder="Your name"
                        required />
                </div>

                <div class="mb-3">
                    <label class="form-label text-white">Email</label>
                    <input v-model="email" type="email" class="form-control form-control-dark"
                        placeholder="you@example.com" required />
                </div>

                <div class="mb-3">
                    <label class="form-label text-white">Password</label>
                    <input v-model="password" type="password" class="form-control form-control-dark"
                        placeholder="At least 8 characters" minlength="8" required />
                </div>

                <div class="mb-4">
                    <label class="form-label text-white">Confirm Password</label>
                    <input v-model="passwordConfirmation" type="password" class="form-control form-control-dark"
                        placeholder="Repeat password" minlength="8" required />
                </div>

                <button class="btn btn-gold w-100" type="submit" :disabled="auth.loading">
                    <span v-if="auth.loading" class="spinner-border spinner-border-sm me-2"></span>
                    Register
                </button>
            </form>

            <div class="mt-4 text-center text-white-50 small">
                Already registered? <router-link to="/login" class="link-gold">Sign in</router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const auth = useAuthStore()
const name = ref('')
const email = ref('')
const password = ref('')
const passwordConfirmation = ref('')

async function submit() {
    auth.error = null

    const success = await auth.register({
        name: name.value.trim(),
        email: email.value.trim(),
        password: password.value,
        passwordConfirmation: passwordConfirmation.value,
    })

    if (success) {
        router.push({ name: 'dashboard' })
    }
}
</script>

<style scoped>
.auth-page {
    background: radial-gradient(circle at top, rgba(255, 215, 0, 0.12), transparent 38%),
        linear-gradient(180deg, #050507 0%, #0f1116 100%);
}

.card-dark {
    background: rgba(12, 13, 20, 0.95);
    border: 1px solid rgba(212, 175, 55, 0.15);
}

.btn-gold {
    background-color: #d4af37;
    color: #0f1116;
}

.link-gold {
    color: #d4af37;
}
</style>
