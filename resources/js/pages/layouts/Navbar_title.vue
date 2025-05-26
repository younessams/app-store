<template>
    <!-- Navbar Title -->
    <nav class="bg-white shadow-md pb-3 px-8">
            <h1 class="text-xl font-bold text-gray-800">
                {{ pageName }}
            </h1>
        </nav>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';

const routeName = usePage().props.routeName;
const reversedArray = routeName.split('.').reverse();
const pageName = reversedArray.toString().replace('.', ' ');

// const pageName = reversedArray.
</script>