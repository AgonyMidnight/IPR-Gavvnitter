<template>
  <div>
    <div class="d-flex align-items-center flex-column m-5 p-5">
      <div v-if="errors.length !== 0"
           class="alert alert-danger m-3 w-75"
           role="alert">
        <ul class="text-start">
          <li v-for="error in errors">{{error}}</li>
        </ul>

      </div>

      <b-form class="row p-5"
              @submit.prevent="formSubmit">
        <div class="mt-5">
          <p>
            Create a new password
          </p>
        </div>
        <div>
          <b-input-group
              prepend="🔒"
              class="mb-3 mr-sm-2 mb-sm-0">
            <b-form-input
                v-model="password.password"
                class="mb-2 mr-sm-2 mb-sm-0"
                placeholder="***********"
                type="password"
                required
            ></b-form-input>
          </b-input-group>
        </div>

        <div class="mt-2">
          <b-input-group
              prepend="🔒"
              class="mb-3 mr-sm-2 mb-sm-0">
            <b-form-input
                v-model="password.password_confirmation"
                class="mb-2 mr-sm-2 mb-sm-0"
                placeholder="***********"
                type="password"
                required
            ></b-form-input>
          </b-input-group>
        </div>

        <div class="d-flex justify-content-center">
          <b-button
              class="mt-3 submit-btn"
              type="submit"
              variant="outline-primary"
          >
            Save
          </b-button>
        </div>

      </b-form>


    </div>
  </div>
</template>

<script lang="ts">
import {useRoute} from "vue-router";
import {computed, defineComponent, Ref, ref} from "vue";
import {resetPassword} from "@/libs/functions/request";
import {parsErrors} from "@/libs/functions/helper";

export default defineComponent({
  name: "ResetPassword",
  setup() {
    const route = useRoute();
    const password:any = ref({
      password: '',
      password_confirmation: '',
    });
    const errors:any = ref([]);

    const passwordLength = (pass:string) => {
      return pass !==''? pass.length >= 8:false;
    }

    const repeat = () => {
      return password.password === password.password_confirmation
          &&
          passwordLength(password.password_confirmation);
    }


    const formSubmit = async () => {
      errors.value = [];
      let response = await resetPassword(password.value, route.query.email, route?.query?.token);
      if (response.status !== 200) errors.value = [...errors.value, ...parsErrors(response.data)];
    }

    return {
      password,
      passwordLength,
      repeat,
      resetPassword,
      route,
      formSubmit,
      errors,
    }
  }
})
</script>

<style scoped>
.submit-btn {
  width: 100px;
}
</style>
