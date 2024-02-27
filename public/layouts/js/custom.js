var url_list = ['/', "/why-use-outdoor", "/locations"];
document.addEventListener("DOMContentLoaded", function(event) { 
    var visits = JSON.parse(localStorage.getItem("visits"));
    var pathname = window.location.pathname;
    if(jQuery.inArray(pathname,  url_list) !== -1 && jQuery.inArray(pathname, visits) === -1){
        if(visits == null){
            visits = [pathname];
        }
        else{
            visits.push(pathname);
        }
        localStorage.setItem("visits", JSON.stringify(visits));
        setTimeout(() => {
            if ($('.page_img').length > 0){
                $(".btn-fc").click();
            }
        }, 5000);
        setTimeout(() => {
            $('.c-term-modal').click();
        }, 10000);
    }
    if(jQuery.inArray('cookie', visits) === -1){
        setTimeout(() => {
            $(".cookie").removeClass('d-none');
        }, 2000);
    }
    $("#accept-cookie").on('click', function(){
        manageCookie();
    })
    $("#decline-cookie").on('click', function(){
        manageCookie();
    })
    function manageCookie(){
        $(".cookie").addClass('d-none');
        var visits = JSON.parse(localStorage.getItem("visits"));
        if(visits == null){
            visits = [];
        }
        visits.push('cookie');
        localStorage.setItem("visits", JSON.stringify(visits));
    }
});