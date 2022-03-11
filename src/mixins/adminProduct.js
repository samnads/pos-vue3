export default function () {
    function randCode() {
        return Math.floor(Math.random() * (10000000 - 99999999 + 1)) + 99999999;
    }
    return {
        randCode
    }
}