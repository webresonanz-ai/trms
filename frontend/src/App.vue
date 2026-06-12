<template>
  <div class="app-wrapper">
    <template v-if="isGuestPage">
      <router-view v-slot="{ Component }">
        <transition name="fade" mode="out-in">
          <component :is="Component" />
        </transition>
      </router-view>
    </template>

    <template v-else>
      <div class="row g-0">
        <div class="col-auto">
          <AppSidebar />
        </div>
        <div class="col">
          <div class="main-content">
            <AppTopbar />
            <div class="p-4">
              <router-view v-slot="{ Component }">
                <transition name="fade" mode="out-in">
                  <component :is="Component" />
                </transition>
              </router-view>
            </div>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import AppSidebar from './components/Layout/AppSidebar.vue'
import AppTopbar from './components/Layout/AppTopbar.vue'

const route = useRoute()
const isGuestPage = computed(() => route.meta.guest === true)
</script>

<style scoped>
.app-wrapper {
  min-height: 100vh;
  background: var(--luxury-dark);
}

.main-content {
  min-height: 100vh;
  margin-left: 260px;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

@media (max-width: 768px) {
  .main-content {
    margin-left: 0;
  }
}
</style>