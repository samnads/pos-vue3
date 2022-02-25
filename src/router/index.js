import { createRouter, createWebHashHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
// admin pages
import AdminMain from '../admin/AdminMain.vue'
import AdminLogin from '../admin/AdminLogin.vue'
import AdminProfile from '../admin/AdminProfile.vue'
import AdminDashboard from '../admin/AdminDashboard.vue'
// Product Based Pages
import AdminProductMain from '../admin/product/ProductMain.vue'
import AdminProductList from '../admin/product/ProductList.vue'
import AdminProductNew from '../admin/product/ProductNew.vue'
// error pages
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
    redirect: '/admin/dashboard',
    children: [
      {
        path: 'login',
        name: 'adminLogin',
        component: AdminLogin,
      },
      {
        path: 'dashboard',
        name: 'adminDashboard',
        component: AdminDashboard,
      },
      {
        path: 'product',
        name: 'adminProductMain',
        component: AdminProductMain,
        redirect: '/admin/product/list',
        children: [
          {
            path: 'list',
            name: 'adminProductList',
            component: AdminProductList,
          },
          {
            path: 'new',
            name: 'adminProductNew',
            component: AdminProductNew,
          },
        ],
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
  history: createWebHashHistory(process.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  // remove modal backdrop if one exists
  let modalBackground = document.querySelector('.modal-backdrop')
  if (modalBackground) {
    modalBackground.remove()
  }
  // do other stuff

  next()
})

export default router

