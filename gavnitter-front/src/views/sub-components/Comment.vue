<template>
  <div class="comment">
    <div>
      <span
          @click="getProfileUser(bodyComment?.author?.id)"
          class="comment-author">{{ bodyComment?.author?.login ?? 'unknown' }}</span>
      <p>{{ bodyComment?.text_comment }}</p>
    </div>
    <hr>
    <div class="comment-info-panel text-center">
      <div
          class="w-50"
      >{{ formatDateTime(bodyComment?.updated_at) }}
      </div>
      <div class="comment-info-panel-button">
        <div
            class="comment-info-panel-button"
            v-if="user.id === bodyComment?.author?.id">
          <div class="d-flex align-items-center justify-content-end">
            <div
                @click="deleteComment(bodyComment.id)"
            >
              <a
                  class="deleteLink"
              >
                Delete </a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">

import {computed, defineComponent} from "vue";
import store from "@/store";
import {deleteComment, getProfile} from "@/libs/functions/request"
import {formatDateTime} from "@/libs/functions/helper"

export default defineComponent({
  name: "Comment",
  props: {
    bodyComment: Object,
  },
  setup(props) {
    const user = computed(() => store.getters['user/getProfile']);

    const getProfileUser = (id:number) => {
      //@ts-ignore
      document.querySelector('#comments-modal-' + props.bodyComment.post_id + ' .btn-close').click();
      getProfile(id);
    }

    return {
      props,
      formatDateTime,
      getProfileUser,
      getProfile,
      user,
      deleteComment,
    }
  }
})
</script>

<style scoped>
a {
  cursor: pointer;
  text-decoration: none;
}

.comment {
  padding: 10px;
  border-radius: 15px;
  border: #a4a6a8 solid 1px;
}

.comment-author {
  cursor: pointer;
  font-weight: bold;
  font-size: 1.5vm;
}

.comment-info-panel {
  display: flex;
  justify-content: space-around;
  font-size: 0.8vm;
  color: #073779;
}

.editLink {
  font-size: 1.5vm;
  color: darkgreen;
}

.deleteLink {
  font-size: 1.5vm;
  color: #001764;
}

.comment-info-panel-button {
  border-left: #c2c2c2 1px solid;
  width: 40%;
}
</style>
