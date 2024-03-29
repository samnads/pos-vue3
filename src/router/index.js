/* eslint-disable */
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
// Sale Based Pages
import AdminSaleMain from '../admin/sale/SaleMain.vue'
import AdminSalePosList from '../admin/sale/SalePosList.vue'
// Purchase Based Pages
import AdminPurchaseMain from '../admin/purchase/PurchaseMain.vue'
import AdminPurchaseList from '../admin/purchase/PurchaseList.vue'
import AdminPurchaseNew from '../admin/purchase/PurchaseNew.vue'
// Purchase Return Based Pages
import AdminPurchaseReturnMain from '../admin/purchase_return/PurchaseReturnMain.vue'
import AdminPurchaseReturnList from '../admin/purchase_return/PurchaseReturnList.vue'
import AdminPurchaseReturnNew from '../admin/purchase_return/PurchaseReturnNew.vue'
// Product Adjustment Based Pages
import AdjustmentMain from '../admin/adjustment/AdjustmentMain.vue'
import AdjustmentList from '../admin/adjustment/AdjustmentList.vue'
import AdjustmentNew from '../admin/adjustment/AdjustmentNew.vue'
// Supplier based pages
import AdminSupplierMain from '../admin/supplier/SupplierMain.vue'
import AdminSupplierList from '../admin/supplier/SupplierList.vue'
// Supplier based pages
import AdminCategoryMain from '../admin/category/CategoryMain.vue'
import AdminCategoryList from '../admin/category/CategoryList.vue'
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
// Tax based pages
import AdminPosMain from '../admin/pos/PosMain.vue'
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
        path: 'sale',
        name: 'adminSaleMain',
        component: AdminSaleMain,
        redirect: '/admin/sale/pos',
        children: [
          {
            path: 'pos',
            name: 'adminSalePosList',
            component: AdminSalePosList,
          },
        ],
      },
      {
        path: 'purchase',
        name: 'adminPurchaseMain',
        component: AdminPurchaseMain,
        redirect: '/admin/purchase/list',
        children: [
          {
            path: 'list',
            name: 'adminPurchaseList',
            component: AdminPurchaseList,
          },
          {
            path: 'new',
            name: 'adminPurchaseNew',
            component: AdminPurchaseNew,
          },
          {
            path: 'edit/:id',
            name: 'adminPurchaseEdit',
            component: AdminPurchaseNew,
          },
        ],
      },
      {
        path: 'purchase_return',
        name: 'adminPurchaseReturnMain',
        component: AdminPurchaseReturnMain,
        redirect: '/admin/purchase_return/list',
        children: [
          {
            path: 'list',
            name: 'adminPurchaseReturnList',
            component: AdminPurchaseReturnList,
          },
          {
            path: 'new/:id',
            name: 'adminPurchaseReturnNew',
            component: AdminPurchaseReturnNew,
          },
          {
            path: 'edit/:id',
            name: 'adminPurchaseReturnEdit',
            component: AdminPurchaseReturnNew,
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
        path: 'category',
        name: 'adminCategoryMain',
        component: AdminCategoryMain,
        redirect: '/admin/category/list',
        children: [
          {
            path: 'list',
            name: 'adminCategoryList',
            component: AdminCategoryList,
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
        path: 'pos',
        name: 'adminPosMain',
        component: AdminPosMain,
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
  history: createWebHistory(config.VUE_APP_SUB_PATH),
  routes
})
router.beforeEach((to, from, next) => {
  // bug fix - tooltip not hiding because of v-if (route show or hide based on if condition)
  const stickedTooltips = document.querySelectorAll('.tooltip');
  for (const tooltip of stickedTooltips) { tooltip.remove(); }
  next();
});
router.afterEach((to, from, failure) => {
});

export default router

