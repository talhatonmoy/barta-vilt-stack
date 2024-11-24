<script setup>
import { useForm, usePage, router } from '@inertiajs/vue3';

const props = defineProps({
    postUuid: {
        type: String,
        Required: true
    }
 })

const user = usePage().props.auth.user
const form = useForm({
    comment_body: "",
    post_uuid: props.postUuid
})

function handleSubmit() {
    form.post(route('comments.store'), {
        onSuccess: () => {
            form.reset()
            // Navigate back to the single post page to fetch updated data
            router.visit(route('posts.show', props.postUuid), {
                preserveScroll: true
            });
        },
        preserveScroll: true
    })
}

</script>

<template>
    <form @submit.prevent="handleSubmit">
        <!-- Create Comment Card Top -->
        <div>
            <div class="flex items-start space-x-3">
                <!-- User Avatar -->
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full object-cover"
                        :src="user.profileImgUrl" alt="Ahmed Shamim" />
                </div>
                <!-- /User Avatar -->

                <!-- Auto Resizing Comment Box -->
                <div class="text-gray-700 font-normal w-full">
                    <textarea type="text" v-model="form.comment_body" placeholder="Write your comment..." class="flex w-full h-auto min-h-[40px] px-3 py-2 text-sm bg-gray-100 focus:bg-white border border-sm rounded-lg border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-1 focus:ring-offset-0 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50 text-gray-900"></textarea>
                </div>
            </div>
        </div>

        <!-- Create Comment Card Bottom -->
        <div>
            <!-- Card Bottom Action Buttons -->
            <div class="flex items-center justify-end">
                <button type="submit"
                    class="mt-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white">
                    Comment
                </button>
            </div>
            <!-- /Card Bottom Action Buttons -->
        </div>
        <!-- /Create Comment Card Bottom -->
    </form>
</template>

<style scoped>

</style>