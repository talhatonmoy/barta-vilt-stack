<script setup>
import Footer from '../Partials/Footer.vue';
import Navigation from '../Partials/Navigation.vue';

import { usePage } from '@inertiajs/vue3';

const user = usePage().user

</script>


<template>

    <body class="bg-gray-100">
        <header class=" sticky top-0 z-50">
            <!-- Navigation -->
             {{ user }}
            <Navigation />
        </header>

        <slot>

        </slot>


        <!-- Footer -->
        <Footer />
    </body>

</template>
