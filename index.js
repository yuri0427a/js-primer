function dummyFetch(path) {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
            if (path.startsWith("/success")) {
                resolve({ body: `Response body of ${path}` });
            } else {
                reject(new Error("NOT FOUND"));
            }
        }, 1000 * Math.random())
    })
}

dummyFetch("/success/data").then(function onFulfilled(response) {
    console.log(response);
}, function onRejected(error) {
    // この行は実行されません
});

dummyFetch("/failure/data").then(function onFulfilled(response){

}, function onRejcted(error) {
    console.log(error);
});