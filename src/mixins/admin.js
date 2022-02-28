export default {
    data() {
        return {
            toastMessage: "Message",
            toastType: "bg-primary",
            toastBG: "bg-primary",
            toastBgClass: "bg-primary",
        };
    },
    computed: {
        toastBgClassZz() {
            return "bg-" + this.toastType
        }
    },
    created: function () {
        //console.log("Printing from the Mixin")
    },
    methods: {
        toastResponse: function (data) {
            this.toastMessage = data.message;
            this.toastType = data.type;
            this.toastBgClass = "bg-" + data.type;
            this.toastBG = "bg-" + data.type;
            window.toast.show();
        }
    }
}