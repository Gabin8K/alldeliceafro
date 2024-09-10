<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import {Link, router, usePage} from "@inertiajs/vue3";
import {loadLanguageAsync} from "laravel-vue-i18n";

function changeLocale(locale) {
    router.get(route('change.locale', [usePage().props.currentLocale, locale]), {}, {
        onFinish: () => loadLanguageAsync(locale)
    })
}

function toggleLanguageSelectionMenu() {
    document.getElementById('languageSelectionMenu').classList.toggle('hidden')
}

function closeLanguageSelectionMenu() {
    document.getElementById('languageSelectionMenu').classList.add('hidden')
}
</script>

<template>
    <nav class="bg-white py-5 px-4 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <ApplicationLogo
                    class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"
                />
            </div>

            <div class="flex items-center justify-end gap-x-4">
                <div class="relative" v-click-outside="closeLanguageSelectionMenu">
                    <div
                        @click="toggleLanguageSelectionMenu"
                        class="font-bold px-1 hover:cursor-pointer hover:scale-105 transform transition duration-200"
                    >
                        <img class="h-4 rounded" :src="$page.props.available_languages[$page.props.currentLocale].flag" alt="flag">
                    </div>
                    <div id="languageSelectionMenu" class="bg-white shadow-md absolute top-7 -left-2 rounded-lg z-10 text-gray-800 px-6 py-3 hidden">
                        <div class="flex flex-col gap-3">
                            <div v-for="([key, locale]) in Object.entries($page.props.available_languages)"
                               class="hover:cursor-pointer hover:font-bold hover:scale-105 transform transition duration-200"
                               @click="changeLocale(key)"
                            >
                                <div class="flex items-center gap-2 pr-8">
                                    <img class="h-4 rounded" :src="locale.flag" alt="flag">
                                    <p>{{ locale.name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <Link
                    v-if="!$page.props.auth.user"
                    :href="route('login', $page.props.currentLocale)"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                >{{ $t('auth.login') }}</Link>

                <Link
                    v-if="!$page.props.auth.user"
                    :href="route('register', $page.props.currentLocale)"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                >{{ $t('auth.register') }}</Link>

                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard', $page.props.currentLocale)"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                >Dashboard</Link>
            </div>
        </div>
    </nav>

    <main>
        <slot />
    </main>
</template>

<style scoped>

</style>
