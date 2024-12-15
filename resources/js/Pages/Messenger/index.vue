<script setup>
import MessengerLeft from '../../Components/Messenger/MessengerLeft.vue';
import ChatInputArea from '../../Components/Messenger/ChatInputArea.vue';


</script>

<template>
    <div class="main-container mt-3 md:mt-8">
        <div class="w-full flex antialiased text-neutral-800 main-border bg-white overflow-hidden">
            <div class="flex-1 flex flex-col">
                <main class="flex-grow flex flex-row min-h-0">

                    <!-- Left Section -->
                    <MessengerLeft />

                    <!-- Message Area -->
                    <section class="flex flex-col flex-auto border-l border-gray-300">
                        <!-- Top Section -->
                        <div class="chat-header px-5 py-3 flex flex-row flex-none justify-between items-center shadow">
                            <div class="flex items-center">
                                <div class="w-12 h-12 mr-4 relative flex flex-shrink-0">
                                    <img class="shadow-md rounded-full w-full h-full object-cover"
                                        src="https://avatars.githubusercontent.com/u/74638065?v=4" alt="" />
                                </div>
                                <div class="text-sm">
                                    <p class="font-bold">Scarlett Johansson</p>
                                    <p>Active 1h ago</p>
                                </div>
                            </div>
                        </div>

                        <!-- Message Display Area -->
                        <div class="p-4 overflow-y-auto space-y-5 " style="height: calc(100vh - 300px);">

                            <!-- Chat Bubble (Other User) -->
                            <div class="flex items-start gap-2.5">
                                <img class="w-8 h-8 rounded-full"
                                    src="https://avatars.githubusercontent.com/u/74638065?v=4" alt="Jese image">
                                <div
                                    class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">Bonnie
                                            Green</span>
                                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">11:46</span>
                                    </div>
                                    <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">That's awesome.
                                        I think our users will really appreciate the improvements.</p>
                                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Delivered</span>
                                </div>
                                <!-- <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots"
                                    data-dropdown-placement="bottom-start"
                                    class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:ring-gray-600"
                                    type="button">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                        <path
                                            d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                    </svg>
                                </button>
                                <div id="dropdownDots"
                                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                        aria-labelledby="dropdownMenuIconButton">
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reply</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Forward</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Copy</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a>
                                        </li>
                                    </ul>
                                </div> -->
                            </div>

                            <!-- Chat Bubble (Auth User) -->
                            <div class="flex items-start justify-end gap-2.5">

                                <!-- <button id="dropdownMenuIconButton" data-dropdown-toggle="dropdownDots"
                                    data-dropdown-placement="bottom-start"
                                    class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:ring-gray-600"
                                    type="button">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                        <path
                                            d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                    </svg>
                                </button>
                                <div id="dropdownDots"
                                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                        aria-labelledby="dropdownMenuIconButton">
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reply</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Forward</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Copy</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a>
                                        </li>
                                    </ul>
                                </div> -->

                                <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-l-xl rounded-br-xl dark:bg-gray-700">
                                    <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                        <span class="text-sm font-semibold text-gray-900 dark:text-white">Bonnie
                                            Green</span>
                                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">11:46</span>
                                    </div>
                                    <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">That's awesome.
                                        I think our users will really appreciate the improvements.</p>
                                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Delivered</span>
                                </div>

                                <img class="w-8 h-8 rounded-full"
                                    src="https://avatars.githubusercontent.com/u/74638065?v=4" alt="Jese image">

                            </div>
                        </div>

                        <!-- Message Input Area -->
                        <ChatInputArea/> 
                    </section>
                </main>
            </div>
        </div>
    </div>
</template>

<style scoped>

/* can be configured in tailwind.config.js */
/* .group:hover .group-hover\:block {
    display: block;
} */

/* .hover\:w-64:hover {
    width: 45%;
} */


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