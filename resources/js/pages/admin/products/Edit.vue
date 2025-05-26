<script setup>
import Main from "../Main.vue";
import Upload_File from "../../layouts/Upload_File.vue";
import { reactive, ref, onMounted } from "vue";
import TagInput from "../../layouts/TagInput.vue";
import { router } from "@inertiajs/vue3";

defineOptions({
    layout: Main, // Assign layout dynamically
});

const props = defineProps({
    product: Object, // The product to edit
    categories: Object,
    tags: Object,
    sizes: Object,
    colors: Object,
    errors: Object,
});

const hasImageErrors = (errors) => {
    const err = Object.keys(errors).find(key => key.startsWith('images'))
    return err ? props.errors[err] : ''
};

const form = reactive({
    images: null,
    name: "",
    category_id: "",
    brand: "",
    weight: "",
    gender: "male",
    sizes: [],
    colors: [],
    description: "",
    tag_number: "",
    stock: null,
    tags: [],
    price: null,
    discount: null,
    tax: null,
});

// Fill the form with product data when component mounts
onMounted(() => {
    if (props.product) {
        form.name = props.product.name || "";
        form.category_id = props.product.category_id || "";
        form.brand = props.product.brand || "";
        form.weight = props.product.weight || "";
        form.gender = props.product.gender || "male";
        form.sizes = props.product.sizes?.map(size => size.id) || [];
        form.colors = props.product.colors?.map(color => color.id) || [];
        form.description = props.product.description || "";
        form.tag_number = props.product.tag_number || "";
        form.stock = props.product.stock || null;
        form.tags = props.product.tags?.map(tag => tag.id) || [];
        form.price = props.product.price || null;
        form.discount = props.product.discount || null;
        form.tax = props.product.tax || null;
    }
});

const updateProduct = () => {
    router
        .put(`/admin/products/${props.product.id}`, form)
        .then(() => {
            alert("Product updated successfully!");
        })
        .catch((err) => {
            console.error("Error updating product:", err);
        });
};
</script>

