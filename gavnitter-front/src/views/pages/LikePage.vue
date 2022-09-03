<template>
  <div class="justify-content-start m-4">
    <div class="justify-content-start text-start mx-5">
      <span class="header-like-page">Who likes me</span>
    </div>
    <div class="mx-4">
      <div v-for="notification in notifications"
           :key="notification.id">
       <like-info
           :body-notification="notification"
       ></like-info>
        <hr>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, onMounted, Ref, ref} from "vue";
import LikeInfo from "@/views/sub-components/LikeInfo.vue"
import {getNotification} from "@/libs/functions/request"
export default defineComponent({
  name: "LikePage",
  components: {
    LikeInfo,
  },
  setup() {
    const notifications: Ref = ref(null);
    onMounted(async () => {
      notifications.value = await getNotification('like', true);
    });
    return {
      notifications,
    }
  }
})
</script>

<style scoped>
.header-like-page {
  font-size: 40px;
  color: #073779;
  font-weight: bolder;
  font-kerning: none;
}
</style>
