<template>
  <div class="min-h-screen bg-gray-50">
    
    <!-- Hero Section with Featured Offer -->
    <section v-if="offers.length > 0" class="w-full relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-700">
      <div class="absolute inset-0 opacity-10 bg-pattern"></div>
      <div class="container mx-auto px-4 py-16 md:py-24 relative">
        <div class="overflow-hidden rounded-2xl shadow-2xl">
          <div class="flex transition-transform duration-700 ease-out" :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
            <div v-for="(offer, i) in offers" :key="i" class="min-w-full bg-gradient-to-br from-blue-800 to-indigo-900 relative">
              <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 rounded-full opacity-20 -mr-20 -mt-20"></div>
              <div class="absolute bottom-0 left-0 w-48 h-48 bg-indigo-500 rounded-full opacity-20 -ml-16 -mb-16"></div>
              <div class="flex flex-col md:flex-row items-center p-6 md:p-10">
                <div class="md:w-1/2 text-white z-10 mb-8 md:mb-0 md:pr-8">
                  <span class="inline-block px-4 py-1 rounded-full bg-blue-400 bg-opacity-30 text-blue-100 text-sm font-medium mb-4">
                    {{ useTrans('home.special_offer') }}
                  </span>
                  <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">{{ offer.title }}</h1>
                  <p class="text-xl mb-8 text-blue-100 leading-relaxed">{{ offer.description }}</p>
                  <div class="flex space-x-4">
                    <Link :href="`/products?offer=${offer.slug}`" class="bg-white text-blue-700 px-6 py-3 rounded-lg font-bold hover:bg-blue-50 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                      {{ useTrans('home.shop_now') }}
                    </Link>
                    <Link :href="`/offers/${offer.slug}`" class="border border-white border-opacity-30 text-white px-6 py-3 rounded-lg font-medium hover:bg-white hover:bg-opacity-10 transition duration-300">
                      {{ useTrans('home.learn_more') }}
                    </Link>
                  </div>
                </div>
                <div class="md:w-1/2 flex justify-center z-10">
                  <img :src="offer.image_url_path || '/images/featured-shoes.png'" :alt="offer.title" class="max-w-full h-auto rounded-lg shadow-2xl transform hover:rotate-2 transition duration-500 hover:scale-105">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="flex justify-between absolute left-8 right-8 top-1/2 transform -translate-y-1/2 z-10">
          <button @click="prevSlide" class="bg-white bg-opacity-20 hover:bg-opacity-90 text-blue-700 rounded-full w-12 h-12 flex items-center justify-center transition duration-300 shadow-lg" :aria-label="useTrans('home.prev_slide')">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
          </button>
          <button @click="nextSlide" class="bg-white bg-opacity-20 hover:bg-opacity-90 text-blue-700 rounded-full w-12 h-12 flex items-center justify-center transition duration-300 shadow-lg" :aria-label="useTrans('home.next_slide')">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>
        <div class="flex justify-center mt-8">
          <button v-for="(_, index) in offers" :key="index" @click="goToSlide(index)" class="mx-2 w-3 h-3 rounded-full transition-all duration-300 shadow-md transform hover:scale-125"
            :class="currentSlide === index ? 'bg-white scale-125 w-8' : 'bg-white bg-opacity-50 hover:bg-opacity-75'" :aria-label="`${useTrans('home.go_to_slide')} ${index + 1}`">
          </button>
        </div>
        <div v-if="autoplay" class="w-full h-1 mt-4 bg-white bg-opacity-20 rounded overflow-hidden">
          <div class="h-full bg-white transition-all duration-200 ease-linear" :style="{ width: `${timerProgress}%` }"></div>
        </div>
      </div>
    </section>

    <!-- Categories Section -->
    <section class="py-12 bg-white">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-10">{{ useTrans('home.shop_by_category') }}</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          <div v-for="category in categories" :key="category.id" class="group">
            <Link :href="`/products?category=${category.slug}`" class="block">
              <div class="rounded-lg overflow-hidden bg-gray-100 shadow-md aspect-square flex items-center justify-center group-hover:shadow-lg transition duration-300">
                <img :src="category.url || '/images/category-placeholder.jpg'" :alt="category.name" class="w-full h-full object-cover">
              </div>
              <h3 class="mt-3 text-center font-medium text-gray-800 group-hover:text-blue-600 transition duration-300">{{ category.name }}</h3>
            </Link>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-16 bg-gray-50">
      <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-2">{{ useTrans('home.featured_products') }}</h2>
        <p class="text-gray-600 text-center mb-10">{{ useTrans('home.discover_popular') }}</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="product in products" :key="product.id" class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
            <Link :href="`/products/product/${product.slug}`">
              <div class="h-64 overflow-hidden">
                <img :src="getPrimaryImage(product)" :alt="product.name" class="w-full h-full object-cover transition duration-300 hover:scale-105">
              </div>
              <div class="p-5">
                <h3 class="font-bold text-lg mb-1">{{ product.name }}</h3>
                <p class="text-gray-600 mb-2 text-sm">{{ product.brand }}</p>
                <div class="flex justify-between items-center">
                  <span class="font-bold text-xl text-blue-700">${{ product.price }}</span>
                  <span v-if="product.old_price" class="text-sm line-through text-gray-500">${{ product.old_price }}</span>
                </div>
              </div>
            </Link>
          </div>
        </div>
        <div class="text-center mt-10">
          <Link href="/products" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition duration-300">
            {{ useTrans('home.view_all_products') }}
          </Link>
        </div>
      </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-12 bg-white">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center p-6">
            <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">{{ useTrans('home.quality_guaranteed') }}</h3>
            <p class="text-gray-600">{{ useTrans('home.authentic_products') }}</p>
          </div>
          <div class="text-center p-6">
            <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">{{ useTrans('home.fast_delivery') }}</h3>
            <p class="text-gray-600">{{ useTrans('home.delivery_time') }}</p>
          </div>
          <div class="text-center p-6">
            <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
              </svg>
            </div>
            <h3 class="text-xl font-bold mb-2">{{ useTrans('home.secure_payment') }}</h3>
            <p class="text-gray-600">{{ useTrans('home.secure_payment_description') }}</p>
          </div>
        </div>
      </div>
    </section>
     <!-- Footer -->
