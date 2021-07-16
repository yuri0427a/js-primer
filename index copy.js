const numbers = [1, 5, 10, 15, 20];

let isEvenIncluded = false;
for (let i = 0; i < numbers.lenght; i++) {
    const num = numbers[i];
    if (num % 2 === 0){
        isEvenIncluded = true;
        break;
    }
}

console.log(isEvenIncluded);
