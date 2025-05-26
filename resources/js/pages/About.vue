<template>
    <div dir="rtl" class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 py-12 px-4 sm:px-6 mt-14">
      <div class="max-w-5xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-16">
          <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-700">
              {{ useTrans('about.title') }}
            </span>
          </h1>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            {{ useTrans('about.subtitle') }}
          </p>
        </div>
  
        <!-- Main Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
          <!-- Delivery Information Card -->
          <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 py-4 px-6">
              <h2 class="text-2xl font-bold text-white flex items-center">
                <span class="ml-3"><i class="fas fa-shipping-fast"></i></span>
                {{ useTrans('about.delivery.title') }}
              </h2>
            </div>
            <div class="p-6">
              <ul class="space-y-3 text-right">
                <li class="flex items-center text-gray-700">
                  <span class="text-lg">{{ useTrans('about.delivery.cod') }}</span>
                  <span class="ml-3 text-indigo-500"><i class="fas fa-money-bill-wave"></i></span>
                </li>
                <li class="flex items-center text-gray-700">
                  <span class="text-lg">{{ useTrans('about.delivery.bank_payment') }}</span>
                  <span class="ml-3 text-indigo-500"><i class="fas fa-money-bill-wave"></i></span>
                </li>
                <li class="flex items-center text-gray-700">
                  <span class="text-lg">{{ useTrans('about.delivery.fast_delivery') }}</span>
                  <span class="ml-3 text-indigo-500"><i class="fas fa-clock"></i></span>
                </li>
                <li class="flex items-center text-gray-700">
                  <span class="text-lg">{{ useTrans('about.delivery.free_delivery') }}</span>
                  <span class="ml-3 text-indigo-500"><i class="fas fa-gift"></i></span>
                </li>
                <li class="flex items-center text-gray-700">
                  <span class="text-lg">{{ useTrans('about.delivery.delivery_cost') }}</span>
                  <span class="ml-3 text-indigo-500"><i class="fas fa-truck"></i></span>
                </li>
                <li class="flex items-center text-gray-700">
                  <span class="text-lg">{{ useTrans('about.delivery.support') }}</span>
                  <span class="ml-3 text-indigo-500"><i class="fas fa-headset"></i></span>
                </li>
                <li class="flex items-center text-gray-700">
                  <span class="text-lg">{{ useTrans('about.delivery.return_policy') }}</span>
                  <span class="ml-3 text-indigo-500"><i class="fas fa-undo"></i></span>
                </li>
              </ul>
            </div>
          </div>
  
          <!-- Contact Information Card -->
          <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 py-4 px-6">
              <h2 class="text-2xl font-bold text-white flex items-center">
                <span class="ml-3"><i class="fas fa-address-card"></i></span>
                {{ useTrans('about.contact.title') }}
              </h2>
            </div>
            <div class="p-6">
              <div class="mb-8 flex justify-center">
                <div class="w-32 h-32 rounded-full bg-gray-200 flex items-center justify-center">
                  <span class="text-gray-400 text-5xl">
                    <i class="fas fa-user"></i>
                  </span>
                </div>
              </div>
              <ul class="space-y-4">
                <li class="flex items-center justify-between text-gray-700 bg-gray-50 rounded-lg p-3">
                  <span class="text-lg font-medium">{{ useTrans('about.contact.shop_name') }}</span>
                  <span class="bg-indigo-100 text-indigo-600 rounded-full p-2">
                    <i class="fas fa-user"></i>
                  </span>
                </li>
                <li class="flex items-center justify-between text-gray-700 bg-gray-50 rounded-lg p-3">
                  <span class="text-lg font-medium dir-ltr">{{ useTrans('about.contact.phone') }}</span>
                  <span class="bg-indigo-100 text-indigo-600 rounded-full p-2">
                    <i class="fas fa-phone"></i>
                  </span>
                </li>
                <li class="flex items-center justify-between text-gray-700 bg-gray-50 rounded-lg p-3">
                  <span class="text-lg font-medium">{{ useTrans('about.contact.email') }}</span>
                  <span class="bg-indigo-100 text-indigo-600 rounded-full p-2">
                    <i class="fas fa-envelope"></i>
                  </span>
                </li>
              </ul>
            </div>
          </div>
        </div>
  
        <!-- Important Note Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:shadow-xl hover:-translate-y-1 mb-16">
          <div class="bg-gradient-to-r from-purple-500 to-pink-500 py-4 px-6">
            <h2 class="text-2xl font-bold text-white flex items-center">
              <span class="ml-3"><i class="fas fa-exclamation-circle"></i></span>
              {{ useTrans('about.important_note.title') }}
            </h2>
          </div>
          <div class="p-6 text-center">
            <p class="text-xl text-gray-700 leading-relaxed">
              {{ useTrans('about.important_note.message') }}
              <br>
              <span class="font-bold text-indigo-600">{{ useTrans('about.important_note.thanks') }}</span>
            </p>
          </div>
        </div>
  
        <!-- Browse Products Button -->
        <div class="text-center">
          <Link
            href="/products"
            class="inline-flex items-center px-8 py-4 text-lg font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-700 rounded-full shadow-lg hover:from-blue-700 hover:to-indigo-800 transform transition duration-300 hover:-translate-y-1 hover:shadow-xl"
          >
            <span class="ml-2">{{ useTrans('about.browse_products') }}</span>
            <i class="fas fa-arrow-left"></i>
          </Link>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { Link } from '@inertiajs/vue3';
  import Main from './Main.vue';
  import { useTrans } from '../composables/trans';
  
  defineOptions({
    layout: Main, // Assign layout dynamically
  });
  </script>
  
  <style>
  /* For RTL-specific adjustments */
  [dir="rtl"] .ml-3 {
    margin-right: 0.75rem;
    margin-left: 0;
  }
  
  [dir="rtl"] .ml-2 {
    margin-right: 0.5rem;
    margin-left: 0;
  }
  
  /* For left-to-right content like phone numbers */
  .dir-ltr {
    direction: ltr;
    display: inline-block;
  }
  </style>