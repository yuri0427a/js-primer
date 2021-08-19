async function asyncMain() {
    try {
        const value = await Promise.reject(new Error("メッセージ"));
    }catch (error) {
        console.log(error.message); // => "エラーメッセージ"
    }
}
// asyncMainはResolvedなPromiseを返す
asyncMain().catch(error => {
    // すでにtry...catchされているため、この行は実行されません
});

