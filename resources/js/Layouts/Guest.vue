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

    <!-- content -->
    <div class="flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <p>Here API TEST Message -> {{msgs}}</p>
        <slot />
    </div>  <!-- content -->

</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Link,
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    },
     data: function () {
         return {
            msgs: []
         }
     },
    methods: {
         getMsg() {
             axios.get('/api/apitest')
                    .then((res) => {
                        this.msgs = res.data;
                    });
         }
    },
    mounted() {
        this.getMsg();
    }
}
</script>
