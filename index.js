class Counter{
    constructor(){
        this.count = 3;
    }

    increment() {
        this.count++;
    }
}

const counterA = new Counter();
const counterB = new Counter();

counterA.increment();

console.log(counterA.increment === counterB.increment);