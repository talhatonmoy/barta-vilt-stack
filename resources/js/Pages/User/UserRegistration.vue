<script setup>
import InputError from '../../Components/InputError.vue';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

defineOptions({
    layout: GuestLayout
})

const form = useForm({
    first_name: "",
    last_name: "",
    user_name: "",
    email: "",
    password: ""
})

function handleSubmit() {
    form.submit('post', route('user.store'))
}


</script>

<template>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <a href="./index.html" class="text-center text-6xl font-bold text-gray-900">
                <h1>Barta</h1>
            </a>
            <h1 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
                Create a new account
            </h1>
        </div>

        <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-4" @submit.prevent="handleSubmit">
                <!-- First Name -->
                <div>
                    <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">First
                        Name</label>
                    <div class="mt-2">
                        <input id="first_name" v-model="form.first_name" type="text" autocomplete="first_name"
                            placeholder="Muhammad"
                            class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" />
                    </div>
                    <InputError :field="form.errors.first_name" />
                </div>

                <!-- Last Name -->
                <div>
                    <label for="last_name" class="block text-sm font-medium leading-6 text-gray-900">Last
                        Name</label>
                    <div class="mt-2">
                        <input id="last_name" v-model="form.last_name" type="text" autocomplete="last_name"
                            placeholder="Alp Arslan"
                            class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" />
                    </div>
                    <InputError :field="form.errors.last_name" />
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                    <div class="mt-2">
                        <input id="username" v-model="form.user_name" type="text" autocomplete="username"
                            placeholder="Alp Arslan"
                            class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" />
                    </div>
                    <InputError :field="form.errors.user_name" />
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email
                        address</label>
                    <div class="mt-2">
                        <input id="email" v-model="form.email" type="email" autocomplete="email"
                            placeholder="alp.arslan@mail.com"
                            class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" />
                    </div>
                    <InputError :field="form.errors.email" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    <div class="mt-2">
                        <input id="password" v-model="form.password" type="password" placeholder="••••••••"
                            class="block w-full rounded-md border-0 p-2 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" />
                    </div>
                    <InputError :field="form.errors.password" />
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-black px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">
                        Register
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm text-gray-500">
                Already a member?
                <Link :href="route('user.login.create')" class="font-semibold leading-6 text-black hover:text-black">
                Sign In</Link>
            </p>
        </div>
    </div>
</template>

<style scoped>

</style>