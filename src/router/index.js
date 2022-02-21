import { createRouter, createWebHashHistory  } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import AdminMain from '../admin/AdminMain.vue'
import AdminLogin from '../admin/AdminLogin.vue'
import AdminProfile from '../admin/AdminProfile.vue'
import AdminDashboard from '../admin/AdminDashboard.vue'
// Product Based Pages
import AdminProducts from '../admin/AdminProducts.vue'
//
import PageNotFound from '../admin/PageNotFound.vue'

const routes = [
  {
    path: '/',
    redirect: '/home'
  },
  {
    path: '/home',
    name: 'home',
    component: HomeView
  },
  {
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  },
  {
    path: '/admin',
    component: AdminMain,
    children: [
      {
        path: 'login',
        component: AdminLogin,
      },
      {
        path: 'dashboard',
        name: 'adminDashboard',
        component: AdminDashboard,
      },
      {
        path: 'products',
        name: 'adminProducts',
        component: AdminProducts,
      },
      {
        path: 'profile',
        component: AdminProfile,
      },
      {
        path: '/:pathMatch(.*)*',
        component: PageNotFound,
      }
    ],
  },
]

const router = createRouter({
  history: createWebHashHistory (process.env.BASE_URL),
  routes
})

export default router
