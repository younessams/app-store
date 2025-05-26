<template>
    <div class="max-w-2xl mx-auto p-8 bg-white rounded-lg shadow-lg border border-gray-100 my-2 mt-18">
  
      <!-- Form content -->
      <div>
        <div class="mb-8">
          <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ useTrans('contact.pageTitle') }}</h1>
          <p class="text-gray-600">{{ useTrans('contact.pageSubtitle') }}</p>
        </div>
  
        <form @submit.prevent="submit" class="space-y-6">
          <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Name Input -->
            <div class="relative">
              <label for="name" class="text-sm font-medium text-gray-700 mb-1 block">{{ useTrans('contact.form.fullName') }}</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                  </svg>
                </div>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  class="pl-10 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                  :placeholder="useTrans('contact.form.fullNamePlaceholder')"
                />
              </div>
              <p v-if="errors.name" class="mt-1 text-sm text-red-500">{{ errors.name }}</p>
            </div>
  
            <!-- Phone Input -->
            <div>
              <label for="phone" class="text-sm font-medium text-gray-700 mb-1 block">{{ useTrans('contact.form.phone') }}</label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                  </svg>
                </div>
                <input
                  id="phone"
                  v-model="form.phone"
                  type="tel"
                  class="pl-10 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                  :placeholder="useTrans('contact.form.phonePlaceholder')"
                />
              </div>
              <p v-if="errors.phone" class="mt-1 text-sm text-red-500">{{ errors.phone }}</p>
            </div>
          </div>
  
          <!-- Email Input -->
          <div>
            <label for="email" class="text-sm font-medium text-gray-700 mb-1 block">{{ useTrans('contact.form.email') }}</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                  <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
              </div>
              <input
                id="email"
                v-model="form.email"
                type="email"
                class="pl-10 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                :placeholder="useTrans('contact.form.emailPlaceholder')"
              />
            </div>
            <p v-if="errors.email" class="mt-1 text-sm text-red-500">{{ errors.email }}</p>
          </div>
  
          <!-- Message Input -->
          <div>
            <label for="message" class="text-sm font-medium text-gray-700 mb-1 block">{{ useTrans('contact.form.message') }}</label>
            <div class="relative">
              <div class="absolute top-3 left-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
              </div>
              <textarea
                id="message"
                v-model="form.message"
                rows="4"
                class="pl-10 w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                :placeholder="useTrans('contact.form.messagePlaceholder')"
              ></textarea>
            </div>
            <p v-if="errors.message" class="mt-1 text-sm text-red-500">{{ errors.message }}</p>
          </div>
  
          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="form.processing"
            class="w-full md:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 text-white font-medium rounded-lg transition-colors duration-300 flex items-center justify-center"
          >
            <template v-if="form.processing">
              <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22C6.5 22 2 17.5 2 12S6.5 2 12 2s10 4.5 10 10"></path>
                <path d="M12 2v4"></path>
                <path d="M12 18v4"></path>
                <path d="M4.93 4.93l2.83 2.83"></path>
                <path d="M16.24 16.24l2.83 2.83"></path>
                <path d="M2 12h4"></path>
                <path d="M18 12h4"></path>
                <path d="M4.93 19.07l2.83-2.83"></path>
              </svg>
              {{ useTrans('contact.form.sending') }}
            </template>
            <template v-else>
              {{ useTrans('contact.form.submitButton') }}
              <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
              </svg>
            </template>
          </button>
        </form>
  
        <div class="mt-8 pt-6 border-t border-gray-200">
          <p class="text-sm text-gray-500 text-center">
            {{ useTrans('contact.privacyNotice') }}
            <span @click="showPrivacy = true" class="text-blue-600 hover:underline cursor-pointer">
              {{ useTrans('contact.privacyLink') }}
            </span>.
          </p>
        </div>
      </div>
    </div>
    <transition v-if="showPrivacy"
  name="fade"
