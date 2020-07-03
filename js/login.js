$(document).ready(function () {
    $("#captcha_change").click(function () {
        changecaptcha();
    });
    $("#captcha_img").click(function () { 
        changecaptcha();  
    });
    window.onresize=function () { 
        setpoint();
    };
    setpoint();
    $(".login").css("display","block");
});

function setpoint() { 
    var winwidth=window.innerWidth;
    var winheight=window.innerHeight;  
    var height=parseFloat($(".login").css("height"));
    var width=parseFloat($(".login").css("width"));
    $(".login").css("margin-left",(winwidth-width)*0.45);
    $(".login").css("margin-top",(winheight-height)*0.3);
}

function changecaptcha() { 
    var length=parseInt(Math.random()*6+5);
    var random_num="";
    for (var i=0;i<length;i++)
        random_num+=String(parseInt(Math.random()*10));        
    $("#captcha_img").attr("src","./captcha.php?r="+random_num);
 }