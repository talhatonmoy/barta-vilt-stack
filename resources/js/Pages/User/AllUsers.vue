<script setup>
import { usePage, router, useForm } from '@inertiajs/vue3';
import { ref, reactive, onMounted, watch } from 'vue';
import UserCard from '../../Components/User/UserCard.vue';
import SidebarFilter from '../../Partials/AllUsers/SidebarFilter.vue';
const props = usePage().props;

const filterableUserDetails = props.filterableUserDetails;

const allUsers = ref(props.allUsers.data);

watch(usePage().props.allUsers.data, (newvalue) => {
    console.log(newvalue);
})

const initialUrl = usePage().url
const nextPageUrl = ref(props.allUsers.links.next)

function loadMoreItems() {
    if (!nextPageUrl.value) {
        return;
    }

    router.get(nextPageUrl.value, {}, {
        preserveState: true, 
        preserveScroll: true,
        onSuccess: (page) => {
            window.history.replaceState({}, '', initialUrl)
            allUsers.value.push(...page.props.allUsers.data)
            nextPageUrl.value = page.props.allUsers.links.next
        }
    })
}

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            loadMoreItems()
        }
    })
}, {
    rootMargin: '0px 0px 150px 0px'
})

const landMark = ref(null);

onMounted(() => {
    observer.observe(landMark.value)
})





/**
 * Child Component state
 * <SidebarFilter/>
 */
const filterMechanism = reactive({
    form: {},
    performSearch() {
        // this.form.get(route('users.list'), {
        //     data: {
        //         city: this.form.city,
        //         gender: this.form.gender,
        //         primaryLang: this.form.primaryLang
        //     },
        // })
        router.visit(route('users.list'),
            {
                method: 'get',
                data: {
                    city: this.form.city,
                    gender: this.form.gender,
                    primaryLang: this.form.primaryLang
                },
                preserveState: true,
                onSuccess: (page) => {
                    // Update allUsers with filtered data
                    allUsers.value = page.props.allUsers.data;
                    // Update next page URL as well
                    nextPageUrl.value = page.props.allUsers.links.next; 
                }
            }
        )
    },
    reset() {
        router.visit(route('users.list'))
    }

})






</script>

<template>
    <div class="main-container">
        <div class="mt-8 flex justify-between md:gap-4 lg:gap-8 min-h-screen">
            <!-- Sidebar -->
            <div class="md:w-4/12 lg:w-3/12 hidden  md:block">
                <SidebarFilter class="sticky top-24" :filterableData="filterableUserDetails"
                    :filterMechanism="filterMechanism" />
            </div>
            <!-- Content Area -->
            <div class=" w-full md:w-8/12 lg:w-9/12">
                <div class=" grid grid-flow-rows md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <template v-for="user in allUsers" :key="user.id">
                        <UserCard :userData="user" />
                    </template>
                </div>
                <!-- Load More -->
                <div ref="landMark"></div>
                <!-- <div class="flex justify-center mt-8">
                    <button @click.prevent="loadMoreItems" 
                        class="text-gray-900 hover:text-white border-2 border-gray-800 hover:bg-gray-900 focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center hidden md:block">
                        Load More
                    </button>
                </div> -->
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>