import axios from "@/libs/axios";
import store from "@/store";
import router from "@/router";
import {toastFail, toastSuccess} from '@/libs/functions/toast'
import {Ref, ref} from "vue";
import {LocationQueryValue} from "vue-router";

export async function createFormSubmit(user: object) {
    return new Promise(resolve => {
        axios.post('/api/user/create',
            {
                'user': user,
            })
            .then(() => {
                toastSuccess('Thank you for registering');
                resolve(router.push('/login'));
            })
            .catch(error => {
                toastFail('You are not registered. Something went wrong. Sorry');
                resolve ({
                    data: error.response.data.message ?? {},
                    status: 423,
                });
            });
    });
}

export const loginUser = (user: object) => {
    axios.post('/api/user/login', {'user': user})
        .then(response => {
            store.commit('user/setToken', response.data.access_token);
            store.commit('user/setProfile', response.data.userData);
            router.push({name: 'home'});
            return {
                status: response.status,
            }
        })
        .catch(error => {
            toastFail(error.response.data.message);
            return {
                data: error.response.data.message ?? {},
                status: 423,
            }
        })
}

export const logout = () => {
    axios.get('/api/user/logout')
        .then(() => {
            store.commit('user/logout');
            router.push({name: 'login'});
        })
}

export const submitProfile = (user: object) => {
    axios.post('/api/user/profile/update', {
        user: user,
    }).then(res => {
        store.commit('user/setProfile', res.data.userData)
        toastSuccess('Changes saved!')
    }).catch(() => {
        toastFail('Error while saving data 🤬');
    })
}

export async function saveImage(file: object, form: Ref<HTMLFormElement>) {
    if (file) {
        axios.post('/api/user/profile/avatar', {
            avatar: file,
        }, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(res => {
            store.commit('user/setAvatar', res.data.userData);
        })
            .catch(error => {
                console.error(error);
                form.value?.reset();
                file = {};
            })
    }
}

export const getPostsWithNewComment = (page: number): any => {
    return new Promise(resolve => {
        axios.post('/api/user/posts', {
            numberPage: page,
        }).then(response => {
            resolve(response.data.posts);
        }).catch(e => {
            toastFail('Oops. Sorry =(');
            resolve([]);
        });
    });
}

export const getPosts = (numberPage: number, usersId: number | null = null) => {
    axios.get('/api/posts', {
        params: {
            numberPage: numberPage,
            usersId: usersId,
        }
    }).then(res => {
        store.commit(`post/${numberPage === 1 ? 'set' : 'add'}Posts`, res.data.posts);
    })
}

export async function getNotification(type: string | undefined, full: boolean): Promise<any> {
    return new Promise(resolve => {
        axios.get('/api/user/notification', {
            params: {
                type: type,
                full: full,
            },
        }).then(response => {
            resolve(response.data.notifications);
        }).catch(e => {
            resolve([])
        })
    })

}

export const deleteComment = (id: number | undefined) => {
    axios.delete('/api/posts/comment', {
        data: {
            id: id,
        }
    }).then(() => {
        store.commit('comment/deleteComments', id);
    });
};

export const getProfile = ((id: number | undefined) => {
    router.push(`/user/${id}`);
});

export const submitComment = (postId: number | undefined, textComment: string) => {
    axios.post('/api/posts/comment', {
        post_id: postId,
        text_comment: textComment,
    }).then(response => {
        store.commit('comment/addComments', response.data.comment);
        store.commit('post/updatePost', response.data.post);
    })
};

export const setLikeRequest = (id: number): any => {
    return new Promise(resolve => {
        axios.put('/api/posts/like',
            {
                post_id: id,
            }).then(response => {
            resolve(response.data);
        }).catch(error => console.log(error))
    })
}

export const loadCommentsPost = (id: number) => {

    axios.get('/api/posts/comment', {
        params: {
            post_id: id
        }
    }).then(response => {
        store.commit('comment/setComments', response.data.comments);
    })
}

export const clearStore = () => {
    store.commit('comment/clearComment');
};

export const submitPostRequest = (textPost: string) => {
    axios.post('/api/posts/create',
        {
            textPost: textPost,
        }
    ).then(response => {
        store.dispatch('post/addPost', response.data.post);
        toastSuccess('New post successfully created!');
    })
}

export const forgotPassword = (email: string) => {
    axios.post('/api/user/forgot-password', {
        email: email,
    }).then((response) => {
        toastSuccess('An email with a link to reset your password has been sent to your email.\n Check your mail!');
    })
}

export async function resetPassword(
    password: object,
    email: LocationQueryValue | LocationQueryValue[],
    token: LocationQueryValue | LocationQueryValue[]): Promise<any> {
    return new Promise(resolve => {
        axios.post('/api/user/reset-password', {
            password,
            email,
            token,
        }).then(response => {
            toastSuccess('Password changed successfully');
            resolve(router.push('/login'));
        }).catch(error => {
            resolve({
                data: error.response.data.message ?? {},
                status: 423,
            });
        })
    });
}
