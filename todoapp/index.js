const formElement = document.querySelector("#js-form");
formElement.addEventListener("submmit", (event) => {
    const inputElement = document.querySelector("#js-form-input");
    console.log(inputElement.value);
});

import { App } from "./src/App.js";
const app = new App();
app.mount();