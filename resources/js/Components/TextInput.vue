<script setup>

const props = defineProps({
    label: {
        type: String,
        default: "Input Field Label"
    }
})
</script>

<template>
    <div class="sm:col-span-3">
        <label for="DateOfBirth" class="inline-block text-sm font-medium text-gray-500 mt-2.5">
            Date Of Birth
        </label>
    </div>

    <div class="sm:col-span-9">
        <div class="sm:flex">
            <input id="DateOfBirth" type="text"
                class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px rounded-md text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
        </div>
    </div>
</template>

<style scoped>

</style>