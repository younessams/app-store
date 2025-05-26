<template>
  <div class="relative" v-click-outside="closeDropdown">
    <button 
      @click="isOpen = !isOpen"
      type="button"
      class="flex items-center justify-between w-36 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      aria-haspopup="listbox"
      aria-expanded="true"
    >
      <div class="flex items-center">
        <span class="mr-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="2" y1="12" x2="22" y2="12"></line>
            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
          </svg>
        </span>
        <span>{{ languages[currentLanguage].label }}</span>
      </div>
      <span class="ml-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
      </span>
    </button>

    <transition
      enter-active-class="transition ease-out duration-100"
      enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <div 
        v-if="isOpen" 
        class="absolute z-10 mt-1 w-36 bg-white shadow-lg rounded-md ring-1 ring-black ring-opacity-5 focus:outline-none"
      >
        <ul class="max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
          <li 
            v-for="(lang, code) in languages" 
            :key="code"
            @click="switchLang(code)"
            :class="[
              'cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-indigo-50',
              currentLanguage === code ? 'bg-indigo-50 text-indigo-600' : 'text-gray-900'
            ]"
          >
            <div class="flex items-center">
              <span class="block truncate">{{ lang.label }}</span>
              <span v-if="currentLanguage === code" class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
              </span>
            </div>
          </li>
        </ul>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const isOpen = ref(false);
const page = usePage();

const languages = {
  en: { label: 'English' },
  fr: { label: 'Français' },
  ar: { label: 'العربية' }
};

const currentLanguage = computed(() => {
  return page.props.locale || 'en';
});

function switchLang(locale) {
  window.location.href = `/lang/${locale}`;
  isOpen.value = false;
}

function closeDropdown(event) {
  if (isOpen.value) isOpen.value = false;
}

// Optional: Add this directive to handle clicks outside the dropdown
const vClickOutside = {
  mounted(el, binding) {
    el.clickOutsideEvent = function(event) {
      if (!(el === event.target || el.contains(event.target))) {
        binding.value(event);
      }
    };
    document.addEventListener('click', el.clickOutsideEvent);
  },
  unmounted(el) {
    document.removeEventListener('click', el.clickOutsideEvent);
  }
};
</script>