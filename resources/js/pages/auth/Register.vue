<template>
  <div class="flex min-h-screen items-center justify-center bg-gray-100 p-6">
    <div class="w-full max-w-2xl bg-white p-10 rounded-3xl shadow-2xl my-4">
      <h2 class="text-3xl font-extrabold text-center text-gray-800">{{ useTrans('register.title') }}</h2>
      <p class="text-gray-500 text-center mb-8">{{ useTrans('register.subtitle') }}</p>

      <form @submit.prevent="register" class="grid grid-cols-2 gap-6">
        <div class="col-span-2 md:col-span-1">
          <label class="block text-gray-700 font-medium">{{ useTrans('register.name') }}</label>
          <input v-model="form.name" type="text" :placeholder="useTrans('register.namePlaceholder')"
            class="w-full px-5 py-3 mt-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-300">
          <span v-if="errors.name" class="text-red-500 text-sm">{{ errors.name }}</span>
        </div>

        <div class="col-span-2 md:col-span-1">
          <label class="block text-gray-700 font-medium">{{ useTrans('register.email') }}</label>
          <input v-model="form.email" type="email" :placeholder="useTrans('register.emailPlaceholder')"
            class="w-full px-5 py-3 mt-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-300">
          <span v-if="errors.email" class="text-red-500 text-sm">{{ errors.email }}</span>
        </div>

        <div class="col-span-2 md:col-span-1">
          <label class="block text-gray-700 font-medium">{{ useTrans('register.password') }}</label>
          <input v-model="form.password" type="password" :placeholder="useTrans('register.passwordPlaceholder')"
            class="w-full px-5 py-3 mt-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-300">
          <span v-if="errors.password" class="text-red-500 text-sm">{{ errors.password }}</span>
        </div>

        <div class="col-span-2 md:col-span-1">
          <label class="block text-gray-700 font-medium">{{ useTrans('register.confirmPassword') }}</label>
          <input v-model="form.password_confirmation" type="password" :placeholder="useTrans('register.confirmPasswordPlaceholder')"
            class="w-full px-5 py-3 mt-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-300">
        </div>

        <div class="col-span-2">
          <button type="submit"
            class="w-full bg-blue-500 text-white px-6 py-3 rounded-xl hover:bg-blue-600 transition font-semibold shadow-md">
            {{ useTrans('register.signUp') }}
          </button>
        </div>
      </form>

      <p class="text-center text-gray-500 mt-6">
        {{ useTrans('register.haveAccount') }} 
        <Link href="/login" class="text-blue-500 font-semibold hover:underline">
          {{ useTrans('register.signIn') }}
        </Link>
      </p>
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
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const errors = ref({});

const register = () => {
  form.post('/register', {
    onError: (err) => {
      errors.value = err;
    },
  });
};
</script>
