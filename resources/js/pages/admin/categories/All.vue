<template>
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-200 py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-12">
          <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-2">
            Toutes les catégories
          </h1>
          <div class="h-1 w-24 bg-indigo-600 mx-auto rounded-full"></div>
          <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto">
            Découvrez notre sélection de catégories soigneusement organisées pour vous
          </p>
        </div>

        <ConfirmModal
          v-if="showModal"
          :hideBtn="true"
          :message="message"
          :route="deleteRoute"
          @close="showModal = false"
        />

  
        <!-- Categories Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 z-0">
          <div
            v-for="(category, index) in categories"
            :key="index"
            class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group"
          >
          <button
            @click="openModal(category)"
            class="absolute top-2 right-2 bg-red-100 p-2 rounded-full text-red-600 hover:bg-red-200 opacity-0 group-hover:opacity-100 transition z-10"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0H7" />
            </svg>
          </button>

            <div class="relative">
              <img
              :src="category.url ?? '/placeholder.png'"
              alt="Image de la catégorie"
              class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                <div class="p-4 w-full">
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    {{ formatDate(category.created_at) }}
                  </span>
                </div>
              </div>
            </div>
            <div class="p-6">
              <h2 class="text-xl font-bold text-gray-800 mb-2">{{ category.name }}</h2>
              <p v-if="category.description" class="text-gray-600 text-sm">
                {{ category.description }}
              </p>
              <div class="mt-4 flex justify-between items-center">
                <span class="text-sm text-gray-500">
                  <span class="inline-flex items-center text-sm">
                    <svg class="h-4 w-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    {{ formatDate(category.created_at) }}
                  </span>
                </span>
                <button class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                  Explorer
                </button>
              </div>
            </div>
          </div>
        </div>
  
        <!-- Empty State -->
        <div v-if="!categories || categories.length === 0" class="text-center py-12">
          <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune catégorie</h3>
          <p class="mt-1 text-sm text-gray-500">Aucune catégorie n'a été trouvée.</p>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { defineProps, ref } from 'vue'
  import Main from '../Main.vue'
  import ConfirmModal from '../../layouts/ConfirmModal.vue';

  const showModal = ref(false);
  const deleteRoute = ref('');
  const message = ref('');

  const openModal = (category) => {
    deleteRoute.value = `/admin/categories/${category.id}`;
    message.value = `Are you sure you want to delete "${category.name}"?`;
    showModal.value = true;
  };

  defineOptions({
    layout: Main, // Assign layout dynamically
  });
  
  defineProps({
    categories: {
      type: Array,
      default: () => []
    }
  })

  const showDeleteBtn = (id)=>{
    document.getElementById(id).classList.remove("hidden")
  };

  const hideDeleteBtn = (id)=>{
    document.getElementById(id).classList.add("hidden")
  };
  
  const formatDate = (date) => {
    const d = new Date(date)
    return d.toLocaleDateString('fr-FR', {
      day: 'numeric',
      month: 'long',
      year: 'numeric',
    })
  }
  </script>