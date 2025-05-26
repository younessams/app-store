<template>
    <div v-if="ShowDangerModal || hideBtn" class="fixed bg-gray-600/50 inset-0 z-50 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div
          class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
        >
          <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div
                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
              >
                <svg
                  aria-hidden="true"
                  stroke="currentColor"
                  stroke-width="1.5"
                  viewBox="0 0 24 24"
                  fill="none"
                  class="h-6 w-6 text-red-600"
                >
                  <path
                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
                    stroke-linejoin="round"
                    stroke-linecap="round"
                  ></path>
                </svg>
              </div>
              <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                <h3 id="modal-title" class="text-base font-semibold leading-6 text-gray-900">
                  {{ useTrans('confirm-modal-component.title') }}
                </h3>
                <div class="mt-2">
                  <p class="text-sm text-gray-500">
                    {{ message || useTrans('confirm-modal-component.default_message') }}
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
            <button
              @click="cDelete"
              class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto cursor-pointer"
              type="button"
            >
              {{ useTrans('confirm-modal-component.delete_button') }}
            </button>
            <button
              @click="hideModal"
              class="mt-3 cursor-pointer inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
              type="button"
            >
              {{ useTrans('confirm-modal-component.cancel_button') }}
            </button>
          </div>
        </div>
      </div>
    </div>
    <button v-if="!hideBtn" @click="ShowDangerModal = true" class="bg-red-100 p-2 rounded-lg hover:bg-red-200 text-red-600 cursor-pointer">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0H7" />
      </svg>
    </button>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { router } from '@inertiajs/vue3'
import { useTrans } from '../../composables/trans';

  const ShowDangerModal = ref(false);

  const emit = defineEmits(['update:hideBtn', 'close'])

const cDelete = () => {
  router.delete(props.route, {
    onFinish: () => {
      hideModal();
    }
  });
}

const hideModal = () => {
  ShowDangerModal.value = false
  emit('update:hideBtn', false)
  emit('close') // Optional extra emit
}

  const props = defineProps({
    hideBtn: Boolean,
    route: String,
    message: String,
    classes: String,
  });
  
  </script>
  
  <style scoped>
  /* Add any additional styling if needed */
  </style>