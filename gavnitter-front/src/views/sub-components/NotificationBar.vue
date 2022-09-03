<template>
  <div class="notification-bar rounded-1">
    <span
        class="m-5 text-center"
        v-if="notifications.length === 0"
    >No new alerts 🙁</span>
    <div v-for="notification in notifications">
      <notification-note
          :bodyNotification="notification"
          @deleteNotification="deleteNotificationMethod"
      ></notification-note>
    </div>
  </div>
</template>

<script lang="ts">
import NotificationNote from '@/views/sub-components/NotificationNote.vue'
import {defineComponent, onMounted, ref, Ref, watch,} from "vue";
import axios from "@/libs/axios";
import store from "@/store";
import {getNotification} from "@/libs/functions/request"

export default defineComponent({
  name: "NotificationBar",
  props:{
    type: String,
  },
  components:{
    NotificationNote,
  },
  setup(props) {
    const notifications:Ref = ref([]);

    onMounted(async  () => {
      notifications.value = await getNotification(props.type, false);
    });

    const deleteOneNotification = (id:number) => {
      notifications.value = notifications.value.filter((el:any) => el.id !== id);

    }

    const deleteNotificationMethod = (id:number)=>{
      axios.delete('/api/user/notification', {
        data: {
          id: id,
        }
      })
      deleteOneNotification(id);
    };

    watch(() => [...notifications.value], () => {
      store.commit(props.type === 'comment'?
          'notification/setCountComments':
          'notification/setCountLikes', notifications.value.length)
    })

    const addNotification = (n:any) => {
      notifications.value.unshift(n);
    };
    return {
      notifications,
      deleteNotificationMethod,
      addNotification,
      deleteOneNotification,
    }
  }
})
</script>

<style scoped>
.notification-bar{
  background-color: rgba(246, 243, 243, .9) !important;
  width: 300px;
  height: auto;
  max-height: 260px;
  overflow-y: scroll;
}
</style>
