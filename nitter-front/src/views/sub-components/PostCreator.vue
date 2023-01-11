<template>
  <div class="creator-body rounded-3 d-flex flex-column p-4">
    <div>
      <span class="fw-bold fs-5">Create Post</span>
    </div>
    <div class="my-3">
      <b-form-textarea
          class="creator-enter"
          v-model="textPost"
          :state="textPost.length > 255? false: null"
          no-resize
          rows="4"
          placeholder="Enter the text of your new message"
      ></b-form-textarea>
    </div>
    <div>
      <b-button
          class="btn-create"
          variant="outline-primary"
          @click="submitPost">
        Create
      </b-button>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "@/libs/axios";
import store from "@/store"
import { defineComponent, ref } from 'vue'
import { createToast } from 'mosha-vue-toastify';
import {submitPostRequest} from "@/libs/functions/request";


export default defineComponent({
  name: "PostCreator",

  setup () {
    const textPost = ref('');
    const submitPost = () => {
      submitPostRequest(textPost.value);
      textPost.value = '';
    }

    return {
      submitPost,
      textPost,
    }
  }
})


</script>

<style scoped>
.creator-body {
  background-color: rgb(246, 243, 243) !important;
  box-shadow: 0 0 5px rgba(138, 135, 135, 0.96);
  position: sticky;
  top: 20px;
}

/*.btn-create {*/
/*  position: absolute;*/
/*  bottom: 10px;*/
/*}*/

.creator-enter {
  background-color: rgb(246, 244, 244) !important;
}
/*  text-align: center;*/
/*  height: 100px;*/
/*  width: 80%;*/
/*  margin-bottom: 40px;*/
/*}*/

/*.post-header {*/
/*  position: absolute;*/
/*  top: 10px;*/
/*  font-size: 1.2em;*/
/*  font-weight: bold;*/
/*}*/
</style>
