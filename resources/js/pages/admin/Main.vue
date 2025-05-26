<template>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <main>
        <Sidebar />
        <div class="md:ml-64">
            <header class="w-full">
                <Dashboard_navbar />
            </header>

            <!-- info Message alert -->
             <div class="fixed flex w-full z-50 justify-center">
            <div
            v-if="$page.props.message"
                class="flex flex-col gap-2 w-60 sm:w-72 text-[10px] sm:text-xs z-50 md:mr-50"
            >
                <div
                    class="info-alert cursor-default flex items-center justify-between w-full h-12 sm:h-14 rounded-lg bg-[#232738] px-[10px]"
                >
                    <div class="flex gap-2">
                        <div
                            class="text-[#3498db] bg-white/5 backdrop-blur-xl p-1 rounded-lg"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white">Message</p>
                            <p class="text-gray-500">
                                {{ $page.props.message }}
                            </p>
                        </div>
                    </div>
                    <button
                    @click="$page.props.message = ''"
                        class="text-gray-600 hover:bg-white/5 p-1 rounded-md transition-colors ease-linear cursor-pointer"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18 18 6M6 6l12 12"
                            ></path>
                        </svg>
                    </button>
                </div>
            </div>
            </div>

            <!-- Danger alert -->
            <div class="fixed flex w-full z-50 justify-center">
            <div
                class="flex flex-col gap-2 w-60 sm:w-72 text-[10px] sm:text-xs z-50 md:mr-50"
                v-if="$page.props.error"
            >
                <div
                    class="danger-alert cursor-default flex items-center justify-between w-full h-12 sm:h-14 rounded-lg bg-[#2d2326] px-[10px]"
                >
                    <div class="flex gap-2">
                        <div
                            class="text-[#e74c3c] bg-white/5 backdrop-blur-xl p-1 rounded-lg"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"
                                ></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white">Error !</p>
                            <p class="text-gray-500">{{ $page.props.error }}</p>
                        </div>
                    </div>
                    <button
                    @click="$page.props.error = ''"
                        class="text-gray-600 hover:bg-white/5 p-1 rounded-md transition-colors ease-linear cursor-pointer"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18 18 6M6 6l12 12"
                            ></path>
                        </svg>
                    </button>
                </div>
            </div>
            </div>

            <!-- success alert -->
            <div class="fixed flex w-full z-50 justify-center">
                <div
                    v-if="$page.props.success"
                    class="flex flex-col gap-2 w-60 sm:w-72 text-[10px] sm:text-xs md:mr-50"
                >
                    <div
                        class="succsess-alert cursor-default flex items-center justify-between w-full h-12 sm:h-14 rounded-lg bg-[#232531] px-[10px]"
                    >
                        <div class="flex gap-2">
                            <div
                                class="text-[#2b9875] bg-white/5 backdrop-blur-xl p-1 rounded-lg"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m4.5 12.75 6 6 9-13.5"
                                    ></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white">done successfully :)</p>
                                <p class="text-gray-500">
                                    {{ $page.props.success }}
                                </p>
                            </div>
                        </div>
                        <button
                            @click="$page.props.success = ''"
                            class="text-gray-600 hover:bg-white/5 p-1 rounded-md transition-colors ease-linear cursor-pointer"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-6 h-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18 18 6M6 6l12 12"
                                ></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <slot />
            </div>
        </div>
    </main>
</template>

<script setup>
import Sidebar from "../layouts/Sidebar.vue";
import Dashboard_navbar from "../layouts/Dashboard_navbar.vue";
</script>
