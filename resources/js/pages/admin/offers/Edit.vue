<script setup>
import { Link, router } from '@inertiajs/vue3';
import Main from '../Main.vue';
import { onMounted, reactive, ref } from 'vue';

defineOptions({
  layout: Main,
});

const props = defineProps({
  offer: Object,
  products: Array,
  errors: Object,
  offerProducts: Array,
});

// In your <script setup> section, add the following to your form object:
const form = reactive({
  title: '',
  description: '',
  discount_type: '',
  discount_value: '',
  start_date: '',
  end_date: '',
  is_active: true,
  products: [],
  image_url: null, // Add this line
});

// In your onMounted() function, load the image_url if available:
onMounted(()=>{
  if(props.offer){
    form.title = props.offer.title || "";
    form.description = props.offer.description || "";
    form.discount_type = props.offer.discount_type || "";
    form.discount_value = props.offer.discount_value || "";
    form.start_date = props.offer.start_date || "";
    form.end_date = props.offer.end_date || "";
    form.is_active = props.offer.is_active || true;
    form.products = props.offerProducts || [];
    form.image_url = props.offer.image_url || null; // Add this line
  }
})

// Add a function to handle file uploads:
const imageFile = ref(null);

const handleImageUpload = (e) => {
  const file = e.target.files[0];
  if (file) {
    imageFile.value = file;
    form.image_url = URL.createObjectURL(file);
  }
};

const showOfferProducts = ref(false);

const submit = () => {
  // Create a FormData object to handle file uploads
  const formData = new FormData();
  
  // Add all form fields to the FormData
  Object.keys(form).forEach(key => {
    if (key === 'products') {
      // Handle the products array
      form.products.forEach(productId => {
        formData.append('products[]', productId);
      });
    } else if (key === 'is_active') {
      // Convert boolean to '0' or '1' which PHP recognizes
      formData.append(key, form[key] ? '1' : '0');
    } else if (key !== 'image_url' || form.image_url === props.offer?.image_url) {
      // Skip image_url if it hasn't changed
      formData.append(key, form[key]);
    }
  });
  
  // Add the image file if a new one was selected
  if (imageFile.value) {
    formData.append('image', imageFile.value);
  }
  
  // Set the proper HTTP method
  formData.append('_method', 'PUT');
  
  // Submit the form with FormData
  router.post(`/admin/offers/${props.offer.id}`, formData);
};


</script>

