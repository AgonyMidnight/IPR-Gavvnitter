<template>
  <div class="m-5 main-block">
    <div class="row">
      <div class="col-4">
        <div class="col-12 p-1 m-1">
          <img
              :src="urlBack+'/storage/'+user.avatar"
              alt="avatar"
              class="user-avatar">
        </div>
        <div class="mt-4">
          <b-form
              enctype="multipart/form-data"
              @submit="saveImage(file, form)"
              class="large-12 medium-12 small-12 cell">
            <label>
              <input
                  type="file"
                  @change="onFileChanged($event)"
                  accept="image/*"
              />
            </label>
            <b-button
                type="submit"
                variant="outline-primary"
            >Submit
            </b-button>
          </b-form>
        </div>
      </div>
      <div class="col-1"></div>
      <div class="col-7 text-start">
        <div class="col-8">
          <div class="d-flex justify-content-between align-items-center">
            <label for="user-email" class="col-3">Email</label>
            <b-form-input
                id="user-email"
                v-model="user.email"
                class="mb-2 col-8"
                placeholder="john_doe@mail.com"
                type="email"
            ></b-form-input>
          </div>
        </div>
        <div class="col-8">
          <div class="d-flex justify-content-between align-items-center">
            <label for="user-name" class="col-3">Name</label>
            <b-form-input
                id="user-name"
                v-model="user.name"
                class="mb-2 col-8"
                placeholder="your nmae"
            ></b-form-input>
          </div>
        </div>
        <div class="col-8">
          <div class="d-flex justify-content-between align-items-center">
            <label for="user-login" class="col-3">Login</label>
            <b-form-input
                id="user-login"
                v-model="user.login"
                class="mb-2 col-8"
                placeholder="john_doe@mail.com"
            ></b-form-input>
          </div>
        </div>

        <div class="col-4">
          <b-form-group
              label="Sex:"
              v-slot="{ ariaDescribedby }"
              class="d-flex justify-content-start text-start m">
            <b-form-radio
                v-model="user.sex"
                :aria-describedby="ariaDescribedby"
                name="some-radios"
                value="Male">Male
            </b-form-radio>
            <b-form-radio
                v-model="user.sex"
                :aria-describedby="ariaDescribedby"
                name="some-radios"
                value="Female">
              Female
            </b-form-radio>
          </b-form-group>
        </div>
        <div class="d-flex justify-content-center">
          <b-button
              class="m-2"
              variant="primary"
              @click="submitProfile(user)"
          >Save
          </b-button>
          <b-button
              class="m-2"
              variant="outline-danger"
              @click="cancelChange()"
          >Cancel
          </b-button>
        </div>
      </div>
    </div>

  </div>
</template>

<script lang="ts">
import {computed, defineComponent, onMounted, ref, Ref} from "vue";
import store from "@/store";
import {submitProfile, saveImage} from '@/libs/functions/request'


export default defineComponent({
  name: "Profile",
  setup() {
    const file = ref<File | null>();
    const form = ref<HTMLFormElement>();
    const user: Ref = ref({
      name: '',
      login: '',
      email: '',
      sex: '',
      avatar: '',
    });

    function onFileChanged($event: Event) {
      const target = $event.target as HTMLInputElement;
      if (target && target.files) {
        file.value = target.files[0];
      }
    }

    const cancelChange = () => {
      user.value = store.getters['user/getProfile'];
    }

    return {
      form,
      file,
      user: computed(() => store.getters['user/getProfile']),
      urlBack: computed(()=> process.env.VUE_APP_MIX_BASE_URL_BACK),
      submitProfile,
      saveImage,
      onFileChanged,
      cancelChange,
    }
  },
})
</script>

<style scoped>
.main-block {
  font-size: 18px;
}

.user-avatar {
  width: 200px;
  box-shadow: 0 0 15px #6b7280;
  border-radius: 15px;
}
</style>
