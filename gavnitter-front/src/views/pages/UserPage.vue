<template>
  <div class="d-flex justify-content-between m-1">
    <div class="m-3 user-ingo-block">
      <user-info></user-info>
    </div>
    <div class="posts-array m-3">
      <div v-for="post in posts">
        <post :bodyPost="post"></post>
      </div>
      <div>
        <button
            class="btn btn-primary"
            @click="getPosts(numberPage, null)"
        >More
        </button>
      </div>
    </div>

  </div>
</template>

<script lang="ts">
import {computed, defineComponent, onMounted, ref} from "vue";
import Post from '@/views/sub-components/Post.vue'
import UserInfo from "@/views/sub-components/UserInfo.vue";
import {getPosts} from "@/libs/functions/request";
import store from "@/store";
import {useRoute} from "vue-router";
export default defineComponent({
  name: "UserPage",
  components: {
    Post,
    UserInfo,
  },
  setup() {
    let numberPage:number = 0;
    let userId:string|string[]|null = null;
    const route = useRoute();

    onMounted( () => {
      userId = route.params.id;
      getPosts(++numberPage, null);
    })
    return {
      getPosts,
      posts: computed(() => store.getters['post/getPosts']),
      numberPage,
    }
  },
})
</script>

<style scoped>
.posts-array {
  width: 58%;
  float: left;
}
.user-ingo-block {
  width: 38%;
  min-height: 500px;
}
</style>
