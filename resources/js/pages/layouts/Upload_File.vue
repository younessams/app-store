<template>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2 ml-1">Product images</label>

        <!-- Dropzone Area -->
        <div
            class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors"
            ref="dropzoneElement"
        >
            <input
                name="file"
                type="file"
                multiple
                class="hidden"
                ref="fileInput"
                accept="image/*"
                @change="handleFiles"
            />
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path class="text-orange-500" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                />
            </svg>
            <h3 class="text-lg font-medium text-gray-700 mt-2">Drop files here or click to upload.</h3>
            <span class="text-sm text-orange-500">(Max {{ props.maxFiles }} images, first two recommended)</span>
        </div>

        <!-- Image Previews -->
        <div v-if="files.length > 0" class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div v-for="(file, index) in files" :key="index" class="relative rounded-lg shadow-sm overflow-hidden group" :class="{'border-4 border-blue-500': file.is_primary, 'border-2 border-gray-300': !file.is_primary}">
                <div class="h-40 bg-gray-100 overflow-hidden">
                    <img :src="file.preview" class="h-full w-full object-cover" :alt="file.name" />
                </div>
                <div class="p-2">
                    <h5 class="text-sm font-medium text-gray-800 truncate">{{ file.name }}</h5>
                    <p class="text-xs text-gray-500">{{ formatFileSize(file.size * 1024) }}</p>
                </div>
                <div class="absolute top-2 right-2 flex space-x-2">
                    <span @click="setPrimaryImage(index)" class="bg-blue-500 hover:bg-blue-600 cursor-pointer text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity" title="Set as primary image">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2l3.09 6.26 6.91 1-5 4.87 1.18 6.87L12 17.77l-6.18 3.23L7 14.13l-5-4.87 6.91-1L12 2z" />
                        </svg>
                    </span>
                    <span @click="removeFile(index)" class="bg-red-600 hover:bg-red-700 cursor-pointer text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity" title="Remove image">
                        <!-- SVG icon for removing image -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>

        <span v-if="error" class="text-red-500 text-sm">{{ error }}</span>
    </div>
</template>

<script setup>
import { ref, watch, onMounted, onBeforeUnmount } from "vue";

const props = defineProps({
    maxFiles: {
        type: Number,
        default: 5
    },
    modelValue: {
        type: Array,
        default: () => []
    },
});

const emit = defineEmits(['update:modelValue', 'remove-image']);

// const getImageUrl = (path) => `/storage/images/${path}`;


const dropzoneElement = ref(null);
const fileInput = ref(null);
const files = ref([]);
const error = ref('');

const formatFileSize = (bytes) => {
    if (bytes === 0) return "0 B";
    
    const sizes = ['B', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(1024));
    
    return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
};

const handleFiles = (event) => {
    const selectedFiles = event.type === "drop" ? event.dataTransfer.files : event.target.files;
    const remainingSlots = props.maxFiles - files.value.length;
    
    if (remainingSlots <= 0) {
        error.value = `Maximum ${props.maxFiles} files allowed.`;
        return;
    }
    
    const filesToAdd = Array.from(selectedFiles).slice(0, remainingSlots);

    filesToAdd.forEach((file) => {
        if (!file.type.startsWith('image/')) {
            error.value = "Only image files are allowed.";
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            files.value.push({
                name: file.name,
                size: Math.round(file.size / 1024),
                type: file.type,
                preview: e.target.result,
                file: file,
                is_primary: files.value.length === 0
            });
            error.value = '';
        };
        reader.readAsDataURL(file);
    });

    if (event.target === fileInput.value) event.target.value = "";
};

const removeFile = (index) => {
    const wasPrimary = files.value[index].is_primary;
    files.value.splice(index, 1);
    
    // If we removed the primary image and there are other images, set the first one as primary
    if (wasPrimary && files.value.length > 0) {
        files.value[0].is_primary = true;
    }
};

const setPrimaryImage = (index, type = 'new') => {
    if (type === 'new') {
        files.value.forEach(file => file.is_primary = false);
        files.value[index].is_primary = true;
    } else if (type === 'existing') {
        // Handle setting existing image as primary
        // This would require additional props to manage existing images
    }
};

// Set up drag and drop event handlers
const setupDragAndDrop = () => {
    if (!dropzoneElement.value) return;
    
    const preventDefaults = (e) => {
        e.preventDefault();
        e.stopPropagation();
    };
    
    const highlight = () => {
        dropzoneElement.value.classList.add('border-orange-500');
        dropzoneElement.value.classList.remove('border-gray-300');
    };
    
    const unhighlight = () => {
        dropzoneElement.value.classList.add('border-gray-300');
        dropzoneElement.value.classList.remove('border-orange-500');
    };
    
    const handleDrop = (e) => {
        preventDefaults(e);
        unhighlight();
        handleFiles(e);
    };
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzoneElement.value.addEventListener(eventName, preventDefaults, false);
    });
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzoneElement.value.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropzoneElement.value.addEventListener(eventName, unhighlight, false);
    });
    
    dropzoneElement.value.addEventListener('drop', handleDrop, false);
};

// Initialize component with any provided model value
const initializeFiles = () => {
    if (props.modelValue && props.modelValue.length > 0) {
        files.value = [...props.modelValue];
    }
};

watch(files, (newFiles) => {
    emit('update:modelValue', newFiles.map(file => ({ 
        ...file, 
        // Don't include the preview in the emitted value to avoid large data transfers
        preview: undefined 
    })));
}, { deep: true });

onMounted(() => {
    dropzoneElement.value.addEventListener("click", () => fileInput.value.click());
    setupDragAndDrop();
    initializeFiles();
});

onBeforeUnmount(() => {
    if (!dropzoneElement.value) return;
    
    dropzoneElement.value.removeEventListener("click", () => {});
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzoneElement.value.removeEventListener(eventName, () => {});
    });
});
</script>