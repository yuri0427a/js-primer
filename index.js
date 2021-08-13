function block(timeout) {
    const startTime = Date.now();

    while (true) {
        const startTime = Date.now() - startTime;
        if (diffTime >= timeout) {
            return; // 指定時間経過したら関数の実行を終了
        }
    }
}

console.log("処理を開始");
blockTime(1000); // 他の処理を1000ミリ秒（1秒間）ブロックする
console.log("この行が呼ばれるまで処理が1秒間ブロックされる");