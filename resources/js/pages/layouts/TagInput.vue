<template>
    <div class="w-full max-w-md -mt-3">
        <label class="block text-gray-600 mb-2">{{ label }}</label>
        <div class="relative">
            <div
                :class="hasError ? 'border-red-500 focus:ring-white' : ''"
                class="flex flex-wrap items-center gap-2 px-2 py-1 border rounded-md bg-white min-h-12 focus-within:ring-2 focus-within:ring-blue-300 focus-within:border-blue-500"
            >
                <!-- Selected Tags -->
                <div
                    v-for="(tag, index) in selectedTags"
                    :key="tag.id"
                    class="flex items-center bg-orange-500 text-white px-3 py-1 rounded-full"
                >
                    <span>{{ tag.name }}</span>
                    <button
                        @click="removeTag(index)"
                        class="ml-2 focus:outline-none cursor-pointer"
                        type="button"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>

                <!-- Input Field -->
                <input
                    ref="tagInput"
                    v-model="newTag"
                    @keydown.enter.prevent="addTag"
                    @keydown.tab.prevent="addTag"
                    @keydown.delete="handleDelete"
                    @keydown.down="showSuggestions = true"
                    @focus="showSuggestions = true"
                    @click="showSuggestions = true"
                    @blur="handleBlur"
                    type="text"
                    class="flex-grow outline-none min-w-20"
                    placeholder="Add a tag..."
                />
            </div>

            <!-- Suggestions Dropdown -->
            <div
                ref="suggestionsDropdown"
                v-if="showSuggestions && filteredSuggestions.length > 0"
                class="absolute left-0 right-0 mt-1 bg-white rounded-md shadow-md z-10"
            >
                <div
                    v-for="suggestion in filteredSuggestions"
                    :key="suggestion.id"
                    class="px-4 py-2 cursor-pointer hover:bg-gray-100"
                    @mousedown.prevent="selectSuggestion(suggestion)"
                >
                    {{ suggestion.name }}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits, ref, computed, onMounted, onUnmounted } from "vue";

const props = defineProps({
    modelValue: {
        type: Array, // Expecting an array of selected tag IDs
        default: () => [],
    },
    label: {
        type: String,
        default: "Tag",
    },
    suggestions: {
        type: Array, // Expecting an array of { id, name } objects
        default: () => [],
    },
    hasError: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["update:modelValue"]);

const newTag = ref("");
const showSuggestions = ref(false);
const tagInput = ref(null);
const suggestionsDropdown = ref(null);

const selectedTags = computed(() => {
    return props.modelValue
        .map((id) => props.suggestions.find((tag) => tag.id === id))
        .filter(Boolean);
});

const filteredSuggestions = computed(() => {
    const input = newTag.value.toLowerCase();
    return props.suggestions.filter(
        (tag) =>
            tag.name.toLowerCase().includes(input) &&
            !props.modelValue.includes(tag.id)
    );
});

function addTag() {
    const tagName = newTag.value.trim();
    if (!tagName) return;

    const foundTag = props.suggestions.find(
        (tag) => tag.name.toLowerCase() === tagName.toLowerCase()
    );

    if (foundTag && !props.modelValue.includes(foundTag.id)) {
        emit("update:modelValue", [...props.modelValue, foundTag.id]);
        newTag.value = "";
        showSuggestions.value = false;
    }
}

function removeTag(index) {
    const newTags = [...props.modelValue];
    newTags.splice(index, 1);
    emit("update:modelValue", newTags);
}

function handleDelete() {
    if (!newTag.value && props.modelValue.length > 0) {
        const newTags = [...props.modelValue];
        newTags.pop();
        emit("update:modelValue", newTags);
    }
}

function selectSuggestion(suggestion) {
    if (!props.modelValue.includes(suggestion.id)) {
        emit("update:modelValue", [...props.modelValue, suggestion.id]);
        newTag.value = "";
        showSuggestions.value = false;
    }
}

function handleBlur(event) {
    // Use a slight delay to allow for suggestion selection
    setTimeout(() => {
        // Check if the related target (clicked element) is within the dropdown
        if (
            !suggestionsDropdown.value?.contains(event.relatedTarget) &&
            !tagInput.value?.contains(event.relatedTarget)
        ) {
            showSuggestions.value = false;
        }
    }, 200);
}
</script>