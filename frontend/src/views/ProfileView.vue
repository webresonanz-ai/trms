<template>
    <div class="row justify-content-center animate-fade-in-up">
        <div class="col-lg-8">
            <ProfileEditor />

            <div v-if="profile.loading" class="card-luxury p-4 mt-4 text-center">
                <div class="spinner-border text-gold" role="status"></div>
                <p class="text-white-50 mt-2">Loading profile...</p>
            </div>
            <div v-else-if="profile.error" class="alert alert-danger mt-4">{{ profile.error }}</div>
            <div v-else class="card-luxury p-4 mt-4 animate-scale-in">
                <h6 class="brand-font text-gold mb-3">Account Statistics</h6>
                <div class="row g-3">
                    <div class="col-md-4 text-center">
                        <h4 class="text-gold mb-1 animate-float">{{ profile.user?.classesTaught || '—' }}</h4>
                        <small class="text-white-50">Classes Taught</small>
                    </div>
                    <div class="col-md-4 text-center">
                        <h4 class="text-gold mb-1 animate-float">{{ profile.user?.studentsMentored || '—' }}</h4>
                        <small class="text-white-50">Students Mentored</small>
                    </div>
                    <div class="col-md-4 text-center">
                        <h4 class="text-gold mb-1 animate-float">{{ profile.user?.yearsAtTrms || '—' }}</h4>
                        <small class="text-white-50">Years at TRMS</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue'
import ProfileEditor from '@/components/Profile/ProfileEditor.vue'
import { useProfileStore } from '@/stores/profile'

const profile = useProfileStore()

onMounted(() => {
  profile.load()
})
</script>
