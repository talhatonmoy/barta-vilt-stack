<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, reactive, onMounted } from 'vue';
import PostLikeNotificationItem from '../../Components/Notifications/PostLikeNotificationItem.vue';
import FriendRequestSentNotificationItem from '../../Components/Notifications/FriendRequestSentNotificationItem.vue';
import NewCommentNotificationItem from '../../Components/Notifications/NewCommentNotificationItem.vue';
const user = usePage().props.auth.user

const latestNotifications = ref([]);

onMounted(async () => {
    fetchLastFewNotifications()
})

async function fetchLastFewNotifications() {
    const response = await axios.get(route('user.notifications.few'))
    latestNotifications.value = response.data
}


</script>

<template>
    <div
        class="bg-white border-[1px] border-neutral-300 overflow-hidden w-full max-w-sm divide-y divide-gray-100 rounded-lg  dark1:bg-gray-800 dark1:divide-gray-700">
        <div
            class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50 dark1:bg-gray-800 dark1:text-white">
            Notifications
        </div>

        <template v-if="latestNotifications.length === 0">
            <div class="p-4 text-sm text-center text-gray-500 dark1:text-gray-400">
                No new notifications
            </div>
        </template>

        <template v-else>
            <div class="divide-y divide-gray-100 dark1:divide-gray-700"
                v-for="(notification, index) in latestNotifications" :key="index">
                <!-- Displaying all unread notifications -->
                <!-- Post Like -->
                <PostLikeNotificationItem v-if="notification.data.type === 'postLike'" :notification="notification" />

                <!-- Friend Request Sent -->
                <FriendRequestSentNotificationItem v-if="notification.data.type === 'friendRequestSent'"
                    :notification="notification" />

                <!-- New Comment -->
                <NewCommentNotificationItem v-if="notification.data.type === 'newComment'"
                    :notification="notification" />
            </div>
        </template>
        <!-- Actions -->
        <div class="flex justify-between w-full rounded-lg">
            <Link :href="route('user.notifications')"
                class="block w-full py-2 border-r-2 border-r-gray-500 font-medium text-xs text-center text-white bg-gray-800 dark1:bg-gray-700 hover:underline">
            See all notifications
            </Link>
        </div>
    </div>
</template>

<style scoped></style>