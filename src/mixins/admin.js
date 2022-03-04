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
    mounted: function () {
        $(function () {
            // change required fields label color for *
            let labels = document.getElementsByTagName('label'); // get all form labels
            for (let i = 0; i < labels.length; i++) {
                if (labels[i].innerHTML.includes("<i>")) { // have stong tag
                    let strongs = labels[i].getElementsByTagName('i');
                    strongs[0].classList.add("text-danger"); // change style
                }
            }
            // end
        });
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
                title: data.title || "Error occured !",
                text: data.message || this.message,
                group: "general",
                type: data.type || "warning",
                duration: data.duration || this.duration,
                speed: 300
            });
        }
    }
}