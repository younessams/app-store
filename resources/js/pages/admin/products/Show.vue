<template>
    <div class="p-6 bg-gray-50 min-h-screen flex justify-center items-center">
        
      <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-4xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Product Images -->
          <div>
            <div class="bg-gray-100 p-4 rounded-lg overflow-hidden">
              <img :src="primaryImage" alt="Product Main Image" class="w-full object-contain h-96 rounded-lg shadow-sm">
            </div>
            <div class="flex space-x-2 mt-4">
              <div
                v-for="(image, iImage) in product.images"
                :key="iImage"
                class="cursor-pointer border-2 rounded-md overflow-hidden"
                :class="image.is_primary ? 'border-blue-600' : 'border-gray-300'"
                @click="primaryImage = image.path"
              >
                <img :src="image.path" alt="Product Thumbnail" class="w-16 h-16 object-cover">
              </div>
            </div>
          </div>
  
          <!-- Product Details -->
          <div class="flex flex-col justify-between">
            <div>
              <h2 class="text-3xl font-semibold text-gray-800">{{ product.name }}</h2>
              <p class="text-gray-500 text-sm mt-1">Brand: <span class="font-medium">{{ product.brand }}</span></p>
              <p class="text-gray-500 text-sm">Category: <span class="font-medium">{{ product.category.name }}</span></p>
              <p class="text-gray-700 mt-3">{{ product.description }}</p>
  
              <div class="mt-4 flex items-center space-x-2">
                <span class="text-2xl font-bold text-gray-900">${{ product.price }}</span>
                <span class="text-sm text-gray-500">({{ product.stock }} in stock)</span>
              </div>
            </div>
  
            <div class="mt-4">
            <strong class="text-gray-700">Tags:</strong>
            <div class="flex flex-wrap gap-2 mt-2">
              <span v-for="(tag, iTag) in product.tags" :key="iTag" class="bg-orange-500 text-white px-3 py-1 rounded-full text-sm">
                {{ tag.name }}
              </span>
            </div>
          </div>

  
            <div class="mt-4">
              <strong class="text-gray-700">Sizes :</strong>
              <div class="flex space-x-2 mt-1">
                <span v-for="(size, iSize) in product.sizes" :key="iSize" class="px-3 py-1 rounded-lg text-white bg-gray-700 text-sm">{{ size.name }}</span>
              </div>
            </div>
  
            <div class="mt-4 flex items-center">
              <strong class="text-gray-700">Colors:</strong>
              <div v-for="(color, iColor) in product.colors" :key="iColor" class="w-6 h-6 rounded-full border ml-2" :class="color.class"></div>
            </div>
  
            <Link href="/admin/products" class="flex mt-6 transition px-6 py-3 bg-orange-600 rounded-lg text-white text-center shadow-lg"> <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m0 0l6-6m-6 6l6 6" />
</svg>
 Back</Link>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { usePage } from '@inertiajs/vue3';
  import { Link } from '@inertiajs/vue3';
  import Main from "../Main.vue";

defineOptions({
    layout: Main, // Assign layout dynamically
});
  
  const { product } = usePage().props;
  const primaryImage = ref(product.images.find(img => img.is_primary)?.path || product.images[0]?.path);
  </script>
  
  <style scoped>
  /* Custom styles for better aesthetics */
  </style>
  