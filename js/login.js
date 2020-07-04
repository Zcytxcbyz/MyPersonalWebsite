$(document).ready(function () {
    $("#captcha_change").click(function () {
        changecaptcha();
    });
    $("#captcha_img").click(function () { 
        changecaptcha();  
    });
    $("#submit").click(function () { 
        logincheck();
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
    if(/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {
        $(".login").css("margin-left",(winwidth-width)*0.1);
        $(".login").css("margin-top",(winheight-height)*0.3);
    } else {
        $(".login").css("margin-left",(winwidth-width)*0.45);
        $(".login").css("margin-top",(winheight-height)*0.3);
    }
   
}

function changecaptcha() { 
    var length=parseInt(Math.random()*6+5);
    var random_num="";
    for (var i=0;i<length;i++)
        random_num+=String(parseInt(Math.random()*10));        
    $("#captcha_img").attr("src","./captcha.php?r="+random_num);
    $("#captcha").val("");
 }

 function logincheck() {  
     var password=$("#password").val();
     var captcha=$("#captcha").val();
     if(typeof captcha=="undefined"||captcha==null||captcha==""){
        $("#info").text("验证码不能为空");
        changecaptcha();
     }
     else if(typeof password=="undefined"||password==null||password==""){
        $("#info").text("密码不能为空");
        changecaptcha();
     }
     else{
        $.post("logincheck.php", 
        {
            "password":password,
            "captcha":captcha
        },
            function (response) {
                var result=JSON.parse(response);
                if(result["status"]=="success"){
                    location.reload();
                }
                else{
                    $("#info").text(result["message"]);
                    changecaptcha();
                }   
            },
        );
     }
 }