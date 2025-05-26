<template>
  <nav class="bg-white border-b border-gray-200 shadow-sm fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-around lg:justify-between h-16 items-center">
        <!-- Logo -->
        <LogoStore />

        <!-- Main Nav Links - Hidden on mobile -->
        <div class="hidden lg:flex space-x-8 z-50">
          <div class="neomorph-spinner -mt-2">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
          </div>

          <Link href="/products?sort=newest" class="flex items-center space-x-1 text-gray-600 hover:text-indigo-600 transition font-medium group">
            <svg class="w-5 h-5 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <span>{{ useTrans('Shop') }}</span>
          </Link>

          <div class="relative">
            <button
              @mouseenter="showDropdown = true"
              @mouseleave="showDropdown = false"
              class="flex items-center space-x-1 text-gray-600 hover:text-indigo-600 transition font-medium relative z-10"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9-4 9 4-9 4-9-4zm0 6l9 4 9-4m-18 6l9 4 9-4" />
              </svg>
              <span>{{ useTrans('Categories') }}</span>
            </button>

            <!-- Dropdown -->
            <transition
              name="fade-slide"
              enter-active-class="transition ease-out duration-200"
              enter-from-class="opacity-0 translate-y-2"
              enter-to-class="opacity-100 translate-y-0"
              leave-active-class="transition ease-in duration-150"
              leave-from-class="opacity-100 translate-y-0"
              leave-to-class="opacity-0 translate-y-2"
            >
              <div
                v-show="showDropdown"
                @mouseenter="showDropdown = true"
                @mouseleave="showDropdown = false"
                class="absolute mt-2 bg-white border border-gray-200 rounded-md shadow-lg z-20 w-96 max-w-screen-sm"
                :class="{ 'left-0': !isRTL, 'right-0': isRTL }"
              >
                <ul class="py-2 px-2 grid grid-cols-2 sm:grid-cols-3 gap-2">
                  <li v-for="category in $page.props.categories" :key="category.id">
                    <Link
                      :href="`/products?category=${category.slug}`"
                      class="block text-sm text-gray-700 hover:bg-gray-100 px-2 py-1 rounded"
                    >
                      {{ category.name }}
                    </Link>
                  </li>
                </ul>
              </div>
            </transition>
          </div>

          <Link href="/about" class="flex items-center space-x-1 text-gray-600 hover:text-indigo-600 transition font-medium group">
            <svg class="w-5 h-5 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ useTrans('About') }}</span>
          </Link>

          <Link href="/contact" class="flex items-center space-x-1 text-gray-600 hover:text-indigo-600 transition font-medium group">
            <svg class="w-5 h-5 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span>{{ useTrans('Contact Us') }}</span>
          </Link>
        </div>

        <!-- Right Actions -->
        <div class="flex items-center  space-x-4">
          <Link href="/checkout/thanks" class="relative group">
            <div class="absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-800">
                {{ useTrans('Track') }}
              </span>
            </div>
            <svg class="w-6 h-6 text-gray-600 hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
          </Link>

          <button @click="openWishlistModal" class="relative group">
            <div class="absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer">
              <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-pink-100 text-pink-800">
                {{ useTrans('Saved') }}
              </span>
            </div>
            <svg class="w-6 h-6 text-gray-600 hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
          </button>

          <Link href="/cart" class="relative group">
            <div class="absolute -top-2 -right-2 bg-indigo-600 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full transition-transform group-hover:scale-110">
              {{ $page.props.cart.quantity ?? 0 }}
            </div>
            <svg class="w-6 h-6 text-gray-600 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </Link>

          <div class="h-6 w-px bg-gray-300 mx-1"></div>

          <Link 
            :href="user ? '/' : '/register'" 
            class="inline-flex items-center space-x-1 text-gray-600 hover:text-indigo-600 transition group"
          >
            <svg class="w-6 h-6 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-sm font-medium hidden sm:inline">
              {{ user ? user.name : useTrans('Account') }}
            </span>
          </Link>

          <LangSwitcher class="hidden lg:block" />
        </div>

        <!-- Mobile Menu Button -->
        <button 
          @click="mobileOpen = !mobileOpen" 
          class="lg:hidden text-gray-600 hover:text-indigo-600 transition focus:outline-none"
          aria-label="Toggle menu"
        >
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path v-if="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile Menu - Added this section -->
    <transition
      enter-active-class="transition-opacity ease-linear duration-300"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition-opacity ease-linear duration-300"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="mobileOpen" class="lg:hidden bg-white border-t border-gray-200 shadow-lg">
        <div class="px-2 pt-2 pb-3 space-y-1">
          <Link href="/products?sort=newest" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">
            {{ useTrans('Shop') }}
          </Link>
          
          <!-- Categories dropdown for mobile -->
          <div>
            <button 
              @click="mobileCategoryOpen = !mobileCategoryOpen" 
              class="flex justify-between w-full px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50"
            >
              <span>{{ useTrans('Categories') }}</span>
              <svg 
                class="w-5 h-5 transform transition-transform duration-200" 
                :class="{'rotate-180': mobileCategoryOpen}"
                fill="none" 
                stroke="currentColor" 
                viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            
            <div v-if="mobileCategoryOpen" class="pl-4 py-2 space-y-1">
              <div class="grid grid-cols-2 gap-1">
                <div v-for="category in $page.props.categories" :key="category.id">
                  <Link
                    :href="`/products?category=${category.slug}`"
                    class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-indigo-600 hover:bg-gray-50"
                    @click="mobileOpen = false"
                  >
                    {{ category.name }}
                  </Link>
                </div>
              </div>
            </div>
          </div>
          
          <Link href="/about" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">
            {{ useTrans('About') }}
          </Link>
          
          <Link href="/contact" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">
            {{ useTrans('Contact Us') }}
          </Link>

          <!-- Language switcher for mobile -->
          <div class="px-3 py-2">
            <LangSwitcher />
          </div>
        </div>
      </div>
    </transition>
  </nav>

  <!-- Wishlist Modal -->
    <WishlistModal
      :show="wishlistOpen"
      :wishlists="wishlists"
      :loading="loading"
      @close="wishlistOpen = false"
      @update:wishlists="wishlists = $event"
      @moveToCart="handleMoveToCart"
    />
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import axios from 'axios'
import WishlistModal from './WishlistModal.vue'
import { getGuestToken } from '../../utils/guestToken'
import LogoStore from './LogoStore.vue'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import LangSwitcher from './LangSwitcher.vue'
import { useTrans } from '../../composables/trans'

