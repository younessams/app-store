<template>
  <Link href="/">
       <svg class="w-50" viewBox="0 0 300 80" xmlns="http://www.w3.org/2000/svg">
           <!-- Background Elements -->
           <defs>
             <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
               <stop offset="0%" stop-color="#4F46E5" />
               <stop offset="100%" stop-color="#7C3AED" />
             </linearGradient>
           </defs>
           
           <!-- Logo Polygon (Hexagon) replacing circle -->
           <polygon points="40,8 68,24 68,56 40,72 12,56 12,24" fill="url(#logoGradient)" />
           
           <!-- Lightning Bolt Icon -->
           <path d="M44,18 L28,38 L38,38 L34,60 L52,38 L42,38 Z" 
                 fill="white" 
                 stroke="white" 
                 stroke-width="1" />
           
           <!-- Speed Lines -->
           <path d="M55,25 Q65,38 55,52" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" opacity="0.9" />
           <path d="M60,30 Q68,38 60,48" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round" opacity="0.7" />
           
           <!-- YouShop Text -->
           <text x="80" y="48" font-family="Arial, sans-serif" font-weight="700" font-size="32" fill="#1F2937">
             <tspan fill="#4F46E5">You</tspan><tspan fill="#7C3AED">Shoes</tspan>
           </text>
           
           <!-- Tagline -->
           <text x="83" y="65" font-family="Arial, sans-serif" font-weight="400" font-size="12" fill="#6B7280">
             Shop Smarter, Live Better
           </text>
       </svg>
     </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>