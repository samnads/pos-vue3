import { ref, computed } from "vue";
import { notify } from "@kyvg/vue3-notification";
import { useStore } from "vuex";
export default function () {
    var type = 'warning'
    var duration= 3000
    const count = ref(0);
    const double = computed(() => count.value * 2)
    const store = useStore();
    let productTypes = computed(function () {
        return store.state.productTypes
    });
    function increment() {
        console.log("OK")
        count.value++;
    }
    function notifyDefault (data) {
        notify({
            title: data.title || '', // no title
            text: data.message || '',
            group: "general",
            type: data.type || type,
            duration: data.duration || duration,
            speed: 300,
        });
    }
    function notifyApiResponse (data) {
        notify({
            //title: data.title || this.title, // no title
            text: data.message || this.message,
            group: "general",
            type: data.type || this.type,
            duration: data.duration || this.duration,
            speed: 300,
            data: { test: "test data" }
        });
    }
    function notifyCatchResponse (data) {
        notify({
            title: data.title || "",
            text: data.message || data.error || this.message,
            group: "general",
            type: data.type || "warning",
            duration: data.duration || this.duration,
            speed: 300
        });
    }
    function addProductTypes () {
        this.axios.get("http://localhost/CyberLikes-POS/admin/ajax/type", { params: { action: 'all' }, }).then(function (response) {
            store.commit("storeProductTypes", response.data.data);
        }).catch((error) => {
            this.notifyCatchResponse({ message: error.message });
        });
    }
    function addSymbologies () {
        this.axios.get("http://localhost/CyberLikes-POS/admin/ajax/symbology", { params: { action: 'dropdown' }, }).then(function (response) {
            store.commit("storeSymbologies", response.data.data);
        }).catch((error) => {
            this.notifyCatchResponse({ message: error.message });
        });
    }
    return {
        notifyDefault,
        notifyApiResponse,
        notifyCatchResponse,
        /******************* */
        addProductTypes,
        addSymbologies,
        /******************* */
        count,
        double,
        increment,
        productTypes,
    }
}