<script setup>
import { watch, computed } from 'vue';
import { router, useForm } from '@inertiajs/vue3';

const props = defineProps({
    filterableData: {
        type: Object
    },
    // filterForm: {
    //     type: Object
    // }
})

const filterableData = props.filterableData;

// const filterForm = props.filterForm;

const filterForm = useForm({
    city: "",
    gender: "",
    primaryLang: ""
})

function updateFilter() {
    filterForm.get(route('users.list'), {
        preserveState: true,
        onSuccess: (page) => {
            console.log(page.props)
                // router.reload(  )
        }
    })
}


</script>

<template>
    <div
        class="main-border   w-full max-w-sm divide-y divide-gray-100 rounded-lg  dark1:bg-gray-800 dark1:divide-gray-700">
        <pre>
            {{ filterForm }}
        </pre>
        <div
            class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50 dark1:bg-gray-800 dark1:text-white">
            Filter By
        </div>
        <div class="divide-y divide-gray-100 dark1:divide-gray-700">
            <form class="max-w-sm mx-auto p-4 space-y-4">
                <!-- By City -->
                <div>
                    <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark1:text-white">
                        City
                    </label>
                    <select id="city" v-model="filterForm.city" @change="updateFilter"
                        class="bg-gray-50 border  border-gray-300 capitalize text-gray-900 text-sm rounded-md  focus:outline-none block w-full p-2 dark1:bg-gray-700 dark1:border-gray-600 dark1:placeholder-gray-400 dark1:text-white dark1:focus:ring-blue-500 dark1:focus:border-blue-500">
                        <option v-for="(city, index) in filterableData.uniqueCities" :key="city" :value="city">{{ city }}
                        </option>
                    </select>
                </div>

                <!-- By Gender -->
                <div>
                    <label for="gender" class="block mb-2 text-sm font-medium text-gray-900 dark1:text-white">
                        Gender
                    </label>
                    <div class="flex items-center mb-1">
                        <input id="country-option-1" type="radio" v-model="filterForm.gender" @change="updateFilter"
                            name="gender" value="male"
                            class="w-4 h-4 border-gray-300 focus:outline-none dark1:bg-gray-700 dark1:border-gray-600">
                        <label for="country-option-1"
                            class="block ms-2  text-sm font-medium text-gray-900 dark1:text-gray-300">
                            Male
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input id="country-option-2" type="radio" v-model="filterForm.gender" @change="updateFilter"
                            name="gender" value="female"
                            class="w-4 h-4 border-gray-300 focus:outline-none dark1:bg-gray-700 dark1:border-gray-600">
                        <label for="country-option-2"
                            class="block ms-2  text-sm font-medium text-gray-900 dark1:text-gray-300">
                            Female
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input id="country-option-3" type="radio" v-model="filterForm.gender" @change="updateFilter"
                            name="gender" value="3rd gender"
                            class="w-4 h-4 border-gray-300 focus:outline-none dark1:bg-gray-700 dark1:border-gray-600">
                        <label for="country-option-3"
                            class="block ms-2  text-sm font-medium text-gray-900 dark1:text-gray-300">
                            3rd Gender
                        </label>
                    </div>
                </div>

                <!-- By Language -->
                <div>
                    <label for="PrimaryLanguage" class="block mb-2 text-sm font-medium text-gray-900 dark1:text-white">
                        Primary Language
                    </label>

                    <div class="flex items-center mb-1" v-for="(language, index) in filterableData.primaryLang"
                        :key="index">
                        <input :id="language" type="radio" v-model="filterForm.primaryLang" @change="updateFilter"
                            name="primary_lang" :value="language"
                            class="w-4 h-4 border-gray-300 focus:outline-none dark1:bg-gray-700 dark1:border-gray-600">
                        <label :for="language"
                            class="block ms-2 capitalize text-sm font-medium text-gray-900 dark1:text-gray-300">
                            {{ language }}
                        </label>
                    </div>

                </div>
            </form>
        </div>
        <a href="#"
            class="block py-2 text-sm font-medium text-center text-gray-900 rounded-b-lg bg-gray-50 hover:bg-gray-100 dark1:bg-gray-800 dark1:hover:bg-gray-700 dark1:text-white">
            <div class="inline-flex items-center hover:underline ">
                Reset
            </div>
        </a>
    </div>
</template>

<style scoped>

</style>