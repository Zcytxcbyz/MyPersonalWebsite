$(document).ready(function () {
    $(".leftNav a").on("click",function () { 
        $(".leftNav a[class=active]").attr("class","");
        $(this).attr("class","active");
    });
    $(".mainContent .categories>ul>li>a").on("click",function () { 
        $(this).parent().siblings().children("a[class=active]").attr("class","");
        $(this).attr("class","active");
        $(this).next().slideToggle(function(){
            $(".leftNav").css("height",$(".mainContent .categories").css("height"));
        });
        $(this).parent().siblings().children(".drop-list[style*=block]").slideUp();
    });
    $(".mainContent .drop-list a").on("click",function () {
        $(".mainContent .drop-list a[class=active]").attr("class","");
        $(this).attr("class","active");
    });
    $(".mainContent .pages").on("resize",function () { 
        alert("hello");
    });
    $("#categories .drop-list a").on("click",function () {

    });
});