import { createStore } from 'vuex';
import user from '@/store/user';
import notification from '@/store/notification';
import comment from '@/store/comment'
import post from '@/store/post'
import VuexPersistence from 'vuex-persist';


export default createStore({
  modules:{
    user,
    notification,
    comment,
    post,
  },
  plugins: [new VuexPersistence().plugin]
})


