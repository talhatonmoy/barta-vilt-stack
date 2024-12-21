<script setup>
import MessengerLeft from '../../Partials/Messenger/MessengerLeft.vue';
import MessageArea from '../../Partials/Messenger/MessageArea.vue';
import { usePage } from '@inertiajs/vue3';
import { useMessengerUserStore } from '../../Store/useMessengerUserStore'
import { onBeforeMount, onUnmounted } from 'vue';
import { useMessengerLeftFriendWithLatestMessageStore } from '../../Store/useMessengerLeftFriendWithLatestMessageStore';
const { friendsWithLastConversationMessage, friendData } = usePage().props

const messengerStore = useMessengerUserStore()
const friendsWithLatestMessageStore = useMessengerLeftFriendWithLatestMessageStore()


onBeforeMount(() => {
    messengerStore.resetMessages()
    messengerStore.loadMessages(friendData)
    friendsWithLatestMessageStore.loadInitialData(friendsWithLastConversationMessage)

})

onUnmounted(() => {
    messengerStore.resetMessages()
})

</script>

<template>
    <div class="main-container mt-3 md:mt-8">
        <div class="w-full flex antialiased text-neutral-800 main-border bg-white overflow-hidden">
            <div class="flex-1 flex flex-col">
                <!-- <pre class="bg-red-50">
                    {{ friendsWithLastConversationMessage }}
                </pre> -->
                <main class="flex-grow flex flex-row min-h-0">
                    <!-- Left Section -->
                    <MessengerLeft :friends="friendsWithLastConversationMessage" />
                    
                    <!-- Message Area -->
                    <MessageArea :messages="messengerStore.messages" />

                </main>
            </div>
        </div>
    </div>
</template>

<style scoped>

/* can be configured in tailwind.config.js */
/* .group:hover .group-hover\:block {
    display: block;
} */

/* .hover\:w-64:hover {
    width: 45%;
} */


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