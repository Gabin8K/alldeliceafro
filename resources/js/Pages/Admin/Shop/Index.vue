<script setup>
import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
import {Head, router, useForm, usePage} from '@inertiajs/vue3';
import { h, ref } from 'vue'
import TableTanstack from "@/Components/TableTanstack.vue";
import EditDeleteButton from "@/Pages/Admin/Shop/Partials/EditDeleteButton.vue";
import MazDialog from 'maz-ui/components/MazDialog';
import MazBtn from 'maz-ui/components/MazBtn';
import MazInput  from 'maz-ui/components/MazInput';
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import InputError from "@/Components/InputError.vue";

defineProps({
    shops: {
        type: Object,
    }
});

const MAX_IMAGES = 1;

const isOpenCreateShopModal = ref(false)

const uploadingImages = ref(false)

const form = useForm({
    name: '',
    description_en: '',
    description_fr: '',
    description_de: '',
    images: []
});

const CreateShopImageFilePond = vueFilePond(
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
        accessorKey: 'name',
        header: 'Name',
    },
    // {
    //     accessorKey: 'slug',
    //     header: 'Slug',
    // },
    // {
    //     accessorKey: 'created_at',
    //     header: 'Created',
    //     cell: info => format(new Date(info.getValue()), 'MMM d, yyyy'),
    // },
    {
        accessorKey: 'edit',
        header: 'Actions',
        cell: ({ row }) => h(EditDeleteButton, { id: row.original.id }),
        enableSorting: false,
    },
];

const createShop = () => {
    form.post(route('admin.shops.store', usePage().props.currentLocale), {
        preserveScroll: true,
        preserveState: (page) => Object.keys(page.props.errors).length
    })
}

function eventCreateShopModalClose() {
    form.reset();
    form.clearErrors();
    uploadingImages.value = false;
}

function handleFilePondProcessCreateShop(response) {
    form.images.push(response);
    return response;
}

function handleFilePondRevertCreateShop(uniqueId, load, error) {
    form.images = form.images.filter((image) => image !== uniqueId);
    router.delete('/en/delete-tmp/' + uniqueId);
    load();
}

function setLoading(isUploading) {
    uploadingImages.value = isUploading;
}
</script>
<template>
    <Head title="Shops" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Shops</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg sm:relative">
                    <div class="ms-4 sm:ms-6 lg:ms-8 mt-5 sm:absolute sm:top-0.5">
                        <MazBtn
                            @click="isOpenCreateShopModal = true"
                            outline
                        >
                            Create shop
                        </MazBtn>
                    </div>
                    <div class="pb-6">
                        <TableTanstack
                            :data="shops"
                            :columns="columns"
                        />
                    </div>
                </div>
            </div>
        </div>

        <MazDialog
            v-model="isOpenCreateShopModal"
            title="Create shop"
            width="800px"
            maxHeight="80vh"
            scrollable
            @close="eventCreateShopModalClose()"
        >
            <form @submit.prevent="createShop" class="space-y-6">
                <div>
                    <MazInput
                        v-model="form.name"
                        label="Name"
                        required
                    />
                    <InputError class="mt-1" :message="form.errors.name" />
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

                <CreateShopImageFilePond
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
                            onload: handleFilePondProcessCreateShop
                        },
                        revert: handleFilePondRevertCreateShop,
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
