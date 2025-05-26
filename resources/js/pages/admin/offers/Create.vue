<script setup>
import { useForm } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import Main from '../Main.vue'

defineOptions({
  layout: Main,
});

defineProps({
  products: Array,
})

const form = useForm({
  title: '',
  description: '',
  discount_type: 'percentage',
  discount_value: 0,
  start_date: '',
  end_date: '',
  is_active: true,
  products: [],
  image_url: '',
})

const isSubmitted = ref(false)
const discountValueInfo = ref('')
const imagePreview = ref(null)

watch(() => form.discount_type, (newType) => {
  if (newType === 'percentage') {
    discountValueInfo.value = 'Enter a percentage value between 1-100'
  } else {
    discountValueInfo.value = 'Enter a fixed amount in MAD'
  }
}, { immediate: true })

// Image handling functions
function handleImageUpload(event) {
  const file = event.target.files[0];
  if (!file) return;
  
  form.image_url = file;
  
  // Create preview
  const reader = new FileReader();
  reader.onload = e => {
    imagePreview.value = e.target.result;
  };
  reader.readAsDataURL(file);
}

function removeImage() {
  imagePreview.value = null;
  form.image_url = '';
  document.getElementById('offer-image').value = '';
}

function submit() {
  isSubmitted.value = true
  form.post('/admin/offers', {
    preserveScroll: true,
  })
}
</script>

