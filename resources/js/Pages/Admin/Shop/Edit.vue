<script setup>
import {Head, useForm, usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/Admin/AuthenticatedLayout.vue";
import MazBtn from 'maz-ui/components/MazBtn';
import { vFullscreenImg } from 'maz-ui'
import {ref} from "vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    shop: {
        type: Object,
    },
    articles: {
        type: Object,
    }
});

const isOpenStoreArticleModal = ref(false);
let isEdit = false;
let labelOption = [];

const form = useForm({
    article_id: '',
    price: '',
});

const getArticlesDropdown = () => {
    if (isEdit) {
        return labelOption;
    }

    const result = [];
    const articles = props.articles;
    for (let i = 0, len = articles.length; i < len; i++) {
        const article = articles[i];
        result.push({
            valueOption: article.id,
            labelOption: article.name_en,
            inputLabel: article.name_en
        });
    }
    return result;
}

function eventCreateShopModalClose() {
    form.reset();
    form.clearErrors();
    isEdit = false
    labelOption = []
}

function openEditModal(article) {
    form.article_id = article.id
    form.price = article.pivot.price
    isEdit = true
    labelOption.push({
        valueOption: article.id,
        labelOption: article.name_en,
        inputLabel: article.name_en,
        isSelected: true
    })
    isOpenStoreArticleModal.value = true
}

const storeEditArticle = () => {
    if (isEdit) {
        form.patch(route('admin.shops.update.article', [usePage().props.currentLocale, props.shop.id]), {
            preserveScroll: true,
            preserveState: (page) => Object.keys(page.props.errors).length
        })
    } else {
        form.post(route('admin.shops.store.article', [usePage().props.currentLocale, props.shop.id]), {
            preserveScroll: true,
            preserveState: (page) => Object.keys(page.props.errors).length
        })
    }
}

const deleteArticle = (article) => {
    form.article_id = article.id
}
</script>

<template>
    <Head title="Shop" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ shop.name }}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <div class="">
                        <MazBtn
                            @click="isOpenStoreArticleModal = true"
                            outline
                        >
                            Add Article
                        </MazBtn>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                <div v-for="article in shop.articles" class="bg-white p-4 rounded-xl shadow-md">
                    <div class="overflow-hidden hover:cursor-pointer">
                        <img
                            v-fullscreen-img
                            class="hover:scale-105 transform transition duration-200 h-32 object-cover"
                            :src="article.images[0].url"
                            :alt="article.images[0].name"
                        >
                    </div>
                    <div class="text-xl font-bold mt-3">{{ article.name_en }}</div>
                    <small>{{ article.description_en }}</small>
                    <div class="mt-2 flex justify-between items-center">
                        <div class="text-2xl font-extrabold">{{ article.pivot.price }}€</div>
                        <div class="flex gap-3">
                            <div @click="openEditModal(article)"
                                 class="cursor-pointer hover:text-blue-500"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                            </div>
                            <div @click="deleteArticle(article)"
                                 class="cursor-pointer hover:text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <MazDialog
            v-model="isOpenStoreArticleModal"
            title="Add article"
            width="800px"
            maxHeight="80vh"
            scrollable
            @close="eventCreateShopModalClose()"
        >
            <form @submit.prevent="storeEditArticle" class="space-y-6">
                <div>
                    <MazSelect
                        v-model="form.article_id"
                        label="Select an item"
                        :options="getArticlesDropdown()"
                        option-value-key="valueOption"
                        option-label-key="labelOption"
                        option-input-value-key="inputLabel"
                        search
                        maxListWidth="fitt"
                        required
                    >
                        <template #no-results>
                            <div class="p-4 text-center">
                                No result
                            </div>
                        </template>
                    </MazSelect>
                    <InputError class="mt-1" :message="form.errors.article_id" />
                </div>
                <div>
                    <MazInputNumber
                        v-model="form.price"
                        label="Price (in cent)"
                        min="0"
                        no-buttons
                        class="w-full"
                        :text-center="false"
                        required
                    />
                    <InputError class="mt-1" :message="form.errors.price" />
                </div>

                <MazBtn
                    type="submit"
                    :disabled="form.processing || !form.isDirty"
                    block
                >
                    Save
                </MazBtn>
            </form>
        </MazDialog>
    </AuthenticatedLayout>
</template>