<template>
    <div class="bg-gray-50">
        <form
            class="container mx-auto px-4 py-6 max-w-5xl shadow-md"
            @submit.prevent="updateProduct"
        >
            <!-- upload image form -->
            <div v-if="props.product.images.length > 0" class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div v-for="(file, index) in props.product.images" :key="index" class="relative rounded-lg shadow-sm overflow-hidden group" :class="{'border-4 border-blue-500': file.is_primary, 'border-2 border-gray-300': !file.is_primary}">
                <div class="h-40 bg-gray-100 overflow-hidden">
                    <img :src="file.path" class="h-full w-full object-cover" :alt="file.name" />
                </div>
            </div>
        </div>

            <!-- Product Name and Categories -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6 mt-4">
                <div>
                    <label
                        class="block text-sm font-medium text-gray-700 mb-1"
                        for="name"
                        >Product Name <span class="text-red-500">*</span></label
                    >
                    <input
                        id="name"
                        type="text"
                        placeholder="Ex: Men Black Slim Fit T-shirt"
                        v-model="form.name"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        :class="
                            errors.name ? 'border-red-500 focus:ring-white' : ''
                        "
                        required
                    />
                    <span v-if="errors.name" class="text-red-500 text-sm">{{
                        errors.name
                    }}</span>
                </div>
                <div>
                    <label
                        class="block text-sm font-medium text-gray-700 mb-1"
                        for="category"
                        >Product Categories <span class="text-red-500">*</span></label
                    >
                    <div class="relative">
                        <select
                            v-model="form.category_id"
                            id="category"
                            class="appearance-none w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500"
                            :class="
                                errors.category_id
                                    ? 'border-red-500 focus:ring-white'
                                    : ''
                            "
                            required
                        >
                            <option value="" disabled selected>Select a category</option>
                            <option
                                v-for="category in props.categories"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.name }}
                            </option>
                        </select>
                        <span
                            v-if="errors.category_id"
                            class="text-red-500 text-sm"
                            >{{ errors.category_id }}</span
                        >
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

            <!-- Brand, Weight, and Gender -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Brand <span class="text-red-500">*</span></label
                    >
                    <input
                        v-model="form.brand"
                        type="text"
                        placeholder="Ex: Larkon Fashion"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        :class="
                            errors.brand
                                ? 'border-red-500 focus:ring-white'
                                : ''
                        "
                        required
                    />
                    <span v-if="errors.brand" class="text-red-500 text-sm">{{
                        errors.brand
                    }}</span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Weight <span class="text-red-500">*</span></label
                    >
                    <input
                        v-model="form.weight"
                        type="number"
                        placeholder="type: g"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        :class="
                            errors.weight
                                ? 'border-red-500 focus:ring-white'
                                : ''
                        "
                        required
                        min="1"
                    />
                    <span v-if="errors.weight" class="text-red-500 text-sm">{{
                        errors.weight
                    }}</span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Gender <span class="text-red-500">*</span></label
                    >
                    <div class="relative">
                        <select
                            v-model="form.gender"
                            class="appearance-none w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500"
                            :class="
                                errors.gender
                                    ? 'border-red-500 focus:ring-white'
                                    : ''
                            "
                            required
                        >
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <span
                            v-if="errors.gender"
                            class="text-red-500 text-sm"
                            >{{ errors.gender }}</span
                        >
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

            <div class="flex justify-start lg:w-2xl">
                <!-- Size Selection -->
                <div class="mb-6 mr-12">
                    <label class="block text-sm font-medium text-gray-900 mb-2"
                        >Select Size <span class="text-red-500">*</span></label
                    >
                    <div class="flex flex-wrap gap-3" aria-required="true">
                        <label
                            v-for="size in props.sizes"
                            :key="size.id"
                            class="h-12 w-12 rounded-lg bg-gray-100 text-sm flex items-center justify-center font-medium cursor-pointer transition-all border-2 border-transparent hover:border-gray-400"
                            :class="{
                                'bg-gray-800 text-white border-gray-600':
                                    form.sizes.includes(size.id),
                            }"
                        >
                            <input
                                type="checkbox"
                                class="hidden"
                                :value="size.id"
                                v-model="form.sizes"
                            />
                            {{ size.name }}
                        </label>
                    </div>
                    <span
                        v-if="errors.sizes && errors.sizes.length > 0"
                        class="text-red-500 text-sm"
                    >
                        {{ errors.sizes }}
                    </span>
                </div>

                <!-- Color Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-900 mb-2"
                        >Select Color <span class="text-red-500">*</span></label
                    >

                    <div class="flex flex-wrap gap-3" aria-required="true">
                        <div
                            class="p-3 bg-gray-200 rounded-lg"
                            v-for="color in props.colors"
                            :key="color.id"
                            :class="[
                                {
                                    'bg-gray-300 shadow-lg':
                                        form.colors.includes(color.id),
                                },
                            ]"
                        >
                            <label
                                class="h-6 w-6 rounded-full flex items-center justify-center border-2 border-transparent cursor-pointer transition-all hover:border-gray-500 shadow-md"
                                :class="[
                                    color.class,
                                    {
                                        ' border-black shadow-lg scale-110 w-7 h-7':
                                            form.colors.includes(color.id),
                                    },
                                ]"
                            >
                            <input
                                    type="checkbox"
                                    class="hidden"
                                    :value="color.id"
                                    v-model="form.colors"
                                />
                            </label>
                        </div>
                    </div>
                    <span v-if="errors.color" class="text-red-500 text-sm">{{
                        errors.color
                    }}</span>
                </div>
            </div>

            <!-- Description section -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1"
                    >Description <span class="text-red-500">*</span></label
                >
                <textarea
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 h-32"
                    v-model="form.description"
                    :class="
                        errors.description
                            ? 'border-red-500 focus:ring-white'
                            : ''
                    "
                    required
                    minlength="20"
                >
                </textarea>
                <span v-if="errors.description" class="text-red-500 text-sm">{{
                    errors.description
                }}</span>
            </div>

            <!-- Tag Number, Stock, Tag -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Tag Number </label
                    >
                    <input
                        placeholder="REF!"
                        type="text"
                        v-model="form.tag_number"
                        :class="
                            errors.tag_number
                                ? 'border-red-500 focus:ring-white'
                                : ''
                        "
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500"
                    />
                    <span
                        v-if="errors.tag_number"
                        class="text-red-500 text-sm"
                        >{{ errors.tag_number }}</span
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Stock <span class="text-red-500">*</span></label
                    >
                    <input
                        placeholder="Quantity"
                        type="number"
                        v-model="form.stock"
                        :class="
                            errors.stock
                                ? 'border-red-500 focus:ring-white'
                                : ''
                        "
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        required
                        min="1"
                    />
                    <span v-if="errors.stock" class="text-red-500 text-sm">{{
                        errors.stock
                    }}</span>
                </div>

                <div>
                    <TagInput
                        v-model="form.tags"
                        label="Tag"
                        :suggestions="props.tags"
                        :hasError="errors.tags ? true : false"
                        required
                    />
                    <span v-if="errors.tags" class="text-red-500 text-sm">{{
                        errors.tags
                    }}</span>
                </div>
            </div>

            <!-- Price details section -->
            <div>
                <!-- Pricing Details Header -->
                <div class="bg-white p-6 border-b">
                    <h2 class="text-xl font-medium text-gray-700">
                        Pricing Details
                    </h2>
                </div>

                <!-- Pricing Form -->
                <div class="bg-white p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Price Input -->
                        <div>
                            <label class="block text-gray-600 mb-2"
                                >Price <span class="text-red-500">*</span></label
                            >
                            <div
                                class="flex rounded-md overflow-hidden border border-gray-300"
                                :class="
                                    errors.price
                                        ? 'border-red-500 focus:ring-white'
                                        : ''
                                "
                            >
                                <div
                                    class="flex items-center justify-center bg-gray-100 px-4 border-r border-gray-300"
                                >
                                    <span class="text-gray-500 text-lg">$</span>
                                </div>
                                <input
                                    type="number"
                                    v-model="form.price"
                                    class="p-3 flex-1 focus:outline-none"
                                    placeholder="0.00"
                                    required
                                    min="0.01"
                                    step="0.01"
                                />
                            </div>
                            <span
                                v-if="errors.price"
                                class="text-red-500 text-sm"
                                >{{ errors.price }}</span
                            >
                        </div>

                        <!-- Discount Input -->
                        <div>
                            <label class="block text-gray-600 mb-2"
                                >Discount</label
                            >
                            <div
                                :class="
                                    errors.discount
                                        ? 'border-red-500 focus:ring-white'
                                        : ''
                                "
                                class="flex rounded-md overflow-hidden border border-gray-300"
                            >
                                <div
                                    class="flex items-center justify-center bg-gray-100 px-3 border-r border-gray-300"
                                >
                                    <svg
                                        class="w-5 h-5 text-gray-500"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                        ></path>
                                    </svg>
                                </div>
                                <input
                                    type="number"
                                    v-model="form.discount"
                                    class="p-3 flex-1 focus:outline-none"
                                    placeholder="0.00"
                                    min="0"
                                    step="0.01"
                                />
                                <span
                                    v-if="errors.discount"
                                    class="text-red-500 text-sm"
                                    >{{ errors.discount }}</span
                                >
                            </div>
                        </div>

                        <!-- Tax Input -->
                        <div>
                            <label class="block text-gray-600 mb-2">Tax</label>
                            <div
                                :class="
                                    errors.tax
                                        ? 'border-red-500 focus:ring-white'
                                        : ''
                                "
                                class="flex rounded-md overflow-hidden border border-gray-300"
                            >
                                <div
                                    class="flex items-center justify-center bg-gray-100 px-3 border-r border-gray-300"
                                >
                                    <svg
                                        class="w-5 h-5 text-gray-500"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                        ></path>
                                    </svg>
                                </div>
                                <input
                                    type="number"
                                    v-model="form.tax"
                                    class="p-3 flex-1 focus:outline-none"
                                    placeholder="0.00"
                                    min="0"
                                    step="0.01"
                                />
                                <span
                                    v-if="errors.tax"
                                    class="text-red-500 text-sm"
                                    >{{ errors.tax }}</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-gray-50 p-6 flex justify-end space-x-4">
                <button
                    type="button"
                    class="px-6 py-3 cursor-pointer rounded-lg border border-gray-300 bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors"
                    @click="$router.go(-1)"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="px-6 py-3 cursor-pointer rounded-lg border border-gray-300 bg-orange-500 text-white hover:bg-orange-400 transition-colors"
                >
                    Update Product
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped>
/* Add custom styles for the check mark */
</style>