<template>
  <div class="bg-gradient-to-b from-blue-50 to-gray-50 min-h-screen py-12 px-4">
    <div class="max-w-2xl mx-auto">
      <!-- Card Container -->
      <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 flex justify-between items-center">
          <div>
            <h1 class="text-xl font-bold text-white">Create New Offer</h1>
            <p class="text-blue-100 text-sm mt-1">Set up a promotional discount for your customers</p>
          </div>
          <div class="h-12 w-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
          </div>
        </div>
        
        <!-- Breadcrumbs -->
        <div class="bg-gray-50 px-6 py-2 text-xs flex items-center space-x-1">
          <a href="/admin/dashboard" class="text-blue-600 hover:text-blue-800">Dashboard</a>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
          </svg>
          <a href="/admin/offers" class="text-blue-600 hover:text-blue-800">Offers</a>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
          </svg>
          <span class="text-gray-500">New</span>
        </div>

        <!-- Form Content -->
        <div class="p-6">
          <form @submit.prevent="submit" class="space-y-8">
            <!-- Title & Description -->
            <div>
              <div class="mb-5">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                <input
                  id="title"
                  v-model="form.title"
                  type="text"
                  placeholder="e.g. Summer Sale 2025"
                  class="w-full h-10 px-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                />
                <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">
                  {{ form.errors.title }}
                </div>
              </div>

              <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea
                  id="description"
                  v-model="form.description"
                  rows="3"
                  placeholder="Enter a detailed description of this offer"
                  class="w-full px-3 py-2 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                ></textarea>
                <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">
                  {{ form.errors.description }}
                </div>
              </div>
            </div>

            <!-- Product Selection -->
            <div>
              <label for="products" class="block text-sm font-medium text-gray-700 mb-1">Select Products</label>
              <select 
                id="products" 
                v-model="form.products"
                multiple
                class="w-full h-40 px-3 py-2 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
              >
                <!-- Loop through products and create an option for each -->
                <option v-for="product in products" :key="product.id" :value="product.id">
                  {{ product.name }}
                </option>
              </select>
              <div v-if="form.errors.products" class="text-red-500 text-sm mt-1">
                {{ form.errors.products }}
              </div>
            </div>

            <!-- Enhanced Image Upload -->
            <div class="relative rounded-lg border-2 border-dashed border-blue-300 bg-blue-50 p-6 transition hover:bg-blue-100">
              <!-- Preview area -->
              <div v-if="imagePreview" class="mb-4 flex justify-center">
                <div class="relative h-48 w-full max-w-md overflow-hidden rounded-lg shadow-md">
                  <img :src="imagePreview" alt="Offer preview" class="h-full w-full object-cover" />
                  <button 
                    @click.prevent="removeImage" 
                    class="absolute top-2 right-2 rounded-full bg-red-500 p-1 text-white shadow-sm hover:bg-red-600 transition"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              </div>
              
              <!-- Upload area -->
              <div class="flex flex-col items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mb-3 h-12 w-12 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                
                <label for="offer-image" class="mb-2 block text-center text-lg font-medium text-gray-700">Offer Image</label>
                <p class="mb-4 text-center text-sm text-gray-500">Upload a high-quality image for your promotional offer (PNG, JPG, WEBP)</p>
                
                <div class="flex w-full max-w-xs flex-col items-center">
                  <label for="offer-image" class="w-full cursor-pointer rounded-full bg-blue-600 px-6 py-2 text-center font-semibold text-white shadow-md transition hover:bg-blue-700">
                    Choose Image
                  </label>
                  <input 
                    id="offer-image" 
                    type="file" 
                    @input="handleImageUpload" 
                    accept="image/*"
                    class="hidden" 
                  />
                </div>
                
                <p v-if="!imagePreview" class="mt-3 text-xs text-gray-500">Maximum file size: 5MB</p>
                <div v-if="form.errors.image_url" class="mt-2 text-sm font-medium text-red-500">{{ form.errors.image_url }}</div>
              </div>
            </div>

            <!-- Discount Details Card -->
            <div class="bg-blue-50 rounded-lg p-5">
              <div class="flex items-center mb-4">
                <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                  </svg>
                </div>
                <h2 class="text-md font-medium text-gray-800">Discount Details</h2>
              </div>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                  <label for="discount_type" class="block text-sm font-medium text-gray-700 mb-1">Type <span class="text-red-500">*</span></label>
                  <div class="flex space-x-3">
                    <div 
                      @click="form.discount_type = 'percentage'" 
                      class="flex-1 cursor-pointer p-3 rounded-lg border-2 transition-all flex items-center"
                      :class="form.discount_type === 'percentage' ? 'bg-blue-50 border-blue-500' : 'border-gray-200 hover:border-blue-200'"
                    >
                      <input 
                        type="radio" 
                        name="discount_type" 
                        id="percentage" 
                        value="percentage"
                        v-model="form.discount_type" 
                        class="sr-only"
                      />
                      <div class="h-5 w-5 rounded-full border-2 mr-2 flex items-center justify-center"
                        :class="form.discount_type === 'percentage' ? 'border-blue-500' : 'border-gray-400'"
                      >
                        <div v-if="form.discount_type === 'percentage'" class="h-2 w-2 bg-blue-500 rounded-full"></div>
                      </div>
                      <label for="percentage" class="text-sm">Percentage</label>
                    </div>
                    
                    <div 
                      @click="form.discount_type = 'fixed'" 
                      class="flex-1 cursor-pointer p-3 rounded-lg border-2 transition-all flex items-center"
                      :class="form.discount_type === 'fixed' ? 'bg-blue-50 border-blue-500' : 'border-gray-200 hover:border-blue-200'"
                    >
                      <input 
                        type="radio" 
                        name="discount_type" 
                        id="fixed" 
                        value="fixed"
                        v-model="form.discount_type" 
                        class="sr-only"
                      />
                      <div class="h-5 w-5 rounded-full border-2 mr-2 flex items-center justify-center"
                        :class="form.discount_type === 'fixed' ? 'border-blue-500' : 'border-gray-400'"
                      >
                        <div v-if="form.discount_type === 'fixed'" class="h-2 w-2 bg-blue-500 rounded-full"></div>
                      </div>
                      <label for="fixed" class="text-sm">Fixed Amount</label>
                    </div>
                  </div>
                </div>

                <div>
                  <label for="discount_value" class="block text-sm font-medium text-gray-700 mb-1">
                    Value <span class="text-red-500">*</span>
                  </label>
                  <div class="relative">
                    <input
                      id="discount_value"
                      v-model="form.discount_value"
                      type="number"
                      step="0.01"
                      min="0"
                      :max="form.discount_type === 'percentage' ? 100 : null"
                      class="w-full h-10 px-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                    />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                      <span class="text-gray-500 font-medium">{{ form.discount_type === 'percentage' ? '%' : 'MAD' }}</span>
                    </div>
                  </div>
                  <div v-if="discountValueInfo" class="text-gray-500 text-xs mt-1">
                    {{ discountValueInfo }}
                  </div>
                  <div v-if="form.errors.discount_value" class="text-red-500 text-sm mt-1">
                    {{ form.errors.discount_value }}
                  </div>
                </div>
              </div>
            </div>

            <!-- Date Range -->
            <div>
              <h2 class="flex items-center text-md font-medium text-gray-800 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
                Date Range
              </h2>
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                  <input
                    id="start_date"
                    v-model="form.start_date"
                    type="date"
                    class="w-full h-10 px-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                  />
                  <div v-if="form.errors.start_date" class="text-red-500 text-sm mt-1">
                    {{ form.errors.start_date }}
                  </div>
                </div>

                <div>
                  <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                  <input
                    id="end_date"
                    v-model="form.end_date"
                    type="date"
                    class="w-full h-10 px-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition-all"
                  />
                  <div v-if="form.errors.end_date" class="text-red-500 text-sm mt-1">
                    {{ form.errors.end_date }}
                  </div>
                  <div class="text-gray-500 text-xs mt-1">
                    Leave empty for an offer with no expiration date
                  </div>
                </div>
              </div>
            </div>

            <!-- Status Toggle -->
            <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
              <div class="flex items-center">
                <div class="h-8 w-8 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                  </svg>
                </div>
                <div>
                  <h3 class="font-medium text-gray-700">Activation Status</h3>
                  <p class="text-gray-500 text-sm">Make this offer available immediately</p>
                </div>
              </div>
              
              <!-- Toggle Switch -->
              <div class="relative inline-block w-12 align-middle select-none">
                <input 
                  id="is_active" 
                  type="checkbox" 
                  v-model="form.is_active"
                  class="opacity-0 absolute h-0 w-0" 
                />
                <label 
                  for="is_active"
                  class="block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"
                  :class="{ 'bg-green-500': form.is_active }"
                >
                  <span 
                    class="block h-6 w-6 rounded-full bg-white shadow transform transition-transform duration-200 ease-in-out"
                    :class="{ 'translate-x-6': form.is_active }"
                  ></span>
                </label>
              </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-4">
              <a 
                href="/admin/offers" 
                class="px-5 py-2 border-2 border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors"
              >
                Cancel
              </a>
              <button
                type="submit"
                :disabled="form.processing"
                class="px-6 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg flex items-center transition-all shadow-sm"
                :class="{ 'opacity-75 cursor-not-allowed': form.processing }"
              >
                <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ form.processing ? 'Creating...' : 'Create Offer' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>