function extra_hidden() {
    $(document).ready(function () {
        var span = "4";     
        let x = document.getElementsByClassName("hide");
        var str = "table-cell";
        if (x[0].style.display == "table-cell") {
            str = "none";
            span = "2"; 
        }
        for (i = 0; i < x.length; i++) {
            x[i].style.display = str;
        }
        const collection = document.getElementsByClassName("table_col");
        for (let i = 0; i < collection.length; i++) {
            collection[i].colSpan = span;
        }
    });
}