<footer class="bg-gray-800 text-white py-12">
  <div class="container mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
      <div>
        <h3 class="text-xl font-bold mb-4">{{ useTrans('footer.title') }}</h3>
        <p class="text-gray-400">{{ useTrans('footer.description') }}</p>
      </div>
      
      <div>
        <h4 class="font-bold mb-4">{{ useTrans('footer.quick_links') }}</h4>
        <ul class="space-y-2">
          <li><Link href="/about" class="text-gray-400 hover:text-white transition">{{ useTrans('footer.about_us') }}</Link></li>
          <li><Link href="/contact" class="text-gray-400 hover:text-white transition">{{ useTrans('footer.contact') }}</Link></li>
          <li><Link href="/faq" class="text-gray-400 hover:text-white transition">{{ useTrans('footer.faq') }}</Link></li>
          <li><Link href="/shipping" class="text-gray-400 hover:text-white transition">{{ useTrans('footer.shipping_policy') }}</Link></li>
        </ul>
      </div>
      
      <div>
        <h4 class="font-bold mb-4">{{ useTrans('footer.categories') }}</h4>
        <ul class="space-y-2">
          <li v-for="category in categories.slice(0, 4)" :key="category.id">
            <Link :href="`/products?category=${category.slug}`" class="text-gray-400 hover:text-white transition">
              {{ category.name }}
            </Link>
          </li>
        </ul>
      </div>
      
      <div>
        <h4 class="font-bold mb-4">{{ useTrans('footer.connect_with_us') }}</h4>
        <div class="flex space-x-4">
          <a href="https://www.facebook.com/ali.amasri.395" class="text-gray-400 hover:text-white transition">
            <span class="sr-only">{{ useTrans('footer.facebook') }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path d="M22.675 0H1.325C.593 0 0 .593 0 1.326v21.348C0 23.407.593 24 1.325 
              24H12.82v-9.294H9.692V11.41h3.128V8.797c0-3.1 1.893-4.788 4.659-4.788 1.325 
              0 2.464.099 2.797.143v3.24l-1.92.001c-1.504 0-1.796.715-1.796 
              1.763v2.31h3.587l-.467 3.296h-3.12V24h6.116C23.407 24 24 23.407 24 
              22.674V1.326C24 .593 23.407 0 22.675 0z"/>
            </svg>

          </a>
          <a href="https://www.instagram.com/echo_youness/" class="text-gray-400 hover:text-white transition">
            <span class="sr-only">{{ useTrans('footer.instagram') }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path d="M7.75 2h8.5C19.1 2 21 3.9 21 6.25v11.5C21 
              20.1 19.1 22 16.25 22h-8.5C4.9 22 3 20.1 3 
              17.75V6.25C3 3.9 4.9 2 7.75 2zM12 7.25A4.75 
              4.75 0 1 0 12 16.75 4.75 4.75 0 0 0 12 
              7.25zm0 1.5a3.25 3.25 0 1 1 0 6.5 3.25 3.25 
              0 0 1 0-6.5zm5.25-1.5a1.25 1.25 0 1 0 0 2.5 
              1.25 1.25 0 0 0 0-2.5z"/>
            </svg>

          </a>
          <a href="#" class="text-gray-400 hover:text-white transition">
            <span class="sr-only">{{ useTrans('footer.twitter') }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
              <path d="M24 4.557a9.831 9.831 0 01-2.828.775A4.932 
              4.932 0 0023.337 3.1a9.864 9.864 0 01-3.127 1.195 
              4.916 4.916 0 00-8.384 4.482A13.944 13.944 0 011.671 
              3.149a4.916 4.916 0 001.523 6.574A4.903 4.903 0 01.96 
              9.1v.062a4.918 4.918 0 003.946 4.827 4.996 4.996 0 
              01-2.212.084 4.93 4.93 0 004.604 3.417A9.867 9.867 0 
              010 21.539a13.94 13.94 0 007.548 2.212c9.057 0 
              14.009-7.496 14.009-13.986 0-.21-.005-.423-.015-.635A10.012 
              10.012 0 0024 4.557z"/>
            </svg>

          </a>
        </div>
      </div>
    </div>
    
    <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
      <p>&copy; {{ new Date().getFullYear() }} {{ useTrans('footer.title') }}. {{ useTrans('footer.rights_reserved') }}</p>
    </div>
  </div>
</footer>
  </div>
</template>


<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import axios from 'axios'
import { useToast } from 'vue-toastification';
import Main from './Main.vue';
import {useTrans} from '/resources/js/composables/trans.js'

defineOptions({
  layout: Main, // Assign layout dynamically
});

const toast = useToast();

const getPrimaryImage = (product) => {
  const primary = product.images.find(img => img.is_primary === 1);
  return primary ? primary.url : '/placeholder.jpg';
};


const props = defineProps({
  products: Array,
  categories: Array,
  offers: {
    type: Array,
    required: true
  },
  autoplay: {
    type: Boolean,
    default: true
  },
  interval: {
    type: Number,
    default: 5000
  }
});


const formData = ref({
  email: ''
})

const sendContactMail = async () => {
  try {
    await axios.post('/contact/subscribe', formData.value).then((res)=>{
      toast.info(`We will send you a notification email!`)
    })
    formData.value.email = '' // reset the form
  } catch (error) {
    toast.error('Something went wrong. Please try again.')
    console.error(error)
  }
}


const currentSlide = ref(0);
const timerProgress = ref(0);
let autoplayInterval = null;
let progressInterval = null;

const nextSlide = () => {
  currentSlide.value = (currentSlide.value + 1) % props.offers.length;
  resetProgress();
};

const prevSlide = () => {
  currentSlide.value = (currentSlide.value - 1 + props.offers.length) % props.offers.length;
  resetProgress();
};

const goToSlide = (index) => {
  currentSlide.value = index;
  resetProgress();
};

const startAutoplay = () => {
  if (props.autoplay && props.offers.length > 1) {
    autoplayInterval = setInterval(() => {
      nextSlide();
    }, props.interval);
    
    // Start progress animation
    startProgressAnimation();
  }
};

const stopAutoplay = () => {
  if (autoplayInterval) {
    clearInterval(autoplayInterval);
    clearInterval(progressInterval);
  }
};

const startProgressAnimation = () => {
  // Reset progress to 0
  timerProgress.value = 0;
  
  // Clear any existing interval
  if (progressInterval) {
    clearInterval(progressInterval);
  }
  
  // Set up new progress animation
  const stepTime = 50; // Update every 50ms for smooth animation
  const steps = props.interval / stepTime;
  const increment = 100 / steps;
  
  progressInterval = setInterval(() => {
    timerProgress.value = Math.min(100, timerProgress.value + increment);
  }, stepTime);
};

const resetProgress = () => {
  timerProgress.value = 0;
  if (props.autoplay) {
    stopAutoplay();
    startAutoplay();
  }
};

// Pause autoplay when user hovers over the slider
const pauseAutoplay = () => {
  stopAutoplay();
};

// Resume autoplay when user stops hovering
const resumeAutoplay = () => {
  if (props.autoplay) {
    startAutoplay();
  }
};

// Watch for changes in props to restart autoplay if needed
watch(() => props.autoplay, (newVal) => {
  if (newVal) {
    startAutoplay();
  } else {
    stopAutoplay();
  }
});

watch(() => props.interval, () => {
  if (props.autoplay) {
    stopAutoplay();
    startAutoplay();
  }
});

onMounted(() => {
  startAutoplay();
});

onBeforeUnmount(() => {
  stopAutoplay();
});
</script>

<style scoped>
.bg-pattern {
  background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
}
</style>