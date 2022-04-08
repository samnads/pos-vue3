import { createStore } from "vuex";
export default createStore({
    state: {
        products: [],
        cart: [],
        productTypes: undefined,
        symbologies: undefined,
        categories: undefined,
        units: undefined,
        units_bulk: undefined,
        TAXES: undefined,
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
        }
    }
});