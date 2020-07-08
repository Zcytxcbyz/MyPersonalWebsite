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
        $("#title").val("");
        $(".contenteditor").val("");
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
    $(".mainContent #types a").on("click",function () {
        $.post("action.php", {
            "type":"loadtypes",
            "course":$(this).text()
        },
            function (response) {
                $(".mainContent .typecontent .typeeditor").html(response);
            }
        );
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
                $("#title").val("");
                $(".contenteditor").val("");
            }
            else{
                alert("删除失败");
            }
        },
    );
}

function reload() {  
    $.post("action.php", {
        "type":"loadtypes",
        "course":$(".mainContent #types a[class=active]").text()
    },
        function (response) {
            $(".mainContent .typecontent .typeeditor").html(response);
        }
    );
}

function type_add() {
    var selector=".mainContent .typecontent .typeeditor table";  
    var id=parseInt($(selector+" tr:last-child").attr("id"))+1;
    $(selector)
    .append('<tr id="'+String(id)
    +'" onclick="row_click('+String(id)
    +')"><td name="id">'+String(id)
    +'</td><td><input type="text" name="title"></td><td><input type="text" name="describe"></td></tr>');
}

function type_save() { 
    var data=new Array();
    var isEmpty=false;
    $(".typeeditor tr:has(td)").each(function () { 
        var id=$(this).attr("id");
        var title=$(this).find("input[name=title]").val();
        var describe=$(this).find("input[name=describe]").val();
        if(title.search(/^\s+$/)<0
        &&describe.search(/^\s+$/)<0
        &&title!=''
        &&describe!=''){
            data.push({id:id,title:title,describe:describe});
        }
        else {
            isEmpty=true;
        }
    });
    if(isEmpty){
        alert("记录不能为空");
    }
    else{
        $.post("action.php", {
            type:"type_save",
            data:data,
            course:$(".mainContent #types a[class=active]").text()
        },
        function (response) {
            reload();
            alert(response);
        }
    );
}
}

function type_del(){
    if(confirm("是否永久删除记录？（不可恢复）")){
        $(".mainContent .typecontent .typeeditor table tr[class=active]").remove();
    }
}

function row_click(id) {
    $("#"+String(id)).siblings("tr[class=active]").attr("class","");
    $("#"+String(id)).attr("class","active");
}