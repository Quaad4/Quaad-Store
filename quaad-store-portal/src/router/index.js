import { createRouter, createWebHistory } from 'vue-router'
import Orders from '@/views/orders/Index.vue'
import Show from '@/views/orders/show.vue'

const routes = [
  {
    path: '/',
    name: 'orders',
    component: Orders
  },
  {
    path: '/orders/:id',
    name: 'orderShow',
    component: Show,
    props: true 
  },
]

export default createRouter({
  history: createWebHistory(),
  routes
})