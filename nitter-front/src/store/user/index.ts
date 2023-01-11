import VuexPersistence from 'vuex-persist'
import router from "@/router";
const vuexLocal = new VuexPersistence<State>({
    storage: window.localStorage
})
interface State {
    token?: String|null
    profile?: any,
}
const user =  {
    namespaced: true,
    state: {
        token: null,
        profile: [],
    },
    getters: {
        getToken(state:State) {
            return state.token;
        },
        getProfile(state:State){
            return state.profile;
        },
        getIsAuth(state:State) {
            return Boolean(state.token);
        }
    },

    mutations: {
        setToken(state:State, token:string) {
            state.token = token;
        },
        setProfile(state:State, userData?:any) {
            state.profile = userData;
            switch (userData['gender']) {
                case 1: {
                    state.profile.sex = 'Male';
                    break;
                }
                case 2: {
                    state.profile.sex = 'Female';
                    break;
                }
                default: {
                    state.profile.sex = 'Default';
                    break;
                }
            }
        },
        logout(state:State) {
            state.profile = [];
            state.token = null;
        },
        setAvatar(state:State, avatar?:string) {
            state.profile.avatar = avatar;
        }
    },

   actions: {
       setToken({commit}:any, token:string):any {
           commit('setToken',token);
       },
       setProfile({commit}:any, profile:any):any{
           commit('setProfile', profile);
       },
       logout({commit}:any):any {
           commit('logout');
       },
       setAvatar({commit}:any, avatar?: string) {
           commit('setAvatar', avatar);
       }
   },

    plugins: [vuexLocal.plugin]


}

export default user;
