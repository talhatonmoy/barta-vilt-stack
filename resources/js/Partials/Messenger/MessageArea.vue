<script setup>
import ChatInputArea from './ChatInputArea.vue';
import { usePage, Link } from '@inertiajs/vue3';
import { useMessengerUserStore } from '../../Store/useMessengerUserStore';
import { useMessengerLeftFriendWithLatestMessageStore } from '../../Store/useMessengerLeftFriendWithLatestMessageStore';

const friendsWithLastConversationMessage = useMessengerLeftFriendWithLatestMessageStore();
const messengerStore = useMessengerUserStore()

const authUser = usePage().props.auth.user
// const props = defineProps({
//     messages: {
//         type: Array
//     }
// })

</script>

<template>
    <section class="flex flex-col flex-auto border-l border-gray-300">
        <div>
            <!-- Top Section -->
            <div class="chat-header px-5 py-3 flex flex-row flex-none justify-between items-center shadow">
                <div class="flex items-center">
                    <Link :href="route('user.profile.show', messengerStore.friendData.user_name)">
                        <div class="w-12 h-12 mr-4 relative flex flex-shrink-0">
                            <img class="shadow-md rounded-full w-full h-full object-cover"
                                :src="messengerStore.friendData.profileImgUrl" :alt="messengerStore.friendData.user_name" />
                        </div>
                    </Link>
                    <div class="text-sm">
                        <Link :href="route('user.profile.show', messengerStore.friendData.user_name)">
                        <p class="font-bold">{{ messengerStore.friendData.first_name }} {{
                            messengerStore.friendData.last_name }}</p>
                        </Link>
                        <p>Active 1h ago</p>
                    </div>
                </div>
            </div>

            <!-- Message Display Area -->
            <div class="p-4 overflow-y-auto space-y-5 flex flex-col-reverse " style="height: calc(100vh - 300px);">
                <!-- <pre>
                {{ lastMessage }}
            </pre>  -->
                <template v-if="messengerStore.messages.length">
                    <template v-for="(msg, index) in messengerStore.messages" :key="index">

                        <!-- Chat Bubble (Auth User) -->
                        <div class="flex items-start justify-end gap-2.5 mt-5" v-if="msg.sender_id === authUser.id">
                            <div
                                class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-l-xl rounded-br-xl dark1:bg-gray-700">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <span class="text-sm font-semibold text-gray-900 dark1:text-white">
                                        {{ authUser.first_name }} {{ authUser.last_name }}
                                    </span>
                                    <span class="text-xs font-normal text-gray-500 dark1:text-gray-400">{{
                                        msg.created_at
                                        }}</span>
                                </div>
                                <p class="text-sm font-normal py-2.5 text-gray-900 dark1:text-white">{{ msg.body }}</p>
                                <!-- <span class="text-sm font-normal text-gray-500 dark1:text-gray-400">Delivered</span> -->
                            </div>

                            <img class="w-8 h-8 rounded-full" :src="authUser.profileImgUrl" :alt="authUser.user_name">

                        </div>

                        <!-- Chat Bubble (Other User) -->
                        <div class="flex items-start gap-2.5 mt-5" v-else>
                            <img class="w-8 h-8 rounded-full" :src="messengerStore.friendData.profileImgUrl"
                                :alt="messengerStore.friendData.user_name">
                            <div
                                class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark1:bg-gray-700">
                                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                    <span class="text-sm font-semibold text-gray-900 dark1:text-white">{{
                                        messengerStore.friendData.first_name
                                        }} {{ messengerStore.friendData.last_name }}</span>
                                    <span class="text-xs font-normal text-gray-500 dark1:text-gray-400">{{
                                        msg.created_at
                                        }}</span>
                                </div>
                                <p class="text-sm font-normal py-2.5 text-gray-900 dark1:text-white">{{ msg.body }}</p>
                                <!-- <span v-if="msg.read_at" class="text-sm font-normal text-gray-500 dark1:text-gray-400">Seen {{ msg.read_at }}</span> -->
                            </div>
                        </div>
                    </template>
                    <button v-if="messengerStore.next" @click.prevent="messengerStore.loadPreviousMessages">Load
                        More</button>
                </template>


                <!-- for empty message -->
                <div class="mt-2 ml-3" v-else>
                    <p class="text-gray-700"><span class="font-medium text-neutral-800">Say hello and</span>
                        <br> Start conversation with
                        <span class="font-medium text-neutral-800">
                            {{ messengerStore.friendData.first_name }} {{
                            messengerStore.friendData.last_name }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Message Input Area -->
            <ChatInputArea v-on:gotNewMessage="messengerStore.storeMessage({ body: $event })" />
        </div>
    </section>
</template>

<style scoped></style>