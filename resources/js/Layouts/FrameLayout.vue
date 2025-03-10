<script setup>
import Footer from '../Partials/Footer.vue';
import Navigation from '../Partials/Navigation.vue';

import { useMessengerUserStore } from '../Store/useMessengerUserStore';
import { useMessengerLeftFriendWithLatestMessageStore } from '../Store/useMessengerLeftFriendWithLatestMessageStore';
import { usePage } from '@inertiajs/vue3';

const authUser = usePage().props.auth.user
const messengerStore = useMessengerUserStore()
const friendsWithLatestMessageStore = useMessengerLeftFriendWithLatestMessageStore()


// Listening broadcasted message
Echo.private(`messenger.${authUser.id}`)
    .listen('NewMessageCreated', (event) => {
        messengerStore.appendNewMessageToCurrentState(event)
        friendsWithLatestMessageStore.updateTheFriendWithLatestOnMessageReceiverEnd(event)
    })

// Listenting for notification
Echo.private('App.Models.User.' + authUser.id)
    .notification((notification) => {
        console.log(notification);
    });
</script>


<template>

    <body class="bg-gray-100">
        <header class=" sticky top-0 z-50">
            <!-- Navigation -->
            <Navigation />
        </header>

        <slot>

        </slot>


        <!-- Footer -->
        <Footer />
    </body>

</template>
