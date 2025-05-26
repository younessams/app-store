<template>
  <div class="max-w-6xl mx-auto px-4 py-12 mt-14" :dir="$page.props.locale === 'ar' ? 'rtl' : 'ltr'">
    <!-- Breadcrumb -->
    <div class="mb-6 text-sm text-gray-500">
      <span>{{ useTrans('products-show.breadcrumb.home') }}</span>
      <span class="mx-2">/</span>
      <span>{{ product.category?.name }}</span>
      <span class="mx-2">/</span>
      <span class="font-medium text-gray-900">{{ product.name }}</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
      <!-- Product Image Gallery -->
      <div class="space-y-4 order-1" dir="ltr">
        <div class="bg-gray-50 rounded-2xl overflow-hidden">
          <img
            :src="activeImage"
            :alt="useTrans('products-show.product.selected_image_alt')"
            class="w-full h-96 object-contain mx-auto transition-opacity duration-300"
          />
        </div>
  
        <div class="flex gap-3 overflow-x-auto py-2 px-1">
          <div
            v-for="(image, index) in product.images"
            :key="index"
            @click="activeImage = image.url"
            :class="[
              'w-20 h-20 rounded-lg cursor-pointer transition duration-200 flex-shrink-0 overflow-hidden',
              activeImage === image.url ? 'ring-2 ring-offset-2 ring-black' : 'opacity-70 hover:opacity-100'
            ]"
          >
            <img
              :src="image.url"
              class="w-full h-full object-cover"
            />
          </div>
        </div>
      </div>
  
      <!-- Product Info Section -->
      <div class="space-y-8">
        <div class="border-b pb-6">
          <p class="text-indigo-600 font-medium mb-1">{{ product.category?.name }}</p>
          <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ product.name }}</h1>
          <div class="flex items-center gap-2 mb-4">
            <div class="flex text-amber-400">
              <svg v-for="i in 5" :key="i" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="i <= 4 ? 'fill-current' : 'stroke-current fill-none'" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
              </svg>
            </div>
            <span class="text-gray-500 text-sm">4.2 (24 {{ useTrans('products-show.product.rating_text') }})</span>
          </div>
          <p class="text-2xl font-bold text-gray-900">${{ product.price }}</p>
        </div>
  
        <div class="prose prose-gray max-w-none">
          <p>{{ product.description }}</p>
        </div>
  
        <form @submit.prevent="addToCart" class="space-y-6">
          <!-- Color Selection -->
          <div v-if="product.colors.length" class="space-y-3">
            <label class="block font-medium text-gray-700">{{ useTrans('products-show.product.color_label') }}</label>
            <div class="flex gap-3">
              <button
                type="button"
                v-for="color in product.colors"
                :key="color.id"
                :class="[
                  'w-10 h-10 rounded-full shadow transition duration-200',
                  selectedColor === color.id ? 'ring-2 ring-offset-2 ring-black scale-110' : '',
                  color.class
                ]"
                @click="selectedColor = color.id"
              ></button>
            </div>
            <p v-if="!selectedColor && formSubmitted" class="text-red-500 text-sm">{{ useTrans('products-show.product.color_required') }}</p>
          </div>
  
          <!-- Size Selection -->
          <div v-if="product.sizes.length" class="space-y-3">
            <div class="flex justify-between">
              <label class="block font-medium text-gray-700">{{ useTrans('products-show.product.size_label') }}</label>
              <button type="button" class="text-sm text-indigo-600 hover:text-indigo-800">{{ useTrans('products-show.product.size_guide') }}</button>
            </div>
            <div class="flex gap-3 flex-wrap">
              <button
                type="button"
                v-for="size in product.sizes"
                :key="size.id"
                :class="[
                  'px-4 py-2 border rounded-lg text-sm font-medium transition duration-200',
                  selectedSize === size.id 
                    ? 'bg-black text-white border-black' 
                    : 'text-gray-800 border-gray-300 hover:border-gray-700'
                ]"
                @click="selectedSize = size.id"
              >
                {{ size.name }}
              </button>
            </div>
            <p v-if="!selectedSize && formSubmitted" class="text-red-500 text-sm">{{ useTrans('products-show.product.size_required') }}</p>
          </div>
  
          <!-- Quantity & Add to Cart -->
          <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex items-center border border-gray-300 rounded-lg">
              <button 
                type="button"
                @click="quantity > 1 ? quantity-- : null" 
                class="w-10 h-12 flex items-center justify-center text-gray-600 hover:bg-gray-50"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                </svg>
              </button>
              <input 
                type="number" 
                v-model="quantity" 
                min="1" 
                :max="product.stock"
                class="w-16 h-12 border-0 text-center focus:ring-0 focus:outline-none" 
              />
              <button 
                type="button"
                @click="quantity < product.stock ? quantity++ : null" 
                class="w-10 h-12 flex items-center justify-center text-gray-600 hover:bg-gray-50"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
              </button>
            </div>
            
            <button 
              type="submit"
              class="flex-1 bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition duration-200 font-medium flex items-center justify-center gap-2 h-12"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
              {{ useTrans('products-show.product.add_to_cart') }}
            </button>
          </div>
        </form>

        <!-- Additional Info -->
        <div class="border-t pt-6 space-y-4">
          <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            <span class="text-sm text-gray-600">{{ useTrans('products-show.shipping.free_shipping') }}</span>
          </div>
          <div class="flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            <span class="text-sm text-gray-600">{{ useTrans('products-show.shipping.easy_returns') }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { useToast } from 'vue-toastification'
import { getGuestToken } from '../../utils/guestToken'
import { useTrans } from '../../composables/trans'
import Main from '../Main.vue';

defineOptions({
  layout: Main, // Assign layout dynamically
});

const props = defineProps({
  product: Object,
  errors: Object,
})

const activeImage = ref(props.product.images[0]?.url || '')
const selectedColor = ref(null)
const selectedSize = ref(null)
const quantity = ref(1)
const formSubmitted = ref(false)

const toast = useToast();

const addToCart = () => {
  formSubmitted.value = true

  
  if ((!selectedColor.value && props.product.colors.length) || 
      (!selectedSize.value && props.product.sizes.length)) { 
    return
  }

  router.post('/cart', {
    product_id: props.product.id,
    color_id: selectedColor.value,
    size_id: selectedSize.value,
    quantity: quantity.value,
    guest_token: getGuestToken(),
  }, {
  preserveScroll: true,
  onSuccess: () => toast.success(useTrans('products-show.product.add_to_cart_success')),
  onError: (errors) => {
    console.error('Validation or Server Error:', errors)
    toast.error(useTrans('products-show.product.add_to_cart_error'))
  },
  onFinish: () => {
    //console.log('Request completed.')
  }
})
}
</script>