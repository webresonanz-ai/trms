<template>
    <div class="animate-fade-in-up">
        <div class="card-luxury p-5 mb-4 text-center animate-scale-in">
            <div class="mb-4">
                <i class="bi bi-music-note-beamed text-gold" style="font-size: 3rem;"></i>
            </div>
            <h2 class="brand-font text-gold mb-3">The Royal Music School</h2>
            <p class="text-white-50 mx-auto" style="max-width: 600px;">
                Founded in 1892, TRMS has been a beacon of musical excellence for over a century.
                We nurture talent, inspire creativity, and build the next generation of world-class musicians.
            </p>
        </div>

        <div class="row g-4 mb-4">
            <transition-group name="stagger" tag="div" class="row g-4 mb-4">
                <div v-for="(item, index) in values" :key="item.title" class="col-md-4">
                    <div class="card-luxury p-4 text-center h-100" :style="{ animationDelay: `${index * 100}ms` }">
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center animate-float"
                            style="width: 60px; height: 60px; background: rgba(212, 175, 55, 0.15);">
                            <i :class="`bi ${item.icon} text-gold fs-4`"></i>
                        </div>
                        <h5 class="brand-font mb-2">{{ item.title }}</h5>
                        <p class="text-white-50 small mb-0">{{ item.text }}</p>
                    </div>
                </div>
            </transition-group>
        </div>

        <div class="card-luxury p-4 animate-scale-in">
            <h5 class="brand-font text-gold mb-4">Leadership Team</h5>
            <div class="row g-4">
                <div v-for="member in team" :key="member.name" class="col-md-6 col-lg-3">
                    <div class="text-center p-3 team-member">
                        <img :src="member.avatar" class="rounded-circle mb-3" width="80" height="80"
                            style="border: 2px solid #d4af37; transition: all 0.3s ease;">
                        <h6 class="mb-1">{{ member.name }}</h6>
                        <p class="text-gold mb-0" style="font-size: 0.8rem;">{{ member.role }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const team = [
    { name: 'Dr. Elena Voss', role: 'Principal', avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150&h=150&fit=crop' },
    { name: 'Prof. James Chen', role: 'Head of Strings', avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop' },
    { name: 'Maria Santos', role: 'Head of Voice', avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop' },
    { name: 'Robert Klein', role: 'Head of Piano', avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150&h=150&fit=crop' }
]

const values = [
    { title: 'Our Mission', text: 'To provide world-class music education that transforms passionate students into professional artists.', icon: 'bi-bullseye' },
    { title: 'Our Vision', text: 'To be the leading institution for classical and contemporary music education globally.', icon: 'bi-eye' },
    { title: 'Our Values', text: 'Excellence, discipline, creativity, and inclusivity in every note we teach.', icon: 'bi-heart' }
]
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

.team-member {
  transition: all 0.3s ease;
}

.team-member:hover img {
  transform: scale(1.05) rotate(5deg);
  border-color: #f4e5c2;
  box-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
}
</style>