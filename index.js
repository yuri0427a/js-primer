const createCounter = () => {
    let count = 0;
        // `increment`関数は`createCounter`関数のスコープに定義された`変数`count`を参照している
        count = count + 1;
        return count;
};

const myCounter = createCounter();
console.log(myCounter);
console.log(myCounter); 
