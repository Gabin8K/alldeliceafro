<script setup>
import {ref} from 'vue'
import MazDialog from 'maz-ui/components/MazDialog'
import MazBtn from 'maz-ui/components/MazBtn'
import MazTextarea from 'maz-ui/components/MazTextarea'
import MazInput from 'maz-ui/components/MazInput'
import {vFullscreenImg} from 'maz-ui'
import {router, useForm, usePage} from "@inertiajs/vue3";
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    id: Number,
})

const MAX_PRODUCT_IMAGES = 3;

const isOpenEditProductModal = ref(false)
const images = ref([]);
const max_upload = ref(MAX_PRODUCT_IMAGES);

const isOpenDeleteImageModal = ref(false)
const toDeletedImageId = ref(null)

const isOpenDeleteProductModal = ref(false)

const uploadingImages = ref(false)

const form = useForm({
    name: '',
    price: '',
    description: '',
    images: []
});

const UpdateProductImageFilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);

function handleFilePondProcess(response) {
    form.images.push(response);
    return response;
}

function handleFilePondRevert(uniqueId, load, error) {
    form.images = form.images.filter((image) => image !== uniqueId);
    router.delete('/en/delete-tmp/' + uniqueId);
    load();
}

function openEditProductModal() {
    axios.get('products/' + props.id)
        .then(response => {
            form.name = response.data.name
            form.price = response.data.price
            form.description = response.data.description
            images.value = response.data.images
            max_upload.value -= response.data.images.length
            isOpenEditProductModal.value = true
        })
}

function eventEditProductModalClose() {
    form.reset();
    form.clearErrors();
    images.value = [];
    max_upload.value = MAX_PRODUCT_IMAGES;
    uploadingImages.value = false;
}

function openDeleteImageModal(imageId) {
    toDeletedImageId.value = imageId;
    isOpenDeleteImageModal.value = true;
}

function deleteImage() {
    router.delete(route('delete.image', [usePage().props.currentLocale, toDeletedImageId.value]));
    images.value = images.value.filter((image) => image.id !== toDeletedImageId.value);
    max_upload.value = MAX_PRODUCT_IMAGES - images.value.length;
    isOpenDeleteImageModal.value = false;
}

function eventDeleteImageModalClose() {
    toDeletedImageId.value = null;
}

function deleteProduct() {
    router.delete(route('restaurant.products.delete', [usePage().props.currentLocale, props.id]), {
        preserveScroll: true,
        preserveState: (page) => Object.keys(page.props.errors).length,
        onSuccess: () => isOpenDeleteProductModal.value = false
    });
}

function updateProduct() {
    form.patch(route('restaurant.products.update', [usePage().props.currentLocale, props.id]), {
        preserveScroll: true,
        preserveState: (page) => Object.keys(page.props.errors).length,
        onSuccess: () => isOpenEditProductModal.value = false
    });
}

function setLoading(isUploading) {
    uploadingImages.value = isUploading;
}
</script>

<template>
    <div class="flex items-center justify-end gap-x-2 md:gap-x-4">
        <div @click="openEditProductModal()"
             class="hover:text-indigo-500 cursor-pointer"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
            </svg>
        </div>
        <div @click="isOpenDeleteProductModal = true"
             class="hover:text-red-500 cursor-pointer"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
            </svg>
        </div>
    </div>

    <MazDialog
        v-model="isOpenDeleteProductModal"
        title="Delete product"
    >
        <p>
            Are you sure you want to delete this product?
        </p>
        <template #footer="{ close }">
            <MazBtn
                @click="close"
                color="danger"
                class="mr-2"
                outline
            >
                Cancel
            </MazBtn>
            <MazBtn @click="deleteProduct">
                Confirm
            </MazBtn>
        </template>
    </MazDialog>

    <MazDialog
        v-model="isOpenEditProductModal"
        title="Edit product"
        width="800px"
        maxHeight="80vh"
        scrollable
        @close="eventEditProductModalClose()"
    >
        <form @submit.prevent="updateProduct" class="space-y-6">
            <div class="grid grid-cols-3 gap-6">
                <div class="col-span-3 sm:col-span-2">
                    <MazInput
                        v-model="form.name"
                        label="Name"
                        class="focus:ring-amber-600"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.name"/>
                </div>
                <div class="col-span-3 sm:col-span-1">
                    <MazInput
                        v-model="form.price"
                        label="Price"
                        type="number"
                        required
                    />
                    <InputError class="mt-2" :message="form.errors.price"/>
                </div>
            </div>

            <MazTextarea
                v-model="form.description"
                label="Description"
                required
            />
            <InputError class="mt-2" :message="form.errors.description"/>

            <div v-if="images.length > 0" class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div v-for="image in images"
                     class="relative rounded-xl overflow-hidden hover:scale-105 transform transition duration-200 w-fit">
                    <div @click="openDeleteImageModal(image.id)"
                         class="absolute top-2 right-2 bg-red-500 rounded-full p-1 cursor-pointer hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-5 h-5 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                        </svg>
                    </div>

                    <img
                        v-fullscreen-img
                        :src="image.url"
                        alt="image"
                    />
                </div>
            </div>

            <MazDialog
                v-model="isOpenDeleteImageModal"
                title="Delete image"
                @close="eventDeleteImageModalClose()"
            >
                <p>
                    Are you sure you want to delete this image?
                </p>
                <template #footer="{ close }">
                    <MazBtn
                        @click="close"
                        color="danger"
                        class="mr-2"
                        outline
                    >
                        Cancel
                    </MazBtn>
                    <MazBtn @click="deleteImage">
                        Confirm
                    </MazBtn>
                </template>
            </MazDialog>

            <UpdateProductImageFilePond
                :class="{
                    'cursor-pointer': max_upload > 0,
                    'cursor-no-drop': max_upload <= 0,
                    'mb-0': true
                }"
                name="image"
                ref="pond"
                :label-idle="'Drop images here... Max: ' + max_upload"
                accepted-file-types="image/jpeg, image/png, image/jpg"
                :allow-multiple="true"
                :maxFiles="max_upload"
                :disabled="max_upload <= 0"
                :required="max_upload >= MAX_PRODUCT_IMAGES"
                @initfile="setLoading(true)"
                @processfilestart="setLoading(true)"
                @processfiles="setLoading(false)"
                :server="{
                        process: {
                            url: '/en/upload-tmp',
                            method: 'POST',
                            onload: handleFilePondProcess
                        },
                        revert: handleFilePondRevert,
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
</template>
