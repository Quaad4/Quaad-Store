import { createRouter, createWebHistory } from 'vue-router'
import Orders from '@/views/orders/Index.vue'
import ShowOrder from '@/views/orders/Show.vue'
import Products from '@/views/products/Index.vue'
import showProduct from '@/views/products/Show.vue'

const routes = [
  {
    path: '/orders',
    name: 'orders',
    component: Orders
  },
  {
    path: '/orders/:id',
    name: 'orderShow',
    component: ShowOrder,
    props: true 
  },
  {
    path: '/products',
    name: 'products',
    component: Products
  },
  {
    path: '/products/:id',
    name: 'productShow',
    component: showProduct,
    props: true 
  },
]

export default createRouter({
  history: createWebHistory(),
  routes
})