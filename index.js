const color = [
    { color: "red" },
    { color: "green" },
    { color: "blue" },
];

const blueColor = color.find((obj) => {
    return obj.color === "blue";
});

console.log(blueColor);

const whiteColor = color.find((obj) => {
    return obj.color === "white";
});
console.log(whiteColor);