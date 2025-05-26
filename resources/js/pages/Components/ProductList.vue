<script setup>
import ProductCard from './ProductCard.vue';
import Pagination from'./Pagination.vue'
import { useTrans } from '../../composables/trans';

const props = defineProps({
  products: Object,
  getProductImageUrl: Function,
  showProductDetails: Function,
  getCategoryName: Function,
  filters: Object,
  applyFilters: Function
});
</script>
<template>
  <div class="w-full">
    <!-- Sort + Count UI (same as before) -->
    <div class="flex items-center justify-between mb-6">
      <div class="text-sm text-gray-500">
        {{ useTrans('product-list-component.showing') }} {{ products.data.length }} <b>/</b> {{ products.total }}
      </div>
      <div class="sm:hidden relative">
        <select 
          v-model="filters.sort" 
          @change="applyFilters" 
          class="appearance-none py-2 pl-3 pr-10 rounded-lg border border-gray-300 focus:border-gray-500 focus:ring-0 transition text-sm"
        >
          <option value="newest">{{ useTrans('product-list-component.latest') }}</option>
          <option value="price_asc">{{ useTrans('product-list-component.price_low_to_high') }}</option>
          <option value="price_desc">{{ useTrans('product-list-component.price_high_to_low') }}</option>
        </select>
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
          <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </div>
      </div>
    </div>
    <!-- Product Grid using ProductCard -->
    <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
      <ProductCard
        v-for="product in products.data"
        :key="product.id"
        :product="product"
        :getProductImageUrl="getProductImageUrl"
        :showProductDetails="showProductDetails"
        :getCategoryName="getCategoryName"
      />
    </div>
    <!-- Pagination -->
    <div class="mt-16">
      <Pagination :links="products.links" />
    </div>
  </div>
</template>