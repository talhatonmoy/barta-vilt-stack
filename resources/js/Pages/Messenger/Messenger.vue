<script setup>
import { onBeforeMount, onUnmounted } from 'vue';
import MessengerLeft from '../../Partials/Messenger/MessengerLeft.vue';
import { usePage } from '@inertiajs/vue3';
import { useMessengerLeftFriendWithLatestMessageStore } from '../../Store/useMessengerLeftFriendWithLatestMessageStore';

const friendsWithLatestMessageStore = useMessengerLeftFriendWithLatestMessageStore()

const { friendListWithLatestMessage } = usePage().props

onBeforeMount(() => {
    friendsWithLatestMessageStore.loadInitialData(friendListWithLatestMessage)
})

// onUnmounted(() => {
//     friendsWithLatestMessageStore.reset()
// })

</script>

<template>
    <div class="main-container mt-3 md:mt-8">
        <div class="w-full flex antialiased text-neutral-800 main-border bg-white overflow-hidden">
            <div class="flex-1 flex flex-col">
                <!-- <pre>
                    {{ friendsWithLatestMessageStore }}
                </pre> -->
                <main class="flex-grow flex flex-row min-h-0">
                    <!-- Left Section -->
                    <MessengerLeft :friends="friendsWithLatestMessageStore.friends" />
                    <!-- Blank area -->
                    <div class="flex items-center justify-center bg-black/10 w-full"
                        style="height: calc(100vh - 300px);">
                        <h3 class="text-md px-5 text-center leading-6 text-gray-700 ">
                            Select or Search any of your friend form <span class="text-gray-800 font-medium italic">left
                                sidebar</span> and start conversation
                        </h3>
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

<style scoped>



/* NO NEED THIS CSS - just for custom scrollbar which can also be configured in tailwind.config.js*/
::-webkit-scrollbar {
    width: 2px;
    height: 2px;
}

::-webkit-scrollbar-button {
    width: 0px;
    height: 0px;
}

::-webkit-scrollbar-thumb {
    background: #2d3748;
    border: 0px none #ffffff;
    border-radius: 50px;
}

::-webkit-scrollbar-thumb:hover {
    background: #2b6cb0;
}

::-webkit-scrollbar-thumb:active {
    background: #000000;
}

::-webkit-scrollbar-track {
    background: #1a202c;
    border: 0px none #ffffff;
    border-radius: 50px;
}

::-webkit-scrollbar-track:hover {
    background: #666666;
}

::-webkit-scrollbar-track:active {
    background: #333333;
}

::-webkit-scrollbar-corner {
    background: transparent;
}
</style>