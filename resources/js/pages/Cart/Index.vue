<template>

  <div class="max-w-6xl mx-auto py-8 px-4 md:px-6 lg:px-8 pb-32 md:pb-16 relative">
    <!-- Header -->
    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">{{ useTrans('cart.title') }}</h1>

```
<div v-if="cartItems.length">
  <div class="flex flex-col lg:flex-row gap-8">
    <!-- Left Column: Cart Items -->
    <div class="w-full lg:w-7/12 space-y-6">
      <!-- Cart Items -->
      <div v-for="item in cartItems" :key="item.id" class="flex py-6 border-b border-gray-200">
        <!-- Product Image -->
        <div class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden">
          <img 
            :src="item.product.images[0]?.url" 
            alt="Product Image" 
            class="w-full h-full object-center object-cover" 
          />
        </div>

        <!-- Product Details -->
        <div class="ml-4 flex-1 flex flex-col">
          <div class="flex justify-between">
            <div>
              <h3 class="text-base font-medium text-gray-900">{{ item.product.name }}</h3>
              <p class="mt-1 text-sm text-gray-500">{{ item.color.name }} | {{ item.size.name }}</p>
            </div>
            <p class="text-base font-medium text-gray-900">${{ item.total_price }}</p>
          </div>
          
          <div class="flex items-center justify-between mt-4">
            <!-- Quantity Selector - Modified to match the design -->
            <div class="flex border border-gray-300 rounded-md">
              <button 
                class="px-3 py-1 text-gray-500 hover:bg-gray-50"
                @click="updateQuantity(item, Math.max(1, item.quantity - 1))"
              >
                -
              </button>
              <span class="px-3 py-1 border-l border-r border-gray-300 flex items-center justify-center min-w-[40px]">
                {{ item.quantity }}
              </span>
              <button 
                class="px-3 py-1 text-gray-500 hover:bg-gray-50"
                @click="updateQuantity(item, item.quantity + 1)"
              >
                +
              </button>
            </div>
            
            <!-- Remove Button -->
            <button 
              class="p-2"
              @click="removeItem(item.id)"
            >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 hover:text-red-600 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>

            </button>
          </div>

          <!-- Status -->
          <div class="mt-2">
            <p v-if="item.product.stock" class="text-sm text-green-500 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              {{ useTrans('cart.product.inStock') }}
            </p>
            <p v-else class="text-sm text-gray-500 flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              {{ useTrans('cart.product.ships') }}
            </p>
          </div>
        </div>
      </div>
      <div class="w-full flex justify-between">
        <Link
          title="Add new product"
          href="/products"
          class="flex items-center gap-2 px-4 py-2 rounded-lg bg-cyan-700 text-white hover:bg-cyan-600 transition disabled:opacity-50"
        >
        <svg class="w-5 h-5 mr-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
        </svg>
          <span>{{ useTrans('cart.actions.addMore') }}</span>
        </Link>
        
        <TrackOrder />
      </div>
    </div>

    <!-- Right Column: Delivery Info + Order Summary -->
    <div class="w-full lg:w-5/12 space-y-6">
      <!-- Delivery Information Card - Moved above Order Summary -->
      <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">{{ useTrans('cart.delivery.title') }}</h2>
        
        <div class="space-y-4">
          <!-- Full Name -->
          <div>
            <label for="fullName" class="block text-sm font-medium text-gray-700">{{ useTrans('cart.delivery.fullName') }}</label>
            <input 
              type="text" 
              id="fullName" 
              v-model="delivery.full_name" 
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm focus:ring-indigo-500 focus:border-indigo-500" 
              :placeholder="useTrans('cart.delivery.fullNamePlaceholder')"
            />
          </div>
          
          <!-- Phone Number -->
          <div>
            <label for="phone" class="block text-sm font-medium text-gray-700">{{ useTrans('cart.delivery.phone') }}</label>
            <input 
              type="text" 
              id="phone" 
              v-model="delivery.phone_number" 
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm focus:ring-indigo-500 focus:border-indigo-500" 
              :placeholder="useTrans('cart.delivery.phonePlaceholder')"
            />
          </div>
          
          <!-- City -->
          <div>
            <label for="city" class="block text-sm font-medium text-gray-700">{{ useTrans('cart.delivery.city') }}</label>
            <input 
              type="text" 
              id="city" 
              v-model="delivery.city" 
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm focus:ring-indigo-500 focus:border-indigo-500" 
              :placeholder="useTrans('cart.delivery.cityPlaceholder')"
            />
          </div>
          
          <!-- Delivery Address -->
          <div>
            <label for="address" class="block text-sm font-medium text-gray-700">{{ useTrans('cart.delivery.address') }}</label>
            <textarea 
              id="address" 
              v-model="delivery.delivery_address" 
              rows="2"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 text-sm focus:ring-indigo-500 focus:border-indigo-500" 
              :placeholder="useTrans('cart.delivery.addressPlaceholder')"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- Order Summary Card -->
      <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">{{ useTrans('cart.summary.title') }}</h2>
        
        <div class="space-y-4">
          <div class="flex justify-between">
            <p class="text-base text-gray-500">{{ useTrans('cart.summary.subtotal') }}</p>
            <p class="text-base font-medium text-gray-900">${{ calculateSubtotal().toFixed(2) }}</p>
          </div>
          
          <div class="flex justify-between">
            <div class="flex items-center">
              <p class="text-base text-gray-500">{{ useTrans('cart.summary.shipping') }}</p>
              <button class="ml-2 text-gray-400 hover:text-gray-500">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>
            <p class="text-base font-medium text-green-500">{{ useTrans('cart.summary.free') }}</p>
          </div>
          
          <div class="flex justify-between">
            <div class="flex items-center">
              <p class="text-base text-gray-500">{{ useTrans('cart.summary.cod') }}</p>
              <button class="ml-2 text-gray-400 hover:text-gray-500">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                </svg>
              </button>
            </div>
            <p class="text-base font-medium text-gray-900">$2.00</p>
          </div>
          
          <div class="border-t border-gray-200 pt-4 flex justify-between">
            <p class="text-base font-medium text-gray-900">{{ useTrans('cart.summary.total') }}</p>
            <p class="text-base font-medium text-gray-900">${{ (calculateSubtotal() + 2.00).toFixed(2) }}</p>
          </div>
        </div>
        
        <div class="mt-6">
          <button 
            @click="handleCheckout" 
            class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            :disabled="!isDeliveryInfoComplete() || isLoading"
          >
            <span v-if="isLoading" class="flex items-center justify-center">
              <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ useTrans('cart.checkout.processing') }}
            </span>
            <span v-else>{{ useTrans('cart.checkout.button') }}</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Empty Cart State -->
<div v-else class="text-center py-16 bg-white rounded-lg border border-gray-200">
  <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
  </svg>
  <h3 class="mt-2 text-lg font-medium text-gray-900">{{ useTrans('cart.empty.title') }}</h3>
  <p class="mt-1 text-sm text-gray-500">{{ useTrans('cart.empty.description') }}</p>
  <div class="mt-6">
    <a href="/products" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
      {{ useTrans('cart.empty.button') }}
    </a>
  </div>
</div>
```

  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import { getGuestToken } from '../../utils/guestToken'
