<template>
    <div class="absolute top-2 right-2 z-10">
      <!-- Wishlist Button -->
      <button 
        @click="toggleWishlist" 
        :disabled="loading" 
        class="rounded-full bg-white shadow-md transition-all duration-300 transform p-1"
        :class="loading ? 'opacity-70 cursor-not-allowed' : 'hover:scale-110'"
        :aria-label="inWishlist ? 'Remove from wishlist' : 'Add to wishlist'"
      >
        <!-- Heart Icon - Filled Version -->
        <svg
          v-if="inWishlist"
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6 transition-all duration-500 ease-in-out text-red-500"
          :class="{ 'scale-125': isAnimating, 'scale-100': !isAnimating }"
          fill="currentColor"
          viewBox="0 0 20 20"
        >
          <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.657l-6.828-6.829a4 4 0 010-5.656z" />
        </svg>
        
        <!-- Heart Icon - Outline Version -->
        <svg
          v-else
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6 transition-all duration-500 ease-in-out text-gray-400 hover:text-red-500"
          :class="{ 'scale-125': isAnimating, 'scale-100': !isAnimating }"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            stroke-width="2"
            d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.682l-7.682-7.682a4.5 4.5 0 010-6.364z" 
          />
        </svg>
      </button>
      
      <!-- Animation elements -->
      <div v-if="isAnimating && inWishlist" class="absolute top-0 left-0 w-full h-full pointer-events-none">
        <!-- Heart particles -->
        <div 
          v-for="i in 6" 
          :key="i"
          class="absolute top-1/2 left-1/2 w-2 h-2 rounded-full bg-red-500"
          :style="{
            animation: `particle 0.7s ease-out forwards`,
            animationDelay: `${i * 0.05}s`,
            transform: `translate(-50%, -50%) rotate(${i * 60}deg) translateY(-10px)`,
            opacity: 0
          }"
        ></div>
        
        <!-- Ripple effect -->
        <div class="absolute inset-0 flex items-center justify-center">
          <div class="w-12 h-12 rounded-full bg-red-100 animate-ping opacity-70"></div>
        </div>
      </div>
    </div>
    
    <!-- Toast notification - Using vue-toastification from your original code -->
  </template>
  
  <script setup>
  import { ref, watch } from 'vue'
  import { router } from '@inertiajs/vue3'
  import { useToast } from 'vue-toastification'
import { getGuestToken } from '../../utils/guestToken'
  
  const props = defineProps({
    productId: {
      type: Number,
      required: true,
    },
    initialInWishlist: {
      type: Boolean,
      default: false,
    },
  })
  
  const inWishlist = ref(props.initialInWishlist)
  const loading = ref(false)
  const isAnimating = ref(false)
  const toast = useToast()
  
  const toggleWishlist = async () => {
    if (loading.value) return
    
    loading.value = true
    isAnimating.value = true
    
    router.post('/wishlist/toggle', { 
        product_id: props.productId,
        guest_token: getGuestToken()
     }, {
      preserveScroll: true,
      onSuccess: () => {
        inWishlist.value = !inWishlist.value
        // toast.success(inWishlist.value ? 'Added to wishlist' : 'Removed from wishlist')
      },
      onError: () => {
        toast.error('Something went wrong. Please try again.')
      },
      onFinish: () => {
        loading.value = false
        // Keep animation running a bit longer than the loading state
        setTimeout(() => {
          isAnimating.value = false
        }, 300)
      }
    })
  }
  
  // Reset animation state after timeout
  watch(isAnimating, (newValue) => {
    if (newValue) {
      setTimeout(() => {
        isAnimating.value = false
      }, 700)
    }
  })
  </script>
  
  <style scoped>
  @keyframes particle {
    0% { 
      transform: translate(-50%, -50%) rotate(var(--rotation)) translateY(0);
      opacity: 1;
    }
    100% { 
      transform: translate(-50%, -50%) rotate(var(--rotation)) translateY(-20px);
      opacity: 0;
    }
  }
  
  .animate-ping {
    animation: ping 1s cubic-bezier(0, 0, 0.2, 1) forwards;
  }
  
  @keyframes ping {
    0% {
      transform: scale(0.5);
      opacity: 0;
    }
    50% {
      opacity: 0.7;
    }
    100% {
      transform: scale(2);
      opacity: 0;
    }
  }
  </style>