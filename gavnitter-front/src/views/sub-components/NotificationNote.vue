<template>
  <div class="border-1 border-primary">
    <div class="d-flex justify-content-start m-1 p-1 align-items-center body-notification">
      <div class="rounded-1">
        <img
            class="img-icon"
            v-if="bodyNotification.type===1"
            :src="require('@/assets/img/icons/heart-blue.svg')"
            alt="like">
        <img
            class="img-icon"
            v-else
            :src="require('@/assets/img/icons/comments-blue.svg')"
            alt="comments">
      </div>
      <div class="mx-3">
        <span>{{ bodyNotification.text }}t</span>
      </div>
      <div
          class="opacity-0 block-cancel"
          @click="$emit('deleteNotification', bodyNotification.id)"
      >
        <img
            class="img-cancel"
            :src="require('@/assets/img/icons/cancel.svg')"
            alt="cancel">
      </div>
    </div>
  </div>
</template>

<script>
import {defineComponent, onMounted} from "vue";
import axios from '@/libs/axios'

export default defineComponent({
  name: "Notification",
  props: {
    bodyNotification: Object,
  },
  setup(props) {
    return {

    }
  }
})
</script>

<style lang="scss" scoped>
.img-icon {
  height: 40px;
}

.img-cancel {
  height: 20px;
}

.block-cancel {
  cursor: pointer;
}

.body-notification {
  &:hover {
    background-color: rgba(250, 250, 250, 0.95) !important;
    .block-cancel {
      opacity: 1 !important;
    }
  }
}

</style>
