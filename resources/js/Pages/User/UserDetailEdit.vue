<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import InputError from '../../Components/InputError.vue';
import UserLayoutWithSidebar from '../../Layouts/UserLayoutWithSidebar.vue';

const props = usePage().props

const userDetails = props.userDetails;

const form = useForm({
    mobile: (userDetails) ? userDetails.mobile : '',
    website: (userDetails) ? userDetails.website : '',
    facebook: (userDetails) ? userDetails.facebook : '',
    whatsapp: (userDetails) ? userDetails.whatsapp : '',
    linkedin: (userDetails) ? userDetails.linkedin : '',
    gender: (userDetails) ? userDetails.gender : '',
    date_of_birth: (userDetails) ? userDetails.date_of_birth : '',
    nick_name: (userDetails) ? userDetails.nick_name : '',
    primary_lang: (userDetails) ? userDetails.primary_lang : '',
    secondary_lang: (userDetails) ? userDetails.secondary_lang : '',
    favorite_quote: (userDetails) ? userDetails.favorite_quote : '',
    current_city: (userDetails) ? userDetails.current_city : ''
})

function handleSubmit() {
    if (userDetails) {
        // Update The Model
        form.patch(route('user.detail.update'))
    } else {
        // Store the model
        form.post(route('user.detail.store'))
    }
}

</script>

