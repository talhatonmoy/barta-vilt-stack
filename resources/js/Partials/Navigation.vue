<script setup>
import { computed, reactive } from 'vue'
import { usePage, Link } from '@inertiajs/vue3';
import SearchBar from '../Components/SearchBar.vue';
import InAppNotificationTray from '../Components/Notifications/InAppNotificationTray.vue';
const page = usePage();
// const user = true
const user = page.props.auth.user


// Barta Navigation Menu
const bartaNavMenu = reactive({
    open: false,
    handleChange() {
        bartaNavMenu.open = !bartaNavMenu.open
    },
    reset() {
        bartaNavMenu.open = false
    }
})


// User Account userAccountMenu State
const userAccountMenu = reactive({
    open: false,
    handleChange() {
        userAccountMenu.open = !userAccountMenu.open
    },
    reset() {
        userAccountMenu.open = false
    }
})
</script>

<template>
    <nav class="bg-white shadow">
        <div class="main-container">
            <div class="flex h-16 justify-between gap-2">
                <!-- Left Part -->
                <div class="flex">
                    <div class="flex flex-shrink-0 items-center">
                        <Link :href="route('user.timeline')">
                            <h2 class="font-bold text-2xl">Barta</h2>
                        </Link>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <!-- Left Side Desktop Menu Items -->
                        <template v-if="user">
                            <Link :href="route('user.timeline')" :class="{' border-b-gray-800 text-gray-900' : $page.url === '/timeline'}"
                                class="inline-flex items-center border-b-2 border-transparent  border-gray-800 px-1 pt-1 text-sm font-medium text-gray-600  hover:border-gray-300 hover:text-gray-800">
                            Timeline
                            </Link>
                            <a href="#"
                                class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-600  hover:border-gray-300 hover:text-gray-800">For
                                you
                            </a>

                            <Link :href="route('users.list')"
                                :class="{ 'border-b-gray-800 text-gray-900': $page.url === '/users' }"
                                class="inline-flex items-center border-b-2 border-transparent  border-gray-800 px-1 pt-1 text-sm font-medium text-gray-600  hover:border-gray-300 hover:text-gray-800">
                            People
                            </Link>

                        </template>
                    </div>

                </div>
                <!-- Search input -->
                <SearchBar />

                <!-- Right Part Start -->
                <!--Signin Button For Guest -->
                <div v-if="!user" class="hidden sm:ml-6 sm:flex gap-2 sm:items-center">
                    <!-- This Button Should Be Hidden on Mobile Devices -->
                    <a href="" type="button"
                        class="text-gray-900 hover:text-white border-2 border-gray-800 hover:bg-gray-900 focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center hidden md:block">
                        Sign In
                    </a>
                </div>

                <!-- For Auth  -->
                <div v-if="user" class="sm:ml-6 mr-2 flex items-center gap-3 justify-between sm:items-center">
                    <!-- Notification -->
                    <InAppNotificationTray />
                    <!-- Message -->
                    <Link :href="route('messenger')" class="rounded-full text-gray-800">
                        <span class="sr-only">Messages</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 sm:size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                        </svg>
                    </Link>

                    <!-- Profile dropdown -->
                    <div class="relative ml-3 hidden sm:block">
                        <div>
                            <button @click="userAccountMenu.handleChange" type="button"
                                v-click-away="userAccountMenu.reset" class="flex rounded-full "
                                id="user-userAccountMenu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user userAccountMenu</span>
                                <img class="h-8 w-8 rounded-full" :src="user.profileImgUrl" alt="user.first_name" />
                            </button>
                        </div>
                        <!-- Dropdown userAccountMenu -->
                        <div v-show="userAccountMenu.open"
                            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            role="userAccountMenu" aria-orientation="vertical"
                            aria-labelledby="user-userAccountMenu-button" tabindex="-1">
                            <Link :href="route('user.profile.show', user.user_name)"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                role="userAccountMenuitem" tabindex="-1" id="user-userAccountMenu-item-0">Your
                            Profile
                            </Link>
                            <Link :href="route('user.profile.edit')"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                role="userAccountMenuitem" tabindex="-1" id="user-userAccountMenu-item-1">Edit
                            Profile
                            </Link>
                            <Link :href="route('user.logout')"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                role="userAccountMenuitem" tabindex="-1" id="user-userAccountMenu-item-2">Sign out
                            </Link>
                        </div>
                    </div>

                    <!-- Mobile Menu Barta Nav -->
                    <div class="-mr-2 flex justify-between items-center sm:hidden">
                        <!-- Mobile userAccountMenu button -->
                        <button @click="bartaNavMenu.handleChange" v-click-away="bartaNavMenu.reset" type="button"
                            class="inline-flex items-center justify-center rounded-full  text-gray-400">
                            <span class="sr-only">Open main userAccountMenu</span>
                            <!-- Icon when userAccountMenu is closed -->
                            <svg v-show="!bartaNavMenu.open" class="block size-5 sm:size-6"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>

                            <!-- Icon when userAccountMenu is open -->
                            <svg v-show="bartaNavMenu.open" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 sm:size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                </div>
                <!-- Right Part End -->
                <!-- For Auth End -->
            </div>
        </div>

        <!-- Mobile userAccountMenu, show/hide based on userAccountMenu state. -->
        <div v-show="bartaNavMenu.open" class="sm:hidden transition-all duration-300" id="mobile-userAccountMenu">
            <div class="border-t border-gray-200 pt-4 pb-3">
                <div class="flex items-center px-4">
                    <div>
                        <div class="text-base font-medium text-gray-800">
                            Ahmed Shamim Hasan Shaon
                        </div>
                        <div class="text-sm font-medium text-gray-500">
                            shaon@shamim.com
                        </div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="/user/profile"
                        class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Your
                        Profile</a>
                    <a href="/user/edit-profile"
                        class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Edit
                        Profile</a>
                    <a href=""
                        class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Sign
                        out</a>
                </div>
            </div>
        </div>
    </nav>
</template>

<style scoped>
</style>