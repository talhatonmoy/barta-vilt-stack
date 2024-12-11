import { usePage } from "@inertiajs/vue3"
import {ref} from 'vue'

export function useInfiniteScroll(allData) {
    const items = ref(allData.data)
    const nextPageUrl = ref(allData.links.next)

    const initialUrl = usePage().url

    //Load More Posts
    function loadMoreItems() {
        if (!nextPageUrl.value) return;

        router.get(nextPageUrl.value, {}, {
            preserveState: true,
            preserveScroll: true,
            onSuccess: (page) => {
                window.history.replaceState({}, '', initialUrl)
                items.value.push(...page.props.propCollectionName.data)
                nextPageUrl.value = page.props.propCollectionName.links.next
            }
        })
    }

    return {
        items,
        loadMoreItems
    }
}