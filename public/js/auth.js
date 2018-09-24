if(window.location.hash === '#register'){
    $("#login").css("display", "none");
    $("#registration").css("display", "block");
}

$(document).ready(function(){
    'use strict';

    // Change between Login & Registration
    $("#login a.register").click(function(e){
        e.preventDefault();
        $(".form-note").toggleClass("fold");
        setTimeout(function(){
            $("#login input[type=checkbox]").toggle();
        }, 300);
        setTimeout(function(){
            $("#login").hide();
            $("#registration").show();
            $(".form-note").toggleClass("fold");
        }, 900);
    });

    $("#registration a.login").click(function(e){
        e.preventDefault();
        $(".form-note").toggleClass("fold");
        setTimeout(function(){
            $("#registration").hide();
            $("#login").show();
            $(".form-note").toggleClass("fold");
            setTimeout(function(){
                $("#login input[type=checkbox]").toggle();
            }, 200);
        }, 900);

    });

});
