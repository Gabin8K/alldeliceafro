<script setup>
import AuthenticatedLayout from '@/Layouts/Restaurant/AuthenticatedLayout.vue';
import UpdateOpeningHoursForm from './Partials/UpdateOpeningHoursForm.vue';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import UpdateInfoForm from "@/Pages/Restaurant/Info/Partials/UpdateInfoForm.vue";
import {ref} from "vue";
import MazDialog from 'maz-ui/components/MazDialog';
import MazInputCode from 'maz-ui/components/MazInputCode';
import InputError from "@/Components/InputError.vue";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    openingInfo: {
        type: String
    },
    openingHours: {
        type: Object
    }
});

const shouldVerifyPhoneNumber = ref(usePage().props.auth.user.restaurant.phone !== null && usePage().props.auth.user.restaurant.phone_verified_at === null);
const form = useForm({
    code: '',
});

function verify() {
    form.post(route('verify.phone.number', usePage().props.currentLocale), {
        preserveScroll: true,
        preserveState: (page) => Object.keys(page.props.errors).length,
        onSuccess: () => {
            form.reset();
            shouldVerifyPhoneNumber.value = false;
        }
    })
}
</script>

<template>
    <Head title="Info" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Info</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 grid grid-cols-1 lg:grid-cols-2 lg:space-x-6 lg:items-start lg:space-y-0">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <UpdateInfoForm
                        class=""
                    />
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <UpdateOpeningHoursForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        :opening-info="openingInfo"
                        :opening-hours="openingHours"
                        class=""
                    />
                </div>
            </div>
        </div>

        <MazDialog
            v-model="shouldVerifyPhoneNumber"
            title="Please verify your number"
        >
            <form @submit.prevent="verify" class="space-y-6">
                <MazInputCode
                    v-model="form.code"
                    size="xs"
                    @completed="verify"
                    required
                />
                <InputError :message="form.errors.code" />

                <div class="flex items-center justify-end gap-4">
                    <div>
                        <a
                            :href="route('get.sms.code', $page.props.currentLocale)"
                            class="underline"
                        >
                            Resend verification code?
                        </a>
                    </div>
                    <MazBtn type="submit">
                        Verify
                    </MazBtn>
                </div>
            </form>
        </MazDialog>
    </AuthenticatedLayout>
</template>
