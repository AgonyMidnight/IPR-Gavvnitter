<template>
<div>
  <div
      class="body-like-info d-flex justify-content-start align-items-center"
  >
    <div class="d-flex justify-content-center align-items-start col-2">
      <img
          :src="urlBack+'/storage/'+ notification?.author?.avatar"
          alt=""
          class="mx-2 rounded-3"
      >
    </div>
    <div class="col-8 text-start">
      <b @click="getProfile( notification?.value.author.id)">{{ notification?.author?.login}}</b>
      liked your post: "<i>{{slicePost(notification?.post?.message)}}</i>"
      in {{formatDateTime(notification?.created_at)}}
    </div>
  </div>
</div>
</template>

<script lang="ts">

import {computed, defineComponent} from "vue";
import router from "@/router";
import {formatDateTime, slicePost} from '@/libs/functions/helper'
import {getProfile} from  '@/libs/functions/request'

export default defineComponent({
  name: "LikeInfo",
  props: {
    bodyNotification: Object,
  },
  setup(props) {
    const notification = props.bodyNotification;

    return {
      notification,
      slicePost,
      getProfile,
      formatDateTime,
      urlBack: computed(()=> process.env.VUE_APP_MIX_BASE_URL_BACK),
    }
  },
})
</script>

<style lang="scss" scoped>
.body-like-info {
  font-size: 20px;
  height: 150px;
  img {
    height: 120px;
    border: #073779 1px solid;
  }
}
</style>
