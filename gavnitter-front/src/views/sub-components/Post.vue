<template>
  <div class="post-body">
    <div class="p-1">
      <div class="d-flex align-items-start px-1 my-1">
          <span
              class="post-author mx-1"
              @click="getProfile(post?.author?.id)"
          >{{ post?.author?.login ?? ' ' }}</span>
      </div>
      <div class="d-flex w-100 justify-content-start align-items-start">
        <img
            :src="urlBack+'/storage/'+ post?.author?.avatar"
            alt=""
            class="post-img mx-2"
        >
        <p class="post-message d-flex text-start p-1 mb-2">{{ post.message }}</p>
      </div>
    </div>
    <div class="post-panel d-flex justify-content-end">
      <span class="mx-5">{{ formatDateTime(post?.updated_at) }}</span>
      <div class="px-3">
        <img
            class="post-panel-icon"
            :src="require('@/assets/img/icons/comments-blue.svg')"
            v-b-modal="'comments-modal-' + post.id"
            alt="likes"
        >
        <span class="post-panel-font ps-2"> {{ checkLastPost !== post.id? post.comments_count : 0 }}</span>
      </div>

      <b-modal
          ref="modal"
          :id="'comments-modal-' + post.id"
          title="Gavno-Comments"
          @show="loadComments"
          @hidden="clearStore"
          hide-footer
      >
        <div>
          <show-comment
              v-if="showCommentsModal"
              :postId="post.id"
          ></show-comment>
        </div>
        <div>
          <comment-creator
              class="comment-creator m-1 align-items-end"
              :postId="post.id"
          ></comment-creator>
        </div>

      </b-modal>

      <div class="px-3">
        <img class="post-panel-icon"
             :src="post.selfLike?
              require('@/assets/img/icons/heart-dark-fill.svg')
              :require('@/assets/img/icons/heart-blue.svg')"
             alt="likes"
             @click="setLike"
        >
        <span class="post-panel-font ps-2">{{ post.likes_count ?? 0 }}</span>
      </div>
    </div>
  </div>

</template>

<script>
import ShowComment from "@/views/sub-components/ShowComment";
import CommentCreator from "@/views/sub-components/CommentCreator";
import store from '@/store'
import {computed, defineComponent, ref} from "vue";
import {clearStore, getProfile, loadCommentsPost, setLikeRequest} from "@/libs/functions/request";
import {formatDateTime} from "@/libs/functions/helper";

export default defineComponent({

  components: {CommentCreator, ShowComment},
  name: "Post",
  props: [
    'bodyPost',
  ],
  setup(props) {
    const showCommentsModal = ref(false);

    const post = (computed(() => props.bodyPost)) ;

    const loadComments = () => {
      showCommentsModal.value = true;
      loadCommentsPost(post.value.id);
    };


     async function setLike  ()  {
      let response = await setLikeRequest(post.value.id);
      if(response) {
        post.value.selfLike = response.likeStatus;
        response.likeStatus?
            post.value.likes_count++
            : post.value.likes_count--;
      }
    }

    return {
      showCommentsModal,
      post,
      loadComments,
      clearStore,
      setLike,
      getProfile,
      checkLastPost: computed(() => store.getters['comment/getPostId']),
      urlBack: computed(() => process.env.VUE_APP_MIX_BASE_URL_BACK),
      formatDateTime,
    }
  },

})
</script>

<style lang="scss" scoped>
a {
  text-decoration: none;
  &:hover {
    text-decoration: none !important;
  }
}

.post-img {
  width: 120px;
  border-radius: 15px;
  border: #073779 solid 1px;
}

.post-author {
  margin-top: 20px;
  font-size: 1.4em;
  font-weight: bold;
  cursor: pointer;
}

.post-body {
  font-size: 20px;
  position: relative;
  background-color: rgb(246, 243, 243) !important;
  border-radius: 15px;
  box-shadow: 0 0 15px rgb(138, 135, 135);
  margin-bottom: 20px;
}

.post-panel {
  padding: 10px 0;
}

.post-panel-icon {
  height: 25px;
  cursor: pointer;
}

.post-message {
  font-size: 20px;
}

.comment-creator {
  height: 15%;
}
</style>
