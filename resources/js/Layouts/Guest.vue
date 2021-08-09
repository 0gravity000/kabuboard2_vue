<template>
    <!-- Page Heading -->
    <header class="bg-white shadow" v-if="$slots.header">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <slot name="header" />
        </div>
    </header>

    <div v-if="$page.props.canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
        <span>Guestさん</span>
        <Link v-if="$page.props.auth.user" href="/dashboard" class="text-sm text-gray-700 underline">
            Dashboard
        </Link>

        <div v-else>
            <Link :href="route('login')" class="text-sm text-gray-700 underline">
                Log in
            </Link>

            <Link v-if="$page.props.canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                Register
            </Link>
        </div>
    </div>

    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <Link href="/">
                <BreezeApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
            </Link>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>

<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue'
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeApplicationLogo,
        Link,
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    },
}
</script>
