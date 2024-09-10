<script setup>
import InputError from '@/Components/InputError.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import MazPhoneNumberInput from 'maz-ui/components/MazPhoneNumberInput';
import MazBtn from 'maz-ui/components/MazBtn';
import MazInput from 'maz-ui/components/MazInput';
import MazSelect from 'maz-ui/components/MazSelect';

defineProps({
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    phone: user.restaurant.phone ?? '',
    address: user.restaurant.address ?? '',
    shipping: user.restaurant.shipping ?? '',
});

const shippingOptions = [
    { value: 'a', label: 'A'},
    { value: 'b', label: 'B'},
    { value: 'c', label: 'C'},
];

function updateInfo() {
    form.patch(route('restaurant.info.update', usePage().props.currentLocale), {
        preserveScroll: true,
        preserveState: (page) => Object.keys(page.props.errors).length
    })
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Restaurant Information</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your restaurant's information and email address.
            </p>
        </header>

        <form @submit.prevent="updateInfo" class="mt-6 space-y-6">
            <div>
                <MazPhoneNumberInput
                    id="phone"
                    v-model="form.phone"
                    show-code-on-list
                    no-validation-success
                    no-search
                    no-flags
                    :only-countries="['DE']"
                    :valid-button="user.restaurant.phone_verified_at !== null"
                    required
                />
                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div>
                <MazInput
                    v-model="form.address"
                    label="Address"
                    placeholder="Teststraße. 11, 11111 Test"
                    autocomplete="address"
                    required
                />

                <InputError class="mt-2" :message="form.errors.address" />
            </div>

            <div class="mt-4">
                <MazSelect
                    v-model="form.shipping"
                    label="Shipping"
                    :options="shippingOptions"
                />
                <InputError class="mt-2" :message="form.errors.shipping" />
            </div>

            <div class="flex items-center gap-4">
                <MazBtn
                    :disabled="form.processing || !form.isDirty"
                    type="submit"
                >
                    Save
                </MazBtn>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
