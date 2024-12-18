<script setup>
import Footer from '../Partials/Footer.vue';
import Navigation from '../Partials/Navigation.vue';

import { useMessengerUserStore } from '../Store/useMessengerUserStore';
import { usePage } from '@inertiajs/vue3';

const authUser = usePage().props.auth.user
const messengerStore = useMessengerUserStore()


// Listening broadcasted message
Echo.private(`messenger.${authUser.id}`)
    .listen('NewMessageCreated', (event) => {
        messengerStore.appendNewMessageToCurrentState(event)
        console.log(event)
    })


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
