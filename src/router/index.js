import { createRouter, createWebHistory } from 'vue-router'
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
import AdminProductListTest from '../admin/product/TestProductList.vue'
// Product Adjustment Based Pages
import AdjustmentMain from '../admin/adjustment/AdjustmentMain.vue'
import AdjustmentList from '../admin/adjustment/AdjustmentList.vue'
import AdjustmentNew from '../admin/adjustment/AdjustmentNew.vue'
// Supplier based pages
import AdminSupplierMain from '../admin/supplier/SupplierMain.vue'
import AdminSupplierList from '../admin/supplier/SupplierList.vue'
// Customer based pages
import AdminCustomerMain from '../admin/customer/CustomerMain.vue'
import AdminCustomerList from '../admin/customer/CustomerList.vue'
// User based pages
import AdminUserMain from '../admin/user/UserMain.vue'
import AdminUserList from '../admin/user/UserList.vue'
// Role based pages
import AdminRoleMain from '../admin/role/RoleMain.vue'
import AdminRoleList from '../admin/role/RoleList.vue'
import AdminRoleNew from '../admin/role/RoleNew.vue'
import AdminRoleEdit from '../admin/role/RoleNew.vue'
// Warehouse based pages
import AdminWarehouseMain from '../admin/warehouse/WarehouseMain.vue'
import AdminWarehouseList from '../admin/warehouse/WarehouseList.vue'
// Brand based pages
import AdminBrandMain from '../admin/brand/BrandMain.vue'
import AdminBrandList from '../admin/brand/BrandList.vue'
// Unit based pages
import AdminUnitMain from '../admin/unit/UnitMain.vue'
import AdminUnitList from '../admin/unit/UnitList.vue'
// Tax based pages
import AdminTaxMain from '../admin/tax/TaxMain.vue'
import AdminTaxList from '../admin/tax/TaxList.vue'
// TEST pages
import AdminTestQuery from '../admin/test_query.vue'
// error pages
import PageNotFound from '../admin/PageNotFound.vue'

const routes = [
  {
    path: '/',
    redirect: '/admin'
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
          {
            path: 'edit/:id',
            name: 'adminProductEdit',
            component: AdminProductNew,
          },
          {
            path: 'copy/:id',
            name: 'adminProductCopy',
            component: AdminProductNew,
          },
        ],
      },
      {
        path: 'product/test',
        name: 'adminProductTest',
        component: AdminProductListTest,
      },
      {
        path: 'adjustment',
        name: 'adminProductAdjustment',
        component: AdjustmentMain,
        redirect: '/admin/adjustment/list',
        children: [
          {
            path: 'list',
            name: 'adminProductAdjustmentList',
            component: AdjustmentList,
          },
          {
            path: 'new',
            name: 'adminProductAdjustmentNew',
            component: AdjustmentNew,
          },
          {
            path: 'edit/:id',
            name: 'adminProductAdjustmentEdit',
            component: AdjustmentNew,
          },
        ],
      },
      {
        path: 'supplier',
        name: 'adminSupplierMain',
        component: AdminSupplierMain,
        redirect: '/admin/supplier/list',
        children: [
          {
            path: 'list',
            name: 'adminSupplierList',
            component: AdminSupplierList,
          }
        ],
      },
      {
        path: 'customer',
        name: 'adminCustomerMain',
        component: AdminCustomerMain,
        redirect: '/admin/customer/list',
        children: [
          {
            path: 'list',
            name: 'adminCustomerList',
            component: AdminCustomerList,
          }
        ],
      },
      {
        path: 'user',
        name: 'adminUserMain',
        component: AdminUserMain,
        redirect: '/admin/user/list',
        children: [
          {
            path: 'list',
            name: 'adminUserList',
            component: AdminUserList,
          }
        ],
      },
      {
        path: 'warehouse',
        name: 'adminWarehouseMain',
        component: AdminWarehouseMain,
        redirect: '/admin/warehouse/list',
        children: [
          {
            path: 'list',
            name: 'adminWarehouseList',
            component: AdminWarehouseList,
          }
        ],
      },
      {
        path: 'brand',
        name: 'adminBrandMain',
        component: AdminBrandMain,
        redirect: '/admin/brand/list',
        children: [
          {
            path: 'list',
            name: 'adminBrandList',
            component: AdminBrandList,
          }
        ],
      },
      {
        path: 'unit',
        name: 'adminUnitMain',
        component: AdminUnitMain,
        redirect: '/admin/unit/list',
        children: [
          {
            path: 'list',
            name: 'adminUnitList',
            component: AdminUnitList,
          }
        ],
      },
      {
        path: 'tax',
        name: 'adminTaxMain',
        component: AdminTaxMain,
        redirect: '/admin/tax/list',
        children: [
          {
            path: 'list',
            name: 'adminTaxList',
            component: AdminTaxList,
          }
        ],
      },
      {
        path: 'role',
        name: 'adminRoleMain',
        component: AdminRoleMain,
        redirect: '/admin/role/list',
        children: [
          {
            path: 'list',
            name: 'adminRoleList',
            component: AdminRoleList,
          },
          {
            path: 'new',
            name: 'adminRoleNew',
            component: AdminRoleNew,
          },
          {
            path: 'edit/:id',
            name: 'adminRoleEdit',
            component: AdminRoleEdit,
          },
        ],
      },
      {
        path: 'profile',
        component: AdminProfile,
      },
      {
        path: 'test_query',
        name: 'test_query',
        component: AdminTestQuery,
      },
      {
        path: '/:pathMatch(.*)*',
        component: PageNotFound,
      }
    ],
  },
]
const router = createRouter({
  history: createWebHistory(),
  routes
})
router.beforeEach((to, from, next) => {
  //console.log(`Navigating to: ${to.name}`);
  next();
});

export default router

