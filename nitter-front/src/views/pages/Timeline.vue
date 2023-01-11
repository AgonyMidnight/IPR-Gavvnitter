<template>
  <div class="mx-5 mt-4">
    <div class="timeline-posts d-flex flex-column-reverse flex-sm-row flex-wrap">
      <div class="posts-array col-12 col-sm-7">
        <div v-for="post in posts" :key="post.id">
          <post
              class="mb-3"
              :bodyPost="post"
          ></post>
        </div>
        <div>
          <button
              class="btn btn-primary"
              @click="getPosts(++numberPage, null)"
          >More
          </button>
        </div>
      </div>

      <div class="new-post col-12 col-sm-5 ps-0 ps-sm-3 position-relative">
        <post-creator></post-creator>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Post from '@/views/sub-components/Post.vue'
import PostCreator from "@/views/sub-components/PostCreator.vue";
import axios from "@/libs/axios";
import store from "@/store"
import {getPosts} from "@/libs/functions/request"
import {computed, defineComponent, onMounted, ref, Ref} from "vue";

export default defineComponent({
  name: "Timeline",
  components: {
    Post,
    PostCreator,
  },
  setup() {
    const numberPage:Ref =  ref(1);

   onMounted( () => {
      getPosts(numberPage.value, null);
   })

    return {
      getPosts,
      posts: computed(() => store.getters['post/getPosts']),
      numberPage,
    }
  }
})
</script>

<style scoped>

</style>
