<template>
    <div class="row justify-content-center animate-fade-in-up">
        <div class="col-lg-8">
            <ProfileEditor />

            <div class="card-luxury p-4 mt-4 animate-scale-in">
                <h6 class="brand-font text-gold mb-3">Account Statistics</h6>
                <div class="row g-3">
                    <div class="col-md-4 text-center">
                        <h4 class="text-gold mb-1 animate-float">42</h4>
                        <small class="text-white-50">Classes Taught</small>
                    </div>
                    <div class="col-md-4 text-center">
                        <h4 class="text-gold mb-1 animate-float">156</h4>
                        <small class="text-white-50">Students Mentored</small>
                    </div>
                    <div class="col-md-4 text-center">
                        <h4 class="text-gold mb-1 animate-float">8</h4>
                        <small class="text-white-50">Years at TRMS</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import ProfileEditor from '@/components/Profile/ProfileEditor.vue'
</script>