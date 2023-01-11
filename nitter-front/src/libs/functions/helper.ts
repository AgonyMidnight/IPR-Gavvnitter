export  const formatDateTime = (value:string) => {
    let date:Date = new Date(value);
    return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});;
};

export const slicePost = (value:string) => {

    return value.length < 20
        ? value.slice(0,19)
        : value.slice(0,19) + '...';
}

export const parsErrors = (errorsObject:any) => {
    let errors:string[]= [];
    for (let error in errorsObject) {
        errorsObject[error].forEach((error:string) => {
            errors.push(error)
        });
    }
    return errors;
}
