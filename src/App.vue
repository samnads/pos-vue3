<template>
  <router-view></router-view>
</template>
<style>
@import url(https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700);
#app {
  font-family: "Roboto Condensed", Helvetica Neue, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
nav {
  padding: 30px;
}
nav a {
  font-weight: bold;
  color: #2c3e50;
}
nav a.router-link-exact-active {
  color: #42b983;
}
</style>
<script>
import { Tooltip } from "bootstrap";
export default {
  mounted() {
    new Tooltip(document.body, {
      selector: "[data-bs-toggle='tooltip']",
    });
  },
};
</script>
