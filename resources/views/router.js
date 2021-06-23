import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    component: () => import('./layouts/main/Main.vue'),
    children: [
      {
        path: '/',
        name: 'home',
        component: () => import('./pages/Home.vue'),
        meta: {pageTitle: 'Home',}
      },
    ],
  },
  {
    path: '/',
    component: () => import('./layouts/simple/Simple.vue'),
    children: [
      
    ],
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
