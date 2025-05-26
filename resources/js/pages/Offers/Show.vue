<template>
  <div class="max-w-5xl mx-auto py-12 px-4 sm:px-6 font-sans mt-18">
    <!-- Featured Badge -->
    <div v-if="offer.featured" class="mb-4 flex">
      <span class="inline-flex items-center rounded-full bg-indigo-100 px-3 py-1 text-sm font-medium text-indigo-800">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
        {{ useTrans('offer.featuredBadge') }}
      </span>
    </div>

    <!-- Card Container -->
    <div class="overflow-hidden rounded-2xl bg-white shadow-xl">
      <!-- Offer Image with Gradient Overlay -->
      <div class="relative">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent z-10"></div>
        <img
          v-if="offer.image_url_path"
          :src="offer.image_url_path"
          :alt="offer.title"
          class="h-72 w-full object-cover"
        />
        <!-- Discount Badge -->
        <div v-if="offer.discount_percentage" class="absolute top-4 right-4 z-20">
          <div class="flex h-16 w-16 items-center justify-center rounded-full bg-rose-600 text-white font-bold">
            <span>{{ offer.discount_percentage }}%</span>
          </div>
        </div>
      </div>

      <!-- Content Section -->
      <div class="px-6 pt-6 pb-8">
        <!-- Offer Metadata -->
        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
          <!-- Validity Period -->
          <div v-if="offer.valid_until" class="flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            <span>{{ useTrans('offer.validUntil') }} {{ offer.valid_until }}</span>
          </div>
          
          <!-- Discount Info Pill -->
          <div v-if="offer.discount_percentage" class="flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12V8H6a2 2 0 1 1 0-4h12v4"></path><path d="M20 12v4H6a2 2 0 1 0 0 4h12v-4"></path></svg>
            <span>{{ offer.discount_percentage }}{{ useTrans('offer.discount') }}</span>
          </div>
        </div>

        <!-- Offer Title -->
        <h1 class="text-3xl font-bold mb-3 text-gray-900">{{ offer.title }}</h1>

        <!-- Offer Description -->
        <p class="text-gray-600 text-lg mb-6">{{ offer.description }}</p>

        <!-- CTA Section -->
        <div class="flex items-center justify-between pt-2">
          <!-- View Products Button -->
          <Link
            :href="`/products?offer=${offer.slug}`"
            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-6 rounded-lg text-sm transition-colors duration-200"
          >
            {{ useTrans('offer.viewProducts') }}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
          </Link>

          <!-- Share Button (Optional) -->
          <button 
            class="p-2 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors"
            :aria-label="useTrans('offer.shareButton')"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Main from '../Main.vue';
import { useTrans } from '../../composables/trans';

defineOptions({
  layout: Main,
});

defineProps({
  offer: Object,
});
</script>