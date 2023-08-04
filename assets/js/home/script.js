    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('timestamp').innerHTML =
        h + ":" + m + ":" + s;
        var t = setTimeout(startTime, 500);
    }

    function checkTime(i) {
        if (i < 10) {i = "0" + i}  // add zero in front of numbers < 10
        return i;
    }

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });

    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
        $(".clickable-row").css("cursor", "pointer");
    });

    function loader(){
        document.getElementById('load').style.visibility="visible";
        return true;
    }

    function submitSort(){
        sort.submit()
        loader();
    }

    function valueCari(){
        var keyword = document.cari.keyword.value;
        if(keyword === null || keyword === ''){
            document.getElementById("keyword").className = "form-control is-invalid";
            return false;
        }else{
            loader();
            return true;
        }
    }