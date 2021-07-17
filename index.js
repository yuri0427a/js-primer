const obj ={
    aaa: "value"
};

if(obj.hasOwnProperty("key")){
    console.log("`object`は`key`プロパティを持っている");
}else{
    console.log("`object`は`key`プロパティを持っていない");
}
