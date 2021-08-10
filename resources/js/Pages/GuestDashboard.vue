<template>
    <Head title="Dashboard(Guest)" />

    <GuestLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a href="/guest-dashboard">Dashboard</a>
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- {{stocks}} -->
                        <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">code</th>
                            <th scope="col">name</th>
                            <th scope="col">market_id</th>
                            <th scope="col">industry_id</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(stock, index) in stocks" :key="index">
                            <th scope="row" >{{stock.id}}</th>
                            <td>{{stock.code}}</td>
                            <td>{{stock.name}}</td>
                            <td>{{stock.market_id}}</td>
                            <td>{{stock.industry_id}}</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>

</template>

<script>
import GuestLayout from '@/Layouts/Guest.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        GuestLayout,
        Head,
    },
    data: function () {
         return {
            stocks: []
         }
     },
    methods: {
         getStocks() {
             axios.get('/api/stock/index')
                    .then((res) => {
                        this.stocks = res.data;
                    });
         }
    },
    mounted() {
        this.getStocks();
    }
}
</script>
