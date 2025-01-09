<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import axios from 'axios';
const authUser = usePage().props.auth.user

let postDetail = usePage().props.postDetail

const editForm = useForm({
    post_body: (postDetail.post_body) ? postDetail.post_body : '',
    media: postDetail.media,
})

async function trashMedia(mediaId) {
    const mediaIndex = editForm.media.findIndex(item => item.id === mediaId)
    if (mediaIndex !== -1) {
        // First Delete The media
        const response = await axios.post(route('media.destroy', mediaId));
        // Then Remove From state
        editForm.media.splice(mediaIndex, 1);
    }
}

async function handleNewMedia(event) {
    const mediaFiles = Array.from(event.target.files)
    const formData = new FormData()

    // Append each file to the form data object
    mediaFiles.forEach(file => {
        formData.append('media[]', file)
    })

    try {
        const response = await axios.post(route('posts.mediaUpload', postDetail.uuid), formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        // Update the media in edit form
        editForm.media = response.data.postDetail.media

    } catch (error) {
        console.error('Error Uploading Media', error)
    }
}

function handleSubmit() {
    editForm.submit('put', route('posts.update', postDetail.uuid))
}

</script>

<template>
    <main class="container max-w-2xl mx-auto space-y-8 mt-8 px-2 md:px-0 min-h-screen">
        <!-- <pre class="text-xs">
            <p>Post Detail</p>
            {{ postDetail }}
            <hr>
            <p>Edit Post Form</p>
            {{ editForm }}
        </pre> -->
        <form @submit.prevent="handleSubmit" class="bg-white main-border shadow-sm mx-auto max-w-none px-4 py-5 sm:px-6 space-y-3">
            <!-- Create Post Card Top -->
            <div>
                <div class="flex items-start space-x-3">
                    <!-- User Avatar -->
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full object-cover" :src="authUser.profileImgUrl"
                            :alt="authUser.user_name" />
                    </div>
                    <!-- /User Avatar -->

                    <!-- Content -->
                    <div class="text-gray-700 font-normal w-full">
                        <textarea v-model="editForm.post_body"
                            class="block w-full p-2 pt-2 text-gray-900 rounded-lg border-none outline-none focus:ring-0 focus:ring-offset-0"
                            rows="2" placeholder="What's going on?"></textarea>
                    </div>
                </div>

                <!-- Existing Images (Preview) -->
                <template v-if="editForm.media">
                    <div class="mt-5 grid gap-3 grid-cols-1" :class="{'grid-cols-2' : editForm.media.length > 1}">
                        <div class="relative" v-for="img in editForm.media" :key="img.id">
                            <img class="rounded-md" :src="img.original_url" :alt="img.file_name" />
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                @click.prevent="trashMedia(img.id)" stroke="currentColor"
                                class="size-6 absolute top-3 right-3 hover:stroke-red-500 cursor-pointer">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                    </div>
                </template>


                <!-- Input Errors -->
                <!-- <div class="text-red-500 text-sm mt-2">Error message here</div> -->
            </div>

            <!-- Create Post Card Bottom -->
            <div>
                <!-- Card Bottom Action Buttons -->
                <div class="flex items-center justify-between">
                    <div class="flex text-gray-600">
                        <!-- Upload Picture Button -->
                        <div>
                            <input type="file" @change="handleNewMedia" id="picture" multiple class="hidden" />
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

                    <!-- Post Button -->
                    <button type="submit"
                        class="-m-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white">
                        Save
                    </button>
                </div>
                <!-- /Card Bottom Action Buttons -->
            </div>
            <!-- /Create Post Card Bottom -->
        </form>

    </main>


</template>

<style scoped>

</style>