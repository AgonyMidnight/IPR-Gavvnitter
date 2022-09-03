<template>
  <component :is="nav">
  </component>
  <router-view/>
</template>

<script lang="ts">
import NavBar from "@/views/nav-bar/NavBar.vue";
import NavBarBoot from "@/views/nav-bar/NavBarBoot.vue";

import {defineComponent, computed} from "vue";
import {useRouter, useRoute} from 'vue-router';

export default defineComponent({
  components: {
    NavBar,
    NavBarBoot,
  },
  setup() {
    const route = useRoute()

    let nav = computed(
        () => route.meta.layout === "full" ? '' : NavBarBoot
    )

    return {
      nav,
    }
  },

})
</script>

<style lang="scss">

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

</style>
