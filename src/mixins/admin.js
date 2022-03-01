import { notify } from "@kyvg/vue3-notification";
export default {
    data() {
        return {
            title: "Default Titlle",
            message: "An error occured !",
            type: "warning",
            duration: 3000,
        };
    },
    computed: {
    },
    created: function () {
        //console.log("Printing from the Mixin")
    },
    methods: {
        notifyApiResponse: function (data) {
            notify({
                //title: data.title || this.title, // no title
                text: data.message || this.message,
                group: "general",
                type: data.type || this.type,
                duration: data.duration || this.duration,
                speed: 300,
                data: { test: "test data" }
            });
        },
        notifyCatchResponse: function (data) {
            notify({
                title: "Error !",
                text: data.message || this.message,
                group: "general",
                type: data.type || "warning",
                duration: data.duration || this.duration,
                speed: 300
            });
        }
    }
}