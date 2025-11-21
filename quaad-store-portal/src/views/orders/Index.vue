<template>
    <div>
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <button @click.prevent="applyFilter(1)" class="sm:col-span-2 rounded-md bg-sky-500 hover:bg-sky-700 cursor-pointer px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">All Orders</button>
            <button @click.prevent="applyFilter(2)" class="sm:col-span-2 rounded-md bg-sky-500 hover:bg-sky-700 cursor-pointer px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Price above 20</button>
            <div class="sm:col-span-2 flex items-center rounded-md bg-white/5 pl-3 outline-1 -outline-offset-1 outline-white/10 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
                <div class="shrink-0 text-base text-gray-400 select-none sm:text-sm/6"></div>
                <input id="name" type="text" name="name" placeholder="Filter by name" class="block min-w-0 grow bg-transparent py-1.5 pr-3 pl-1 text-base text-white placeholder:text-gray-500 focus:outline-none sm:text-sm/6" v-model="filterName"/>
            </div>
        </div>
        <form @submit.prevent="createNewOrder">
            <div class="space-y-12">
                <div class="border-b border-white/10 pb-12">
                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                        <div class="sm:col-span-3">
                            <label for="name" class="block text-sm/6 font-medium text-white">Name</label>
                            <div class="mt-2">
                                <div class="flex items-center rounded-md bg-white/5 pl-3 outline-1 -outline-offset-1 outline-white/10 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
                                    <div class="shrink-0 text-base text-gray-400 select-none sm:text-sm/6"></div>
                                    <input id="name" type="text" name="name" placeholder="Scarf" class="block min-w-0 grow bg-transparent py-1.5 pr-3 pl-1 text-base text-white placeholder:text-gray-500 focus:outline-none sm:text-sm/6" v-model="newOrder.name"/>
                                </div>
                                <div class="mt-3 text-sm/6 text-red-400">
                                    <span v-for="error in errors.name">{{ error }} &nbsp;</span>
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="price" class="block text-sm/6 font-medium text-white">Price</label>
                            <div class="mt-2">
                                <div class="flex items-center rounded-md bg-white/5 pl-3 outline-1 -outline-offset-1 outline-white/10 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
                                    <div class="shrink-0 text-base text-gray-400 select-none sm:text-sm/6"></div>
                                    <input id="price" type="number" step=".01" name="price" placeholder="9.99" class="block min-w-0 grow bg-transparent py-1.5 pr-3 pl-1 text-base text-white placeholder:text-gray-500 focus:outline-none sm:text-sm/6" :value="newOrder.price" @input="update"/>
                                </div>
                                <div class="mt-3 text-sm/6 text-red-400">
                                    <span v-for="error in errors.price">{{ error }} &nbsp;</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-span-full">
                        <div class="mt-5">
                        <label for="about" class="block text-sm/6 font-medium text-white">Description</label>
                            <textarea id="about" name="about" rows="3" placeholder="Information about the item" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6 mt-2" v-model="newOrder.description"></textarea>
                        </div>
                        <div class="mt-3 text-sm/6 text-red-400">
                            <span v-for="error in errors.description">{{ error }} &nbsp;</span>
                        </div>
                    </div>

                    <div class="mt-5">
                        <button v-if="!loading" type="submit" class="rounded-md bg-sky-500 hover:bg-sky-700 cursor-pointer px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Submit</button>
                        <button v-else="loading" type="submit" class="rounded-md bg-sky-500 hover:bg-sky-700 cursor-pointer px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500" disabled>Loading</button>
                    </div>

                    <p v-if="success" class="mt-3 text-sm/6 text-green-400">Order Created Successfully</p>


                </div>
            </div>
        </form>
        <h2 class="mt-2 mb-2">All Orders</h2>
        <ul class="max-w-xl mx-auto space-y-2"> 
            <li v-for="order in filteredOrders" :key="order.id" class="flex justify-between items-center">
                {{ order.name }} | {{ order.price }} 
                <button @click="goToEdit(order.id)" class="rounded-md bg-sky-500 hover:bg-sky-700 cursor-pointer px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                    View
                </button>
            </li>
        </ul>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        data() {
            return {
                orders: [],
                newOrder: {
                    name: '',
                    price: null,
                    description: '',
                },
                errors: [],
                success: false,
                loading: false,
                filter: 1,
                filterName: '',
            }
        },
        mounted() {
            this.fetchAllData()
        },
        computed: {
            filteredOrders() {
                let orders = this.orders
                if(this.filter === 2) {
                    orders = this.orders.filter(order => order.price >= 20)
                } 
                return orders.filter(order => order.name.toLowerCase().includes(this.filterName.toLowerCase()))
            }
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
            },
            update(evt) {
                this.newOrder.price = parseFloat(evt.target.value).toFixed(2)
            },
            goToEdit(id) {
                this.$router.push(`/orders/${id}`)
            },
            applyFilter(type) {
                this.filter = type
            },
            createNewOrder() {
                this.errors = []
                this.success = false
                this.loading = true
                axios.post('http://127.0.0.1:8000/api/orders', this.newOrder)
                .then(response => {
                    this.orders.push(response.data.data)
                    this.newOrder = {
                        name: '',
                        price: null,
                        description: ''
                    }
                    this.success = true
                })
                .catch(error => {
                    console.log(error.response.data.errors)
                    this.errors = error.response.data.errors
                })
                .finally(() => {
                    this.loading = false
                })
            }
        }
    }
</script>