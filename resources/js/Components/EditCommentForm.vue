<script setup>
import { useForm, router } from '@inertiajs/vue3';
import { defineProps, inject } from 'vue';
import InputError from './InputError.vue';

// Receiving comment mood state
const CommentMoodStore = inject('CommentMoodStore')

const props = defineProps({
    commentData: {
        type: Object,
        Required: true
    }
})

const form = useForm({
    comment_body: props.commentData.comment_body,
    uuid : props.commentData.uuid,
})

function handleSubmit() {
    form.put(route('comments.update', props.commentData.uuid), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset()
            CommentMoodStore.editing = false
            // Navigate back to the single post page to fetch updated data
            router.visit(route('posts.show', props.commentData.post_uuid), {
                preserveScroll: true
            });
        }
    })
}

</script>

<template>
    <form @submit.prevent="handleSubmit">
        <!-- Create Comment Card Top -->
        <div>
            <div class="flex items-start space-x-3 mt-4">
                <!-- Auto Resizing Comment Box -->
                <div class="text-gray-700 font-normal w-full">
                    <textarea type="text" v-model="form.comment_body" placeholder="Write a comment..."
                        class="flex w-full h-auto min-h-[40px] px-3 py-2 text-sm bg-gray-100 focus:bg-white border border-sm rounded-lg border-neutral-300 ring-offset-background placeholder:text-neutral-400 focus:border-neutral-300 focus:outline-none focus:ring-1 focus:ring-offset-0 focus:ring-neutral-400 disabled:cursor-not-allowed disabled:opacity-50 text-gray-900"></textarea>
                </div>
            </div>
            <InputError :field="form.errors.comment_body" />
        </div>

        <!-- Create Comment Card Bottom -->
        <div>
            <!-- Card Bottom Action Buttons -->
            <div class="flex items-center justify-end gap-2">
                <button @click.prevent="CommentMoodStore.reset"
                    class="mt-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-100 hover:bg-black hover:text-white text-back">
                    Cancel
                </button>

                <button type="submit"
                    class="mt-2 flex gap-2 text-xs items-center rounded-full px-4 py-2 font-semibold bg-gray-800 hover:bg-black text-white">
                    Save
                </button>
            </div>

            <!-- /Card Bottom Action Buttons -->
        </div>
        <!-- /Create Comment Card Bottom -->
    </form>
</template>

<style scoped>

</style>