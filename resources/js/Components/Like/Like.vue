<script setup>
/**
 * Required Dataset as modelData
 * Need eager load - withCount('likes') and with('likes.user')
 */
// {
//     "uuid": "715e252e-d2cd-44e7-a663-ef35ecffa79d",
//         "excerpt": "new post",
//             "last_modified_time": "3 days ago",
//                 "comments_count": 1,
//                     "likes_count": 1,
//                         "is_liked_by_current_user": false,
//                             "postImages": [
//                                 {
//                                     "file_name": "A-coaching-website-home-page-should-be-a-warm-welcome,-showcasing-your-passion-and-expertise.-.gif",
//                                     "url": "http://localhost:8000/storage/74/A-coaching-website-home-page-should-be-a-warm-welcome,-showcasing-your-passion-and-expertise.-.gif"
//                                 }
//                             ],
//                                 "user": {
//         "first_name": "Chaity",
//             "last_name": "Khandakar",
//                 "user_name": "chaity",
//                     "bio": null,
//                         "profileImgUrl": "http://localhost:8000/storage/73/Icon_White_Bg-(1).png"
//     },
//     "likes": [
//         {
//             "id": 46,
//             "user": {
//                 "first_name": "Arsalan",
//                 "last_name": "Islam",
//                 "user_name": "arsalan",
//                 "bio": "Helping businesses developing the custom solutions on ad hoc basis | Freelance Web Developer",
//                 "profileImgUrl": "http://localhost:8000/storage/70/dummy-customer.jpg"
//             }
//         }
//     ]
// }

import { router, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { reactive, ref } from 'vue';

const props = defineProps({
    modelData: {
        type: Object,
        required: true
    },
    likeActionRouteName: {
        type: String,
        required: true
    }
})

// Accepting Post Data
const modelObj = ref(props.modelData)

// Preparing Like data
const likeData = reactive({
    likes_count: modelObj.value.likes_count,
    is_liked_by_current_user: modelObj.value.is_liked_by_current_user,
    allLikes: modelObj.value.likes
})

// Like Mechanism initiation
async function likePost() {
    const response = await axios.post(`/posts/${modelObj.value.uuid}/like`);

    //Updating Post data
    likeData.likes_count = response.data.likes_count
    likeData.is_liked_by_current_user = response.data.is_liked_by_current_user
    likeData.allLikes = response.data.likes
}

// Likers Modal
const modal = reactive({
    open: false,
    handleChange() {
        this.open = !this.open
    },
    reset() {
        modal.open = false
    }
})

</script>

<template>
    <div class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">
        <span class="sr-only">Likes</span>
        <svg @click.prevent="likePost" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor"
            :class="(likeData.is_liked_by_current_user == true) ? 'fill-red-700 stroke-red-700' : ''"
            class="size-5 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
        </svg>
        <div v-if="likeData.likes_count > 0">
            <div class="flex flex-shrink-0 self-center">
                <div class="relative inline-block text-left">
                    <div>
                        <!-- Like Count -->
                        <button @click="modal.handleChange" v-click-away="modal.reset"
                            class=" cursor-pointer hover:underline">
                            <p>{{ likeData.likes_count }}</p>
                        </button>
                    </div>
                    <!-- Dropdown Modal -->
                    <div v-show="modal.open"
                        class="absolute px-0 z-10 mt-5 w-64 md:w-80 lg:w-96 origin-top-right  rounded-md bg-gray-50 shadow-xl transition-all ring-1 ring-black ring-opacity-5 focus:outline-none">
                        <ul class=" divide-y divide-gray-200">
                            <li class="py-5 px-2 sm:py-1.5 hover:bg-gray-100" v-for="like in likeData.allLikes" :key="like.id">
                                <div class="flex items-center gap-2">
                                    <div class="flex-shrink-0">
                                        <img class="w-9 h-9 rounded-full" :src="like.user.profileImgUrl"
                                            :alt="like.user.last_name">
                                    </div>
                                    <div class="flex-1 min-w-0 ">
                                        <Link :href="route('user.profile.show', like.user.user_name)">
                                        <p class="text-sm font-medium text-gray-900 truncate ">
                                            {{ like.user.first_name }} {{ like.user.last_name }}
                                        </p>
                                        </Link>
                                        <p class="text-[12px] text-gray-500 truncate ">
                                            {{ like.user.bio }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<style scoped></style>

