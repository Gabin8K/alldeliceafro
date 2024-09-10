<script setup>
import GuestLayout from '@/Layouts/Partner/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';

const form = useForm({
    firstname: '',
    lastname: '',
    // partner_phone: '',
    email: '',
    partner_name: '',
    // partner_address: '',
    partner_type: '',
    // partner_shipping: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('partner.register.store', usePage().props.currentLocale), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="firstname" value="Firstname" />

                <TextInput
                    id="firstname"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.firstname"
                    required
                    autocomplete="firstname"
                />

                <InputError class="mt-2" :message="form.errors.firstname" />
            </div>

            <div class="mt-4">
                <InputLabel for="lastname" value="Lastname" />

                <TextInput
                    id="lastname"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.lastname"
                    required
                    autocomplete="lastname"
                />

                <InputError class="mt-2" :message="form.errors.lastname" />
            </div>

<!--            <div class="mt-4">
                <InputLabel for="partner_phone" value="Partner phone" />

                <TextInput
                    id="partner_phone"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.partner_phone"
                    required
                    autocomplete="partner_phone"
                />

                <InputError class="mt-2" :message="form.errors.partner_phone" />
            </div>-->

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="email"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="partner_name" value="Partner name" />

                <TextInput
                    id="partner_name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.partner_name"
                    required
                    autocomplete="partner_name"
                />

                <InputError class="mt-2" :message="form.errors.partner_name" />
            </div>

<!--            <div class="mt-4">
                <InputLabel for="partner_address" value="Partner address" />

                <TextInput
                    id="partner_address"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.partner_address"
                    required
                    autocomplete="partner_address"
                />

                <InputError class="mt-2" :message="form.errors.partner_address" />
            </div>-->

            <div class="mt-4">
                <InputLabel for="partner_type" value="Partner type" />

                <select
                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
                    id="partner_type"
                    v-model="form.partner_type"
                    required
                >
                    <option disabled value="">Please select one</option>
                    <option value="restaurant">Restaurant</option>
<!--                    <option value="store">Store</option>-->
                </select>

                <InputError class="mt-2" :message="form.errors.partner_type" />
            </div>

<!--            <div class="mt-4">
                <InputLabel for="partner_shipping" value="Partner shipping" />

                <select
                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full"
                    id="partner_shipping"
                    v-model="form.partner_shipping"
                    required
                >
                    <option disabled value="">Please select one</option>
                    <option value="a">A</option>
                    <option value="b">B</option>
                    <option value="c">C</option>
                </select>

                <InputError class="mt-2" :message="form.errors.partner_shipping" />
            </div>-->

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('partner.login', $page.props.currentLocale)"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    Already registered?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
