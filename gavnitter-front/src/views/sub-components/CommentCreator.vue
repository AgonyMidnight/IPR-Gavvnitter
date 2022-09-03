<template>
  <div>
    <b-form
        @submit.prevent="saveComment"
    >
      <b-form-textarea
          class="comment-enter"
          v-model="textComment"
          :state="textComment?.length > 255? false: null"
          no-resize
          required
      >

      </b-form-textarea>
      <div class="m-2">
        <b-button
            class="btn-create"
            variant="outline-primary"
            type="submit"
            size="sm"
        >
          Create
        </b-button>
        <b-button
            @click="textComment=null"
            variant="outline"
            size="sm"
        >
          Cancel
        </b-button>
      </div>
    </b-form>


  </div>
</template>

<script lang="ts">
import {defineComponent, Ref, ref,} from "vue";
import {submitComment} from '@/libs/functions/request'

export default defineComponent({
  name: "CommentCreator",
  props: {
    postId: Number,
  },
  setup(props) {
    const textComment: Ref = ref(null);

    const saveComment = () => {
      submitComment(props.postId, textComment.value);
      textComment.value = null;
    }
    return {
      textComment,
      submitComment,
      saveComment,
    }
  },
})
</script>

<style scoped>

</style>
