import { notify } from "@kyvg/vue3-notification";
import { useStore } from "vuex";
import axios from "axios";
import router from "@/router";
import { getCurrentInstance } from "vue";
const endpoint = process.env.VUE_APP_API_ROOT + "admin/ajax/";
const env = process.env.VUE_APP_ENV;
const timeout = 8000;
export default function () {
    var notType = 'warning'
    var notTitle = ''
    var notMessage = ''
    var notDuration = 3000
    var notSpeed = 300
    const store = useStore();
    const internalInstance = getCurrentInstance();
    async function axiosAsyncCallReturnData(method, url, data, AbortController, options = { showSuccessNotification: true, showCatchNotification: true, showProgress: true }) {
        options.showProgress && internalInstance.appContext.config.globalProperties.$Progress.start();
        try {
            let res = await axios({
                url: endpoint + url,
                method: method,
                data: data,
                params: method == 'get' ? data : undefined,
                signal: AbortController ? AbortController.signal : undefined,
                timeout: 8000,
                headers: {
                    'Content-Type': 'application/json'
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
                    env == "development" ? notifyFormError({
                        title: "Form Validation Error (server) !",
                        message: "This error is for debugging only !",
                        type: "warning",
                    }) : undefined;
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
    async function axiosAsyncStoreReturnBool(mutation, url, data, method = "get") {
        try {
            let res = await axios({
                url: endpoint + url,
                method: method,
                data: data,
                params: method == 'get' ? data : undefined,
                timeout: timeout,
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            let response = res.data;
            if (response.success == true) {
                store.commit(mutation, response.data);
                return true;
            }
            return false;
        }
        catch (error) {
            return false;
        }
    }
    function addSubCatsLevel1(id) {
        axiosAsyncCallReturnData("get", "category", {
            action: "category",
            id: id
        }, null, {
            showSuccessNotification: false,
            showCatchNotification: true,
            showProgress: true,
        }).then(function (response) {
            if (response.success == true) {
                store.commit("storeSubCatLevel1", response.data);
            }
        });
    }
    async function axiosAsyncStoreUpdateReturnData(mutation, url, data, method = "get") {
        internalInstance.appContext.config.globalProperties.$Progress.start();
        store.commit(mutation, false); // reset specific store data
        try {
            let res = await axios({
                url: endpoint + url,
                method: method,
                data: data,
                params: method == 'get' ? data : undefined,
                timeout: timeout,
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
                store.commit(mutation, resData.data); // store new data
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
            return err
        }
    }
    function x_percentage_of_y(x, y) {
        return (x / 100) * y;
    }
    return {
        /******************* for notify */
        notifyDefault,
        notifyApiResponse,
        notifyCatchResponse,
        notifyFormError,
        /******************* for data */
        addSubCatsLevel1,
        /******************* */
        axiosAsyncCallReturnData,
        axiosAsyncStoreUpdateReturnData,
        axiosAsyncStoreReturnBool,
        /******************* */ // calculations
        x_percentage_of_y
    }
}