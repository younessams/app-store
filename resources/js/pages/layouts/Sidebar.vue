<template>
    <div class="min-h-screen bg-gray-100 fixed top-0 left-0 z-10">
      <div class="hidden md:block w-64 h-screen bg-white shadow-md">
        <!-- Logo section -->
        <div class="py-2">
          <LogoStore />
        </div>
  
        <!-- Menu sections -->
        <div class="px-4 py-2">
          <p class="text-xs font-medium text-gray-400">GENERAL</p>
        </div>
  
        <!-- Menu items -->
        <div>
          <Link href="/admin/dashboard" class="flex items-center px-4 py-3 text-orange-500 bg-orange-100 border-l-4 border-orange-500">
            <div class="w-6 h-6 mr-3">
              <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
                <path d="M4 13h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1zm0 8h6a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1zm10-8h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1zm0 8h6a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-6a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1z" />
              </svg>
            </div>
            <span class="font-medium">Dashboard</span>
          </Link>
  
          <div>
            <!-- Products menu -->
            <div @click="toggleProducts" class="flex items-center justify-between px-4 py-3 text-orange-500 cursor-pointer hover:bg-gray-50">
              <div class="flex items-center">
                <div class="w-6 h-6 mr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                  </svg>
                </div>
                <span class="font-medium">Products</span>
              </div>
              <svg class="w-5 h-5 transition-transform" :class="{ 'transform rotate-180': productsOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </div>
  
            <div v-if="productsOpen" class="ml-6 border-l border-gray-200">
              <Link href="/admin/products" class="block px-4 py-2 text-gray-600 hover:bg-gray-50">List</Link>
              <Link href="/admin/products/create" class="block px-4 py-2 text-gray-600 hover:bg-gray-50">Create</Link>
            </div>
          </div>

            <!-- Categories menu -->
          <div>
            <div @click="toggleCategory" class="flex items-center justify-between px-4 py-3 text-orange-500 cursor-pointer hover:bg-gray-50">
              <div class="flex items-center">
                <div class="w-6 h-6 mr-3">
                  <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 3H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2zm-13 16v-6h2v6H6zm5 0v-8h2v8h-2zm5 0v-4h2v4h-2z" />
                  </svg>
                </div>
                <span class="font-medium">Categories</span>
              </div>
              <svg class="w-5 h-5 transition-transform" :class="{ 'transform rotate-180': categoryOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </div>
            <div v-if="categoryOpen" class="ml-6 border-l border-gray-200">
              <Link href="/admin/categories" class="block px-4 py-2 text-gray-600 hover:bg-gray-50">List</Link>
              <Link href="/admin/categories/create" class="block px-4 py-2 text-gray-600 hover:bg-gray-50">Create</Link>
            </div>
          </div>

          <!-- Offers -->
          <div>
            <div @click="toggleOffer" class="flex items-center justify-between px-4 py-3 text-orange-500 cursor-pointer hover:bg-gray-50">
              <div class="flex items-center">
                <div class="w-6 h-6 mr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-500 group-hover:text-blue-600 transition duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9l4 4-8 8H5a2 2 0 01-2-2v-8l8-8 6 6z" />
                    <circle cx="9" cy="15" r="1.5" />
                  </svg>

                </div>
                <span class="font-medium">Offers</span>
              </div>
              <svg class="w-5 h-5 transition-transform" :class="{ 'transform rotate-180': offerOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </div>
            <div v-if="offerOpen" class="ml-6 border-l border-gray-200">
              <Link href="/admin/offers" class="block px-4 py-2 text-gray-600 hover:bg-gray-50">List</Link>
              <Link href="/admin/offers/create" class="block px-4 py-2 text-gray-600 hover:bg-gray-50">Create</Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { Link } from '@inertiajs/vue3';
import LogoStore from '../Components/LogoStore.vue';
  
  const productsOpen = ref(false);
  const categoryOpen = ref(false);
  const offerOpen = ref(false);
  
  const toggleProducts = () => {
    productsOpen.value = !productsOpen.value;
  };
  
  const toggleCategory = () => {
    categoryOpen.value = !categoryOpen.value;
  };

  const toggleOffer = () => {
    offerOpen.value = !offerOpen.value;
  };
  </script>