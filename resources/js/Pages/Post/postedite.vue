<script setup>
import { useForm, usePage, Link, router } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';
import InputError from '../../Components/InputError.vue';
import UserLayout from '../../Layouts/UserLayout.vue';

const props = usePage().props
const user = reactive(props.auth.user);
const postDetail = reactive(props.postDetail)

const newUploadedImagesToPreview = ref([])
const fileInput = ref(null)

function handleNewImageUpload(event) {
    const newFiles = event.target.files
    if (newFiles) {
        const newFilesArray = Array.from(newFiles)
        form.new_images_to_add.push(...newFilesArray);

        // Making url and push to preview array
        const newFileUrls = newFilesArray.map(image => URL.createObjectURL(image))
        newUploadedImagesToPreview.value.push(...newFileUrls)

        // Clearing Input File Cache To Reset It - so that i could take the same image again
        fileInput.value.value = null
    }
}

function handleRemoveNewlyAddedImages(index) {
    // Must Clear Before Clearing State 
    cleanupImageState(index)

    newUploadedImagesToPreview.value.splice(index, 1)
    form.new_images_to_add.splice(index, 1)
    
    // Clearing Input File Cache To Reset It - so that i could take the same image again
    fileInput.value.value = null
}



// Only For New Uploaded Image
function cleanupImageState(index) {
    // Make sure we only try to revoke if there's a valid URL at that index
    if (index >= 0 && index < newUploadedImagesToPreview.value.length) {
        const objectUrl = newUploadedImagesToPreview.value[index];
        if (objectUrl) {
            // Revoke the object URL to release memory
            URL.revokeObjectURL(objectUrl);
        }
    }
}

const existingImagesToPreview = ref(postDetail.post_images) // Array

function handleRemoveExistingImages(index) {
    const imgToRemove = existingImagesToPreview.value.at(index)
    existingImagesToPreview.value.splice(index, 1)
    form.remove_image_ids_from_post.push(imgToRemove.id)
}

const form = useForm({
    post_body: postDetail.post_body,
    new_images_to_add: [], // Sending as uploaded file object
    remove_image_ids_from_post: [] // Sending Ids
})

function handleSubmit() {
    console.log("Form data before submission:", form); // Debugging line
    form.submit('put', route('posts.update', postDetail.uuid), {
        onError: (errors) => {
            console.error("Submission errors:", errors);
        }
    });
    // console.log("Form data before submission:", form); // Debugging line
    // form.submit('put', route('posts.update', postDetail.uuid))
    // console.log("Form data before submission:", form); // Debugging line
}

</script>

<template>
    <UserLayout>
        <form @submit.prevent="handleSubmit" class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6 space-y-3">
            <!-- Create Post Card Top -->
            <div>
                <div class="flex items-start /space-x-3/">
                    <!-- User Avatar -->
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full object-cover" :src="user.profileImgUrl"
                            :alt="user.first_name" />
                    </div>
                    <!-- /User Avatar -->

                    <!-- Content -->
                    <div class="text-gray-700 font-normal w-full">
                        <textarea
                            class="block w-full p-2 pt-2 text-gray-900 rounded-lg border-none outline-none focus:ring-0 focus:ring-offset-0"
                            v-model="form.post_body" rows="2"
                            :placeholder="`What's going on, ${user.last_name} ?`"></textarea>
                    </div>
                </div>
                <!-- Existing Images (Preview) -->
                <div v-if="existingImagesToPreview.length" class="mt-5 grid gap-3"
                    :class="(existingImagesToPreview.length > 1) ? 'grid-cols-2' : 'grid-cols-1'">
                    <div v-for="(img,index) in existingImagesToPreview" :key="img.id" class="relative">
                        <img class="rounded-md" :src="img.url">
                        <svg @click="handleRemoveExistingImages(index)" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="size-6 absolute top-3 right-3 hover:stroke-red-500 cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <!-- New Uploaded Images (Preview) -->
                <div v-if="newUploadedImagesToPreview.length" class="mt-5 grid gap-3"
                    :class="(newUploadedImagesToPreview.length > 1) ? 'grid-cols-2' : 'grid-cols-1'">
                    <div v-for="(img, index) in newUploadedImagesToPreview" :key="index" class="relative">
                        <img class="rounded-md" :src="img">
                        <svg @click="handleRemoveNewlyAddedImages(index)" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="size-6 absolute top-3 right-3 hover:stroke-red-500 cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>

                <!-- Input Errors -->
                <InputError :field="form.errors.post_body" />
                <InputError :field="form.errors.new_images_to_add" />
            </div>

            <!-- Create Post Card Bottom -->
            <div>
                <!-- Card Bottom Action Buttons -->
                <div class="flex items-center justify-between">
                    <div class="flex gap-4 text-gray-600">
                        <!-- Upload Picture Button -->
                        <div>
                            <input type="file" ref="fileInput" @change="handleNewImageUpload" name="picture" multiple
                                id="picture" class="hidden" />
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
                        <!-- /Upload Picture Button -->

                        <!-- GIF Button -->
                        <!--                <button-->
                        <!--                  type="button"-->
                        <!--                  class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">-->
                        <!--                  <span class="sr-only">GIF</span>-->
                        <!--                  <svg-->
                        <!--                    xmlns="http://www.w3.org/2000/svg"-->
                        <!--                    fill="none"-->
                        <!--                    viewBox="0 0 24 24"-->
                        <!--                    stroke-width="1.5"-->
                        <!--                    stroke="currentColor"-->
                        <!--                    class="w-6 h-6">-->
                        <!--                    <path-->
                        <!--                      stroke-linecap="round"-->
                        <!--                      stroke-linejoin="round"-->
                        <!--                      d="M12.75 8.25v7.5m6-7.5h-3V12m0 0v3.75m0-3.75H18M9.75 9.348c-1.03-1.464-2.698-1.464-3.728 0-1.03 1.465-1.03 3.84 0 5.304 1.03 1.464 2.699 1.464 3.728 0V12h-1.5M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />-->
                        <!--                  </svg>-->
                        <!--                </button>-->
                        <!-- /GIF Button -->

                        <!-- Emoji Button -->
                        <!--                <button-->
                        <!--                  type="button"-->
                        <!--                  class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">-->
                        <!--                  <span class="sr-only">Emoji</span>-->
                        <!--                  <svg-->
                        <!--                    xmlns="http://www.w3.org/2000/svg"-->
                        <!--                    fill="none"-->
                        <!--                    viewBox="0 0 24 24"-->
                        <!--                    stroke-width="1.5"-->
                        <!--                    stroke="currentColor"-->
                        <!--                    class="w-6 h-6">-->
                        <!--                    <path-->
                        <!--                      stroke-linecap="round"-->
                        <!--                      stroke-linejoin="round"-->
                        <!--                      d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />-->
                        <!--                  </svg>-->
                        <!--                </button>-->
                        <!-- /Emoji Button -->
                    </div>

                    <div>
                        <!-- Post Button -->
                        <button type="submit"
                            class="-m-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white">
                            Post
                        </button>
                        <!-- /Post Button -->
                    </div>
                </div>
                <!-- /Card Bottom Action Buttons -->
            </div>
            <!-- /Create Post Card Bottom -->
        </form>
    </UserLayout>
</template>

<style scoped></style>