<template>
  <!-- Main container with enhanced styling -->
  <div class="py-8 px-6 max-w-4xl mx-auto">

    <!-- Card container with enhanced shadow and rounded corners -->
    <div class="bg-white rounded-xl shadow-xl overflow-hidden border border-gray-100">
      <!-- Header section with enhanced gradient background -->
      <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 rounded-full bg-indigo-500 opacity-20"></div>
        <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-32 h-32 rounded-full bg-blue-500 opacity-10"></div>
        
        <h1 class="text-2xl font-bold text-white relative z-10">Edit Offer</h1>
        <p class="text-blue-100 text-sm mt-1 relative z-10">Update your promotional campaign details</p>
      </div>

      <!-- Form content with improved spacing -->
      <div class="p-8">
        <form @submit.prevent="submit" class="space-y-6">
          <!-- Title input with icon -->
          <div class="space-y-1">
            <label for="title" class="font-medium text-gray-700 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 12h10m-10 5h10" />
              </svg>
              Offer Title
            </label>
            <input
              id="title"
              v-model="form.title"
              type="text"
              class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition"
              placeholder="Enter a catchy title"
            />
            <div v-if="errors.title" class="text-red-500 text-sm mt-1 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
              {{ errors.title }}
            </div>
          </div>

          <!-- Description textarea with enhanced styling -->
          <div class="space-y-1">
            <label for="description" class="font-medium text-gray-700 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
              </svg>
              Description
            </label>
            <textarea
              id="description"
              v-model="form.description"
              rows="4"
              class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition"
              placeholder="Describe your offer"
            ></textarea>
            <div v-if="errors.description" class="text-red-500 text-sm mt-1 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
              </svg>
              {{ errors.description }}
            </div>
          </div>

          <!-- Image section with improved layout and visual appeal -->
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 p-6 rounded-lg border border-emerald-100 mb-6">
          <h3 class="font-medium text-emerald-700 mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Offer Image
          </h3>
          
          <div class="space-y-4">
            <!-- Current image preview -->
            <div v-if="props.offer && props.offer.image_url_path" class="mb-4">
              <label class="block font-medium text-gray-700 mb-2">Current Image</label>
              <div class="relative border border-gray-200 rounded-lg overflow-hidden w-full max-w-md h-48 bg-gray-100">
                <img 
                  :src="props.offer.image_url_path" 
                  alt="Current offer image" 
                  class="w-full h-full object-cover"
                />
              </div>
            </div>
            
            <!-- Image upload -->
            <div>
              <label class="block font-medium text-gray-700 mb-2">Update Image</label>
              <div class="flex items-center space-x-4">
                <!-- Preview of new image if selected -->
                <div v-if="form.image_url && form.image_url !== props.offer?.image_url" class="relative border border-gray-200 rounded-lg overflow-hidden w-24 h-24 bg-gray-100 flex-shrink-0">
                  <img 
                    :src="form.image_url" 
                    alt="New offer image" 
                    class="w-full h-full object-cover"
                  />
                </div>
                
                <!-- File input with styling -->
                <div class="flex-1">
                  <label for="image_upload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-white hover:bg-gray-50 transition">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                      <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                      </svg>
                      <p class="mt-2 text-sm text-gray-500">
                        <span class="font-semibold">Click to upload</span> or drag and drop
                      </p>
                      <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                    </div>
                    <input 
                      id="image_upload" 
                      type="file" 
                      accept="image/*" 
                      class="hidden"
                      @change="handleImageUpload" 
                    />
                  </label>
                  <div v-if="errors.image_url" class="text-red-500 text-sm mt-1 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    {{ errors.image_url }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

          <!-- Products selection with enhanced styling -->
          <div class="bg-gradient-to-r from-purple-50 to-indigo-50 p-6 rounded-lg border border-purple-100">
            <h3 class="font-medium text-purple-700 mb-4 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
              Products
            </h3>

            <div class="shadow-sm bg-grat-100 p-2 rounded-lg mb-4">
                <span 
                class="cursor-pointer text-blue-600 hover:text-blue-800 transition-colors duration-300 flex items-center space-x-2"
                @click="showOfferProducts = !showOfferProducts">
                <span class="font-extrabold">{{ showOfferProducts ? '-' : '+'}}</span>
                <span class="font-semibold">Offer products</span>
            </span>

            <div v-if="showOfferProducts" class="mt-2 space-y-2">
                <div v-for="(offerProduct, i) in offer.products" :key="i"
                    class="text-gray-700 italic ml-2">
                    <span> {{ i+1 }} - </span>
                    {{ offerProduct.name }}
                </div>
            </div>
            </div>

            
            <div class="space-y-2">
              <p class="text-sm text-gray-500 mb-2">Select products that this offer applies to</p>
              
              <div class="relative">
                <select
                  v-model="form.products"
                  multiple 
                  class="w-full border-b-2 focus:border-b-2 focus:outline-none  focus:ring-0 focus:border-transparent py-2 min-h-32"
                >
                <label :for="`product-${i}`" class="border-1 w-2 h-2"></label>
                  <option :id="`product-${i}`" class="bg-indingo-500" v-for="product in products" :key="product.id" :value="product.id">
                    {{ product.name }}
                  </option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple products</p>
              </div>
              
              <div v-if="errors.products" class="text-red-500 text-sm mt-1 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                {{ errors.products }}
              </div>
              
              <div v-if="form.products && form.products.length > 0" class="mt-2">
                <p class="text-sm font-medium text-gray-700">Selected Products: {{ form.products.length }}</p>
              </div>
            </div>
          </div>

          <!-- Discount section with improved layout and visual appeal -->
          <div class="bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-lg border border-indigo-100">
            <h3 class="font-medium text-indigo-700 mb-4 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Discount Details
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Discount Type -->
              <div class="space-y-1">
                <label for="discount_type" class="block font-medium text-gray-700">Discount Type</label>
                <select
                  id="discount_type"
                  v-model="form.discount_type"
                  class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition"
                >
                  <option value="percentage">Percentage (%)</option>
                  <option value="fixed">Fixed Amount (MAD)</option>
                </select>
                <div v-if="errors.discount_type" class="text-red-500 text-sm mt-1 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                  </svg>
                  {{ errors.discount_type }}
                </div>
              </div>

              <!-- Discount Value -->
              <div class="space-y-1">
                <label for="discount_value" class="block font-medium text-gray-700">Discount Value</label>
                <div class="relative">
                  <input
                    id="discount_value"
                    v-model="form.discount_value"
                    type="number"
                    step="0.01"
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition"
                    placeholder="Enter discount amount"
                  />
                  <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                    {{ form.discount_type === 'percentage' ? '%' : 'MAD' }}
                  </div>
                </div>
                <div v-if="errors.discount_value" class="text-red-500 text-sm mt-1 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                  </svg>
                  {{ errors.discount_value }}
                </div>
              </div>
            </div>
          </div>

          <!-- Dates section with improved layout and visual appeal -->
          <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-lg border border-blue-100">
            <h3 class="font-medium text-blue-700 mb-4 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              Offer Duration
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Start Date -->
              <div class="space-y-1">
                <label for="start_date" class="block font-medium text-gray-700">Start Date</label>
                <input
                  id="start_date"
                  v-model="form.start_date"
                  type="date"
                  class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition"
                />
                <div v-if="errors.start_date" class="text-red-500 text-sm mt-1 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                  </svg>
                  {{ errors.start_date }}
                </div>
              </div>

              <!-- End Date -->
              <div class="space-y-1">
                <label for="end_date" class="block font-medium text-gray-700">End Date</label>
                <input
                  id="end_date"
                  v-model="form.end_date"
                  type="date"
                  class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition"
                />
                <div v-if="errors.end_date" class="text-red-500 text-sm mt-1 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                  </svg>
                  {{ errors.end_date }}
                </div>
              </div>
            </div>
          </div>

          <!-- Active status toggle with improved styling -->
          <div class="p-6 rounded-lg border border-gray-200 flex items-center space-x-3">
            <div class="flex-none">
              <div class="relative inline-block w-12 h-6 transition duration-200 ease-in-out">
                <input
                  v-model="form.is_active"
                  type="checkbox"
                  id="is_active"
                  class="absolute opacity-0 w-0 h-0"
                />
                <label
                  for="is_active" 
                  class="block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer transition-colors duration-200 ease-in-out"
                  :class="{ 'bg-green-500': form.is_active }"
                >
                  <span 
                    class="block h-6 w-6 rounded-full bg-white shadow transform transition-transform duration-200 ease-in-out"
                    :class="{ 'translate-x-6': form.is_active }"
                  ></span>
                </label>
              </div>
            </div>
            <div class="flex-1 pl-2">
              <label for="is_active" class="font-medium text-gray-700">Offer Status</label>
              <p class="text-gray-500 text-sm">Toggle to activate or deactivate this offer</p>
            </div>
            <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium" v-if="form.is_active">
              Active
            </div>
            <div class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-medium" v-else>
              Inactive
            </div>
          </div>

          <div v-if="errors.is_active" class="text-red-500 text-sm flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            {{ errors.is_active }}
          </div>

          <!-- Submit buttons with a cancel option -->
          <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
            <Link
              href="/admin/offers"
              as="button"
              class="px-5 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-sm"
            >
              Cancel
            </Link>
            <button
              type="submit"
              :disabled="form.processing"
              class="flex items-center px-5 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-sm"
            >
              <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <span>Update Offer</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>