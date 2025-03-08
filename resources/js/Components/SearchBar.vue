<script setup>
import { useForm } from '@inertiajs/vue3';
const searchForm = useForm({
    searchQuery: ''
});

function handleSubmit() {
    if(searchForm.searchQuery === '') {
        return;
    }
    searchForm.submit('get', route('search'), {
        onSuccess: () => {
            searchForm.reset()
        }
    });
}
</script>

<template>
    <form @submit.prevent="handleSubmit" class="flex items-center relative">
        <input type="text" v-model="searchForm.searchQuery" name="search_query" placeholder="Search..."
            class="border-2 border-gray-300 w-40 sm:w-56 bg-white h-9 px-5 pr-10 rounded-full text-sm focus:outline-none" />
        <button type="submit" class="absolute right-1.5 top-3.5 mt-2 mr-2">
            <svg class="text-gray-600 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-5.2-5.2M15 10.5a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z">
                </path>
            </svg>
        </button>
    </form>
</template>

<style scoped></style>