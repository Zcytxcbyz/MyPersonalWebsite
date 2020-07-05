$(document).ready(function () {
    $(".leftNav a").on("click",function () { 
        $(".leftNav a[class=active]").attr("class","");
        $(this).attr("class","active");
        $.post("action.php", {
            "type":"leftNavClick",
            "navItem":$(this).attr("id")
        },
            function (response) {
                if(response=="1") location.reload();
            }
        );
    });
    $(".mainContent .categories>ul>li>a").on("click",function () { 
        $(this).parent().siblings().children("a[class=active]").attr("class","");
        $(this).attr("class","active");
        $(this).next().slideToggle(function(){
            changeHeight();
            //$(".leftNav").css("height",$(".mainContent .categories").css("height"));
        });
        $(this).parent().siblings().children(".drop-list[style*=block]").slideUp();
    });
    $(".mainContent .drop-list a").on("click",function () {
        $(".mainContent .drop-list a[class=active]").attr("class","");
        $(this).attr("class","active");
        $.post("action.php", {
            "type":"loadpages",
            "category":$(this).text()
        },
            function (response) {
                $(".mainContent .pages").html(response);
                changeHeight();
            },
        );
    });
    $("#categories a").on("click",function () {
        changeHeight();
    });
});

function pages_click(e) {
    $(e).parent().siblings().children("a[class=active]").attr("class","");
    $(e).attr("class","active");
    $.post("action.php", {
        "type":"pagecontent",
        "page":$(e).text()
    },
        function (response) {
            $(".toolbar #title").val($(e).text());
            $(".contenteditor").val(response);
        }
    );
}

function changeHeight() { 
    var cateHeight=parseFloat($(".mainContent #categories").css("height"));
    var pageHeight=parseFloat($(".mainContent .pages").css("height"));
    if(cateHeight>pageHeight){
        $(".mainContent .pages").css("height",String(cateHeight));
        $(".leftNav").css("height",String(cateHeight));
        $(".mainContent .pagecontent .contenteditor").css("height",String(cateHeight-60));
    }
    else if(cateHeight<pageHeight){
        $(".mainContent #categories").css("height",String(pageHeight));
        $(".leftNav").css("height",String(pageHeight));
        $(".mainContent .pagecontent .contenteditor").css("height",String(pageHeight-60));
    }
}

function save(){
    $.post("action.php",{
        "type":"savepage",
        "title0":$(".mainContent .pages a[class=active]").text(),
        "title1":$("#title").val(),
        "content":$(".contenteditor").val()
    },
        function (response) {
            if(response=="1") {
                $.post("action.php",{
                    "type":"loadpages",
                    "category":$("#categories .drop-list a[class=active]").text()
                },
                    function (response) {
                        $(".mainContent .pages").html(response);
                        changeHeight();
                        $(".mainContent .pages a[class=active]").attr("class","");
                        $(".mainContent .pages a:contains("+$("#title").val()+")").attr("class","active");
                    },
                );
                alert("保存成功");
            }
            else {
                alert("保存失败");
            }
        }
    );
}

function add(){
    $.post("action.php", {
        "type":"addpage",
        "title":$("#title").val(),
        "content":$(".contenteditor").val(),
        "category":$("#categories .drop-list a[class=active]").text()
    },
        function (response) {
            if(response=="1") {
                $.post("action.php", {
                    "type":"loadpages",
                    "category":$("#categories .drop-list a[class=active]").text()
                },
                    function (response) {
                        $(".mainContent .pages").html(response);
                        changeHeight();
                        $(".mainContent .pages a[class=active]").attr("class","");
                        $(".mainContent .pages a:contains("+$("#title").val()+")").attr("class","active");
                    },
                );
                alert("添加成功");
            }
            else {
                alert("添加失败");
            }
        }
    );
}


function del() {
    $.post("action.php", {
        "type":"delpage",
        "title":$("#title").val()
    },
        function (response) {
            if(response=="1"){
                $.post("action.php",{
                    "type":"loadpages",
                    "category":$("#categories .drop-list a[class=active]").text()
                },
                    function (response) {
                        $(".mainContent .pages").html(response);
                        changeHeight();
                    },
                );
                alert("删除成功");
            }
            else{
                alert("删除失败");
            }
        },
    );
}