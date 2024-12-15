<script setup>

</script>

<template>
    <section
        class="flex flex-col flex-none overflow-auto w-24 group lg:max-w-sm md:w-2/5 transition-all duration-100 ease-in-out">

        <!-- Head Section -->
        <div class="header p-4 flex flex-row justify-center md:justify-start gap-5 items-center flex-none">
            <div class="w-12 md:w-16  h-12 md:h-16 relative flex flex-shrink-0">
                <img class="rounded-full w-full h-full object-cover" alt="ravisankarchinnam"
                    src="https://avatars.githubusercontent.com/u/74638065?v=4" />
            </div>
            <div class="hidden md:block">
                <p class="text-md font-bold ">Talha Tonmoy</p>
                <p class="text-sm">Web Developer</p>
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
            <div class="flex justify-center md:justify-between gap-3 items-center p-3 hover:bg-gray-100 rounded-lg relative">
                <!-- Image -->
                <div class="w-12 h-12 relative flex justify-center">
                    <img class="shadow-md rounded-full w-full h-full object-cover"
                        src="https://avatars.githubusercontent.com/u/74638065?v=4" alt="" />
                </div>
                <!-- Short Message -->
                <div class="flex-auto min-w-0 hidden md:block ">
                    <p class="text-sm font-medium md:text-md">Angelina Jolie<span class="text-xs ml-1 font-bold"> - Just now</span></p>
                    <div class="flex items-center text-xs md:text-sm  text-gray-600">
                        <div class="min-w-0">
                            <p class="truncate">Ok, see you at the subway in a bit.</p>
                        </div>
                    </div>
                </div>

            </div>
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