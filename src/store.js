import { createStore } from "vuex";
export default createStore({
    state: {
        products: [],
        cart: [],
        productTypes: undefined,
        CUSTOMER_GROUPS: undefined,
        symbologies: undefined,
        categories: undefined,
        units: undefined,
        units_bulk: undefined,
        TAXES: undefined,
        WARE_HOUSES: undefined,
        COMMON_GENDERS: undefined,
        COMMON_ROLES: undefined,
        COMMON_ROLE_STATUSES: undefined,
        COMMON_WAREHOUSE_STATUSES: undefined,
        PAYMENT_MODES: undefined
    },
    mutations: {
        storeProductTypes(state, item) {
            state.productTypes = item;
        },
        storeSymbologies(state, item) {
            state.symbologies = item;
        },
        storeCategories(state, item) {
            state.categories = item;
        },
        storeBrands(state, item) {
            state.brands = item;
        },
        storeUnits(state, item) {
            state.units = item;
        },
        storeUnitsBulk(state, item) {
            state.units_bulk = item;
        },
        storeTaxes(state, item) {
            state.TAXES = item;
        },
        storeWareHouses(state, item) {
            state.WARE_HOUSES = item;
        },
        storeCustomerGroups(state, item) {
            state.CUSTOMER_GROUPS = item;
        },
        storeCommonGenders(state, item) {
            state.COMMON_GENDERS = item;
        },
        storeCommonRoles(state, item) {
            state.COMMON_ROLES = item;
        },
        storeCommonRoleStatuses(state, item) {
            state.COMMON_ROLE_STATUSES = item;
        },
        storeCommonWarehouseStatuses(state, item) {
            state.COMMON_WAREHOUSE_STATUSES = item;
        },
        storePaymentModes(state, item) {
            state.PAYMENT_MODES = item;
        }
    }
});