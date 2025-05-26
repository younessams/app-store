<template>
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-200 py-12 px-4 sm:px-2 lg:px-4">
      <div class="max-w-3xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-10">
          <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-2">
            Créer une catégorie
          </h1>
          <div class="h-1 w-24 bg-indigo-600 mx-auto rounded-full"></div>
          <p class="mt-4 text-lg text-gray-600">
            Ajoutez une nouvelle catégorie à votre collection
          </p>
        </div>
  
        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
          <div class="p-8">
            <form @submit.prevent="submitForm">
              <!-- Name -->
              <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                  Nom de la catégorie *
                </label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  required
                  class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                  placeholder="Entrez le nom de la catégorie"
                />
              </div>
  
              <!-- Description -->
              <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                  Description
                </label>
                <textarea
                  id="description"
                  v-model="form.description"
                  rows="3"
                  class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                  placeholder="Description de la catégorie (optionnel)"
                ></textarea>
              </div>
  
              <!-- Image Upload -->
              <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                  Image de la catégorie
                </label>
                <div class="mt-1 flex items-center">
                  <div v-if="imagePreview" class="relative w-32 h-32 rounded-lg overflow-hidden mr-4">
                    <img :src="imagePreview" alt="Aperçu" class="w-full h-full object-cover" />
                    <button
                      type="button"
                      @click="removeImage"
                      class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </div>
  
                  <div
                    class="flex flex-col justify-center items-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition-colors cursor-pointer"
                    @click="triggerFileInput"
                  >
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                      <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                      </svg>
                      <p class="mb-2 text-sm text-gray-500">
                        <span class="font-semibold">Cliquez pour uploader</span> ou glissez-déposez
                      </p>
                      <p class="text-xs text-gray-500">SVG, PNG, JPG ou GIF (max. 2MB)</p>
                    </div>
                    <input
                      ref="fileInput"
                      type="file"
                      class="hidden"
                      accept="image/*"
                      @change="handleFileUpload"
                    />
                  </div>
                </div>
              </div>
  
              <!-- Active Toggle -->
              <div class="mb-6">
                <div class="flex items-center">
                  <button
                    type="button"
                    @click="form.is_active = !form.is_active"
                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    :class="[form.is_active ? 'bg-indigo-600' : 'bg-gray-200']"
                  >
                    <span
                      class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                      :class="[form.is_active ? 'translate-x-5' : 'translate-x-0']"
                    ></span>
                  </button>
                  <span class="ml-3 text-sm font-medium text-gray-700">Catégorie active</span>
                </div>
              </div>
  
              <!-- Submit Buttons -->
              <div class="flex justify-end space-x-3 mt-8">
                <button
                  type="button"
                  @click="resetForm"
                  class="px-5 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all"
                >
                  Annuler
                </button>
                <button
                  type="submit"
                  :disabled="processing"
                  class="px-5 py-2 bg-indigo-600 rounded-lg text-white font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all"
                >
                  Créer la catégorie
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, reactive } from 'vue'
  import Main from '../Main.vue'
  import { router } from '@inertiajs/vue3'
  
  defineOptions({
    layout: Main,
  })
  
  const fileInput = ref(null)
  const imagePreview = ref(null)
  const processing = ref(false)
  
  const form = reactive({
    name: '',
    description: '',
    image: null,
    is_active: true,
  })
  
  const triggerFileInput = () => {
    fileInput.value?.click()
  }
  
  const handleFileUpload = (event) => {
    const file = event.target.files[0]
    if (!file) return
  
    if (file.size > 2 * 1024 * 1024) {
      alert('Le fichier est trop volumineux. La taille maximale est de 2MB.')
      return
    }
  
    form.image = file
  
    const reader = new FileReader()
    reader.onload = (e) => {
      imagePreview.value = e.target.result
    }
    reader.readAsDataURL(file)
  }
  
  const removeImage = () => {
    form.image = null
    imagePreview.value = null
    if (fileInput.value) {
      fileInput.value.value = ''
    }
  }
  
  const submitForm = () => {
    processing.value = true
  
    const formData = new FormData()
    formData.append('name', form.name)
    if (form.description.trim()) {
      formData.append('description', form.description)
    }
    if (form.image instanceof File) {
      formData.append('image', form.image)
    }
    formData.append('is_active', form.is_active ? '1' : '0')
  
    router.post('/admin/categories', formData, {
      forceFormData: true, // ✅ this is crucial for file upload
      onSuccess: () => {
        resetForm()
      },
      onError: (errors) => {
        console.error('Erreurs de validation:', errors)
      },
      onFinish: () => {
        processing.value = false
      },
    })
  }
  
  const resetForm = () => {
    form.name = ''
    form.description = ''
    form.image = null
    form.is_active = true
    imagePreview.value = null
    if (fileInput.value) {
      fileInput.value.value = ''
    }
  }
  </script>
  