<template>
    <div>
        <form>
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
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="price" class="block text-sm/6 font-medium text-white">Price</label>
                            <div class="mt-2">
                                <div class="flex items-center rounded-md bg-white/5 pl-3 outline-1 -outline-offset-1 outline-white/10 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
                                    <div class="shrink-0 text-base text-gray-400 select-none sm:text-sm/6"></div>
                                    <input id="price" type="number" name="price" class="block min-w-0 grow bg-transparent py-1.5 pr-3 pl-1 text-base text-white placeholder:text-gray-500 focus:outline-none sm:text-sm/6" v-model="newOrder.price"/>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-span-full">
                        <div class="mt-5">
                        <label for="about" class="block text-sm/6 font-medium text-white">Description</label>
                            <textarea id="about" name="about" rows="3" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6 mt-2" v-model="newOrder.description"></textarea>
                        </div>
                        <p class="mt-3 text-sm/6 text-gray-400">Write a description about the Item.</p>
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="rounded-md bg-sky-500 hover:bg-sky-700 cursor-pointer px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
                    </div>

                </div>
            </div>
        </form>
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
                orders: {},
                newOrder: {
                    name: '',
                    price: 0,
                    description: ''
                }
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