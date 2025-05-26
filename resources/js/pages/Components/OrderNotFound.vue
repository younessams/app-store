<template>
    <div class="max-w-screen-md mx-auto p-6 text-center mt-18">
      <!-- Error Animation SVG -->
      <div class="flex justify-center mb-6 animate-fadeIn">
        <svg class="w-24 h-24" viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg">
          <circle class="animate-circle" cx="60" cy="60" r="54" fill="none" stroke="#FFEBEE" stroke-width="12" />
          <path class="animate-x" d="M40,40 L80,80 M80,40 L40,80" fill="none" stroke="#F44336" stroke-width="8" stroke-linecap="round" />
          <circle class="animate-pulse" cx="60" cy="60" r="48" fill="none" stroke="#FFCDD2" stroke-width="2" stroke-dasharray="4 4" />
        </svg>
      </div>
  
      <h1 class="text-3xl font-bold mb-3 text-gray-800 animate-fadeIn">{{ useTrans('order-not-found-component.title') }}</h1>
      <p class="text-lg mb-6 text-gray-600 animate-fadeIn">{{ useTrans('order-not-found-component.subtitle') }}</p>
  
      <!-- Message Card -->
      <div class="bg-white rounded-lg shadow-lg p-6 mb-8 transform transition-all duration-500 animate-slideUp">
        <div class="flex items-center justify-center mb-4">
          <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <h2 class="text-xl font-semibold text-gray-700">{{ useTrans('order-not-found-component.what-happened-title') }}</h2>
        </div>
  
        <div class="text-left mb-4">
          <p class="mb-2">{{ useTrans('order-not-found-component.reasons-intro') }}</p>
          <ul class="list-disc pl-5 space-y-1 text-gray-600">
            <li>{{ useTrans('order-not-found-component.reason-incorrect') }}</li>
            <li>{{ useTrans('order-not-found-component.reason-cancelled') }}</li>
            <li>{{ useTrans('order-not-found-component.reason-system') }}</li>
          </ul>
        </div>
        
        <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-md text-left mt-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <p class="text-sm text-red-700">
                {{ useTrans('order-not-found-component.error-message') }}
              </p>
            </div>
          </div>
        </div>
      </div>
  
      <div class="flex flex-col items-center animate-slideUp" style="animation-delay: 400ms;">
        <div class="relative mb-8">
          <div class="flex items-center justify-center bg-blue-50 rounded-lg p-4 max-w-md text-blue-800">
            <svg class="w-6 h-6 text-blue-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p>{{ useTrans('order-not-found-component.help-message') }}</p>
          </div>
          <!-- Decorative wave SVG -->
          <svg class="absolute -bottom-3 left-0 w-full h-3 text-blue-50" preserveAspectRatio="none" viewBox="0 0 100 10">
            <path d="M0 10 C 30 4, 70 4, 100 10 L 100 0 L 0 0 Z" fill="currentColor"></path>
          </svg>
        </div>
  
        <div class="flex space-x-4">
          <Link 
            href="/products" 
            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg shadow-md transform transition-all duration-300 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            {{ useTrans('order-not-found-component.browse-products') }}
          </Link>
  
          <Link 
            href="/contact" 
            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-medium rounded-lg shadow-md transform transition-all duration-300 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50"
          >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            {{ useTrans('order-not-found-component.contact-support') }}
          </Link>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { Link } from '@inertiajs/vue3';
  import { useTrans } from '../../composables/trans';
  import Navbar from '../Components/Navbar.vue';
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
  
  @keyframes drawX {
    0% { stroke-dasharray: 0 120; }
    100% { stroke-dasharray: 120 120; }
  }
  
  @keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.05); opacity: 0.7; }
    100% { transform: scale(1); opacity: 1; }
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
  
  .animate-x {
    stroke-dasharray: 120 120;
    stroke-dashoffset: 120;
    animation: drawX 0.6s 0.8s ease-in-out forwards;
  }
  
  .animate-pulse {
    animation: pulse 2s infinite;
  }
  </style>