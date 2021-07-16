function isEven(num){
    return num % 2 === 0;
}

function fillterEven(numbers){
    const results = [];
    for(let i = 0; i < numbers.length; i++){
        const num = numbers[i];
    if(!isEven(num)){
        continue;
    }
    results.push(num);
}
return results;
}

const array = [1, 5, 10, 15, 20];
console.log(fillterEven(array));