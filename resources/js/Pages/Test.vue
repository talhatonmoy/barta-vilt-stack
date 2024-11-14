<script setup>
import { usePage } from '@inertiajs/vue3';
import UserLayout from '../Layouts/UserLayout.vue';

const {validatedData} = usePage().props


</script>

<template>
    <UserLayout>
        <h2 class=" bg-red-400 text-4xl">Welcome Man</h2>
        <button @click="showAlert">Hello world</button>
        <pre>
    {{ validatedData }}
</pre>
    </UserLayout>
</template>

<style scoped>

</style>