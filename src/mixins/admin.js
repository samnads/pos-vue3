import { computed } from "vue";
import { notify } from "@kyvg/vue3-notification";
import { useStore } from "vuex";
import axios from "axios";
import router from "@/router";
export default function () {
    var notType = 'warning'
    var notTitle = ''
    var notMessage = ''
    var notDuration = 3000
    var notSpeed = 300
    const store = useStore();
    let productTypes = computed(function () {
        return store.state.productTypes
    });
    async function axiosCall(method, url, data) {
        const endpoint = "http://localhost/pos-vue3/server/admin/ajax/";
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
            if (resData.success == false) {
                if (resData.location) { // redirect found
                    notifyApiResponse(resData);
                    router.push({ path: "/" + resData.location }).catch((e) => {
                        console.log(e);
                    });
                } else if (resData.errors) { // may be form errors
                    notifyFormError({
                        message: "Form Data Error !",
                        type: "warning",
                    });
                }
                else {
                    notifyApiResponse(resData);
                }
            } else if (resData.success == true && resData.location) {
                notifyApiResponse(resData);
                if (resData.location) { // redirect found
                    router.push({ path: "/" + resData.location }).catch((e) => {
                        console.log(e);
                    });
                }
            }
            else if (resData.success == true) {
                if (resData.location) { // redirect found
                    router.push({ path: "/" + resData.location }).catch((e) => {
                        console.log(e);
                    });
                }
            }

            /******************************* */
            // Don't forget to return something   
            return res.data
        }
        catch (err) {
            notifyCatchResponse({ title: err });
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
        this.axios.get("http://localhost/CyberLikes-POS/admin/ajax/type", { params: { action: 'all' }, }).then(function (response) {
            store.commit("storeProductTypes", response.data.data);
        }).catch((error) => {
            this.notifyCatchResponse({ message: error.message });
        });
    }
    function addSymbologies() {
        this.axios.get("http://localhost/CyberLikes-POS/admin/ajax/symbology", { params: { action: 'dropdown' }, }).then(function (response) {
            store.commit("storeSymbologies", response.data.data);
        }).catch((error) => {
            this.notifyCatchResponse({ message: error.message });
        });
    }
    function addCategories() {
        this.axios.get("http://localhost/CyberLikes-POS/admin/ajax/category", { params: { action: 'getall' }, }).then(function (response) {
            store.commit("storeCategories", response.data.data);
        }).catch((error) => {
            this.notifyCatchResponse({ message: error.message });
        });
    }
    function addBrands() {
        this.axios.get("http://localhost/CyberLikes-POS/admin/ajax/brand", { params: { action: 'dropdown' }, }).then(function (response) {
            store.commit("storeBrands", response.data.data);
        }).catch((error) => {
            this.notifyCatchResponse({ message: error.message });
        });
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
        addBrands,
        /******************* */
        axiosCall,
        productTypes,
    }
}