<template>
    <UserLayoutWithSidebar>
        <div class="container max-w-4xl mx-auto space-y-8 mt-8 px-2 md:px-0 min-h-screen">
            <!-- Card -->
            <div class="">
                <!-- Section -->
                <div
                    class="grid sm:grid-cols-12 gap-2 sm:gap-4 py-8 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200">
                    <div class="sm:col-span-12">
                        <h2 class="text-lg font-semibold text-gray-800">
                            Contact Info
                        </h2>
                    </div>

                    <!-- Mobile No -->
                    <div class="sm:col-span-3">
                        <label for="af-submit-application-full-name"
                            class="inline-block text-sm font-medium text-gray-500 mt-2.5">
                            Mobile No
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <input v-model="form.mobile" id="af-submit-application-full-name" type="tel"
                                class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px rounded-md text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">

                        </div>
                        <InputError :field="form.errors.mobile" />

                    </div>
                    <!-- End Mobile No -->


                    <!--  Website -->
                    <div class="sm:col-span-3">
                        <label for="website" class="inline-block text-sm font-medium text-gray-500 mt-2.5">
                            Website
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input v-model="form.website" id="website" type="url"
                            class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-md focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        <InputError :field="form.errors.website" />
                    </div>
                    <!-- End Website -->


                    <!--  Facebook Url -->
                    <div class="sm:col-span-3">
                        <label for="fb-url" class="inline-block text-sm font-medium text-gray-500 mt-2.5">
                            Facebook
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input v-model="form.facebook" id="fb-url" type="url"
                            class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-md focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        <InputError :field="form.errors.facebook" />
                    </div>
                    <!-- End  Facebook Url -->

                    <!--  Whatsapp Url -->
                    <div class="sm:col-span-3">
                        <label for="whatsapp" class="inline-block text-sm font-medium text-gray-500 mt-2.5">
                            Whatsapp No
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input v-model="form.whatsapp" id="whatsapp" type="tel"
                            class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-md focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        <InputError :field="form.errors.whatsapp" />
                    </div>
                    <!-- End  Whatsapp Url -->

                    <!--  LinkedIn Url -->
                    <div class="sm:col-span-3">
                        <label for="LinkedIn" class="inline-block text-sm font-medium text-gray-500 mt-2.5">
                            LinkedIn
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input v-model="form.linkedin" id="LinkedIn" type="url"
                            class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-md focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                        <InputError :field="form.errors.linkedin" />
                    </div>
                    <!-- End  LinkedIn Url -->
                </div>
                <!-- End Section -->

                <!-- Section -->
                <div
                    class="grid sm:grid-cols-12 gap-2 sm:gap-4 py-8 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200">
                    <div class="sm:col-span-12">
                        <h2 class="text-lg font-semibold text-gray-800">
                            Baisc Info
                        </h2>
                    </div>
                    <!-- End Col -->

                    <!-- Gender -->
                    <div class="sm:col-span-3">
                        <label for="af-account-gender-checkbox" class="inline-block text-sm text-gray-800 mt-2.5">
                            Gender
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <label for="af-account-gender-checkbox"
                                class="flex py-2 px-3 w-full border border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none ">
                                <input type="radio" name="af-account-gender-checkbox" v-model="form.gender" value="male"
                                    class="shrink-0 mt-0.5 border-gray-300 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    id="af-account-gender-checkbox">
                                <span class="text-sm text-gray-500 ms-3 ">Male</span>
                            </label>

                            <label for="af-account-gender-checkbox-female"
                                class="flex py-2 px-3 w-full border border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                                <input type="radio" name="af-account-gender-checkbox"
                                    class="shrink-0 mt-0.5 border-gray-300 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    id="af-account-gender-checkbox-female" v-model="form.gender" value="female">
                                <span class="text-sm text-gray-500 ms-3">Female</span>
                            </label>

                            <label for="af-account-gender-checkbox-other"
                                class="flex py-2 px-3 w-full border border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none ">
                                <input type="radio" name="af-account-gender-checkbox"
                                    class="shrink-0 mt-0.5 border-gray-300 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    id="af-account-gender-checkbox-other" v-model="form.gender" value="3rd Gender">
                                <span class="text-sm text-gray-500 ms-3">3rd Gender</span>
                            </label>
                        </div>
                        <InputError :field="form.errors.gender" />
                    </div>
                    <!-- End Gender -->


                    <!-- date_of_birth -->
                    <div class="sm:col-span-3 ">
                        <label for="date_of_birth" class="inline-block text-sm font-medium text-gray-500 mt-2.5">
                            Date Of Birth
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <input v-model="form.date_of_birth" id="date_of_birth" type="date"
                                class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px rounded-md text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                            <InputError :field="form.errors.date_of_birth" />
                        </div>
                    </div>
                    <!-- End date_of_birth -->

                    <!-- nick_name -->
                    <div class="sm:col-span-3">
                        <label for="nick_name" class="inline-block text-sm font-medium text-gray-500 mt-2.5">
                            Nick Name
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <input v-model="form.nick_name" id="nick_name" type="text"
                                class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px rounded-md text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                            <InputError :field="form.errors.nick_name" />
                        </div>
                    </div>
                    <!-- End nick_name -->

                    <!-- primary_language -->
                    <div class="sm:col-span-3">
                        <label for="primary_language" class="inline-block text-sm font-medium text-gray-500 mt-2.5">
                            Primary Language
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <input v-model="form.primary_lang" id="primary_language" type="text"
                                class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px rounded-md text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">

                        </div>
                        <InputError :field="form.errors.primary_lang" />
                    </div>
                    <!-- End primary_language -->


                    <!-- secondary_language -->
                    <div class="sm:col-span-3">
                        <label for="secondary_language" class="inline-block text-sm font-medium text-gray-500 mt-2.5">
                            Secondary Language
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <input v-model="form.secondary_lang" id="secondary_language" type="text"
                                class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px rounded-md text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">

                        </div>
                        <InputError :field="form.errors.secondary_lang" />
                    </div>
                    <!-- End secondary_language -->

                    <!-- favorite_quote -->
                    <div class="sm:col-span-3">
                        <label for="favorite_quote" class="inline-block text-sm font-medium text-gray-500 mt-2.5">
                            Favorite Quote
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <input v-model="form.favorite_quote" id="favorite_quote" type="text"
                                class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px rounded-md text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                            <InputError :field="form.errors.favorite_quote" />
                        </div>
                    </div>
                    <!-- End favorite_quote -->

                    <!-- current_city -->
                    <div class="sm:col-span-3">
                        <label for="current_city" class="inline-block text-sm font-medium text-gray-500 mt-2.5">
                            Currently Lives In
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <div class="sm:flex">
                            <input v-model="form.current_city" id="current_city" type="text"
                                class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px rounded-md text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                            <InputError :field="form.errors.current_city" />
                        </div>
                    </div>
                    <!-- End current_city -->
                </div>
                <!-- End Section -->

                <!-- Section -->
                <!-- <div class="py-8 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200">
                <div class="mt-5 flex">
                    <input type="checkbox"
                        class="shrink-0 mt-0.5 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                        id="af-submit-application-privacy-check">
                    <label for="af-submit-application-privacy-check" class="text-sm text-gray-500 ms-2">Allow us to
                        process your personal information.</label>
                </div>
            </div> -->
                <!-- End Section -->

                <button @click.prevent="handleSubmit"
                    class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-md border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                    Save
                </button>
            </div>
            <!-- End Card -->
        </div>
    </UserLayoutWithSidebar>
</template>

<style scoped></style>