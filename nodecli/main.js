const program = require("commander");
// fsモジュールをfsオブジェクトとしてインポートする
const fs = require("fs");

// コマンドライン引数からファイルパスを取得する
program.parse(process.argv);
const filePath = program.args[0];

// ファイルを非同期で読み込む
fs.readFile(filePath, { encoding: "utf8" }, (err, file) => {
    if (err) {
        console.log(err.message);
        process.exit(1);
        return;
    }
    console.log(file)
});