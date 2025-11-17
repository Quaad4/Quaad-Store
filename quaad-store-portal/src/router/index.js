import { createRouter, createWebHistory } from 'vue-router'
import Orders from '../views/orders/index.vue'

const routes = [
  {
    path: '/',
    name: 'orders',
    component: Orders
  },
]

export default createRouter({
  history: createWebHistory(),
  routes
})