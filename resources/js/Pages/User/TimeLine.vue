<script setup>
import { router, usePage } from '@inertiajs/vue3';
import CreatePostCard from '../../Components/CreatePostCard.vue';
import PostCard from '../../Components/PostCard.vue';
import { onMounted, ref } from 'vue';
import LeftUserOverview from '../../Partials/Timeline/LeftUserOverview.vue';
import RightSide from '../../Partials/Timeline/RightSide.vue';

const props = usePage().props
const userData = props.userData

const timelinePostCollection = ref(props.timelinePostsData.data)
const nextPageUrl = ref(props.timelinePostsData.links.next)

const initialUrl = usePage().url

//Load More Posts
function loadMoreItems() {
    if (!nextPageUrl.value) return; 

    router.get(nextPageUrl.value, {}, {
        preserveState: true,
        preserveScroll: true, 
        onSuccess: (page) => {
            window.history.replaceState({}, '', initialUrl)
            timelinePostCollection.value.push(...page.props.timelinePostsData.data)
            nextPageUrl.value = page.props.timelinePostsData.links.next
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

</script>

<template>
    <div class="flex max-w-7xl gap-6 md:gap-3 mx-auto px-4 pt-8 sm:px-6 lg:px-8">
        <!-- Left part -->
        <div class=" hidden md:block lg:block  w-3/12">
            <LeftUserOverview :userData="userData" class="sticky top-24" />
        </div>

        <!-- Main section -->
        <div class="container md:w-9/12 lg:w-6/12 max-w-7xl mx-auto space-y-8 min-h-screen">
            <main class="container mx-auto space-y-5 min-h-screen">
                <!-- Create Post Card -->
                <CreatePostCard rows="2" />

                <!-- User Specific Posts Feed -->
                <template v-for="post in timelinePostCollection" :key="post.uuid">
                    <PostCard :post="post" />
                </template>

                <!-- LoadMore LandMark -->
                <div ref="landMark"></div>
            </main>
        </div>

        <!-- Right Part -->
        <div class=" hidden lg:block w-3/12">
            <RightSide class="sticky top-24" />
        </div>
    </div>
</template>

<style scoped></style>