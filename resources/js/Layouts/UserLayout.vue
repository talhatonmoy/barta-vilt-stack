<script setup>
import Footer from '../Partials/Footer.vue';
import Navigation from '../Partials/Navigation.vue';



</script>


<template>

    <body class="bg-gray-100">
        <header >
            <!-- Navigation -->
            <Navigation />
        </header>

        <div class="container max-w-2xl mx-auto space-y-8 mt-8 px-2 min-h-screen">
            <slot>

            </slot>
        </div>

        <!-- Footer -->
        <Footer />
    </body>

</template>
