<template>
  <div v-if="order" class="max-w-screen-md mx-auto p-6 text-center mt-16">
    <!-- Success Animation SVG -->
    <div class="flex justify-center mb-6 animate-fadeIn">
      <svg class="w-24 h-24" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
        <circle class="animate-circle" cx="60" cy="60" r="54" fill="none" stroke="#E8F5E9" stroke-width="12" />
        <path class="animate-check" d="M40,60 L55,75 L80,45" fill="none" stroke="#4CAF50" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </div>

    <h1 class="text-3xl font-bold mb-3 text-gray-800 animate-fadeIn">{{ useTrans('thanks.title') }}</h1>
    <p class="text-lg mb-6 text-gray-600 animate-fadeIn">{{ useTrans('thanks.subtitle') }}</p>

    <!-- Order Summary Card -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8 transform transition-all duration-500 animate-slideUp">
      <div class="flex items-center justify-center mb-4">
        <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <h2 class="text-xl font-semibold text-gray-700">{{ useTrans('thanks.summary_title') }}</h2>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 text-left">
        <div class="bg-gray-50 p-3 rounded-md">
          <div class="flex items-center mb-1">
            <svg class="w-5 h-5 text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
            </svg>
            <span class="text-sm text-gray-500">{{ useTrans('thanks.order_number') }}</span>
          </div>
          <p class="font-semibold">{{ order.id }}</p>
        </div>

        <div class="bg-gray-50 p-3 rounded-md">
          <div class="flex items-center mb-1">
            <svg class="w-5 h-5 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm text-gray-500">{{ useTrans('thanks.total_price') }}</span>
          </div>
          <p class="font-semibold">${{ order.total_price }}</p>
        </div>

        <div class="bg-gray-50 p-3 rounded-md">
          <div class="flex items-center mb-1">
            <svg class="w-5 h-5 text-purple-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm text-gray-500">{{ useTrans('thanks.status') }}</span>
          </div>
          <p class="font-semibold">{{ order.status }}</p>
        </div>
      </div>
    </div>

    <!-- Order Details -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8 animate-slideUp" style="animation-delay: 200ms;">
      <div class="flex items-center justify-center mb-4">
        <svg class="w-6 h-6 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
        </svg>
        <h2 class="text-xl font-semibold text-gray-700">{{ useTrans('thanks.details_title') }}</h2>
      </div>

      <ul class="divide-y divide-gray-200">
        <li v-for="item in order.items" :key="item.id" class="py-4 transform transition hover:bg-gray-50 rounded-md px-3">
          <div class="flex items-center justify-between mb-2">
            <p class="font-bold text-lg text-gray-800">{{ item.product.name }}</p>
            <p class="font-semibold text-green-600">${{ item.price }}</p>
          </div>

          <div class="flex items-center text-gray-600 mb-2">
            <svg class="w-5 h-5 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
            </svg>
            <span>{{ useTrans('thanks.quantity') }}: {{ item.quantity }}</span>
          </div>

          <div v-if="item.sizes && item.sizes.length" class="flex items-start mt-2">
            <svg class="w-5 h-5 mr-1 text-gray-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
            </svg>
            <div>
              <p class="font-medium text-gray-700">{{ useTrans('thanks.sizes') }}:</p>
              <div class="flex flex-wrap gap-2 mt-1">
                <span v-for="size in item.sizes" :key="size.id" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                  {{ size.name }} ({{ size.pivot.quantity }})
                </span>
              </div>
            </div>
          </div>

          <div v-if="item.colors && item.colors.length" class="flex items-start mt-2">
            <svg class="w-5 h-5 mr-1 text-gray-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
            </svg>
            <div>
              <p class="font-medium text-gray-700">{{ useTrans('thanks.colors') }}:</p>
              <div class="flex flex-wrap gap-2 mt-1">
                <span v-for="color in item.colors" :key="color.id" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                  {{ color.name }} ({{ color.pivot.quantity }})
                </span>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>

    <div class="flex flex-col items-center animate-slideUp" style="animation-delay: 400ms;">
      <div class="relative mb-8">
        <div class="flex items-center justify-center bg-blue-50 rounded-lg p-4 max-w-md text-blue-800">
          <svg class="w-6 h-6 text-blue-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <p>{{ useTrans('thanks.whatsapp_message') }}</p>
        </div>
      </div>
    </div>
  </div>
    <OrderNotFound v-else />
  </template>
  
  <script setup>
  import { Link } from '@inertiajs/vue3';
  import { defineProps } from 'vue';
import OrderNotFound from '../Components/OrderNotFound.vue';
import Main from '../Main.vue';
import { useTrans } from '../../composables/trans';

defineOptions({
  layout: Main, // Assign layout dynamically
});
  
  // Defining the props
  const props = defineProps({
    order: Object
  });
  </script>
  
  <style scoped>
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  
  @keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
  
  @keyframes drawCircle {
    0% { stroke-dasharray: 0 360; }
    100% { stroke-dasharray: 360 360; }
  }
  
  @keyframes drawCheck {
    0% { stroke-dasharray: 0 100; }
    100% { stroke-dasharray: 100 100; }
  }
  
  .animate-fadeIn {
    animation: fadeIn 0.8s ease-in-out forwards;
  }
  
  .animate-slideUp {
    animation: slideUp 0.8s ease-out forwards;
  }
  
  .animate-circle {
    stroke-dasharray: 360 360;
    stroke-dashoffset: 0;
    animation: drawCircle 1s ease-in-out forwards;
  }
  
  .animate-check {
    stroke-dasharray: 100 100;
    stroke-dashoffset: 0;
    animation: drawCheck 0.6s 0.8s ease-in-out forwards;
  }
  
  .animate-bounce {
    animation: bounce 1s infinite;
  }
  
  @keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-3px); }
  }
  </style>