<template>
    <div class="flex gap-1">
      <template v-for="(link, index) in links" :key="index">
        <component
          :is="link.url ? 'Link' : 'span'"
          :href="link.url"
          class="px-3 py-1 border rounded"
          :class="{
            'bg-indigo-600 text-white': link.active,
            'text-gray-500': !link.url,
          }"
          v-html="link.label"
        />
      </template>
    </div>
  </template>
  
  <script setup>
  import { Link } from '@inertiajs/vue3'
  defineProps({ links: Array })
  </script>
  