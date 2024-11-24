<script setup>
import Footer from '../Partials/Footer.vue';
import Navigation from '../Partials/Navigation.vue';
import { Link } from '@inertiajs/vue3';
import { reactive } from 'vue';

// Menu State
const menu = reactive({
    open: false,
    handleChange() {
        menu.open = !menu.open
    },
    reset() {
        menu.open = false
    }
})

</script>


<template>

    <body class="bg-gray-100">
        <header>
            <!-- Navigation -->
            <Navigation />
        </header>
        <div class="container max-w-7xl mx-auto mt-8 px-8 min-h-screen">
            <div class="lg:flex gap-5 relative">
                <div class="absolute top-0 right-0 lg:relative lg:mt-8 ">
                    <ul
                        class="hidden lg:block w-64 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-md">
                        <Link :href="route('user.profile.edit')">
                        <li for="basic_info"
                         :class="{ 'border-l-neutral-900 border-l-8': $page.url == route('user.profile.edit') }"
                            class=" transition w-full px-4 py-2 border-b cursor-pointer hover:bg-gray-50 border-gray-200 rounded-t-md">
                            Basic Info
                        </li>
                        </Link>
                        <Link :href="route('user.detail.edit')">
                        <li class="w-full px-4 py-2 border-b cursor-pointer hover:bg-gray-50 border-gray-200">
                            Contact and Detail
                        </li>
                        </Link>
                    </ul>
                    <!-- Mobile Menu -->
                    <div class="flex flex-shrink-0 self-center lg:hidden ">
                        <div class="relative inline-block text-left">
                            <div>
                                <button type="button" @click="menu.handleChange" v-click-away="menu.reset"
                                    class="-m-2 flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600"
                                    id="menu-0-button">
                                    <span class="sr-only">Open options</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path
                                            d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <!-- Dropdown menu -->
                            <ul v-show="menu.open"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-md">
                                <Link :href="route('user.profile.edit')">
                                <li for="basic_info"
                                    class="w-full px-4 py-2 border-b cursor-pointer hover:bg-gray-50 border-gray-200 rounded-t-lg">
                                    Basic Info
                                </li>
                                </Link>
                                <Link :href="route('user.detail.edit')">
                                <li class="w-full px-4 py-2 border-b cursor-pointer hover:bg-gray-50 border-gray-200">
                                    Contact and Detail
                                </li>
                                </Link>
                            </ul>
                        </div>
                    </div>

                </div>

                <slot>

                </slot>


            </div>
        </div>

        <!-- Footer -->
        <Footer />
    </body>

</template>
