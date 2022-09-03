import VuexPersistence from 'vuex-persist'
import router from "@/router";

const vuexLocal = new VuexPersistence<State>({
    storage: window.localStorage
})

interface State {
    countLikes?: Number
    countComments?: Number,
}

const notification = {
    namespaced: true,
    state: {
        countLikes: 0,
        countComments: 0,
    },
    getters: {
        getCountLikes(state: State) {
            return state.countLikes;
        },
        getCountComments(state: State) {
            return state.countComments;
        },
    },
    mutations: {
        setCountLikes(state: State, count:number){
            state.countLikes = count;
        },
        setCountComments(state: State, count:number){
            state.countComments = count;
        },
    },
    actions: {
        setCountLikes({commit}:any, count:number){
            commit('setCountLikes', count);
        },
        setCountComments({commit}:any, count:number){
            commit('setCountComments', count);
        },
    },
    plugins: [vuexLocal.plugin]
}
export default notification;
