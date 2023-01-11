import {createToast} from "mosha-vue-toastify";

export const toastFail = (text: string) => {
    createToast({
        description: text,
    }, {
        type: 'danger',
        showIcon: true,
    })
}

export const toastSuccess = (text: string) => {
    createToast({
        description: text,
    }, {
        type: 'success',
        showIcon: true,
    })
}
