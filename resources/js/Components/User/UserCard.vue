<script setup>
import { Link, router } from '@inertiajs/vue3';
import { reactive } from 'vue';

const props = defineProps({
    userData: {
            type: Object
        }
})

const userData = reactive(props.userData)

function toggleFriendRequest() {
    router.visit(route('friend.request.toggle', userData.user_name), {
        method: 'post',
        preserveScroll: true,
    })
}

function acceptFriendRequest() {
    router.visit(route('friend.request.accept', userData.sent_friend_request_data), {
        method: 'post',
        preserveScroll: true
    })
}
</script>

<template>
    <div class="w-full max-w-sm main-border rounded-lg dark1:bg-gray-800 dark1:border-gray-700">
        <div class="flex flex-col items-center py-5 px-4 space-y-3">
            <img class="w-24 h-24 rounded-full shadow-lg" :src="userData.profileImgUrl" :alt="userData.first_name" />
            <h5 class=" text-xl font-medium text-gray-900 dark1:text-white">{{ userData.first_name }} {{
                userData.last_name }}</h5>
            <span class="text-sm text-gray-500 text-center dark1:text-gray-400"> {{ userData.bio }}</span>
            <div class="flex">
                <!-- Confirm Friend Request -->
                <div v-if="!userData.is_my_friend">
                    <button @click.prevent="acceptFriendRequest"
                        v-if="userData.sent_friend_request_data && userData.sent_friend_request_data.status === 'Pending'"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-md hover:bg-blue-800  focus:outline-none  dark1:bg-blue-600 dark1:hover:bg-blue-700 ">
                        Confirm
                    </button>

                    <button v-else @click.prevent="toggleFriendRequest"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-md hover:bg-blue-800  focus:outline-none  dark1:bg-blue-600 dark1:hover:bg-blue-700 ">
                        {{ (userData.received_friend_request_data) ? userData.received_friend_request_data.status : 'Add Friend' }}
                    </button>
                </div>


                <Link :href="route('user.profile.show', userData.user_name)"
                    class="py-2 px-4 ms-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-md border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10   dark1:bg-gray-800 dark1:text-gray-400 dark1:border-gray-600 dark1:hover:text-white dark1:hover:bg-gray-700">
                Profile
                </Link>
            </div>
        </div>
        <!-- <pre class="text-xs">
            {{ userData }}
        </pre> -->
    </div>

</template>

<style scoped>

</style>