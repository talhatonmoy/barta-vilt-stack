<script setup>
import { ref } from 'vue';
const emit = defineEmits()

const message = ref('');
const shift = ref(false);

function handleEnter() {
    if (shift.value ===  true && message.value.length) {
        message.value = message.value + '\n'
        return
    }

    if (message.value.length) {
        emit('gotNewMessage', message.value);
        message.value = ''
    }
}

</script>

<template>
    <div class="chat-footer flex-none">
        <div class="flex flex-row items-center p-4">
            <div class="relative flex-grow">
                <label class="flex gap-2 items-center ">
                    <textarea v-model="message" 
                        @keydown.enter.prevent="handleEnter" 
                        @keydown="shift = true"
                        @keyup="shift = false"
                        rows="1"
                        class="rounded-xl p-2  w-full text-neutral-800 border border-gray-300 focus:border-gray-300 bg-gray-100  focus:outline-none focus:shadow-md transition duration-100 ease-in"
                        type="text" value="" placeholder="Aa"></textarea>
                    <button type="button" class="" @click.prevent="handleEnter">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                        </svg>
                    </button>
                </label>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>