<template>
    <div class="wishlist-container">
      <h1 class="text-xl font-semibold">{{ useTrans('wishlist-list.title') }}</h1>
  
      <div v-if="products.length === 0" class="mt-4 text-gray-500">
        {{ useTrans('wishlist-list.empty') }}
      </div>
  
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
        <div v-for="product in products" :key="product.id" class="relative bg-white p-4 rounded-lg shadow-md">
          <img 
            :src="product.image_url" 
            :alt="useTrans('wishlist-list.product_alt')" 
            class="w-full h-48 object-cover rounded-md" 
          />
          <div class="mt-4">
            <h3 class="font-semibold text-lg">{{ product.name }}</h3>
            <p class="text-gray-500 text-sm">{{ product.description }}</p>
          </div>
  
          <button 
            @click="removeFromWishlist(product.id)"
            :title="useTrans('wishlist-list.remove')"
            class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full hover:bg-red-600 focus:outline-none">
            <span class="material-icons">remove_circle</span>
          </button>
          
          <button 
            @click="toggleWishlist(product.id)"
            :title="useTrans('wishlist-list.toggle')"
            class="absolute bottom-2 right-2 bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600 focus:outline-none">
            <span class="material-icons">{{ isInWishlist(product.id) ? 'favorite' : 'favorite_border' }}</span>
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { usePage } from '@inertiajs/inertia-vue3';
  import { useTrans } from '../../composables/trans';
  
  const { props } = usePage();
  const products = ref(props.products || []); // Initial products list passed as prop
  
  const toggleWishlist = async (productId) => {
    try {
      const response = await axios.post(route('wishlist.toggle'), { product_id: productId });
      // Optionally use your toast library here for notifications
      console.log(useTrans('wishlist-list.success_toggle')); // Example success message
      await reloadProducts();
    } catch (error) {
      console.error(useTrans('wishlist-list.error_toggle'), error);
    }
  };
  
  const removeFromWishlist = async (productId) => {
    try {
      const response = await axios.delete(route('wishlist.destroy', { productId }));
      // Optionally use your toast library here for notifications
      console.log(useTrans('wishlist-list.success_remove')); // Example success message
      await reloadProducts();
    } catch (error) {
      console.error(useTrans('wishlist-list.error_remove'), error);
    }
  };
  
  const isInWishlist = (productId) => {
    return products.value.some(product => product.id === productId);
  };
  
  // Reload products after any modification (adding/removing)
  const reloadProducts = async () => {
    // Re-fetch the updated products list from the backend
    await Inertia.reload();
  };
  </script>
  
  <style scoped>
  .wishlist-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
  }
  
  .material-icons {
    font-size: 24px;
  }
  </style>