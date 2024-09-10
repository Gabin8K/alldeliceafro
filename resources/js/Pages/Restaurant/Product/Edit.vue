<script setup>
import AuthenticatedLayout from '@/Layouts/Restaurant/AuthenticatedLayout.vue';
import {Head, router, useForm, usePage} from '@inertiajs/vue3';
import { h, ref } from 'vue'
import TableTanstack from "@/Components/TableTanstack.vue";
import EditDeleteButton from "@/Pages/Restaurant/Product/Partials/EditDeleteButton.vue";
import { format } from 'date-fns';
import MazDialog from 'maz-ui/components/MazDialog';
import MazBtn from 'maz-ui/components/MazBtn';
import MazTextarea from 'maz-ui/components/MazTextarea';
import MazInput  from 'maz-ui/components/MazInput';
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";

defineProps({
    products: {
        type: Object,
    }
});

const MAX_PRODUCT_IMAGES = 3;

const isOpenCreateProductModal = ref(false)

const uploadingImages = ref(false)

const form = useForm({
    name: '',
    price: '',
    description: '',
    images: []
});

const CreateProductImageFilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);

const productsColumns = [
    {
        accessorKey: 'id',
        header: 'ID',
        enableSorting: false,
    },
    {
        accessorKey: 'name',
        header: 'Name',
    },
    {
        accessorKey: 'price',
        header: 'Price',
    },
    {
        accessorKey: 'created_at',
        header: 'Created',
        cell: info => format(new Date(info.getValue()), 'MMM d, yyyy'),
    },
    {
        accessorKey: 'edit',
        header: 'Actions',
        cell: ({ row }) => h(EditDeleteButton, { id: row.original.id }),
        enableSorting: false,
    },
];

const createProduct = () => {
    form.post(route('restaurant.products.store', usePage().props.currentLocale), {
        preserveScroll: true,
        preserveState: (page) => Object.keys(page.props.errors).length
    })
}

function eventCreateProductModalClose() {
    form.reset();
    form.clearErrors();
    uploadingImages.value = false;
}

function handleFilePondProcessCreateProduct(response) {
    form.images.push(response);
    return response;
}

function handleFilePondRevertCreateProduct(uniqueId, load, error) {
    form.images = form.images.filter((image) => image !== uniqueId);
    router.delete('/en/delete-tmp/' + uniqueId);
    load();
}

function setLoading(isUploading) {
    uploadingImages.value = isUploading;
}
</script>
<template>
    <Head title="Product" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Products</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg sm:relative">
                    <div class="ms-4 sm:ms-6 lg:ms-8 mt-5 sm:absolute sm:top-0.5">
                        <MazBtn
                            @click="isOpenCreateProductModal = true"
                            outline
                        >
                            Create product
                        </MazBtn>
                    </div>
                    <div class="pb-6">
                        <TableTanstack
                            :data="products"
                            :columns="productsColumns"
                        />
                    </div>
                </div>
            </div>
        </div>

        <MazDialog
            v-model="isOpenCreateProductModal"
            title="Create product"
            width="800px"
            maxHeight="80vh"
            scrollable
            @close="eventCreateProductModalClose()"
        >
            <form @submit.prevent="createProduct" class="space-y-6">
                <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-3 sm:col-span-2">
                        <MazInput
                            v-model="form.name"
                            label="Name"
                            class="focus:ring-amber-600"
                            required
                        />
                    </div>
                    <div class="col-span-3 sm:col-span-1">
                        <MazInput
                            v-model="form.price"
                            label="Price"
                            type="number"
                            required
                        />
                    </div>
                </div>

                <MazTextarea
                    v-model="form.description"
                    label="Description"
                    required
                />

                <CreateProductImageFilePond
                    name="image"
                    ref="pond"
                    :label-idle="'Drop images here... Max: ' + MAX_PRODUCT_IMAGES"
                    class="cursor-pointer"
                    :allow-multiple="true"
                    :maxFiles="MAX_PRODUCT_IMAGES"
                    accepted-file-types="image/jpeg, image/png, image/jpg"
                    @initfile="setLoading(true)"
                    @processfilestart="setLoading(true)"
                    @processfiles="setLoading(false)"
                    :server="{
                        url: '',
                        process: {
                            url: '/en/upload-tmp',
                            method: 'POST',
                            onload: handleFilePondProcessCreateProduct
                        },
                        revert: handleFilePondRevertCreateProduct,
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
