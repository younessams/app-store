<template>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <main>
        <header class="w-full">
            <Navbar />
        </header>
        <div>
            <slot />
        </div>
    </main>
</template>

<script setup>
import Navbar from "./Components/Navbar.vue"
</script>
