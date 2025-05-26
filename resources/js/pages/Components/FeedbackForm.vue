<template>
  <div class="mt-4 mx-auto bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-500 transform hover:shadow-xl">
      <!-- Check if feedback exists for the order -->
      <div v-if="!order.feedback && !isSuccess" class="p-6 space-y-4">
        <div class="">
          <h3 class="text-xl font-bold text-right text-gray-800 mb-4">كيف كانت تجربتك؟</h3>
          
          <div class="mb-6">
            <label class="block mb-2 text-right text-gray-700 font-medium">التقييم من 1 إلى 5</label>
            <div class="flex justify-end space-x-2 space-x-reverse">
              <button 
                :disabled="isSuccess"
                v-for="star in 5" 
                :key="star" 
                @click="form.rating = star"
                class="transition-all duration-300 transform"
                :class="[form.rating >= star ? 'text-yellow-500 scale-110' : 'text-gray-300 hover:text-yellow-400']"
                type="button"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" :fill="form.rating >= star ? 'currentColor' : 'none'" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>
              </button>
            </div>
          </div>
          
          <div class="mb-6">
            <label class="block mb-2 text-right text-gray-700 font-medium">ملاحظاتك</label>
            <textarea
              v-model="form.comment"
              rows="3"
              class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 resize-none text-right"
              placeholder="شاركنا برأيك..."
            ></textarea>
          </div>
          
          <div class="flex justify-end">
            <button
              @click="submitFeedback"
              :disabled="!form.rating || isSubmitting || isSuccess"
              class="flex items-center gap-2 px-6 py-3 rounded-lg text-white font-medium transition-all duration-300 transform"
              :class="!form.rating || isSubmitting || isSuccess? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700 hover:scale-105'"
            >
              <span v-if="isSubmitting" class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
              <span v-else-if="isSuccess" class="w-5 h-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                  <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
              </span>
              <span v-else class="w-5 h-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="22" y1="2" x2="11" y2="13"></line>
                  <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
              </span>
              {{ isSuccess ? 'تم الإرسال' : 'إرسال التقييم' }}
            </button>
          </div>
        </div>
      </div>
    
      <!-- If feedback already exists -->
      <div v-else class="p-6 bg-green-50 border-l-4 border-green-500">
        <div class="flex items-center justify-end gap-3 text-green-700 animate-bounce">
          <p class="font-medium text-lg">تم تقييم هذا الطلب مسبقاً. شكرًا لملاحظاتك!</p>
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
            <polyline points="22 4 12 14.01 9 11.01"></polyline>
          </svg>
        </div>
      </div>
    </div>
    
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { router } from '@inertiajs/vue3'
  
  const props = defineProps({
    order: {
      type: Object,
      required: true
    }
  })
  
  const form = ref({
    rating: 0,
    comment: ''
  })
  
  const isSubmitting = ref(false)
  const isSuccess = ref(false)
  
  const submitFeedback = async () => {
    try {
      isSubmitting.value = true
      
      // Send data to Laravel backend
      router.post('/feedback', {
        order_id: props.order.id,
        customer_name: props.order.full_name ?? null,
        rating: form.value.rating,
        comment: form.value.comment,
      }, { 
        preserveState: true,
        onFinish: ()=>{
            form.value.rating = 0
            form.value.comment = ''
            isSuccess.value = true
        }
       })
      
       
    } catch (error) {
      console.error('Error submitting feedback:', error)
    } finally {
      isSubmitting.value = false
    }
  }
  </script>
  
  <style scoped>

  </style>