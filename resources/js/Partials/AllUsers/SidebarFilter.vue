<script setup>

</script>

<template>
    <div
        class="main-border   w-full max-w-sm divide-y divide-gray-100 rounded-lg  dark1:bg-gray-800 dark1:divide-gray-700">
        <div
            class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50 dark1:bg-gray-800 dark1:text-white">
            Filter By
        </div>
        <div class="divide-y divide-gray-100 dark1:divide-gray-700">
            <form class="max-w-sm mx-auto p-4 space-y-4">
                <!-- By City -->
                <div>
                    <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark1:text-white">
                        City
                    </label>
                    <select id="countries"
                        class="bg-gray-50 border  border-gray-300 text-gray-900 text-sm rounded-md  focus:outline-none block w-full p-2 dark1:bg-gray-700 dark1:border-gray-600 dark1:placeholder-gray-400 dark1:text-white dark1:focus:ring-blue-500 dark1:focus:border-blue-500">

                        <option>United States</option>
                        <option>Canada</option>
                        <option>France</option>
                        <option>Germany</option>
                    </select>
                </div>

                <!-- By Gender -->
                <div>
                    <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark1:text-white">
                        Gender
                    </label>
                    <div class="flex items-center mb-1">
                        <input id="country-option-1" type="radio" name="countries" value="male"
                            class="w-4 h-4 border-gray-300 focus:outline-none dark1:bg-gray-700 dark1:border-gray-600"
                            checked>
                        <label for="country-option-1"
                            class="block ms-2  text-sm font-medium text-gray-900 dark1:text-gray-300">
                            Male
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input id="country-option-2" type="radio" name="countries" value="female"
                            class="w-4 h-4 border-gray-300 focus:outline-none dark1:bg-gray-700 dark1:border-gray-600"
                            checked>
                        <label for="country-option-2"
                            class="block ms-2  text-sm font-medium text-gray-900 dark1:text-gray-300">
                            Female
                        </label>
                    </div>
                </div>

                <!-- By Language -->
                <div>
                    <label for="PrimaryLanguage" class="block mb-2 text-sm font-medium text-gray-900 dark1:text-white">
                        Primary Language
                    </label>
                    <div class="flex items-center mb-1">
                        <input id="bangla" type="radio" name="countries" value="male"
                            class="w-4 h-4 border-gray-300 focus:outline-none dark1:bg-gray-700 dark1:border-gray-600"
                            checked>
                        <label for="bangla" class="block ms-2  text-sm font-medium text-gray-900 dark1:text-gray-300">
                            Bangla
                        </label>
                    </div>

                    <div class="flex items-center mb-1">
                        <input id="English" type="radio" name="countries" value="male"
                            class="w-4 h-4 border-gray-300 focus:outline-none dark1:bg-gray-700 dark1:border-gray-600"
                            checked>
                        <label for="English" class="block ms-2  text-sm font-medium text-gray-900 dark1:text-gray-300">
                            English
                        </label>
                    </div>
                </div>
            </form>
        </div>
        <a href="#"
            class="block py-2 text-sm font-medium text-center text-gray-900 rounded-b-lg bg-gray-50 hover:bg-gray-100 dark1:bg-gray-800 dark1:hover:bg-gray-700 dark1:text-white">
            <div class="inline-flex items-center ">
                <svg class="w-4 h-4 me-2 text-gray-500 dark1:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                    <path
                        d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                </svg>
                View all
            </div>
        </a>
    </div>
</template>

<style scoped>

</style>