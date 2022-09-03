<template>
  <!--
  <nav>
    <router-link to="/">Home</router-link>
    | <nav-bar></nav-bar>
    <router-link to="/about">About</router-link>
  </nav>
  -->
  <component :is="nav">
  </component>
  <router-view/>
</template>

<script lang="ts">
import store from '@/store'
import NavBar from "@/views/nav-bar/NavBar.vue";
import NavBarBoot from "@/views/nav-bar/NavBarBoot.vue";

import {defineComponent, onMounted, Ref, ref, computed, watch} from "vue";
import {useRouter, useRoute} from 'vue-router';
import router from "@/router";

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

    onMounted(() => {
    });

    return {
      nav,
    }
  },
  /*
  created() {
    window.Echo.private(`post-notification.${store.getters['user/getProfile'].id}`)
        .listen('NotificationPost', (e) => {
          console.log('test successful ')
          console.log(e);
        })
  } */
  //   console.log('window.Echo.private',window.Echo.private('post-notification'))
  //   window.Echo.private('post-notification')
  //       .listen('.post-notification.NotificationPost',
  //           (e) => {
  //         console.log('test successful ' + e)
  //       })
  // }

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

nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
