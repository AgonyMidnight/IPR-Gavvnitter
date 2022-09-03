<template>
  <div class="comment-line">
    <div class="text-center" v-if="comments === null">
      <b-spinner type="grow" variant="primary"></b-spinner>
    </div>

    <div
        v-if="comments.length === 0"
        class="text-center text-primary"
    >
      <span>There are no comments here yet 😔
        <p> Be the first!</p>
       </span></div>
    <div
        v-else
        v-for="comment in comments"
        class="m-2">
      <comment
          :bodyComment="comment"
      ></comment>
    </div>
  </div>
</template>

<script lang="ts">

import {computed, defineComponent, ref} from "vue";
import store from "@/store"
import Comment from "@/views/sub-components/Comment.vue";

export default defineComponent({
  name: "ShowComment",
  components: {
    Comment,
  },
  props: {
    postId: Number,
  },
  setup(props) {
    return {
      props,
      comments: computed(() => store.getters['comment/getComments']),
    }
  }
})
</script>

<style scoped>
.comment-line {
  max-height: 500px;
  overflow-y: scroll;
}
</style>
