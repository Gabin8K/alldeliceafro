<script setup>
import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
import {Head, router, useForm, usePage} from '@inertiajs/vue3';
import {h, ref} from 'vue'
import TableTanstack from "@/Components/TableTanstack.vue";
import EditDeleteButton from "@/Pages/Admin/Article/Partials/EditDeleteButton.vue";
import MazDialog from 'maz-ui/components/MazDialog';
import MazBtn from 'maz-ui/components/MazBtn';
import MazInput from 'maz-ui/components/MazInput';
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import InputError from "@/Components/InputError.vue";
import MazInputNumber from 'maz-ui/components/MazInputNumber';
import MazSelect from 'maz-ui/components/MazSelect';
import MazTextarea from 'maz-ui/components/MazTextarea';

const props = defineProps({
    categories: {
        type: Object,
    },
    articles: {
        type: Object,
    }
});

const MAX_IMAGES = 3;

const isOpenCreateArticleModal = ref(false)

const uploadingImages = ref(false)

const form = useForm({
    category_id: null,
    name_en: '',
    name_fr: '',
    name_de: '',
    description_en: '',
    description_fr: '',
    description_de: '',
    weight: null,
    images: []
});

const CreateArticleImageFilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);

const columns = [
    // {
    //     accessorKey: 'id',
    //     header: 'ID',
    //     enableSorting: false,
    // },
    {
        accessorKey: 'name_en',
        header: 'Name (en)',
    },
    {
        accessorKey: 'name_fr',
        header: 'Name (fr)',
    },
    {
        accessorKey: 'name_de',
        header: 'Name (de)',
    },
    // {
    //     accessorKey: 'slug',
    //     header: 'Slug',
    // },
    {
        accessorKey: 'weight',
        header: 'Weight (g)',
    },
    // {
    //     accessorKey: 'created_at',
    //     header: 'Created',
    //     cell: info => format(new Date(info.getValue()), 'MMM d, yyyy'),
    // },
    {
        accessorKey: 'edit',
        header: 'Actions',
        cell: ({row}) => h(EditDeleteButton, {id: row.original.id, categories: props.categories}),
        enableSorting: false,
    },
];

const createArticle = () => {
    form.post(route('admin.articles.store', usePage().props.currentLocale), {
        preserveScroll: true,
        preserveState: (page) => Object.keys(page.props.errors).length
    })
}

function eventCreateArticleModalClose() {
    form.reset();
    form.clearErrors();
    uploadingImages.value = false;
}

function handleFilePondProcessCreateArticle(response) {
    form.images.push(response);
    return response;
}

function handleFilePondRevertCreateArticle(uniqueId, load, error) {
    form.images = form.images.filter((image) => image !== uniqueId);
    router.delete('/en/delete-tmp/' + uniqueId);
    load();
}

function setLoading(isUploading) {
    uploadingImages.value = isUploading;
}
</script>
<template>
    <Head title="Article"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Articles</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg sm:relative">
                    <div class="ms-4 sm:ms-6 lg:ms-8 mt-5 sm:absolute sm:top-0.5">
                        <MazBtn
                            @click="isOpenCreateArticleModal = true"
                            outline
                        >
                            Create article
                        </MazBtn>
                    </div>
                    <div class="pb-6">
                        <TableTanstack
                            :data="articles"
                            :columns="columns"
                        />
                    </div>
                </div>
            </div>
        </div>

        <MazDialog
            v-model="isOpenCreateArticleModal"
            title="Create article"
            width="800px"
            maxHeight="80vh"
            scrollable
            @close="eventCreateArticleModalClose()"
        >
            <form @submit.prevent="createArticle" class="space-y-6">
                <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-3 md:col-span-1">
                        <MazInput
                            v-model="form.name_en"
                            label="Name (en)"
                            required
                        />
                        <InputError class="mt-1" :message="form.errors.name_en"/>
                    </div>

                    <div class="col-span-3 md:col-span-1">
                        <MazInput
                            v-model="form.name_fr"
                            label="Name (fr)"
                        />
                        <InputError class="mt-1" :message="form.errors.name_fr"/>
                    </div>

                    <div class="col-span-3 md:col-span-1">
                        <MazInput
                            v-model="form.name_de"
                            label="Name (de)"
                        />
                        <InputError class="mt-1" :message="form.errors.name_de"/>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="col-span-2 md:col-span-1">
                        <MazInputNumber
                            v-model="form.weight"
                            label="Weight (g)"
                            :min="0"
                            :step="1"
                            style="width: 100%"
                            required
                        />
                        <InputError class="mt-1" :message="form.errors.weight"/>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <MazSelect
                            label="Select category"
                            v-model="form.category_id"
                            :options="categories"
                            option-value-key="id"
                            :option-label-key="'name_' + $page.props.currentLocale"
                            :option-input-value-key="'name_' + $page.props.currentLocale"
                            search
                            required
                        />
                        <InputError class="mt-1" :message="form.errors.category_id"/>
                    </div>
                </div>

                <div>
                    <MazTextarea
                        v-model="form.description_en"
                        label="Description (en)"
                    />
                    <InputError class="mt-1" :message="form.errors.description_en"/>
                </div>

                <div>
                    <MazTextarea
                        v-model="form.description_fr"
                        label="Description (fr)"
                    />
                    <InputError class="mt-1" :message="form.errors.description_fr"/>
                </div>

                <div>
                    <MazTextarea
                        v-model="form.description_de"
                        label="Description (de)"
                    />
                    <InputError class="mt-1" :message="form.errors.description_de"/>
                </div>

                <CreateArticleImageFilePond
                    name="image"
                    ref="pond"
                    :label-idle="'Drop images here... Max: ' + MAX_IMAGES"
                    class="cursor-pointer"
                    :allow-multiple="true"
                    :maxFiles="MAX_IMAGES"
                    :required="true"
                    accepted-file-types="image/jpeg, image/png, image/jpg"
                    @initfile="setLoading(true)"
                    @processfilestart="setLoading(true)"
                    @processfiles="setLoading(false)"
                    :server="{
                        url: '',
                        process: {
                            url: '/en/upload-tmp',
                            method: 'POST',
                            onload: handleFilePondProcessCreateArticle
                        },
                        revert: handleFilePondRevertCreateArticle,
                        headers: {
                            'X-CSRF-TOKEN': $page.props.csrf_token
                        }
                    }"
                />

                <MazBtn
                    type="submit"
                    :disabled="form.processing || uploadingImages || !form.isDirty"
                    block
                >
                    Save
                </MazBtn>
            </form>
        </MazDialog>
    </AuthenticatedLayout>
</template>
