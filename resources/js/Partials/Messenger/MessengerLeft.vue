<script setup>
import { usePage, Link } from '@inertiajs/vue3';
import { useMessengerUserStore } from '../../Store/useMessengerUserStore';

const messengerStore = useMessengerUserStore()

const props = defineProps({
    friends: {
        type: Object
    }
})

const authUser = usePage().props.auth.user

</script>

<template>
    <section
        class="flex flex-col flex-none overflow-auto w-24 group lg:max-w-sm md:w-2/5 transition-all duration-100 ease-in-out">
        <!-- <pre>
        {{ friends }}
    </pre> -->
        <!-- Head Section -->
        <div class="header p-4 flex gap-4 items-center">
            <!-- Image -->
            <div class="w-14 h-14 relative flex justify-center ring-1 p-0.5 rounded-full">
                <img class="shadow-md rounded-full w-full h-full object-cover" :src="authUser.profileImgUrl"
                    :alt="authUser.user_name" />
            </div>
            <div>
                <h2 class="text-2xl font-bold leading-0">Chats</h2>
                <p class="font-medium leading-0 text-gray-500">{{ authUser.first_name }} {{ authUser.last_name }}</p>
            </div>
        </div>

        <!-- Search Form -->
        <div class="search-box p-2 flex-none">
            <form onsubmit="">
                <div class="relative">
                    <label
                        class="flex flex-row-reverse items-center  border px-1.5 border-gray-400 rounded-lg focus:border-gray-600  focus:outline-none text-gray-800 focus:shadow-md transition duration-300 ease-in">
                        <input type="text" value=""
                            class="text-xs md:text-sm leading-none rounded-full p-2 focus:outline-none w-full"
                            placeholder="Search Messenger" />
                        <span class=" inline-block">
                            <svg viewBox="0 0 24 24" class="size-4">
                                <path fill="#bbb"
                                    d="M16.32 14.9l5.39 5.4a1 1 0 0 1-1.42 1.4l-5.38-5.38a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z" />
                            </svg>
                        </span>
                    </label>
                </div>
            </form>
        </div>

        <!-- Users -->
        <div class="contacts p-2 overflow-y-auto">
            <!-- User -->
            <template v-if="friends.length">
                <template v-for="friend in friends" :key="friend.id">
                    <Link preserve-scroll :href="route('message.index', friend.user_name)">
                    <div
                        class="flex justify-center md:justify-between gap-3 items-center p-3 hover:bg-gray-100 rounded-lg relative">
                        <!-- Image -->
                        <div class="w-12 h-12 relative flex justify-center">
                            <img class="shadow-md rounded-full w-full h-full object-cover" :src="friend.profileImgUrl"
                                :alt="friend.user_name" />
                        </div>
                        <!-- Short Message -->
                        <div class="flex-auto min-w-0 hidden md:block">
                            <p class="text-sm font-medium md:text-md">
                                {{ friend.first_name }} {{ friend.last_name }}
                                <span v-if="friend.latest_message" class="text-xs ml-1 font-bold"> - {{
                                    friend.latest_message.created_at }}</span>
                            </p>
                            <div class="flex items-center text-xs md:text-sm  text-gray-600">
                                <div class="min-w-0">
                                    <p v-if="friend.latest_message" class="truncate">
                                        {{ friend.latest_message.body}}</p>
                                    <p class="font-normal" v-else>start conversation</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    </Link>
                </template>
            </template>

            <template v-else>
                <div class="flex justify-center items-center h-64">
                    <p class="text-gray-500">No friends found</p>
                </div>
            </template>



        </div>
    </section>
</template>

<style scoped>
/* NO NEED THIS CSS - just for custom scrollbar which can also be configured in tailwind.config.js*/
::-webkit-scrollbar {
    width: 2px;
    height: 2px;
}

::-webkit-scrollbar-button {
    width: 0px;
    height: 0px;
}

::-webkit-scrollbar-thumb {
    background: #2d3748;
    border: 0px none #ffffff;
    border-radius: 50px;
}

::-webkit-scrollbar-thumb:hover {
    background: #2b6cb0;
}

::-webkit-scrollbar-thumb:active {
    background: #000000;
}

::-webkit-scrollbar-track {
    background: #1a202c;
    border: 0px none #ffffff;
    border-radius: 50px;
}

::-webkit-scrollbar-track:hover {
    background: #666666;
}

::-webkit-scrollbar-track:active {
    background: #333333;
}

::-webkit-scrollbar-corner {
    background: transparent;
}
</style>