// Get the authenticated user from the shared Inertia props
const user = computed(() => usePage().props.auth.user)

// Check if the current locale is RTL
const isRTL = computed(() => {
  const locale = usePage().props.locale || 'en'
  return ['ar', 'he', 'fa', 'ur'].includes(locale)
})

// Desktop dropdown state
const showDropdown = ref(false)

// Mobile menu state
const mobileOpen = ref(false)
const mobileCategoryOpen = ref(false)

// Wishlist modal state
const wishlistOpen = ref(false)
const wishlists = ref([])
const loading = ref(false)

const openWishlistModal = async () => {
  wishlistOpen.value = true
  loading.value = true

  try {
    const response = await axios.get('wishlist/fetch', {
      params: {
        guest_token: getGuestToken()
      }
    })
    wishlists.value = response.data.wishlists
  } catch (error) {
    console.error('Error fetching wishlists:', error)
    wishlists.value = []
  } finally {
    loading.value = false
  }
}

const closeModal = () => {
  wishlistOpen.value = false
}
</script>

<style scoped>
/* From Uiverse.io by MyNameJeremy */ 
.neomorph-spinner {
  position: absolute;
  width: 10px;
  height: 10px;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
  /* margin-top: -15px; */
  margin-left: -12px;
  box-shadow: 0 2px 10px 0 rgba(0, 0.3, 0, 0);
}

.neomorph-spinner > div {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background-color: green;
  box-shadow: 0 2px 10px 0 rgba(0, 0.3, 0, 0);
  animation: spin_5113 0.8s ease infinite;
}

.neomorph-spinner > div:nth-child(1) {
  transform: rotate(0deg);
}

.neomorph-spinner > div:nth-child(2) {
  transform: rotate(90deg);
}

.neomorph-spinner > div:nth-child(3) {
  transform: rotate(180deg);
}

.neomorph-spinner > div:nth-child(4) {
  transform: rotate(270deg);
}

@keyframes spin_5113 {
  0% {
    opacity: 1;
  }

  100% {
    opacity: 0.2;
  }
}
</style>