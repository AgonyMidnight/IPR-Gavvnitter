import VuexPersistence from 'vuex-persist'
import axios from "@/libs/axios";
import notification from "@/store/notification";

const vuexLocal = new VuexPersistence<State>({
    storage: window.localStorage
})

interface State {
    comments: object[],
    postId: null | number,
}

const comment = {
    namespaced: true,
    state: {
        comments: [],
    },
    getters: {
        getComments(state: State) {
            return state.comments;
        },
    },
    mutations: {
        setComments(state: State, comments: object[]) {
            state.comments = [...state.comments, ...comments];
        },
        addComments(state: State, comment: object) {
            state.comments.push(comment);
        },
        deleteComments(state:State, commentId:number) {
            state.comments = state.comments.filter((el:any) => el.id !== commentId);
        },
        clearComment(state: State) {
            state.comments = [];
        }
    },
    actions: {
        setPostId({commit}: any, postId: number) {
            commit('setPostId', postId);
        },
        setComments({commit}: any, comments: object[]) {
            commit('setComments');
        },
        addComments({commit}: any, comment:object) {
            commit('addComments');
        },
        deleteComments({commit}: any,commentId:number) {
            commit('deleteComments');
        },
        clearComment({commit}: any) {
            commit('clearComment');
        },
    },
}
export default comment;
