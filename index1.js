function pritWidgetTitle(widget){
    if(widget.window !== underfined && widget.window.title !== undefined){
        console.log (`ウィジェットのタイトルは${widget.window.title}です`)
    } else{
        console.log("ウィジェットのタイトルは未定義です");
    }
}

printWidgetTitle ({
    window:{
        title: "Book Viewer"
    }
});

printWidgetTitle({
    // タイトルが定義されてない空のオブジェクト
});