<template>
  <div class="m-2">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark nav-menu m-2">
      <div class="container-fluid">
        <router-link
            class="navbar-brand"
            :to="{name:'home'}"
        >
          <img
              :src="require('@/assets/img/icons/logo-white.svg')"
              alt="logo" style="height: 50px; margin-right: 20px">
        </router-link>
        <div
            v-if="isAuth"
            class="collapse navbar-collapse"
        >
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li
                class="nav-item d-flex justify-content-end m-2"
                aria-label="Toggle navigation"
            >
              <b-dropdown
                  split
                  variant="outline-primary"

                  toggle-class="text-decoration-none"
                  no-caret
                  class="m-2"
                  @click="router.push({name:'user-like'})"
              >
                <template #button-content>

                  <img
                      class="menu-icon mx-1"
                      :src="require('@/assets/img/icons/heart-light.svg')"
                      alt="likes"
                  >
                  <div
                      v-if="countLikes > 0"
                      class="position-relative">
                    <div class="rounded-4 count-notification-like px-1">
                      <span>{{ countLikes }}</span>
                    </div>
                  </div>

                </template>
                <notification-bar
                    ref="notificationLikes"
                    :type="'like'"
                ></notification-bar>
              </b-dropdown>
            </li>

            <li
                class="nav-item d-flex justify-content-end m-2"
                aria-label="Toggle navigation">
              <b-dropdown
                  variant="outline-primary"
                  split
                  class="m-2"
                  @click="router.push({name:'user-post'})">
                <template #button-content>
                  <div class="d-flex justify-content-center"
                  >
                    <img
                        class="menu-icon mx-1"
                        :src="require('@/assets/img/icons/comments-ligth.svg')"
                        alt="likes"
                    >
                    <div v-if="countComments > 0"
                         class="position-relative">
                      <div class="rounded-4 count-notification px-1">
                        <span>{{ countComments }}</span>
                      </div>
                    </div>

                  </div>
                </template>
                <notification-bar
                    ref="notificationComments"
                    :type="'comment'"
                ></notification-bar>
              </b-dropdown>
            </li>
            <li
                class="nav-item d-flex justify-content-center align-items-center"
            >
              <span
                  class="user-name"
              >{{ name }}</span>
            </li>
          </ul>
          <b-dropdown variant="link" toggle-class="text-decoration-none me-5" right no-caret>
            <template #button-content><span class="navbar-toggler-icon"></span></template>
            <b-dropdown-item href="#">
              <router-link :to="{name: 'user-profile'}">Profile</router-link>
            </b-dropdown-item>
            <b-dropdown-item href="#" @click="logout()">Exit</b-dropdown-item>
          </b-dropdown>
        </div>
      </div>
    </nav>
  </div>
</template>

<script lang="ts">
import store from "@/store";
import {defineComponent, ref, onMounted, Ref, watch, computed} from 'vue';
import router from "@/router";
import NotificationNote from "@/views/sub-components/NotificationNote.vue";
import NotificationBar from "@/views/sub-components/NotificationBar.vue";
import {logout} from '@/libs/functions/request';

export default defineComponent({
  name: "NavBarBoot",
  components: {
    NotificationBar,
    NotificationNote,
  },
  setup() {
    const notificationLikes = ref(null);
    const notificationComments = ref(null);

    onMounted(() => {
      if (store.getters['user/getProfile']['id']) {
        window.Echo.private(
            `post-notification.${store.getters['user/getProfile']['id']}`
        )
            .listen('NotificationPost',
                (e: any) => {
                  if (e.notifications.type === 1) {
                    if (e.move === 'add') {
                      // @ts-ignore
                      notificationLikes.value.addNotification(e.notifications);
                    } else {
                      // @ts-ignore
                      notificationLikes.value.deleteOneNotification(e.notifications.id);
                    }
                  } else {
                    if (e.move === 'add') {
                      // @ts-ignore
                      notificationComments.value.addNotification(e.notifications);
                    } else {
                      // @ts-ignore
                      notificationComments.value.deleteOneNotification(e.notifications.id);
                    }
                  }
                })
      }
    })

    return {
      name: computed(() => store.getters['user/getProfile'].login ?? store.getters['user/getProfile'].user),
      logout,
      isAuth: computed(() => store.getters['user/getIsAuth']),
      notificationLikes,
      countLikes: computed(() => store.getters['notification/getCountLikes']),
      notificationComments,
      countComments: computed(() => store.getters['notification/getCountComments']),
      router,
    }
  },

})
</script>

<style lang="scss" scoped>
.nav-menu {
  background-color: #165BBA !important;
  box-shadow: 0 0 20px #073779;
  border-radius: 25px;
  min-height: 80px;
}

.menu-icon {
  height: 25px;
}

.user-name {
  font-size: 20px;
  font-weight: bold;
  margin: 0 50px;
  color: #cbd5e0;
}

.navbar-toggler-icon {
  border-color: #cbd5e0;
}

.collapse-menu {
  position: absolute;
  text-align: left;
  right: 10px;
  top: 70px;
  width: 120px;
  height: 70px;
  background-color: #165BBA !important;
  box-shadow: 0 0 20px #073779;
  border-radius: 10px;
  z-index: 999;

  a {
    margin-bottom: 10px;
    margin-left: 20px;
    list-style-type: none;
    color: #cbd5e0 !important;
    font-size: 22px;
  }
}

.count-notification {
  width: fit-content;
  min-width: 21px;
  height: 23px;
  background-color: #9242dc !important;
  position: absolute;
  bottom: 12px;
  left: -7px;

  span {
    font-size: 12px;
    color: #cbd5e0;
    font-weight: bolder;
  }
}

.count-notification-like {
  width: fit-content;
  min-width: 21px;
  height: 23px;
  background-color: #9242dc !important;
  position: absolute;
  bottom: 12px;
  left: 18px;

  span {
    font-size: 12px;
    color: #cbd5e0;
    font-weight: bolder;
  }
}
</style>
