<template>
    <div>
        <h2>All Orders</h2>
        <ul>
            <li v-for="order in orders" :key="order.id">{{ order.name }} | {{ order.price }}</li>
        </ul>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                orders: {}
            }
        },
        mounted() {
            this.fetchAllData()
        },
        methods: {
            fetchAllData() {
                axios.get('http://127.0.0.1:8000/api/orders')
                .then(response => {
                    this.orders = response.data.data
                })
                .catch(error => {
                    console.error(error.message)
                })
            }
        }
    }
</script>