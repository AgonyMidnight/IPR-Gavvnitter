import VuexPersistence from 'vuex-persist'
const vuexLocal = new VuexPersistence<State>({
    storage: window.localStorage
})

interface State {
    posts: object[],
}
const post = {
    namespaced:true,
    state: {
        posts: [],
    },
    getters: {
        getPosts(state:State) {
            return state.posts;
        }
    },
    mutations: {
        deletePost(state:State, postId:number) {
            state.posts = state.posts.filter((el:any) => el.id !== postId);
        },
        clearPosts(state: State) {
            state.posts = [];
        },
        setPosts(state: State, posts: object[]) {
            state.posts = posts;
        },
        addPosts(state: State, posts: object[]) {
            state.posts = [...state.posts, ...posts];
        },
        addPost(state: State, post: object) {
            state.posts = [post, ...state.posts];
        },
        updatePost(state:State, post:object){
            //@ts-ignore
            //let index = state.posts.findIndex((el:any) => el.id === post.id)
            //@ts-ignore
            //state.posts[index].comments_count = post.comments_count;

            //@ts-ignore
            let storePost = state.posts.find((el:any) => el.id === post.id);
            //@ts-ignore
            storePost.comments_count = post.comments_count;
        }
    },
    actions:{
        addPost({commit}:any, post: object) {
            commit('addPost',post);
        },
    }
}
export default post;
