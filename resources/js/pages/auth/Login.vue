<template> 
  <div class="flex min-h-screen items-center justify-center bg-gray-100 pt-2">
    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">
      <h2 class="text-2xl font-bold text-center text-gray-800">{{ useTrans('login.welcome') }}</h2>
      <p class="text-gray-500 text-center mb-6">{{ useTrans('login.signInPrompt') }}</p>

      <form @submit.prevent="login">
        <div class="mb-4">
          <label class="block text-gray-700">{{ useTrans('login.email') }}</label>
          <input v-model="form.email" type="email" :placeholder="useTrans('login.emailPlaceholder')"
            class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <span v-if="errors.email" class="text-red-500 text-sm">{{ errors.email }}</span>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700">{{ useTrans('login.password') }}</label>
          <input v-model="form.password" type="password" :placeholder="useTrans('login.passwordPlaceholder')"
            class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <span v-if="errors.password" class="text-red-500 text-sm">{{ errors.password }}</span>
        </div>

        <div class="flex justify-between items-center mb-4">
          <label class="flex items-center">
            <input type="checkbox" v-model="form.remember" class="mr-2">
            <span class="text-gray-700 text-sm">{{ useTrans('login.rememberMe') }}</span>
          </label>
          <a href="#" class="text-blue-500 text-sm">{{ useTrans('login.forgotPassword') }}</a>
        </div>

        <button type="submit"
          class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
          {{ useTrans('login.signIn') }}
        </button>

        <p class="text-center text-gray-500 mt-4">
          {{ useTrans('login.noAccount') }} 
          <Link href="/register" class="text-blue-500">{{ useTrans('login.signUp') }}</Link>
        </p>
      </form>
    </div>
  </div>
</template>

  
  <script setup>
  import { ref } from 'vue';
  import { useForm, Link } from '@inertiajs/vue3';
  import Main from '../Main.vue';
  import { useTrans } from '../../composables/trans';

defineOptions({
  layout: Main, // Assign layout dynamically
});
  
  const form = useForm({
    email: '',
    password: '',
    remember: false,
  });
  
  const errors = ref({});
  
  const login = () => {
    form.post('/login', {
      onError: (err) => {
        errors.value = err;
      },
    });
  };
  </script>
  