<template>
  <div class="bg-gray-50 min-h-screen pb-16 mt-14" :dir="$page.props.locale === 'ar' ? 'rtl' : 'ltr'">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 pt-10 lg:px-8">
      <!-- Header section with title and search -->
      <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between">
        <div class="flex">
          <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-6 md:mb-0">{{ useTrans('products-index.title') }}</h1>
          <!-- Category title -->
          <div v-if="filters.category" className="bg-gray-900 bg-opacity-95 text-nowrap px-6 py-2 lg:mx-50 mx-6 mb-6 text-white rounded-md shadow-md flex items-center space-x-2 max-w-sm hover:bg-gray-800 transition-colors duration-200">
            <span className="text-sm font-medium tracking-wide uppercase">{{ filters.category.replace(/-/g, ' ') }}</span>
          </div>
        </div>
        
        <div class="flex items-center gap-4">
          <!-- Search -->
          <div class="relative flex-grow md:w-64">
            <input
              type="text"
              v-model="filters.search"
              :placeholder="useTrans('products-index.search.placeholder')"
              @input="debounceApplyFilters"
              class="w-full py-2.5 pl-10 pr-4 rounded-full border border-gray-200 shadow-sm focus:border-gray-400 focus:ring-0 transition"
            />
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
          </div>
          
          <button 
            @click="isFilterMenuOpen = !isFilterMenuOpen"
            class="flex items-center gap-2 py-2.5 px-5 bg-white hover:bg-gray-100 text-gray-800 rounded-full shadow-sm border border-gray-200 text-sm font-medium transition cursor-pointer"
          >
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 010 2H4a1 1 0 01-1-1zm0 8a1 1 0 011-1h16a1 1 0 010 2H4a1 1 0 01-1-1zm0 8a1 1 0 011-1h16a1 1 0 010 2H4a1 1 0 01-1-1zM4 10h6m10 0h-6m0 0V4m0 6v6" />
            </svg>
            {{ isFilterMenuOpen ? useTrans('products-index.filter.hideFilters') : useTrans('products-index.filter.button') }}
          </button>
        </div>
      </div>
      
      <!-- Active filters section -->
      <div v-if="hasActiveFilters" class="mb-6 flex flex-wrap gap-2">
        <div v-if="filters.category" class="flex items-center px-3 py-1.5 rounded-full bg-gray-100 text-gray-700 text-xs">
          <span>{{ getCategoryName(filters.category) }}</span>
          <button @click="clearCategory" class="ml-2 text-gray-500 hover:text-gray-700">
            <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>
        
        <div v-if="filters.gender" class="flex items-center px-3 py-1.5 rounded-full bg-gray-100 text-gray-700 text-xs">
          <span>{{ filters.gender === 'male' ? useTrans('products-index.gender.men') : useTrans('products-index.gender.women') }}</span>
          <button @click="clearGender" class="ml-2 text-gray-500 hover:text-gray-700">
            <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>
        
        <div v-for="(name, index) in selectedColorNames" :key="`color-${index}`" class="flex items-center px-3 py-1.5 rounded-full bg-gray-100 text-gray-700 text-xs">
          <span>{{ name }}</span>
          <button @click="toggleColor(colors.find(c => c.name === name).id)" class="ml-2 text-gray-500 hover:text-gray-700">
            <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>
        
        <div v-for="(name, index) in selectedSizeNames" :key="`size-${index}`" class="flex items-center px-3 py-1.5 rounded-full bg-gray-100 text-gray-700 text-xs">
          <span>{{ useTrans('products-index.sizes.prefix') }}{{ name }}</span>
          <button @click="toggleSize(sizes.find(s => s.name === name).id)" class="ml-2 text-gray-500 hover:text-gray-700">
            <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </button>
        </div>
        <button
          v-if="hasActiveFilters" 
          @click="resetFilters" 
          class="flex items-center px-3 py-1.5 rounded-full bg-gray-800 text-white text-xs hover:bg-gray-900 transition-colors"
        >
          <span>{{ useTrans('products-index.filter.clearAll') }}</span>
        </button>
      </div>
      
      <!-- Main content area with filter sidebar and products -->
      <div class="relative flex">
        <!-- Filters Sidebar - Sliding panel -->
        <div 
          v-if="isFilterMenuOpen" 
          class="fixed inset-0 z-40 bg-black/30"
          @click="isFilterMenuOpen = false"
        ></div>
        
        <div 
          v-show="isFilterMenuOpen"
          class="fixed right-0 top-0 z-50 h-full w-80 md:w-96 bg-white shadow-xl transform transition-transform duration-300 ease-in-out overflow-y-auto"
          :class="isFilterMenuOpen ? 'translate-x-0' : 'translate-x-full'"
        >
          <div class="p-6">
            <div class="flex justify-between items-center mb-8">
              <h2 class="text-xl font-bold text-gray-900">{{ useTrans('products-index.filter.title') }}</h2>
              <button @click="isFilterMenuOpen = false" class="text-gray-500 hover:text-gray-700 cursor-pointer p-1 rounded-full hover:bg-gray-100">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <!-- Category -->
            <div class="mb-8">
              <label class="block text-sm font-medium text-gray-700 mb-3">{{ useTrans('products-index.category.label') }}</label>
              <div class="relative">
                <select 
                  v-model="filters.category" 
                  @change="applyFilters" 
                  class="appearance-none w-full py-2.5 pl-4 pr-10 rounded-lg border border-gray-300 focus:border-gray-500 focus:ring-0 transition"
                >
                  <option value="">{{ useTrans('products-index.category.allCategories') }}</option>
                  <option v-for="cat in categories" :key="cat.id" :value="cat.slug">{{ cat.name }}</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                  <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </div>
              </div>
            </div>
            
            <!-- Price Range -->
            <div class="mb-8">
              <div class="flex justify-between mb-3">
                <label class="block text-sm font-medium text-gray-700">{{ useTrans('products-index.price.label') }}</label>
                <span class="text-sm font-medium text-gray-900">MAD {{ filters.min_price }} - {{ filters.max_price }}</span>
              </div>
              <div class="w-full flex justify-between text-xs text-gray-500 mb-1">
                <span>{{ useTrans('products-index.price.min') }}</span> 
                <span>{{ useTrans('products-index.price.max') }}</span>
              </div>
              <div class="mb-2">
                <input
                  type="range"
                  min="1"
                  max="799"
                  v-model="filters.min_price"
                  class="w-full accent-gray-900"
                  @mouseup="applyFilters"
                />
              </div>
              <div>
                <input
                  type="range"
                  min="1"
                  max="799"
                  v-model="filters.max_price"
                  class="w-full accent-gray-900"
                  @mouseup="applyFilters"
                />
              </div>
            </div>
            
            <!-- Gender -->
            <div class="mb-8">
              <label class="block text-sm font-medium text-gray-700 mb-3">{{ useTrans('products-index.gender.label') }}</label>
              <div class="grid grid-cols-3 gap-2">
                <button
                  @click="setGender('')"
                  class="py-2.5 px-3 rounded-lg text-sm font-medium transition-colors"
                  :class="filters.gender === '' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200'"
                >
                  {{ useTrans('products-index.gender.all') }}
                </button>
                <button
                  @click="setGender('male')"
                  class="py-2.5 px-3 rounded-lg text-sm font-medium transition-colors"
                  :class="filters.gender === 'male' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200'"
                >
                  {{ useTrans('products-index.gender.men') }}
                </button>
                <button
                  @click="setGender('female')"
                  class="py-2.5 px-3 rounded-lg text-sm font-medium transition-colors"
                  :class="filters.gender === 'female' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200'"
                >
                  {{ useTrans('products-index.gender.women') }}
                </button>
              </div>
            </div>
            
            <!-- Colors -->
            <div class="mb-8">
              <label class="block text-sm font-medium text-gray-700 mb-3">{{ useTrans('products-index.colors.label') }}</label>
              <div class="flex flex-wrap gap-3">
                <button
                  v-for="color in colors"
                  :key="color.id"
                  @click="toggleColor(color.id)"
                  class="w-8 h-8 rounded-full transition transform hover:scale-110 border"
                  :class="[
                    color.class,
                    isColorSelected(color.id) ? 'ring-2 ring-offset-2 ring-gray-900' : 'ring-1 ring-gray-200'
                  ]"
                  :title="color.name"
                />
              </div>
              <div v-if="selectedColorNames.length > 0" class="mt-2 flex flex-wrap gap-1">
                <span v-for="(name, index) in selectedColorNames" :key="index" class="text-xs text-gray-500">
                  {{ name }}{{ index < selectedColorNames.length - 1 ? ',' : '' }}
                </span>
              </div>
            </div>

            <!-- Sizes -->
            <div class="mb-8">
              <label class="block text-sm font-medium text-gray-700 mb-3">{{ useTrans('products-index.sizes.label') }}</label>
              <div class="flex flex-wrap gap-2">
                <button
                  v-for="size in sizes"
                  :key="size.id"
                  @click="toggleSize(size.id)"
                  class="w-10 h-10 flex items-center justify-center rounded-lg text-sm font-medium transition-colors"
                  :class="isSizeSelected(size.id) ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200'"
                >
                  {{ size.name }}
                </button>
              </div>
            </div>
            
            <!-- Sort By -->
            <div class="mb-8">
              <label class="block text-sm font-medium text-gray-700 mb-3">{{ useTrans('products-index.sortBy.label') }}</label>
              <div class="relative">
                <select 
                  v-model="filters.sort" 
                  @change="applyFilters" 
                  class="appearance-none w-full py-2.5 pl-4 pr-10 rounded-lg border border-gray-300 focus:border-gray-500 focus:ring-0 transition"
                >
                  <option value="newest">{{ useTrans('products-index.sortBy.newest') }}</option>
                  <option value="price_asc">{{ useTrans('products-index.sortBy.priceLowHigh') }}</option>
                  <option value="price_desc">{{ useTrans('products-index.sortBy.priceHighLow') }}</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                  <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </div>
              </div>
            </div>

            <!-- Tags -->
            <div class="mb-8">
              <label class="block text-sm font-medium text-gray-700 mb-3">{{ useTrans('products-index.tags.label') }}</label>
              <div class="flex flex-wrap gap-2">
                <button
                  v-for="tag in tags"
                  :key="tag.id"
                  @click="toggleTag(tag.id)"
                  class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors"
                  :class="isTagSelected(tag.id) ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200'"
                >
                  {{ tag.name }}
                </button>
              </div>
            </div>
            
            <!-- Reset Filters -->
            <button 
              @click="resetFilters" 
              class="w-full py-3 mt-6 bg-gray-900 hover:bg-gray-800 text-white rounded-lg text-sm font-medium transition-colors"
            >
              {{ useTrans('products-index.filter.resetAll') }}
            </button>
          </div>
        </div>

        <ProductList
          :products="products"
          :filters="filters"
          :getProductImageUrl="getProductImageUrl"
          :showProductDetails="showProductDetails"
          :getCategoryName="getCategoryName"
          :applyFilters="applyFilters"
        />

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, computed, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import ProductList from '../Components/ProductList.vue';
import Main from '../Main.vue'; 
import { useTrans } from '../../composables/trans'; // Make sure to update this path

