<template>
    <nav class="w-full bg-white shadow-sm py-3 px-6">
  <div class="max-w-7xl mx-auto flex justify-between items-center">
    <!-- Left side - Brand/Title -->
    <div>
      <h1 class="text-gray-600 font-medium text-lg uppercase tracking-wide">{{ pageTitle }}</h1>
    </div>
    
    <!-- Right side - Icons and Profile -->
    <div class="flex items-center space-x-4">
      <!-- Dark Mode Toggle -->
      <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
      </button>
      
      <!-- Notifications with Badge -->
      <div class="relative">
        <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
          </svg>
        </button>
        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">3</span>
      </div>
      
      <!-- Settings -->
      <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
      </button>
      
      <!-- Clock / History -->
      <button class="p-2 text-gray-500 hover:text-gray-700 rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </button>
      
      <!-- Profile Picture -->
      <div class="">
        <Profile_menu />
      </div>
      
      <!-- Search Input -->
      <div class="relative">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
          </svg>
        </span>
        <input type="text" placeholder="Search..." class="pl-10 pr-3 py-2 mb-1 rounded-full bg-gray-100 border-transparent focus:border-gray-300 focus:bg-white focus:ring-0 text-sm w-40">
      </div>
    </div>
  </div>
</nav>
</template>

<script setup>
import Profile_menu from './Profile_menu.vue';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const pageTitle = computed(() => {
  const routeName = usePage().props.pageTitle || ''; // Fallback to avoid errors
  return routeName.split('.').reverse().join(' ');
});
</script>