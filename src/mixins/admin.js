import { notify } from "@kyvg/vue3-notification";
import { useStore } from "vuex";
import axios from "axios";
import router from "@/router";
import { getCurrentInstance } from "vue";
export default function () {
    var notType = 'warning'
    var notTitle = ''
    var notMessage = ''
    var notDuration = 3000
    var notSpeed = 300
    const store = useStore();
    const internalInstance = getCurrentInstance();
    async function axiosCall(method, url, data, AbortController, options = { showSuccessNotification: true, showCatchNotification: true, showProgress: true }) {
        options.showProgress && internalInstance.appContext.config.globalProperties.$Progress.start();
        const endpoint = "http://localhost/pos-vue3/server/admin/ajax/";
        try {
            let res = await axios({
                url: endpoint + url,
                method: method,
                data: data,
                params: method == 'get' ? data : undefined,
                signal: AbortController ? AbortController.signal : undefined,
                timeout: 8000,
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            if (res.status == 200) {
                // test for status you want, etc
                //console.log(res.data)
            }
            /******************************* */ // common things for all response
            let resData = res.data;
            if (resData.success == false) {
                options.showProgress && internalInstance.appContext.config.globalProperties.$Progress.fail();
                if (resData.location) { // redirect found
                    notifyApiResponse(resData);
                    router.push({ path: "/" + resData.location }).catch((e) => {
                        console.log(e);
                    });
                } else if (resData.errors) { // may be form errors
                    notifyFormError({
                        message: "Server Validation Errors Found !",
                        type: "warning",
                    });
                }
                else {
                    notifyApiResponse(resData);
                }
            } else if (resData.success == true && resData.location) {
                options.showProgress && internalInstance.appContext.config.globalProperties.$Progress.finish();
                notifyApiResponse(resData);
                router.push({ path: "/" + resData.location }).catch((e) => {
                    console.log(e);
                });
            }
            else if (resData.success == true) {
                options.showSuccessNotification == true ? notifyApiResponse(resData) : undefined; // show success notify
                options.showProgress && internalInstance.appContext.config.globalProperties.$Progress.finish(); // finish progress
            }
            /******************************* */
            // Don't forget to return something   
            return res.data
        }
        catch (err) {
            if (AbortController && err.message == "canceled") {
                //
            } else {
                options.showProgress && internalInstance.appContext.config.globalProperties.$Progress.fail();
                options.showCatchNotification == true ? notifyCatchResponse({ title: err.message }) : undefined;
            }
            return err;
        }
    }
    function notifyDefault(data) {
        notify({
            title: data.title || notTitle, // no title
            text: data.message || data.error || notMessage,
            group: "general",
            type: data.type || notType,
            duration: data.duration || notDuration,
            speed: notSpeed,
        });
    }
    function notifyFormError(data) {
        notify({
            title: data.title || notTitle, // no title
            text: data.message || data.error || notMessage,
            group: "general",
            type: data.type || notType,
            duration: data.duration || notDuration,
            speed: notSpeed,
        });
    }
    function notifyApiResponse(data) {
        notify({
            title: data.title || notTitle, // no title
            text: data.message || data.error || notMessage,
            group: "general",
            type: data.type || notType,
            duration: data.duration || notDuration,
            speed: notSpeed,
            data: { test: "test data" }
        });
    }
    function notifyCatchResponse(data) {
        notify({
            title: data.title || notTitle,
            text: data.message || data.error || notMessage,
            group: "general",
            type: data.type || notType,
            duration: data.duration || notDuration,
            speed: notSpeed
        });
    }
    function addProductTypes() {
        axiosCall("get", "type", {
            action: "all",
        }).then(function (response) {
            store.commit("storeProductTypes", response.data);
        }).catch((error) => {
            this.notifyCatchResponse({ message: error.message });
        });
    }
    function addSymbologies() {
        axiosCall("get", "symbology", {
            action: "dropdown",
        }).then(function (response) {
            store.commit("storeSymbologies", response.data);
        }).catch((error) => {
            this.notifyCatchResponse({ message: error.message });
        });
    }
    function addCategories() {
        axiosCall("get", "category", {
            action: "getall",
        }).then(function (response) {
            store.commit("storeCategories", response.data);
        }).catch((error) => {
            this.notifyCatchResponse({ message: error.message });
        });
    }
    function addSubCatsLevel1(id) {
        axiosCall("get", "category", {
            action: "category",
            id: id
        }).then(function (response) {
            store.commit("storeSubCatLevel1", response.data);
        }).catch((error) => {
            this.notifyCatchResponse({ message: error.message });
        });
    }
    function addBrands() {
        axiosCall("get", "brand", {
            action: "dropdown",
        }).then(function (response) {
            store.commit("storeBrands", response.data);
        }).catch((error) => {
            this.notifyCatchResponse({ message: error.message });
        });
    }
    function addUnits() {
        axiosCall("get", "unit", {
            action: "list_base",
        }).then(function (response) {
            store.commit("storeUnits", response.data);
        }).catch((error) => {
            this.notifyCatchResponse({ message: error.message });
        });
    }
    function addUnitsBulk(id) {
        store.commit("storeUnitsBulk", undefined);
        axiosCall("get", "unit", {
            action: "list_sub",
            id: id
        }).then(function (response) {
            store.commit("storeUnitsBulk", response.data);
        }).catch((error) => {
            this.notifyCatchResponse({ message: error.message });
        });
    }
    function addTaxes() {
        axiosCall("get", "tax", {
            action: "dropdown",
        }).then(function (response) {
            store.commit("storeTaxes", response.data);
        }).catch((error) => {
            this.notifyCatchResponse({ message: error.message });
        });
    }
    function addWareHouses() {
        axiosCall("get", "warehouse", {
            action: "dropdown",
        }).then(function (response) {
            store.commit("storeWareHouses", response.data);
        }).catch((error) => {
            this.notifyCatchResponse({ message: error.message });
        });
    }
    async function axiosCallAndCommit(mutation, method, url, data) {
        internalInstance.appContext.config.globalProperties.$Progress.start();
        const endpoint = "http://localhost/pos-vue3/server/admin/ajax/";
        store.commit(mutation, false); // reset specific store data
        try {
            let res = await axios({
                url: endpoint + url,
                method: method,
                data: data,
                params: method == 'get' ? data : undefined,
                timeout: 8000,
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            if (res.status == 200) {
                // test for status you want, etc
                //console.log(res.data)
            }
            /******************************* */ // common things for all response
            let resData = res.data;
            if (resData.success == true) {
                internalInstance.appContext.config.globalProperties.$Progress.finish();
                if (resData.location) {
                    notifyApiResponse(resData);
                    router.push({ path: "/" + resData.location }).catch((e) => {
                        console.log(e);
                    });
                }
                else {
                    store.commit(mutation, resData.data); // store new data
                }
            }
            else if (resData.success == false) {
                internalInstance.appContext.config.globalProperties.$Progress.fail();
                notifyApiResponse(resData);
                if (resData.location) { // redirect found
                    router.push({ path: "/" + resData.location }).catch((e) => {
                        console.log(e);
                    });
                }
            }
            // Don't forget to return something 
            return resData
        }
        catch (err) {
            internalInstance.appContext.config.globalProperties.$Progress.fail();
            notifyCatchResponse({ title: err });
        }
    }







    function adminTest() {
        router.push({ name: "adminDashboard" }).catch((e) => {
            console.log(e);
        });
    }
    return {
        adminTest,
        /******************* for notify */
        notifyDefault,
        notifyApiResponse,
        notifyCatchResponse,
        notifyFormError,
        /******************* for data */
        addProductTypes,
        addSymbologies,
        addCategories,
        addSubCatsLevel1,
        addBrands,
        addUnits,
        addUnitsBulk,
        addTaxes,
        addWareHouses,
        /******************* */
        axiosCall,
        axiosCallAndCommit
    }
}