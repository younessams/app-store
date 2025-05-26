<script setup>
import { Link, router, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'
import Main from '../Main.vue'
import ConfirmModal from '../../layouts/ConfirmModal.vue';

defineOptions({
  layout: Main, // Assign layout dynamically
});

const props = defineProps({
  offers: Object,
  filters: Object,
})

const filters = ref({
  status: props.filters?.status || '',
  discout: props.filters?.discout || '',
  start_date: props.filters?.start_date || '',
  end_date: props.filters?.end_date || '',
})

const applyFilters = () => {
  router.get('/admin/offers', filters.value, {
    preserveState: true,
    replace: true,
    preserveScroll: true,
  });
}

const resetFilters = () => {
  filters.status = '';
  filters.discout = '';
  filters.start_date = '';
  filters.end_date = '';
  applyFilters();
};

const applyQuickFilter = (type) => {
  if (type === 'active') {
    filters.status = 'active';
  } else if (type === 'percentage') {
    filters.discout = 'percentage';
  } else if (type === 'fixed') {
    filters.discout = 'fixed';
  } else if (type === 'current') {
    // Set date range to current date
    const today = new Date().toISOString().split('T')[0];
    filters.start_date = today;
    filters.end_date = today;
  }
  applyFilters();
};

const isFilterOpen = ref(false)
const toggleFilters = () => {
  isFilterOpen.value = !isFilterOpen.value
}
</script>

<template>
  <div class="bg-gray-50 min-h-screen py-6 px-4 sm:px-6">
    <div class="max-w-6xl mx-auto">
      <!-- Header Card -->
      <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
          <div>
            <h1 class="text-2xl font-bold text-gray-800">Offers Management</h1>
            <p class="text-gray-500 mt-1">Create and manage special discounts for your customers</p>
          </div>
          <div class="flex gap-3">
            <button 
              @click="toggleFilters"
              class="flex items-center gap-2 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
              </svg>
              Filters
            </button>
            <Link
              href="/admin/offers/create"
              class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors shadow-sm"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
              </svg>
              New Offer
            </Link>
          </div>
        </div>
        
        <!-- Filter Panel - Togglable -->
        <!-- Filter Panel - Togglable -->
<div v-if="isFilterOpen" class="mt-6 pt-6 border-t border-gray-200">
  <!-- Filter Content with Enhanced Design -->
  <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-xl shadow-sm border border-blue-100 mb-4">
    <h3 class="text-lg font-medium text-indigo-800 mb-4 flex items-center">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
      </svg>
      Filter Options
    </h3>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Status Filter -->
      <div class="bg-white p-4 rounded-lg shadow-sm border border-blue-50">
        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
        <div class="relative">
          <select
            @change="applyFilters"
            v-model="filters.status" 
            class="w-full rounded-md border-gray-300 pl-3 pr-10 py-2 text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition"
          >
            <option value="">All Statuses</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-indigo-500">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </div>
        </div>
      </div>
      
      <!-- Discount Type Filter -->
      <div class="bg-white p-4 rounded-lg shadow-sm border border-blue-50">
        <label class="block text-sm font-medium text-gray-700 mb-2">Discount Type</label>
        <div class="relative">
          <select
            @change="applyFilters"
            v-model="filters.discout" 
            class="w-full rounded-md border-gray-300 pl-3 pr-10 py-2 text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition"
          >
            <option value="">All Types</option>
            <option value="percentage">Percentage</option>
            <option value="fixed">Fixed Amount</option>
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-indigo-500">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </div>
        </div>
      </div>
      
      <!-- Date Range Filter -->
      <div class="bg-white p-4 rounded-lg shadow-sm border border-blue-50">
        <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
        <div class="space-y-3">
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <input 
              @change="applyFilters"
              v-model="filters.start_date" 
              type="date" 
              placeholder="Start date"
              class="w-full pl-10 pr-3 py-2 rounded-md border-gray-300 text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition"
            />
          </div>
          
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <input
              @change="applyFilters"
              v-model="filters.end_date" 
              type="date" 
              placeholder="End date"
              class="w-full pl-10 pr-3 py-2 rounded-md border-gray-300 text-gray-700 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition"
            />
          </div>
        </div>
      </div>
    </div>
    
    <!-- Quick Filter Pills -->
    <div class="mt-5 flex flex-wrap gap-2">
      <button 
        @click="applyQuickFilter('active')" 
        class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium hover:bg-green-200 transition flex items-center"
      >
        <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span>
        Active Offers
      </button>
      <button 
        @click="applyQuickFilter('percentage')" 
        class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-medium hover:bg-purple-200 transition flex items-center"
      >
        <span class="w-2 h-2 bg-purple-500 rounded-full mr-1"></span>
        Percentage Discounts
      </button>
      <button 
        @click="applyQuickFilter('fixed')" 
        class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium hover:bg-blue-200 transition flex items-center"
      >
        <span class="w-2 h-2 bg-blue-500 rounded-full mr-1"></span>
        Fixed Discounts
      </button>
      <button 
        @click="applyQuickFilter('current')" 
        class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-medium hover:bg-amber-200 transition flex items-center"
      >
        <span class="w-2 h-2 bg-amber-500 rounded-full mr-1"></span>
        Current Offers
      </button>
    </div>
  </div>
  
  <!-- Action Buttons -->
  <div class="">
    <!-- Reset Button -->
    <button 
      @click="resetFilters"
      class="flex items-center px-4 py-2 text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
      </svg>
      Reset
    </button>
  </div>
</div>
      </div>
      
      <!-- Table Card -->
      <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead>
              <tr class="bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                <th class="px-6 py-3">#</th>
                <th class="px-6 py-3">Title</th>
                <th class="px-6 py-3">Discount</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Period</th>
                <th class="px-6 py-3 text-right">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr
                v-for="(offer, index) in offers.data"
                :key="offer.id"
                class="hover:bg-gray-50 transition-colors"
              >
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ index + 1 }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ offer.title }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span 
                    :class="[
                      'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                      offer.discount_type === 'percentage' 
                        ? 'bg-green-100 text-green-800' 
                        : 'bg-blue-100 text-blue-800'
                    ]"
                  >
                    {{ offer.discount_value }}
                    {{ offer.discount_type === 'percentage' ? '%' : ' MAD' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span 
                    :class="[
                      'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                      offer.is_active 
                        ? 'bg-green-100 text-green-800' 
                        : 'bg-gray-100 text-gray-800'
                    ]"
                  >
                    <span 
                      :class="[
                        'h-2 w-2 rounded-full mr-1',
                        offer.is_active ? 'bg-green-400' : 'bg-gray-400'
                      ]"
                    ></span>
                    {{ offer.is_active ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-500">
                    {{ offer.start_date || '...' }} - {{ offer.end_date || '...' }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex justify-end gap-4">
                    <Link
                      :href="`/admin/offers/${offer.id}/edit`"
                      class="text-violet-600 hover:text-violet-900"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M12 20h9" />
                      <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z" />
                    </svg>

                    </Link>
                    <ConfirmModal 
                      :route="`/admin/offers/${offer.id}`"
                      :message="`Are you sure you want to delete ${offer.title} offer ?`"
                    />
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          
          <!-- Pagination -->
          <div v-if="offers.links && offers.links.length > 3" class="px-6 py-4 flex items-center justify-between border-t border-gray-200">
            <div class="flex-1 flex justify-between sm:hidden">
              <Link
                v-if="offers.prev_page_url"
                :href="offers.prev_page_url"
                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Previous
              </Link>
              <Link
                v-if="offers.next_page_url"
                :href="offers.next_page_url"
                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
              >
                Next
              </Link>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
              <div>
                <p class="text-sm text-gray-700">
                  Showing <span class="font-medium">{{ offers.from }}</span> to <span class="font-medium">{{ offers.to }}</span> of
                  <span class="font-medium">{{ offers.total }}</span> results
                </p>
              </div>
              <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                  <Link
                    v-for="(link, i) in offers.links"
                    :key="i"
                    :href="link.url"
                    v-html="link.label"
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium"
                    :class="[
                      link.active ? 'text-blue-600 bg-blue-50' : 'text-gray-700 hover:bg-gray-50',
                      i === 0 ? 'rounded-l-md' : '',
                      i === offers.links.length - 1 ? 'rounded-r-md' : ''
                    ]"
                  />
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>