import { useToast } from 'vue-toastification'
import TrackOrder from '../Components/TrackOrder.vue'
import Main from '../Main.vue';
import { useTrans } from '../../composables/trans'

defineOptions({
  layout: Main, // Assign layout dynamically
});

const toast = useToast()
const isLoading = ref(false)

const props = defineProps({
  cartItems: {
    type: Array,
    default: () => []
  },
})

const delivery = ref({
  full_name: '',
  phone_number: '',
  city: '',
  delivery_address: ''
})

const removeItem = (id) => {
  router.delete(`/cart/${id}`, {
    preserveScroll: true,
    guest_token: getGuestToken(),
    onSuccess: () => toast.success('Item removed from cart')
  })
}

const updateQuantity = (item, newQuantity) => {
  if (newQuantity < 1) return

  router.patch(`/cart/${item.id}`, {
    quantity: newQuantity,
    guest_token: getGuestToken(),
  }, {
    preserveScroll: true,
    onSuccess: () => toast.success('Quantity updated')
  })
}

const calculateSubtotal = () => {
  return props.cartItems.reduce((total, item) => {
    return total + parseFloat(item.total_price)
  }, 0)
}

const isDeliveryInfoComplete = () => {
  return delivery.value.full_name.trim() !== '' && 
         delivery.value.phone_number.trim() !== '' && 
         delivery.value.city.trim() !== '' &&
         delivery.value.delivery_address.trim() !== ''
}

const handleCheckout = () => {
  if (isLoading.value || !isDeliveryInfoComplete()) return
  
  isLoading.value = true
  
  // Prepare the items array from the cart items
  const items = props.cartItems.map(item => ({
    product_id: item.product.id,
    quantity: item.quantity,
    size_id: item.size.id,
    color_id: item.color.id,
    price: item.total_price
  }))
  
  // Calculate total price
  const totalPrice = calculateSubtotal() + 2.00 // Including shipping cost
  
  // Make the request
  router.post('/checkout', {
    ...delivery.value,
    payment_method: 'cod',
    guest_token: getGuestToken(),
    total_price: totalPrice, // Include the total price
    items: items // Include the items array
  }, {
    onFinish: () => {
      isLoading.value = false
    },
    onSuccess: () => {
      toast.success('Order placed successfully!')
    },
    onError: (errors) => {
      toast.error('Oops! sweet error processing your order')
    }
  })
}

</script>