defineOptions({
  layout: Main, // Assign layout dynamically
});

const props = defineProps({
  products: Object,
  categories: Array,
  tags: Array,
  colors: Array,
  sizes: Array,
  filters: Object,
})

// Initialize filter menu state
const isFilterMenuOpen = ref(false)

// Safely extract filter values from props with fallbacks
const filters = ref({
  search: props.filters?.search || '',
  category: props.filters?.category || '',
  gender: props.filters?.gender || '',
  tags: Array.isArray(props.filters?.tags) ? props.filters.tags : [],
  colors: Array.isArray(props.filters?.colors) ? props.filters.colors : [],
  sizes: Array.isArray(props.filters?.sizes) ? props.filters.sizes : [],
  min_price: props.filters?.min_price || 0,
  max_price: props.filters?.max_price || 799,
  sort: props.filters?.sort || 'newest',
})

// Check if any filters are active
const hasActiveFilters = computed(() => {
  return filters.value.search ||
         filters.value.category || 
         filters.value.gender || 
         filters.value.tags.length > 0 ||
         filters.value.colors.length > 0 ||
         filters.value.sizes.length > 0 ||
         filters.value.min_price > 0 ||
         filters.value.max_price < 799;
})

// Get color names for selected colors
const selectedColorNames = computed(() => {
  return filters.value.colors
    .map(colorId => {
      const color = props.colors.find(c => c.id === colorId)
      return color ? color.name : ''
    })
    .filter(name => name !== '')
})

