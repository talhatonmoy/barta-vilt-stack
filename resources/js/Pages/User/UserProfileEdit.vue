<script setup>

import { Link, useForm, usePage } from '@inertiajs/vue3';
import { reactive, ref, onBeforeMount } from 'vue';
import UserLayoutWithSidebar from '../../Layouts/UserLayoutWithSidebar.vue';

const { userData } = reactive(usePage().props);
const previewProfileImg = ref('/img/placeholders/profile.jpg')

onBeforeMount(() => {
    if (userData.profileImgUrl) {
        previewProfileImg.value = userData.profileImgUrl
    }
})

const form = useForm({
    first_name: userData.first_name,
    last_name: userData.last_name,
    email: userData.email,
    bio: userData.bio,
    profileImg: null
})

function handleSubmit() {
    form.submit('post', route('user.profile.update'))
}

function handleChange(event) {
    const file = event.target.files[0];
    if (file) {
        form.profileImg = file;
        previewProfileImg.value = URL.createObjectURL(file);
    }
}





const openIndex = ref(1);
</script>

<template>
    <UserLayoutWithSidebar>
 
        <main v-if="openIndex == 1" class="container max-w-4xl mx-auto space-y-8 mt-8 px-2 md:px-0 min-h-screen ">
            <!-- Profile Edit Form -->

            <form @submit.prevent="handleSubmit">
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-xl font-semibold leading-7 text-gray-900">
                            Edit Profile
                        </h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">
                            This information will be displayed publicly so be careful what you
                            share.
                        </p>

                        <div class="mt-10 border-b border-gray-900/10 pb-12">
                            <div class="col-span-full mt-10 pb-10">
                                <label for="photo"
                                    class="block text-sm font-medium leading-6 text-gray-900">Photo</label>
                                <div class="mt-2 flex items-center gap-x-3">
                                    <input class="hidden" @change="handleChange" type="file" id="avatar" />
                                    <img class="h-32 w-32 rounded-full" :src="previewProfileImg"
                                        alt="Ahmed Shamim Hasan Shaon" />
                                    <label for="avatar">
                                        <div
                                            class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                            Change
                                        </div>
                                    </label>
                                </div>
                                <p class="text-sm text-red-600 leading-3 mt-2 animate-bounce"
                                    v-if="form.errors.profileImg">
                                    {{ form.errors.profileImg }}
                                </p>
                            </div>


                            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <!-- First Name -->
                                <div class="sm:col-span-3">
                                    <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900">
                                        First name
                                    </label>
                                    <div class="mt-2">
                                        <input type="text" v-model="form.first_name" id="first-name"
                                            autocomplete="given-name" value="Ahmed Shamim Hasan"
                                            class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                                    </div>
                                    <p class="text-sm text-red-600 leading-3 mt-2 animate-bounce"
                                        v-if="form.errors.first_name">
                                        {{ form.errors.first_name }}
                                    </p>
                                </div>

                                <!-- Last Name -->
                                <div class="sm:col-span-3">
                                    <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">
                                        Last name
                                    </label>
                                    <div class="mt-2">
                                        <input type="text" v-model="form.last_name" id="last-name" value="Shaon"
                                            autocomplete="family-name"
                                            class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                                    </div>
                                    <p class="text-sm text-red-600 leading-3 mt-2 animate-bounce"
                                        v-if="form.errors.last_name">
                                        {{ form.errors.last_name }}
                                    </p>
                                </div>

                                <!-- Email -->
                                <div class="col-span-full">
                                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">
                                        Email address
                                    </label>
                                    <div class="mt-2">
                                        <input id="email" disabled type="email" autocomplete="email"
                                            :value="userData.email"
                                            class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                                    </div>
                                    <!-- <p class="text-sm text-red-600 leading-3 mt-2 animate-bounce"
                                    v-if="form.errors.email">
                                    {{ form.errors.email }}
                                </p> -->

                                </div>

                                <!-- User_name -->
                                <div class="col-span-full">
                                    <label for="user_name" class="block text-sm font-medium leading-6 text-gray-900">
                                        Username
                                    </label>
                                    <div class="mt-2">
                                        <input id="user_name" disabled :value="userData.user_name"
                                            class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                                    </div>
                                </div>

                                <!-- Password -->
                                <!-- <div class="col-span-full">
                                <label for="password"
                                    class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                                <div class="mt-2">
                                    <input type="password" name="password" id="password" autocomplete="password"
                                        class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                                </div>
                            </div> -->
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="col-span-full">
                                <label for="bio" class="block text-sm font-medium leading-6 text-gray-900">Bio</label>
                                <div class="mt-2">
                                    <textarea id="bio" v-model="form.bio" rows="3"
                                        class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6">
Less Talk, More Code 💻</textarea>
                                </div>
                                <p class="mt-3 text-sm leading-6 text-gray-600">
                                    Write a few sentences about yourself.
                                </p>
                                <p class="text-sm text-red-600 leading-3 mt-2 animate-bounce" v-if="form.errors.bio">
                                    {{ form.errors.bio }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <Link :href="route('user.profile.show', userData.user_name)"
                        class="text-sm font-semibold leading-6 text-gray-900">
                    Cancel
                    </Link>
                    <button type="submit"
                        class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                        Save
                    </button>
                </div>
            </form>
            <!-- /Profile Edit Form -->
        </main>
    </UserLayoutWithSidebar>
</template>

<style scoped>

</style>