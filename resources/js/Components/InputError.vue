<script setup>
import { defineProps } from 'vue';
defineProps(['field'])
</script>

<template>
    <p class="text-sm text-red-600 leading-3 mt-2 animate-bounce" v-if="field">
        <!-- {{ form.errors.email }} -->
        {{ field }}
    </p>
</template>

<style scoped>

</style>