// Get size names for selected sizes
const selectedSizeNames = computed(() => {
  return filters.value.sizes
    .map(sizeId => {
      const size = props.sizes.find(s => s.id === sizeId)
      return size ? size.name : ''
    })
    .filter(name => name !== '')
})

// Helper to get a safe image URL from the product
const getProductImageUrl = (product) => {
  const primary = product.images.find(img => img.is_primary === 1);
  return primary ? primary.url : '/placeholder.jpg';
};

// Get category name by ID
const getCategoryName = (categoryId) => {
  const category = props.categories.find(cat => cat.id === categoryId)
  return category ? category.name : ''
}

// Helper methods for checking if a tag, color, or size is selected
const isTagSelected = (tagId) => {
  return filters.value.tags.includes(tagId)
}

const isColorSelected = (colorId) => {
  return filters.value.colors.includes(colorId)
}

const isSizeSelected = (sizeId) => {
  return filters.value.sizes.includes(sizeId)
}

// Clear individual filters
const clearSearch = () => {
  filters.value.search = ''
  applyFilters()
}

const clearCategory = () => {
  filters.value.category = ''
  applyFilters()
}

const clearGender = () => {
  filters.value.gender = ''
  applyFilters()
}

const clearSizes = () => {
  filters.value.sizes = []
  applyFilters()
}

