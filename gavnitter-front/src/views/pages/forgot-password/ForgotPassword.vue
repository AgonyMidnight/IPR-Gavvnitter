<template>
  <div class="m-5">
    <div class="d-flex justify-content-center align-items-center h-75">
      <div class="align-items-end">
        <img
            class="h-50"
            :src="require('@/assets/img/form-reset-password.png')"
            alt="">
      </div>
      <div class="align-items-start">
        <div class="col-12">
          <label class="sr-only"
                 for="inline-form-input-email"
          >Email</label>
        </div>
        <div class="col-12">
          <b-input-group
              prepend="@"
              class="mb-3 mr-sm-2 mb-sm-0">
            <b-form-input
                id="inline-form-input-email"
                v-model="email"
                class="mb-2 mr-sm-2 mb-sm-0"
                placeholder="john_doe@mail.com"
                type="email"
                required
            ></b-form-input>
          </b-input-group>
        </div>
        <div>
          <b-button
              variant="outline-primary"
              class="m-3"
              @click="forgotPassword(email)"
          >
            Enter
          </b-button>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, ref} from "vue";
import {forgotPassword} from "@/libs/functions/request";

export default defineComponent({
  name: "ForgotPassword",
  setup() {
    const email = ref(null);

    return {
      email,
      forgotPassword,
    }
  },
})
</script>

<style scoped>
img {
  height: 300px !important;
}
</style>
