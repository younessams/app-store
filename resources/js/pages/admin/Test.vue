<script setup>
import Main from './Main.vue';

defineProps({
  layout: {
    type: Object,
    default: Main, // Assign default layout
  },
});
</script>

<template>
  <div>
    <h2>Welcome to My Web Store</h2>
    <p>Find the best products here!</p>
  </div>
</template>
