<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import MazPicker from 'maz-ui/components/MazPicker'
import MazCheckbox from 'maz-ui/components/MazCheckbox';
import MazBtn from 'maz-ui/components/MazBtn';

const props = defineProps({
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

const form = useForm({
    opening_hours: {
        monday: {
            from: props.openingHours.monday.from,
            to: props.openingHours.monday.to,
            is_active: props.openingHours.monday.is_active
        },
        tuesday: {
            from: props.openingHours.tuesday.from,
            to: props.openingHours.tuesday.to,
            is_active: props.openingHours.tuesday.is_active
        },
        wednesday: {
            from: props.openingHours.wednesday.from,
            to: props.openingHours.wednesday.to,
            is_active: props.openingHours.wednesday.is_active
        },
        thursday: {
            from: props.openingHours.thursday.from,
            to: props.openingHours.thursday.to,
            is_active: props.openingHours.thursday.is_active
        },
        friday: {
            from: props.openingHours.friday.from,
            to: props.openingHours.friday.to,
            is_active: props.openingHours.friday.is_active
        },
        saturday: {
            from: props.openingHours.saturday.from,
            to: props.openingHours.saturday.to,
            is_active: props.openingHours.saturday.is_active
        },
        sunday: {
            from: props.openingHours.sunday.from,
            to: props.openingHours.sunday.to,
            is_active: props.openingHours.sunday.is_active
        },
    },
});

const updateOpeningHours = () => {
    form.patch(route('restaurant.info.update.opening.hours', usePage().props.currentLocale), {
        preserveScroll: true,
        preserveState: (page) => Object.keys(page.props.errors).length,
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Opening Hours</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ props.openingInfo }}
            </p>
        </header>

        <form @submit.prevent="updateOpeningHours" class="mt-6 space-y-6">
            <div v-for="(value, key) in form.opening_hours" class="grid grid-cols-3 gap-4 items-center">
                <div class="flex items-center">
                    <MazCheckbox
                        v-model="value.is_active"
                        size="mini"
                    >
                        {{ key }}
                    </MazCheckbox>
                </div>
                <div>
                    <MazPicker
                        v-model="value.from"
                        format="HH:mm"
                        label="From"
                        color="primary"
                        locale="de"
                        only-time
                    />
                </div>
                <div>
                    <MazPicker
                        v-model="value.to"
                        format="HH:mm"
                        label="To"
                        color="primary"
                        only-time
                    />
                </div>
            </div>

            <div class="flex items-center gap-4">
<!--                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>-->
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
