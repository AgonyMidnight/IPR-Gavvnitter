<template>
  <div class="d-flex justify-content-start align-items-center m-5">
    <img
        :src="require('@/assets/img/registration.webp')"
        class="img-registration"
        alt="">
    <b-card class="body-registration m-1">
      <b-form
          inline
          class="form-registration"
          @submit.prevent="registrationUser"
      >
        <div class="row">
          <div v-if="errors.length !== 0"
               class="alert alert-danger col-12 m-3 w-75"
               role="alert">
            <ul class="text-start">
              <li v-for="error in errors">{{error}}</li>
            </ul>

          </div>
          <div class="col-4 d-flex justify-content-start">
            <span
                class="mb-2 align-baseline"
            >Email</span>
          </div>
          <div class="col-8">
            <b-form-input
                v-model="user.email"
                class="mb-2"
                placeholder="john_doe@mail.com"
                type="email"
                required
            ></b-form-input>
          </div>

          <div class="col-4 d-flex justify-content-start">
            <span class="mb-2">Login</span>
          </div>
          <div class="col-8">
            <b-form-input
                v-model="user.login"
                class="mb-2"
                placeholder="john_doe"
                required
            ></b-form-input>
          </div>

          <div class="col-4 d-flex justify-content-start">
            <span class="mb-2">Name</span>
          </div>
          <div class="col-8">
            <b-form-input
                v-model="user.name"
                class="mb-2"
                placeholder="John"
                required
            >
            </b-form-input>
          </div>

          <div class="col-4 d-flex justify-content-start">
            <span class="mb-2">Password</span>
          </div>
          <div class="col-8">
            <b-form-input
                v-model="user.password"
                class="mb-2"
                placeholder="*******"
                type="password"
                required
            >
            </b-form-input>
          </div>


          <div class="col-4 d-flex justify-content-start">
            <span class="mb-2">Repeat password</span>
          </div>
          <div class="col-8">
            <b-form-input
                v-model="user.password_confirmation"
                class="mb-2"
                placeholder="*******"
                type="password"
                required
            ></b-form-input>
          </div>
        </div>
        <div class="d-flex justify-content-center">
          <b-button
              type="submit"
              class="d-flex justify-content-center"
              variant="outline-primary">Save
          </b-button>
        </div>
      </b-form>
    </b-card>
  </div>
</template>

<script lang="ts">
import { ref, defineComponent } from 'vue'
import {createFormSubmit} from '@/libs/functions/request'
import {parsErrors} from "@/libs/functions/helper";
export default defineComponent({
  name: "Registration",
  setup() {
    const errors:any = ref([]);
    let user = ref ({
      email: '',
      name: '',
      login: '',
      password: '',
      password_confirmation: '',
    });

    const registrationUser = async () => {
      errors.value = [];
      let response = await createFormSubmit(user.value);
      //@ts-ignore
      if (response?.status !== 200) {
        //@ts-ignore
        errors.value = [...errors.value, ...parsErrors(response?.data)]
      }
    }

    return {
      user,
      createFormSubmit,
      errors,
      registrationUser,
    }
  }
})
</script>

<style scoped>
.body-registration {
  height: fit-content;
  width: 500px;
}
.img-registration {
  height: 600px;
}
</style>
