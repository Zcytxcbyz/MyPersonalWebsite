$(document).ready(function () {
    $("#submit").click(function () { 
        var password=$("#password").val();
        var file=$("#file")[0].files[0];
        if(typeof password=="undefined"||password==null||password==""){
            $("#info").text("密码不能为空");
        }
        else if(typeof file=="undefined"||file==null||file==""){
            $("#info").text("文件不能为空");
        }
        else{
            upload();
        }
    });
});

function upload() {
    var password=$("#password").val();
    var file=$("#file")[0].files[0];
    var data=new FormData();
    data.append("file",file);
    data.append("password",password);
    $.ajax({
        type: "POST",
        url: "upload.php",
        processData : false,
        contentType : false,
        data: data,
        success: function (response) {
            result=JSON.parse(response);
            if(result["status"]=="error"){
                $("#info").text(result["info"]);
            }
            else if(result["status"]=="success"){
                $("#info").html(
                    "文件名："+result["filename"]+"<br>"+
                    "文件类型："+result["filetype"]+"<br>"+
                    "文件大小："+result["filesize"]+"<br>"+
                    "文件临时存储的位置："+result["tmp_name"]+"<br>"+
                    "hash值："+result["file_hash"]+"<br>"+
                    "上传时间："+result["time"]
                );
            }
        }
    });
}