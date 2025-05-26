<script setup>
import { Link, router } from "@inertiajs/vue3";
import Main from "../Main.vue";
import ConfirmModal from "../../layouts/ConfirmModal.vue";

defineOptions({
    layout: Main, // Assign layout dynamically
});

defineProps({
    products: Array,
});

// Method to get the primary image
function getPrimaryImage(images) {
    return images.find((image) => image.is_primary === 1); // Assuming is_primary is 1 for primary images
}

const showProduct = (slug) =>
{
    router.visit(`/admin/products/${slug}`);
}

</script>

<template>
    <div class="bg-gray-100 p-6">
        <!-- ModalConfirm Component -->
    <ConfirmModal
      v-if="showModal"
      :message="'Are you sure you want to delete this product?'"
      @confirm="deleteProduct"
      @cancel="closeDeleteModal"
    />
        <div class="bg-white rounded-md shadow-sm p-6 max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-xl font-medium text-gray-700">
                    All Product List
                </h1>
                <div class="flex gap-2">
                    <Link :href="`products/create`"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md"
                    >
                        Add Product
                    </Link>
                    <div class="relative">
                        <select
                            class="appearance-none border border-gray-300 rounded-md px-4 py-2 pr-8 text-gray-600 bg-white"
                        >
                            <option>This Month</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700"
                        >
                            <svg
                                class="fill-current h-4 w-4"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="py-3 px-4 text-left w-8">
                                <input
                                    type="checkbox"
                                    class="rounded border-gray-300"
                                />
                            </th>
                            <th
                                class="py-3 px-4 text-left font-medium text-gray-600"
                            >
                                Product Name & Size
                            </th>
                            <th
                                class="py-3 px-4 text-left font-medium text-gray-600"
                            >
                                Price
                            </th>
                            <th
                                class="py-3 px-4 text-left font-medium text-gray-600"
                            >
                                Stock
                            </th>
                            <th
                                class="py-3 px-4 text-left font-medium text-gray-600"
                            >
                                Category
                            </th>
                            <th
                                class="py-3 px-4 text-left font-medium text-gray-600"
                            >
                                Rating
                            </th>
                            <th
                                class="py-3 px-4 text-left font-medium text-gray-600"
                            >
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="border-b border-gray-200 hover:bg-gray-50"
                            v-for="(product, i) in products"
                            :key="i"
                        >
                            <td class="flex py-4 px-4">
                                <span
                                    class="px-1 mt-3 border-r mr-4 font-bold"
                                    >{{ i + 1 }}</span
                                >
                                <input
                                    type="checkbox"
                                    class="rounded border-gray-300 mt-3"
                                />
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-14 h-14 bg-gray-200 rounded-md flex justify-center items-center mr-3"
                                    >
                                        <img
                                            v-if="
                                                getPrimaryImage(product.images)
                                            "
                                            :src="
                                                getPrimaryImage(product.images)
                                                    .path
                                            "
                                            alt="Primary Image"
                                            class="w-16 h-16 object-cover"
                                        />
                                        <svg
                                            v-else
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-10 w-10 text-gray-500"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-700 cursor-pointer hover:underline" @click="showProduct(product.slug)">
                                            {{ product.name }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            <span class="underline"
                                                >Sizes:</span
                                            >
                                            <span
                                                v-for="(
                                                    size, iSize
                                                ) in product.sizes"
                                                :key="iSize"
                                            >
                                                <span v-if="iSize !== 0"
                                                    >,
                                                </span>
                                                {{ size.name }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-gray-700">
                                ${{ product.price }}
                            </td>
                            <td class="py-4 px-4">
                                <div>
                                    <p class="text-gray-700">
                                        {{ product.stock }} Item
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        old stock: {{ product.stock }}
                                    </p>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-gray-700">
                                {{
                                    product.category
                                        ? product.category.name
                                        : "No Category"
                                }}
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-yellow-400"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                        />
                                    </svg>
                                    <span class="ml-1 text-gray-700">4.5</span>
                                    <span class="ml-2 text-gray-500"
                                        >55 Review</span
                                    >
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex space-x-2">
                                    <Link class="mt-2" :href="`products/${product.id}/edit`">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-green-500"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                            />
                                        </svg>
                                    </Link>

                                    <ConfirmModal :message="'Are you sure you want to delete this order'" :route="`/admin/products/${product.id}`" />
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
