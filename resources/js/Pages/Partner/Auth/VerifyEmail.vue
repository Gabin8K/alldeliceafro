<script setup>
import GuestLayout from '@/Layouts/Partner/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';

const props = defineProps({
    user_id: {
        type: String,
        required: true,
    },
    success: {
        type: String,
    },
    error: {
        type: String,
    },
});

const form = useForm({
    user_id: props.user_id,
    verification_code: '',
});

const submit = () => {
    form.post(route('partner.verify.email.store', usePage().props.currentLocale));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <div class="mb-4 text-md text-gray-600 dark:text-gray-400">
            Please enter the verification code you received per email.
        </div>

        <div v-if="success" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ success }}
        </div>

        <div v-if="error" class="mb-4 font-medium text-sm text-red-600 dark:text-red-400">
            {{ error }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="verification_code" value="Verification code" />

                <TextInput
                    id="verification_code"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.verification_code"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.verification_code" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('partner.verify.email.request', [$page.props.currentLocale, props.user_id])"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    Request new verification code
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Verify
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
