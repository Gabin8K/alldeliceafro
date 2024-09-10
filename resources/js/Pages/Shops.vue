<script setup>
import {Head} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import { vFullscreenImg } from 'maz-ui'

defineProps({
    city: {
        type: String,
    },
    shops: {
        type: Object,
    }
});

// console.log(shops)
</script>

<template>
    <Head title="Shops" />

    <AppLayout>
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <p class="text-2xl font-semibold">Shops. {{ city }}</p>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mt-6">
                <div v-for="shop in shops"
                     class="bg-white p-4 rounded-xl shadow-md hover:cursor-pointer hover:scale-105 transform transition duration-200"
                >
                    <div class="overflow-hidden hover:cursor-pointer">
                        <img
                            v-fullscreen-img
                            class="hover:scale-105 transform transition duration-200 h-52 object-cover"
                            :src="shop.image.url"
                            alt=""
                        >
                    </div>
                    <div class="text-xl font-bold mt-3">{{ shop.name }}</div>
                    <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laborum, voluptatum.</small>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
