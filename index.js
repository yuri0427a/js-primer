const codePointOfい = "い".codePointAt(0);
// 12354の16進数表現は"3042"
const hexOfい = codePointOfい.toString(16);
console.log(hexOfい);// => "3042"
// Unicodeエスケープで"あ"を表現できる
console.log("\u{3044}"); // => "あ"