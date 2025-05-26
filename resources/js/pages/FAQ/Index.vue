
<template> 
  <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-18">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="text-center mb-12">
        <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">{{ useTrans('faq.subtitle') }}</h2>
        <h1 class="mt-2 text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">
          {{ useTrans('faq.title') }}
        </h1>
        <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
          {{ useTrans('faq.description') }}
        </p>
      </div>

      <!-- Search Bar -->
      <div class="relative max-w-xl mx-auto mb-10">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
        <input
          v-model="search"
          type="text"
          :placeholder="useTrans('faq.searchPlaceholder')"
          class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out shadow-sm"
        />
      </div>

      <!-- FAQ Section -->
      <div class="space-y-6">
        <div v-if="filteredFaqs.length" class="space-y-4">
          <div
            v-for="(faq, index) in filteredFaqs"
            :key="index"
            class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300"
          >
            <button
              @click="toggle(index)"
              class="flex justify-between items-center w-full p-6 text-left focus:outline-none"
              :class="{ 'border-b border-gray-100': openIndex === index }"
            >
              <span class="font-medium text-lg text-gray-900">{{ faq.question }}</span>
              <div class="ml-2 flex-shrink-0">
                <div
                  class="rounded-full bg-indigo-50 p-1.5 transition-all duration-200"
                  :class="{ 'bg-indigo-100': openIndex === index }"
                >
                  <svg
                    :class="{ 'rotate-180 text-indigo-600': openIndex === index, 'text-indigo-400': openIndex !== index }"
                    class="w-5 h-5 transition-transform duration-200"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </div>
              </div>
            </button>
            <div 
              v-if="openIndex === index" 
              class="p-6 pt-3 bg-white"
            >
              <div class="prose prose-indigo max-w-none text-gray-600" v-html="faq.answer"></div>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-else class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <h3 class="mt-2 text-lg font-medium text-gray-900">{{ useTrans('faq.noResults.title') }}</h3>
          <p class="mt-1 text-gray-500">{{ useTrans('faq.noResults.description') }}</p>
          <div class="mt-6">
            <button 
              @click="search = ''" 
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              {{ useTrans('faq.noResults.clearButton') }}
            </button>
          </div>
        </div>
      </div>

      <!-- Contact Section -->
      <div class="mt-16 bg-indigo-50 rounded-2xl overflow-hidden shadow-sm">
        <div class="px-6 py-8 sm:p-10 sm:pb-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-10 w-10 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
              </svg>
            </div>
            <div class="ml-5">
              <h3 class="text-lg leading-6 font-medium text-gray-900">{{ useTrans('faq.contactSection.title') }}</h3>
              <div class="mt-2 max-w-xl text-sm text-gray-500">
                <p>{{ useTrans('faq.contactSection.description') }}</p>
              </div>
              <div class="mt-5">
                <a href="/contact" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  {{ useTrans('faq.contactSection.contactButton') }}
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useTrans } from '../../composables/trans';
import Main from '../Main.vue';

defineOptions({
  layout: Main, // Assign layout dynamically
});

const search = ref('')
const openIndex = ref(null)

const toggle = (index) => {
  openIndex.value = openIndex.value === index ? null : index
}

// Load FAQ data from translations
const faqs = computed(() => {
  const questions = useTrans('faq.questions')
  return questions.map(question => ({
    question: question.question,
    answer: question.answer
  }))
})

const filteredFaqs = computed(() =>
  faqs.value.filter(faq =>
    faq.question.toLowerCase().includes(search.value.toLowerCase()) ||
    faq.answer.toLowerCase().includes(search.value.toLowerCase())
  )
)
</script>