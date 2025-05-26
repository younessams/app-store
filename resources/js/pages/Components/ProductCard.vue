<script setup>
import AddToWishlist from './AddToWishlist.vue';
import { defineProps } from 'vue';
import { useTrans } from '../../composables/trans';

const props = defineProps({
  product: Object,
  getProductImageUrl: Function,
  showProductDetails: Function,
  getCategoryName: Function,
});
</script>

<template>
  <div class="group">
    <!-- Product image with hover overlay -->
    <div class="relative aspect-square overflow-hidden rounded-xl bg-gray-100 mb-4">
      <img
        :src="getProductImageUrl(product)"
        class="h-full w-full object-cover object-center transition-transform duration-300 group-hover:scale-105"
        :alt="product.name"
      />
      <AddToWishlist :product-id="product.id" :initial-in-wishlist="product.in_wishlist"/>

      <!-- Hover overlay with Shop Now button -->
      <div class="absolute inset-0 bg-black/0 hover:bg-black/25 transition-opacity duration-300 flex items-center justify-center">
        <button 
          @click="showProductDetails(product)"
          class="bg-white cursor-pointer opacity-0 group-hover:opacity-100 z-10 hover:bg-gray-100 text-gray-900 font-medium py-2.5 px-5 rounded-full transition-colors transform hover:scale-105 uppercase text-sm tracking-wide"
        >
          {{ useTrans('product-card-component.shop-now') }}
        </button>
      </div>
    </div>

    <!-- Product info -->
    <div class="flex flex-col">
      <p v-if="product.brand || product.category" class="text-xs text-gray-500 mb-1">
        {{ product.brand || getCategoryName(product.id) }}
      </p>

      <h3 class="text-sm font-medium text-gray-900 mb-1">{{ product.name }}</h3>
      <p v-if="product.color" class="text-xs text-gray-500 mb-2">{{ product.color }}</p>

      <div class="flex items-center justify-between">
        <p class="text-sm font-semibold text-gray-900">{{ useTrans('product-card-component.currency') }} {{ product.price }}</p>

        <div class="flex space-x-1">
          <div 
            v-for="(color, idx) in (product.colors || []).slice(0, 3)" 
            :key="idx"
            class="h-3 w-3 rounded-full border border-gray-300"
            :class="color.class"
          ></div>
          <div v-if="(product.colors || []).length > 3" class="text-xs text-gray-500">
            + {{product.colors.length - 3}}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>