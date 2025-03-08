<script setup>
import { usePage } from '@inertiajs/vue3';
import UserCard from '../../Components/User/UserCard.vue';
import PostCard from '../../Components/PostCard.vue';
const { users, posts, searchTerm } = usePage().props;
</script>

<template>
    <div class="main-container">
        <h2 v-if="searchTerm != '' " class="text-xl text-center my-3 font-medium md:text-2xl">Search Results For - "{{
            searchTerm }}"</h2>
        <div class="w-full">
            <div v-if="users.length > 0" class=" grid grid-flow-rows md:grid-cols-2 lg:grid-cols-4 gap-4">
                <template v-for="user in users" :key="user.id">
                    <UserCard :userData="user" />
                </template>
            </div>
            <div v-else class="main-border py-5 text-center">
                <p>No Users found to matched your search term</p>
            </div>
            <!-- Load More -->
            <div ref="landMark"></div>
        </div>

        <hr class="my-5">

        <!-- Posts Feed -->
        <div v-if="users.length > 0" class=" grid grid-flow-rows md:grid-cols-2 lg:grid-cols-3 gap-4">
            <template v-for="post in posts.data" :key="post.uuid">
                <PostCard :post="post" />
            </template>
        </div>

        <div v-else class="main-border py-5 text-center">
            <p>No Posts found to matched your search term</p>
        </div>
    </div>
</template>

<style scoped>

</style>