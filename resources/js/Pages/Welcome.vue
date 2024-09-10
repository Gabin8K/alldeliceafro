<script setup>
import {Head, useForm, usePage} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import MazSelect from 'maz-ui/components/MazSelect';
import MazBtn from 'maz-ui/components/MazBtn';
import InputError from "@/Components/InputError.vue";

const form = useForm({
    city: ''
});

const queryShops = () => {
    form.get(route('get.shops', usePage().props.currentLocale), {
        preserveScroll: true,
        preserveState: (page) => Object.keys(page.props.errors).length
    })
}

const available_cities = () => {
    const cities = [];
    const availableShopsCities = usePage().props.available_shops_cities;

    if (availableShopsCities && typeof availableShopsCities === 'object') {
        for (const [key, value] of Object.entries(availableShopsCities)) {
            cities.push({ valueOption: key, labelOption: value, inputLabel: value });
        }
    }

    return cities;
}
</script>

<template>
    <Head title="Welcome" />

    <AppLayout>
        <section class="bg-gray-100">
            <div class="xl:grid xl:grid-cols-2 xl:items-center">
                <div class="p-10">
                    <div class="mx-auto w-fit">
                        <p class="text-5xl font-extrabold">Bestelle Essen und mehr</p>
                        <p class="text-3xl font-bold">Restaurants und Geschäfte, die zu dir liefern</p>

                        <form @submit.prevent="queryShops" class="mt-6">
                            <div class="grid grid-cols-6 items-center gap-2">
                                <div class="col-span-4">
                                    <MazSelect
                                        v-model="form.city"
                                        label="Select your city"
                                        :options="available_cities()"
                                        option-value-key="valueOption"
                                        option-label-key="labelOption"
                                        option-input-value-key="inputLabel"
                                        size="lg"
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
                                </div>

                                <div class="col-span-2">
                                    <MazBtn
                                        type="submit"
                                        size="lg"
                                        color="black"
                                        outline
                                    >Search</MazBtn>
                                </div>
                            </div>

                            <InputError class="mt-1" :message="form.errors.city"/>
                        </form>
                    </div>
                </div>
                <div class="bg-black">
                    <img
                        class="object-contain mx-auto max-h-[30rem] xl:max-h-[45rem]"
                        src="/images/welcome_page_ada_img.jpg"
                        alt="img"
                    >
                </div>
            </div>
        </section>
    </AppLayout>
</template>
