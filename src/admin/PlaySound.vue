<template>
  <div></div>
</template>
<script>
import { inject } from "vue";
export default {
  props: {},
  setup() {
    const emitter = inject("emitter"); // Inject `emitter`
    emitter.on("playSound", (data) => {
      var audio = new Audio(require("@/assets/sounds/" + data.file + ".mp3"));
      audio.play();
    });
    return {};
  },
};
</script>