// Debounce function for search
let searchTimeout = null
const debounceApplyFilters = () => {
  if (searchTimeout) {
    clearTimeout(searchTimeout)
  }
  searchTimeout = setTimeout(() => {
    applyFilters()
  }, 500)
}

const applyFilters = () => {
  // Close the filter menu on mobile after applying filters
  if (window.innerWidth < 768) {
    isFilterMenuOpen.value = false
  }
  
  // Clean up the filters object before sending to avoid empty values
  const cleanFilters = {}
  
  // Only include non-empty values
  if (filters.value.search) cleanFilters.search = filters.value.search
  if (filters.value.category) cleanFilters.category = filters.value.category
  if (filters.value.gender) cleanFilters.gender = filters.value.gender
  
  // Only include non-empty arrays
  if (filters.value.tags && filters.value.tags.length > 0) {
    cleanFilters.tags = filters.value.tags
  }
  
  if (filters.value.colors && filters.value.colors.length > 0) {
    cleanFilters.colors = filters.value.colors
  }
  
  if (filters.value.sizes && filters.value.sizes.length > 0) {
    cleanFilters.sizes = filters.value.sizes
  }
  
  // Only include numeric price values
  if (filters.value.min_price !== '' && filters.value.min_price !== null) {
    cleanFilters.min_price = filters.value.min_price
  }
  
  if (filters.value.max_price !== '' && filters.value.max_price !== null) {
    cleanFilters.max_price = filters.value.max_price
  }
  
  // Always include sort
  cleanFilters.sort = filters.value.sort
  
  // Make the request with clean filters
  router.get('/products', cleanFilters, {
    preserveState: true,
    replace: true,
    preserveScroll: true,
  })
}

const resetFilters = () => {
  filters.value = {
    search: '',
    category: '',
    gender: '',
    tags: [],
    colors: [],
    sizes: [],
    min_price: 0,
    max_price: 799,
    sort: 'newest',
  }
  applyFilters()
}

const setGender = (gender) => {
  filters.value.gender = gender
  applyFilters()
}

const toggleTag = (tagId) => {
  const index = filters.value.tags.indexOf(tagId)
  if (index === -1) {
    filters.value.tags.push(tagId)
  } else {
    filters.value.tags.splice(index, 1)
  }
  applyFilters()
}

const toggleColor = (colorId) => {
  const index = filters.value.colors.indexOf(colorId)
  if (index === -1) {
    filters.value.colors.push(colorId)
  } else {
    filters.value.colors.splice(index, 1)
  }
  applyFilters()
}

const toggleSize = (sizeId) => {
  const index = filters.value.sizes.indexOf(sizeId)
  if (index === -1) {
    filters.value.sizes.push(sizeId)
  } else {
    filters.value.sizes.splice(index, 1)
  }
  applyFilters()
}

// Close filter menu when clicking outside on larger screens
onMounted(() => {
  const handleResize = () => {
    if (window.innerWidth >= 768) {
      document.addEventListener('click', handleClickOutside)
    } else {
      document.removeEventListener('click', handleClickOutside)
    }
  }
  
  const handleClickOutside = (event) => {
    const filterMenu = document.querySelector('.filter-menu')
    const filterButton = document.querySelector('.filter-button')
    
    if (filterMenu && 
        !filterMenu.contains(event.target) && 
        filterButton && 
        !filterButton.contains(event.target)) {
      isFilterMenuOpen.value = false
    }
  }
  
  handleResize()
  window.addEventListener('resize', handleResize)
  
  return () => {
    document.removeEventListener('click', handleClickOutside)
    window.removeEventListener('resize', handleResize)
  }
})

const showProductDetails = (product) => {
  router.get(`/products/product/${product.slug}`);
}
</script>