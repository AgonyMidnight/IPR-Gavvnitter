<template>
  <div class="block-info text-center align-items-center p-1">
    <h1>Users Info</h1>
    <hr>
    <div class="row">
      <span class="col-3">Name:</span>
      <span class="col-8">{{ user.name }}</span>
    </div>
    <div class="row">
      <span class="col-3">Login:</span>
      <span class="col-8">{{ user.login }}</span>
    </div>
    <div class="row">
      <span class="col-3">Sex:</span>
      <span class="col-8">{{ setGender(user.gender) }}</span>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "@/libs/axios";
import {defineComponent, onMounted, Ref, ref} from "vue";
import {useRoute} from "vue-router";
import router from "@/router";

export default defineComponent({
  name: "UserInfo",
  setup() {
    const route = useRoute();
    const user: Ref = ref({})
    onMounted(() => {
      axios.get('/api/user/info', {
        params: {
          id: route.params.id,
        }
      }).then(response => {
        user.value = response.data.userData !== 'null' ?
            response.data.userData
            : router.push({name: 'home'});
      })
    })

    const setGender = ((value:Number) => {
      switch (value) {
        case 1:
          return 'Male';
        case 2:
          return 'Female';
        case 0:
        default:
          return 'Unknown';
      }
    })
    return {
      user,
      setGender,
    }
  }
})
</script>

<style scoped>
.block-info {
  border-radius: 15px;
  box-shadow: 0 0 15px rgb(138, 135, 135);
}
</style>