>
  <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <!-- Background overlay -->
      <div class="fixed inset-0 bg-gray-500/25 transition-opacity" aria-hidden="true" @click="showPrivacy = false"></div>
      
      <!-- Modal panel -->
      <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
              </div>
              <h2 class="ml-3 text-xl font-bold text-white" id="modal-title">{{ useTrans('contact.privacy.title') }}</h2>
            </div>
            <button 
              @click="showPrivacy = false" 
              class="bg-white cursor-pointer bg-opacity-20 rounded-full p-1 hover:bg-opacity-30 focus:outline-none focus:ring-2 focus:ring-white transition duration-150"
            >
              <svg class="h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
        
        <!-- Content -->
        <div class="bg-white px-6 py-4">
          <div class="max-h-[60vh] overflow-y-auto pr-2 space-y-6 text-gray-700 text-sm custom-scrollbar">
            <!-- Introduction -->
            <div>
              <div class="flex items-center mb-3">
                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">{{ useTrans('contact.privacy.sections.commitment.title') }}</h3>
              </div>
              <p class="text-gray-700 ml-11">{{ useTrans('contact.privacy.sections.commitment.content') }}</p>
            </div>
            
            <!-- Data Collection -->
            <div>
              <div class="flex items-center mb-3">
                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">{{ useTrans('contact.privacy.sections.dataCollection.title') }}</h3>
              </div>
              <p class="text-gray-700 ml-11">{{ useTrans('contact.privacy.sections.dataCollection.content') }}</p>
              
              <div class="bg-indigo-50 border-l-4 border-indigo-400 p-4 mt-3 ml-11 rounded-r">
                <div class="flex">
                  <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                  </div>
                  <div class="ml-3">
                    <p class="text-sm text-indigo-700">
                      {{ useTrans('contact.privacy.sections.dataCollection.note') }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Data Sharing -->
            <div>
              <div class="flex items-center mb-3">
                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                  </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">{{ useTrans('contact.privacy.sections.dataSharing.title') }}</h3>
              </div>
              <p class="text-gray-700 ml-11">{{ useTrans('contact.privacy.sections.dataSharing.content') }}</p>
            </div>
            
            <!-- Your Rights -->
            <div>
              <div class="flex items-center mb-3">
                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                  </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">{{ useTrans('contact.privacy.sections.yourRights.title') }}</h3>
              </div>
              <p class="text-gray-700 ml-11">{{ useTrans('contact.privacy.sections.yourRights.content') }}</p>
              
              <div class="bg-green-50 border border-green-200 rounded-md p-4 mt-3 ml-11">
                <div class="flex">
                  <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                  </div>
                  <div class="ml-3">
                    <h3 class="text-sm font-medium text-green-800">{{ useTrans('contact.privacy.sections.yourRights.subtitle') }}</h3>
                    <div class="mt-2 text-sm text-green-700">
                      <ul class="list-disc pl-5 space-y-1">
                        <li v-for="(right, index) in useTrans('contact.privacy.sections.yourRights.list')" :key="index">{{ right }}</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Contact Information -->
            <div>
              <div class="flex items-center mb-3">
                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">{{ useTrans('contact.privacy.sections.contactUs.title') }}</h3>
              </div>
              <p class="text-gray-700 ml-11">{{ useTrans('contact.privacy.sections.contactUs.content') }}</p>
              
              <div class="ml-11 mt-3 bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <div class="px-4 py-5 sm:p-6">
                  <div class="flex items-center">
                    <div class="min-w-0 flex-1 text-sm">
                      <p class="font-medium text-gray-900">{{ useTrans('contact.privacy.sections.contactUs.email') }}</p>
                      <p class="text-gray-500">{{ useTrans('contact.privacy.sections.contactUs.emailValue') }}</p>
                    </div>
                  </div>
                  <div class="mt-4 flex items-center">
                    <div class="min-w-0 flex-1 text-sm">
                      <p class="font-medium text-gray-900">{{ useTrans('contact.privacy.sections.contactUs.phone') }}</p>
                      <p class="text-gray-500">{{ useTrans('contact.privacy.sections.contactUs.phoneValue') }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Security Measures -->
            <div>
              <div class="flex items-center mb-3">
                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">{{ useTrans('contact.privacy.sections.security.title') }}</h3>
              </div>
              <p class="text-gray-700 ml-11">{{ useTrans('contact.privacy.sections.security.content') }}</p>
            </div>
            
            <!-- Cookies Policy -->
            <div>
              <div class="flex items-center mb-3">
                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                  </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">{{ useTrans('contact.privacy.sections.cookies.title') }}</h3>
              </div>
              <p class="text-gray-700 ml-11">{{ useTrans('contact.privacy.sections.cookies.content') }}</p>
            </div>
          </div>
        </div>
        
        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row sm:justify-between sm:items-center border-t border-gray-200">
          <p class="text-xs text-gray-500">{{ useTrans('contact.privacy.footer.lastUpdated') }}</p>
          <div class="mt-3 sm:mt-0 space-x-3">
            <button 
              @click="showPrivacy = false" 
              class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              {{ useTrans('contact.privacy.footer.closeButton') }}
            </button>
            <button 
              class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            >
              {{ useTrans('contact.privacy.footer.acceptButton') }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</transition>

  </template>
  <script setup>
  import { useForm } from '@inertiajs/vue3'
  import Main from '../Main.vue'
  import { useToast } from 'vue-toastification'
  import { ref } from 'vue'
  import { useTrans } from '../../composables/trans'
  
  defineOptions({
    layout: Main, // Assign layout dynamically
  })
  
  const toast = useToast()
  
  const form = useForm({
    name: '',
    phone: '',
    email: '',
    message: '',
  })
  
  const submit = () => {
    form.post('/contact', {
      onSuccess: () => {
        toast.success('Message sent successfully!')
        resetForm()
      }
    })
  }
  
  const resetForm = () => {
    form.reset()
    form.clearErrors()
  }
  
  const errors = form.errors
  const showPrivacy = ref(false);
  </script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #d1d5db;
  border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: #9ca3af;
}
</style>