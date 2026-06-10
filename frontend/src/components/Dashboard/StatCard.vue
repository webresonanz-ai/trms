<template>
    <div class="card-luxury stat-card p-4 h-100 animate-fade-in-up">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div class="rounded-circle p-2 stat-icon" style="background: rgba(212, 175, 55, 0.15);">
                <i :class="`bi ${icon} text-gold fs-4`"></i>
            </div>
            <span class="badge bg-success bg-opacity-25 text-success border border-success">
                {{ change }}
            </span>
        </div>
        <h3 class="brand-font mb-1">{{ value }}</h3>
        <p class="text-white-50 mb-0 small">{{ label }}</p>
    </div>
</template>

<script setup>
defineProps({
    label: String,
    value: [String, Number],
    icon: String,
    change: String
})
</script>