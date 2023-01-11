<template>
  <div>
    <b-card class="d-flex justify-content-center align-items-center body-authorisation align-middle">
      <b-form
          @submit="loginUser(user)"
          inline
          class="d-flex justify-content-center align-items-center text-center"
      >
        <div class="row">
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
                  v-model="user.email"
                  class="mb-2 mr-sm-2 mb-sm-0"
                  placeholder="john_doe@mail.com"
                  type="email"
                  required
              ></b-form-input>
            </b-input-group>
          </div>
          <div class="col-12">
            <label
                class="sr-only"
                for="inline-form-input-password"
            >Password</label>
          </div>
          <div class="col-12">
            <b-input-group
                prepend="🔒"
                class="mb-2 mr-sm-2 mb-sm-0"
            >
              <b-form-input
                  id="inline-form-input-password"
                  v-model="user.password"
                  class="mb-2 mr-sm-2 mb-sm-0"
                  placeholder="*****"
                  type="password"
                  required
              ></b-form-input>
            </b-input-group>
          </div>
          <div class="col-12">
            <span class="help-user-span">Don't have an account?
              <router-link to="registration">Sign up</router-link></span>
          </div>
          <div class="col-12">
            <span class="help-user-span">
              <router-link to="forgot-password">Forgot your password?</router-link>
            </span>
          </div>
          <div class="d-flex justify-content-center">
            <b-button
                type="submit"
                class="mt-2 col-3"
                variant="outline-primary"
            >Login
            </b-button>
          </div>
        </div>
      </b-form>
    </b-card>
    <div class="align-items-end text-center m-3">
      <img :src="require('@/assets/img/background.png')"
           alt="">
    </div>
  </div>
</template>

<script lang="ts">
import { ref, defineComponent } from 'vue'
import {loginUser} from '@/libs/functions/request'
export default defineComponent ({
  name: "Login",
  setup () {
    let user = ref({
      email: '',
      password: '',
    });

    return {
      user,
      loginUser,
    }
  },
})
</script>

<style scoped>
.body-authorisation {
  width: 350px;
  margin: 50px auto;
}

.help-user-span {
  display: flex;
  justify-content: left;
  margin-top: 5px;
}
</style>
