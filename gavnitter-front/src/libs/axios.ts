import axios, { AxiosInstance } from "axios";
import store from "@/store";
import router from "@/router";

const apiClient: AxiosInstance = axios.create({
    baseURL: process.env.VUE_APP_MIX_BASE_URL_BACK,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Access-Control-Allow-Origin': '*',
    },
});

apiClient.interceptors.request.use(
    (config) => {
        // @ts-ignore
        config.headers.Authorization = 'Bearer '+ store.getters['user/getToken'];
        return config;
    }
)

apiClient.interceptors.response.use(
    response => response,
    error => {
        const { response } = error
        //message: "Unauthenticated."
        if (
            response.status === 401 &&
            response.data.message === 'Unauthenticated.'
        ) {
            store.commit('user/logout');
            router.push({name: 'login'});
        }


        return Promise.reject(error)
    }
)

export default apiClient;
