<template>
<div>
  <div class="justify-content-start text-start mx-5">
    <span class="header-post-page">New commented posts:</span>
  </div>
  <div>
    <div
        class="mx-5 col-7"
        v-for="post in posts" :key="post.id">
      <post
          class="mb-3"
          :bodyPost="post"
      ></post>
    </div>
  </div>
</div>
</template>

<script lang="ts">
import {defineComponent, onMounted, ref, Ref} from "vue";
import axios from "@/libs/axios";
import Post from "@/views/sub-components/Post.vue";
import {getPostsWithNewComment} from '@/libs/functions/request'
export default defineComponent({
  name: "CommentPage",
  components: {
    Post,
  },
  setup() {
    const posts: Ref = ref(null);
    let page = 0;

    onMounted(async () => {
      posts.value = await getPostsWithNewComment(++page);
    });
    return {
      posts,
    }
  }
})
</script>

<style scoped>
.header-post-page {
  font-size: 40px;
  color: #073779;
  font-weight: bolder;
  font-kerning: none;
}
</style>
