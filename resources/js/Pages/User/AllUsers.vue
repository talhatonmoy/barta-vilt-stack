<script setup>
import { router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import UserCard from '../../Components/User/UserCard.vue';
import FrameLayout from '../../Layouts/FrameLayout.vue'
import SidebarFilter from '../../Partials/AllUsers/SidebarFilter.vue';
const props = usePage().props;

const allUsers = props.allUsers

const userCollection = ref(allUsers.data)

const nextPageUrl = ref(props.allUsers.links.next)
function loadMoreUser() {
    if (!nextPageUrl) {
        return
    }

    router.get(nextPageUrl.value, {}, {
        preserveState: true, 
        preserveScroll: true,
        onSuccess: (page) => {
            console.log(page.props.allUsers.data)
            if (userCollection.value.push(...page.props.allUsers.data)) {
                console.log('done')
            } else {
            console.log('Not done')     
            }
            // nextPageUrl.value =  page.props.allUsers.links.next
        }
    })
}

</script>

<template>
    <FrameLayout>
        <div class="main-container">
            <div class="mt-8 flex justify-between md:gap-4 lg:gap-8 min-h-screen">
                <!-- Sidebar -->
                <div class="md:w-4/12 lg:w-3/12 hidden  md:block">
                    <SidebarFilter class="sticky top-24" />
                </div>
                <!-- Content Area -->
                <div class=" w-full md:w-8/12 lg:w-9/12">
                    <div class=" grid grid-flow-rows md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <template v-for="user in userCollection" :key="user.id">
                            <UserCard :userData="user" />
                        </template>
                        <!-- <pre>
                            {{ allUsers }}
                        </pre> -->
                    </div>
                    <!-- Load More -->
                    <div class="flex justify-center mt-8">
                        <button @click.prevent="loadMoreUser" v-if="nextPageUrl"
                            class="text-gray-900 hover:text-white border-2 border-gray-800 hover:bg-gray-900 focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center hidden md:block">
                            Load More
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </FrameLayout>
</template>

<style scoped>

</style>