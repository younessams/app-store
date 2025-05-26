<template>
  <div>
    <button
      @click="trackMyOrder"
      :disabled="loading"
      class="flex items-center gap-2 px-4 py-2 rounded-lg bg-black text-white hover:bg-gray-800 transition disabled:opacity-50 cursor-pointer"
    >
      <svg v-if="!loading" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
           viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 18h.01M12 3.25c5.385 0 9.75 4.365 9.75 9.75S17.385 22.75 12 22.75 2.25 18.385 2.25 13 6.615 3.25 12 3.25z" />
      </svg>
      <svg v-else class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
           viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
      </svg>
      <span>{{ useTrans('track-order-component.track-my-order') }}</span>
    </button>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { useTrans } from '../../composables/trans'

const loading = ref(false)

const trackMyOrder = () => {
  loading.value = true
    router.get(`/checkout/thanks`, {
      onFinish: () => loading.value = false
    });
}
</script>