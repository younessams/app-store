<template>
    <div class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 min-h-screen py-16">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
          <div class="inline-flex items-center justify-center p-2 bg-blue-100 rounded-full mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
            </svg>
          </div>
          <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">{{ useTrans('shipping-policy.title') }}</h1>
          <p class="mt-4 text-xl text-gray-500 max-w-2xl mx-auto">{{ useTrans('shipping-policy.subtitle') }}</p>
        </div>
  
        <!-- Policy Content -->
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
          <!-- Quick Overview Card -->
          <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white">
            <h2 class="text-xl font-semibold mb-3">{{ useTrans('shipping-policy.at-glance.title') }}</h2>
            <p class="text-blue-100 mb-4">{{ useTrans('shipping-policy.at-glance.description') }}</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div class="bg-white bg-opacity-20 rounded-lg p-4 backdrop-filter backdrop-blur-sm">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-white text-blue-600 mb-3 mx-auto">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <h3 class="text-center font-medium">{{ useTrans('shipping-policy.at-glance.processing-time.title') }}</h3>
                <p class="text-center text-gray-500 text-sm">{{ useTrans('shipping-policy.at-glance.processing-time.value') }}</p>
              </div>
              <div class="bg-white bg-opacity-20 rounded-lg p-4 backdrop-filter backdrop-blur-sm">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-white text-blue-600 mb-3 mx-auto">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                  </svg>
                </div>
                <h3 class="text-center font-medium">{{ useTrans('shipping-policy.at-glance.domestic-shipping.title') }}</h3>
                <p class="text-center text-gray-500 text-sm">{{ useTrans('shipping-policy.at-glance.domestic-shipping.value') }}</p>
              </div>
              <div class="bg-white bg-opacity-20 rounded-lg p-4 backdrop-filter backdrop-blur-sm">
                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-white text-blue-600 mb-3 mx-auto">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <h3 class="text-center font-medium">{{ useTrans('shipping-policy.at-glance.international-shipping.title') }}</h3>
                <p class="text-center text-gray-500 text-sm">{{ useTrans('shipping-policy.at-glance.international-shipping.value') }}</p>
              </div>
            </div>
          </div>
  
          <!-- Detailed Information -->
          <div class="p-8">
            <div class="space-y-8 text-gray-700 leading-relaxed">
              <!-- Shipping Times Section -->
              <div class="shipping-section">
                <div class="flex items-center mb-4">
                  <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </div>
                  <h2 class="text-xl font-semibold text-gray-900">{{ useTrans('shipping-policy.shipping-times.title') }}</h2>
                </div>
                <div class="bg-gray-50 rounded-lg p-6">
                  <ul class="space-y-3">
                    <li class="flex items-start">
                      <svg class="h-6 w-6 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <span>{{ useTrans('shipping-policy.shipping-times.casablanca') }}</span>
                    </li>
                    <li class="flex items-start">
                      <svg class="h-6 w-6 text-blue-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
                      <span>{{ useTrans('shipping-policy.shipping-times.other-cities') }}</span>
                    </li>
                  </ul>
                </div>
              </div>
  
              <!-- Shipping Costs Section -->
                <div class="shipping-section">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ useTrans('shipping-policy.shipping-costs.title') }}</h2>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                    <p class="text-gray-700">
                      {{ useTrans('shipping-policy.shipping-costs.description') }}
                    </p>

                    <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                      <li>{{ useTrans('shipping-policy.shipping-costs.casablanca-cost') }}</li>
                      <li>{{ useTrans('shipping-policy.shipping-costs.other-cities-cost') }}</li>
                    </ul>

                    <div class="border border-blue-200 rounded-lg overflow-hidden">
                    <div class="bg-blue-50 px-4 py-2 border-b border-blue-200">
                        <h3 class="font-medium text-blue-800">{{ useTrans('shipping-policy.shipping-costs.help.title') }}</h3>
                    </div>
                    <div class="px-4 py-3">
                        <p class="text-sm text-gray-600">
                        {{ useTrans('shipping-policy.shipping-costs.help.description') }}
                        <Link href="/contact" class="text-blue-600 hover:underline">{{ useTrans('shipping-policy.shipping-costs.help.contact-link') }}</Link>.
                        </p>
                    </div>
                    </div>
                </div>
                </div>

  
              <!-- Tracking Section -->
              <div class="shipping-section">
                <div class="flex items-center mb-4">
                  <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                  </div>
                  <h2 class="text-xl font-semibold text-gray-900">{{ useTrans('shipping-policy.tracking.title') }}</h2>
                </div>
                <div class="bg-gray-50 rounded-lg p-6">
                  <p>{{ useTrans('shipping-policy.tracking.description') }} <Link href="/orders/track" class="text-blue-600 hover:underline font-medium">{{ useTrans('shipping-policy.tracking.tracking-link') }}</Link>.</p>
                  
                  <div class="mt-4 flex items-center px-4 py-3 bg-blue-50 text-blue-800 rounded-lg">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-sm">{{ useTrans('shipping-policy.tracking.info') }}</p>
                  </div>
                </div>
              </div>
  
              <!-- Delays Section -->
              <div class="shipping-section">
                <div class="flex items-center mb-4">
                  <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                  </div>
                  <h2 class="text-xl font-semibold text-gray-900">{{ useTrans('shipping-policy.delays.title') }}</h2>
                </div>
                <div class="bg-gray-50 rounded-lg p-6">
                  <p>{{ useTrans('shipping-policy.delays.description') }} <Link href="/contact" class="text-blue-600 hover:underline font-medium">{{ useTrans('shipping-policy.delays.contact-link') }}</Link>.</p>
                  
                  <div class="mt-4 bg-amber-50 border-l-4 border-amber-400 p-4">
                    <div class="flex">
                      <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                      </div>
                      <div class="ml-3">
                        <p class="text-sm text-amber-700">
                          {{ useTrans('shipping-policy.delays.warning') }}
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
  
          <!-- Footer Help Section -->
          <div class="border-t border-gray-200 bg-gray-50 px-6 py-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
              <div class="flex-1">
                <h3 class="text-lg font-medium text-gray-900">{{ useTrans('shipping-policy.footer.title') }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ useTrans('shipping-policy.footer.description') }}</p>
              </div>
              <div class="mt-4 md:mt-0 flex space-x-3">
                <Link href="/faq" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                  {{ useTrans('shipping-policy.footer.view-faqs') }}
                </Link>
                <Link href="/contact" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                  {{ useTrans('shipping-policy.footer.contact-support') }}
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { Link } from '@inertiajs/vue3'
  import Main from '../Main.vue';
  import { useTrans } from '../../composables/trans';
  
  defineOptions({
    layout: Main, // Assign layout dynamically
  });
  
  // Assuming you have a useTrans composable or method available
  // If not, you'll need to import it or define it
  // import { useTrans } from '@/composables/useTranslation';
  </script>