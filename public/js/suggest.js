$("#suggest_form").submit(function(event){
    event.preventDefault();
    var fs = new FormData(document.getElementById("suggest_form"));
    KTApp.blockPage();
    $.ajax({
        url : "/save_suggest",
        type : "POST",
        data : fs,
        processData : false,
        contentType :false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function(res){
            KTApp.unblockPage();
            if(res['success'] == true){
                var suggest_id = res['id'];
                $("#sug_content").val("");
                $("#cs_mo").click();
            }
            else{
                toastr.error("Fail!");
            }
        },
        error : function(res){
            KTApp.blockPage();
            toastr.error("Please refresh your browser");            
        }
    })
})
// Suggestion in Dashboard
$("#frmSuggest").on("submit", function(event){
    event.preventDefault();
    var fs = new FormData(document.getElementById('frmSuggest'));
    fs.append("type", 1);
    KTApp.blockPage();
    $.ajax({
        url : "/save_suggest",
        type : "POST",
        data : fs,
        processData : false,
        contentType : false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function(res){
            KTApp.unblockPage();
            if(res['success'] == true){
                location.reload();
            }
            else{
                toastr.error(res)
            }
        },
        error : function(err){
            KTApp.unblockPage();
            toastr.error("Please refresh your browser");
        }
    })
})
$("#frmUpdateSuggest").on("submit", function(event){
    event.preventDefault();
    var fs = new FormData(document.getElementById('frmUpdateSuggest'));
    fs.append("type", 1);
    KTApp.blockPage();
    $.ajax({
        url : "/update_suggest",
        type : "POST",
        data : fs,
        processData : false,
        contentType : false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function(res){
            KTApp.unblockPage();
            if(res == 'success'){
                location.reload();
            }
            else{
                toastr.error(res)
            }
        },
        error : function(err){
            KTApp.unblockPage();
            toastr.error("Please refresh your browser");
        }
    })
})
function get_news(){
    $.ajax({
        url : "/get-news",
        type : "GET",
        success : function(res){
            if(res['success'] == true){
                $(".all-news").append(res['all']);
                $(".unread-news").append(res['unread']);
                $(".read-news").append(res['read'])
            }
        }
    })
}
var KTSessionTimeoutDemo = function() {
    var initDemo = function() {
        $.sessionTimeout({
            title: "Session Timeout Notification",
            message: "Your session is about to expire.",
            keepAliveUrl: "/login",
            redirUrl: "/login",
            logoutUrl: "/login",
            warnAfter: 3600000, //warn after 5 seconds
            redirAfter: 3605000, //redirect after 10 secons,
            ignoreUserActivity: true,
            countdownMessage: "Redirecting in {timer} seconds.",
            countdownBar: true
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            initDemo();
        }
    };
}();
var url_list = ['/manage_playlist', "/manage-campaign", "/update_ad", "/graphic-design"];
jQuery(document).ready(function() {
    KTSessionTimeoutDemo.init();
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
            $(".btn-trust").click();
        }, 5000);
    }
    get_news();
});