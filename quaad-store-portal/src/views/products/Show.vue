<template>
    <div>   
        <form @submit.prevent="updateProduct">
            <div class="space-y-12">
                <div class="border-b border-white/10 pb-12">
                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                        <div class="sm:col-span-3">
                            <label for="name" class="block text-sm/6 font-medium text-white">Name</label>
                            <div class="mt-2">
                                <div class="flex items-center rounded-md bg-white/5 pl-3 outline-1 -outline-offset-1 outline-white/10 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-500">
                                    <div class="shrink-0 text-base text-gray-400 select-none sm:text-sm/6"></div>
                                    <input id="name" type="text" name="name" placeholder="Scarf" class="block min-w-0 grow bg-transparent py-1.5 pr-3 pl-1 text-base text-white placeholder:text-gray-500 focus:outline-none sm:text-sm/6" v-model="product.name"/>
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
                                    <input id="price" type="number" step=".01" name="price" placeholder="9.99" class="block min-w-0 grow bg-transparent py-1.5 pr-3 pl-1 text-base text-white placeholder:text-gray-500 focus:outline-none sm:text-sm/6" :value="product.price" @input="update"/>
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
                            <textarea id="about" name="about" rows="3" placeholder="Information about the item" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6 mt-2" v-model="product.description"></textarea>
                        </div>
                        <div class="mt-3 text-sm/6 text-red-400">
                            <span v-for="error in errors.description">{{ error }} &nbsp;</span>
                        </div>
                    </div>

                    <div class="mt-5">
                        <button v-if="!loading" type="submit" class="rounded-md bg-sky-500 hover:bg-sky-700 cursor-pointer px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Update</button>
                        <button v-else="loading" type="submit" class="rounded-md bg-sky-500 hover:bg-sky-700 cursor-pointer px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500" disabled>Loading</button>
                        <button @click.prevent="reset" class="ml-2 rounded-md bg-sky-500 hover:bg-sky-700 cursor-pointer px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Reset</button>
                        <button @click.prevent="deleteProduct" class="ml-2 rounded-md bg-red-500 hover:bg-sky-700 cursor-pointer px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Delete</button>
                        <button @click.prevent="restoreProduct" class="ml-2 rounded-md bg-green-500 hover:bg-sky-700 cursor-pointer px-3 py-2 text-sm font-semibold text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Restore</button>

                    </div>

                    <p v-if="updateSuccess" class="mt-3 text-sm/6 text-green-400">product Updated Successfully</p>
                    <p v-if="deleteMessage" class="mt-3 text-sm/6 text-green-400">{{ deleteMessage }}</p>
                    <p v-if="deleteError" class="mt-3 text-sm/6 text-red-400">Failed to delete product</p>
                    <p v-if="restoreMessage" class="mt-3 text-sm/6 text-green-400">{{restoreMessage}}</p>
                    <p v-if="restoreError" class="mt-3 text-sm/6 text-red-400">Failed to restore product</p>

                </div>
            </div>
        </form>
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
        props: [
            'id'
        ],
        data() {
            return {
                originalProduct: {},
                product: {},
                loading: false,
                errors: [],
                updateSuccess: false,
                deleteMessage: '',
                deleteError: false,
                restoreMessage: '',
                restoreError: false
            }
        },
        mounted() {
            axios.get(`http://127.0.0.1:8000/api/products/${this.id}`)
            .then(response => {
                this.originalProduct = {...response.data.data}
                this.product = {...response.data.data}
            })
            .catch(error => {
                console.log(error.message)
            })
        },
        methods: {
            update(evt) {
                this.product.price = parseFloat(evt.target.value).toFixed(2)
            },
            updateProduct() {
                this.loading = true
                this.updateSuccess = false
                this.errors = []
                axios.patch(`http://127.0.0.1:8000/api/products/${this.id}`, this.product)
                .then(response => {
                    this.updateSuccess = true
                    this.originalProduct = {...response.data.data}
                    this.product = {...response.data.data}
                })
                .catch(error => {
                    console.log(error.response.data.errors)
                    this.errors = error.response.data.errors
                })
                .finally(() => {
                    this.loading = false
                })
            },
            reset() {
                this.product = {...this.originalProduct}
                this.errors = []
                this.updateSuccess = false
            },
            deleteProduct() {
                this.deleteMessage= ''
                this.deleteError = false
                axios.delete(`http://127.0.0.1:8000/api/products/${this.id}`)
                .then(response => {
                    this.deleteMessage = response.data.message
                })
                .catch(error => {
                    console.error(error.message)
                    this.deleteError = true
                })
            },
            restoreProduct() {
                this.restoreMessage= ''
                this.restoreError = false
                axios.post(`http://127.0.0.1:8000/api/products/${this.id}/restore`)
                .then(response => {
                    this.restoreMessage = response.data.message
                })
                .catch(error => {
                    console.error(error.message)
                    this.restoreError = true
                })
            }
        }
    }
</script>