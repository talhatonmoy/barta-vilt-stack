<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import InputError from '../../Components/InputError.vue';
const form = useForm({
    email: "",
    password: ""
})


</script>

<template>
    <GuestLayout>
        <div class="flex min-h-full flex-col mt-10 justify-center px-6 py-12 lg:px-8">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <a href="./index.html" class="text-center text-6xl font-bold text-gray-900">
                    <h1>Barta</h1>
                </a>

                <h1 class="mt-5 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                    Sign in to your account
                </h1>
            </div>

            <div class="m-8 sm:mx-auto sm:w-full sm:max-w-sm">
                <form @submit.prevent="form.post(route('user.login.store'))" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email
                            address</label>
                        <div class="mt-2">
                            <input id="email" v-model="form.email" type="email" autocomplete="email"
                                placeholder="bruce@wayne.com"
                                class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" />
                        </div>
                        <InputError :field="form.errors.email" />
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password"
                                class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                            <div class="text-sm">
                                <a href="#" class="font-semibold text-black hover:text-black">Forgot password?</a>
                            </div>
                        </div>
                        <div class="mt-2">
                            <input id="password" v-model="form.password" type="password" placeholder="••••••••"
                                class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" />
                        </div>
                        <InputError :field="form.errors.password" />
                    </div>

                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-black px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">
                            Sign in
                        </button>
                    </div>
                </form>

                <p class="mt-10 text-center text-sm text-gray-500">
                    Don't have an account yet?
                    <Link :href="route('user.create')" class="font-semibold leading-6 text-black hover:text-black">
                    Sign Up
                    </Link>
                </p>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>

</style>