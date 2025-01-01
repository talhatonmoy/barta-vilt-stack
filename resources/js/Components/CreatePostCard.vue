<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { reactive, defineProps, ref, watch } from 'vue';
import InputError from './InputError.vue';

// Accepting Props
const props = defineProps({
    rows: {
        type: String,
        required: false,
        default: '3'
    }
});

// Dynamic textarea row control
const textAreaRowControl = reactive({
    rows: props.rows,
    increaseRowNumber() {
        this.rows = 6;
    },
    resetRowNumber() {
        textAreaRowControl.rows = props.rows;
    }
});

// Getting User Data
const user = reactive(usePage().props.auth.user);

// Collecting Form Data
const form = useForm({
    post_body: "",
    post_images: [],
});

// Handling Form Submission
function handleSubmit() {
    form.submit('post', route('posts.store'), {
        onSuccess: () => {
            form.reset()
            previewImages.value = []
        }
    });
}

// Handling Preview Image
const previewImages = ref([]);

function handleChangePostImages(event) {
    const files = event.target.files;
    if (files) {
        const filesArray = Array.from(files); // Convert FileList to an array
        form.post_images.push(...filesArray)

        // Generate URLs for each file and concatenate with existing previewImages
        const newPreviewImages = filesArray.map(file => URL.createObjectURL(file));
        previewImages.value.push(...newPreviewImages); // Append new URLs to existing ones
    }
}

function removePreviewImage(index) {
    // Revoke the object URL to release memory
    URL.revokeObjectURL(previewImages.value[index]);

    // Remove the image at the specified index from previewImages
    previewImages.value.splice(index, 1);
    // To keep form.post_images in sync with previewImages
    form.post_images.splice(index, 1);
}
</script>

<template>
    <div>
        <form @submit.prevent="handleSubmit" @click="textAreaRowControl.increaseRowNumber"
            v-click-away="textAreaRowControl.resetRowNumber"
            class="bg-white border-[1px] border-neutral-300  rounded-lg mx-auto max-w-none px-4 py-5 sm:px-6 space-y-3">

            <div>
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full object-cover" :src="user.profileImgUrl"
                            :alt="user.first_name" />
                    </div>
                    <div class="text-gray-700 font-normal w-full">
                        <textarea
                            class="block w-full p-2 pt-2 text-gray-900 rounded-lg border-none outline-none focus:ring-0 transition-all"
                            v-model="form.post_body" :rows="textAreaRowControl.rows"
                            :placeholder="`What's going on, ${user.last_name}?`"></textarea>
                    </div>
                </div>

                <div class="mt-5 grid gap-3" :class="(previewImages.length > 1) ? 'grid-cols-2' : 'grid-cols-1'">
                    <div v-for="(img, index) in previewImages" :key="index" class="relative">
                        <img class="rounded-md" :src="img">
                        <svg @click="removePreviewImage(index)" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="size-6 absolute top-3 right-3 hover:stroke-red-500 cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <InputError :field="form.errors.post_body" />
                <!-- <InputError :field="form.errors.post_images" /> -->
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <div class="flex gap-4 text-gray-600">
                        <div>
                            <input type="file" @change="handleChangePostImages" name="picture" multiple id="picture"
                                class="hidden" />
                            <label for="picture"
                                class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800 cursor-pointer">
                                <span class="sr-only">Picture</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="-m-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white">
                            Post
                        </button>
                    </div>
                </div>
            </div>
        </form>
        
        <pre>
            {{ form }}
        </pre>
    </div>
</template>

<style scoped>
/* Add any scoped CSS here */
</style>
