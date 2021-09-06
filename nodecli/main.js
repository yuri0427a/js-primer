const program = require("commander");
// fsモジュールをfsオブジェクトとしてインポートする
const fs = require("fs");
const md2html = require("md2html");




// コマンドライン引数からファイルパスを取得する
program.option("--gfm", "GFMを有効にする");
program.parse(process.argv);
const filePath = program.args[0];

const options = program.opts();

const cliOptions = {
    gfm: options.gfm ?? false,
};

// ファイルを非同期で読み込む
fs.readFile(filePath, { encoding: "utf8" }, (err, file) => {
    if (err) {
        console.log(err.message);
        process.exit(1);
        return;
    }  
    const html = md2html(file, cliOptions);
    console.log(html);
});