<template>
    <div class="relative">
        <!-- Profile Image Button -->
        <button
            @click="toggleMenu"
            class="w-10 cursor-pointer h-10 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden focus:outline-none"
            ref="profileButton"
        >
            <img
                src="https://i.pravatar.cc/150?img=03"
                alt="Profile"
                class="w-full h-full object-cover"
            />
        </button>

        <!-- Dropdown Menu -->
        <div
            v-show="isMenuOpen"
            class="absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white divide-y divide-gray-100 z-50"
            ref="menuContainer"
        >
            <div class="px-4 py-3">
                <p class="text-gray-600 font-bold italic">{{ user.name }}</p>
            </div>

            <div class="py-1">
                <a
                    href="#"
                    class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100"
                >
                    <svg
                        class="w-5 h-5 mr-3 text-gray-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                        />
                    </svg>
                    Profile
                </a>
                <a
                    href="#"
                    class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100"
                >
                    <svg
                        class="w-5 h-5 mr-3 text-gray-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                        />
                    </svg>
                    Messages
                </a>
                <a
                    href="#"
                    class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100"
                >
                    <svg
                        class="w-5 h-5 mr-3 text-gray-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                    Pricing
                </a>
                <a
                    href="#"
                    class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100"
                >
                    <svg
                        class="w-5 h-5 mr-3 text-gray-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                    Help
                </a>
                <a
                    href="#"
                    class="flex items-center px-4 py-2 text-gray-600 hover:bg-gray-100"
                >
                    <svg
                        class="w-5 h-5 mr-3 text-gray-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                        />
                    </svg>
                    Lock screen
                </a>
            </div>

            <div class="px-4 py-2 cursor-pointer hover:bg-gray-100">
                <Link href="/logout" as="button" method="post" class="flex cursor-pointer">
                    <svg
                        class="w-5 h-5 mr-3 text-red-500"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                        />
                    </svg>
                    <span class="text-gray-600">Logout</span>
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { ref, onMounted, onBeforeUnmount } from "vue";

const isMenuOpen = ref(false);
const profileButton = ref(null);
const menuContainer = ref(null);

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};

const handleClickOutside = (event) => {
    if (
        menuContainer.value &&
        !menuContainer.value.contains(event.target) &&
        !profileButton.value.contains(event.target)
    ) {
        isMenuOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener("click", handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener("click", handleClickOutside);
});

const user = usePage().props.auth.user;
</script>
