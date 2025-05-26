<template>
    <div
        v-if="show"
        class="fixed inset-0 z-50 flex items-center justify-center"
    >
        <!-- Backdrop with animation -->
        <div
            class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity duration-300"
            :class="show ? 'opacity-100' : 'opacity-0'"
            @click="onClose"
        ></div>

        <!-- Modal with animation -->
        <div
            class="relative bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 ease-out"
            :class="show ? 'scale-100 opacity-100' : 'scale-95 opacity-0'"
        >
            <!-- Header -->
            <div
                class="flex justify-between items-center p-5 border-b border-gray-100"
            >
                <h2 class="text-xl font-bold text-gray-800">
                    {{ useTrans('wishlist-modal-component.title') }}
                </h2>
                <button
                    @click="onClose"
                    class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="18"
                        height="18"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="text-gray-500"
                    >
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="p-5 max-h-[70vh] overflow-y-auto">
                <!-- Loading state -->
                <div
                    v-if="loading"
                    class="py-10 flex flex-col items-center justify-center text-gray-500"
                >
                    <svg
                        class="animate-spin h-8 w-8 mb-3"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        ></path>
                    </svg>
                    <p>{{ useTrans('wishlist-modal-component.loading') }}</p>
                </div>

                <!-- Items list -->
                <ul
                    v-else-if="wishlists.length"
                    class="divide-y divide-gray-100"
                >
                    <li
                        v-for="item in wishlists"
                        :key="item.id"
                        class="py-4 first:pt-0 last:pb-0 flex gap-4 items-center group"
                    >
                        <!-- Product image with shadow and hover effect -->
                        <div
                            class="relative w-20 h-20 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100 group-hover:shadow-md transition-all duration-200"
                        >
                            <img
                                :src="item.product.images[0]?.url"
                                :alt="item.product.name"
                                class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-200"
                            />
                        </div>

                        <!-- Product details -->
                        <div class="flex-1 min-w-0">
                            <h3
                                class="text-sm font-medium text-gray-800 truncate"
                            >
                                {{ item.product.name }}
                            </h3>
                            <p
                                v-if="item.product.price"
                                class="mt-1 text-sm font-semibold text-indigo-600"
                            >
                                {{ formatPrice(item.product.price) }}
                            </p>
                        </div>

                        <!-- Action buttons -->
                        <div class="flex items-center gap-2">
                            <button
                                @click="moveToCart(item), onClose"
                                class="p-2 text-gray-500 hover:text-indigo-600 transition-colors"
                                :title="useTrans('wishlist-modal-component.add_to_cart')"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path
                                        d="M9 20a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"
                                    ></path>
                                    <path
                                        d="M20 20a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"
                                    ></path>
                                    <path
                                        d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"
                                    ></path>
                                </svg>
                            </button>
                            <button
                                @click="removeItem(item.id)"
                                class="p-2 text-gray-500 hover:text-red-500 transition-colors"
                                :title="useTrans('wishlist-modal-component.remove_from_wishlist')"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M3 6h18"></path>
                                    <path
                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"
                                    ></path>
                                    <path
                                        d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
                                    ></path>
                                </svg>
                            </button>
                        </div>
                    </li>
                </ul>

                <!-- Empty state -->
                <div
                    v-else
                    class="py-10 flex flex-col items-center justify-center text-center"
                >
                    <div class="rounded-full bg-gray-100 p-4 mb-4">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="text-gray-400"
                        >
                            <path
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
                            ></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-800">
                        {{ useTrans('wishlist-modal-component.empty_title') }}
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        {{ useTrans('wishlist-modal-component.empty_description') }}
                    </p>
                    <Link
                        href="/products"
                        @click="onClose"
                        class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors"
                    >
                        {{ useTrans('wishlist-modal-component.continue_shopping') }}
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, router } from "@inertiajs/vue3";
import axios from "axios";
import { getGuestToken } from "../../utils/guestToken";
import { useTrans } from "../../composables/trans";

defineProps({
    show: Boolean,
    wishlists: {
        type: Array,
        default: () => [],
    },
    loading: Boolean,
});

const emit = defineEmits(["close", "update:wishlists", "moveToCart"]);

const onClose = () => {
    emit("close");
};

const moveToCart = (item) => {
    router.get(
        `/products/product/${item.product.slug}`,
        {},
        {
        onFinish: () => {
            onClose();
        },
        }
    );
};

const removeItem = async (item_id) => {
    // console.log(item_id)
    try {
        await axios
            .delete(`/wishlist/${item_id}`, {
                data: {
                    item_id: item_id,
                    guest_token: getGuestToken(),
                },
            })
            .then((response) => {
                console.log(response);
            });

        const response = await axios.get("/wishlist/fetch", {
            params: {
                guest_token: getGuestToken(),
            },
        });

        // Emit to parent to update wishlist state
        emit("update:wishlists", response.data.wishlists);
    } catch (error) {
        console.error("Failed to remove wishlist item:", error);
    }
};

// Helper function to format price
const formatPrice = (price) => {
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    }).format(price);
};
</script>