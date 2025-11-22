<template>
    <div>

        <h2 class="mt-2 mb-2">All Orders</h2>
        <ul class="max-w-xl mx-auto space-y-2"> 
            <li v-for="order in orders" :key="order.id" class="flex justify-between items-center">
                Name: {{ order.name }} | Total Price: {{ totalPrice(order) }} | Items: {{ totalItems(order) }}
                <button @click="goToEdit(order.id)" class="rounded-md bg-sky-500 hover:bg-sky-700 cursor-pointer px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                    View
                </button>
            </li>
        </ul>

        <div style="margin-top: 20px;">
            <button 
                @click="fetchOrders(pagination.prev_page_url)" 
                :disabled="!pagination.prev_page_url"
                class="rounded-md bg-sky-500 hover:bg-sky-700 cursor-pointer px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
            >
                Previous
            </button>

            <span style="margin: 0 10px;">
                Page {{ pagination.current_page }} of {{ pagination.last_page }}
            </span>

            <button 
                @click="fetchOrders(pagination.next_page_url)" 
                :disabled="!pagination.next_page_url"
                class="rounded-md bg-sky-500 hover:bg-sky-700 cursor-pointer px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500"
            >
                Next
            </button>
        </div>

    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                orders: [],
                pagination: {
                    current_page: 1,
                    last_page: 1,
                    next_page_url: null,
                    prev_page_url: null
                },
            }
        },
        mounted() {
            this.fetchOrders()
        },
        methods: {
            fetchOrders(pageUrl = 'http://127.0.0.1:8000/api/orders') {
                axios.get(pageUrl)
                .then(response => {
                    this.orders = response.data.data

                    this.pagination = {
                        current_page: response.data.meta.current_page,
                        last_page: response.data.meta.last_page,
                        next_page_url: response.data.links.next,
                        prev_page_url: response.data.links.prev,
                    }
                })
                .catch(error => {
                    console.error(error.message)
                })
            },
            totalPrice(order) {
                const productsInOrder = order.products.map(product => product.pivot)
                return productsInOrder.reduce((acc, curr) => acc + (curr.price * curr.quantity), 0.00)
            },
            totalItems(order) {
                const productsInOrder = order.products.map(product => product.pivot)
                return productsInOrder.reduce((acc, curr) => acc + curr.quantity, 0)
            },
            goToEdit(id) {
                this.$router.push(`/orders/${id}`)
            },
        }
    }
</script>