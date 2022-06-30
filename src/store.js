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
        }
    }
});