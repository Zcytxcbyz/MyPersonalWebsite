<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            text-align: center;
            margin-top: 100px;
        }
        *:not(body){
            margin-top: 10px;
        }
    </style>
    <title>Upload</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
        <label for="password">密码：</label>
        <input type="password" name="password"><br>
        <label for="file">文件名：</label>
        <input type="file" name="file" id="file"><br>
        <input type="submit" name="submit" value="提交">
    </form>
</body>
</html>
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['password'])){
        if($_POST['password']=='zy9296051'){
            // 允许上传的图片后缀
            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES["file"]["name"]);
            $extension = end($temp);        // 获取文件后缀名
            if ((($_FILES["file"]["type"] == "image/gif")
            || ($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/jpg")
            || ($_FILES["file"]["type"] == "image/pjpeg")
            || ($_FILES["file"]["type"] == "image/x-png")
            || ($_FILES["file"]["type"] == "image/png"))
            && ($_FILES["file"]["size"] < 1024000)    // 小于 1000 kb
            && in_array($extension, $allowedExts))
            {
                if ($_FILES["file"]["error"] > 0)
                {
                    echo "错误：" . $_FILES["file"]["error"] . "<br>";
                }
                else
                {
                    $filename= $_FILES["file"]["name"];
                    $filetype= $_FILES["file"]["type"];
                    $filesize= $_FILES["file"]["size"];
                    $file_tmp= $_FILES["file"]["tmp_name"];
                    $file_hash= hash_file('sha256',$file_tmp);
                    $file_data=fread(fopen($file_tmp,'r'),filesize($file_tmp));
                    $time=date('Y-m-d H:i:s');
                    echo "上传文件名：$filename<br>
                    文件类型：$filetype<br>
                    文件大小：".round($filesize/1024,2)."KB<br>
                    文件临时存储的位置：$file_tmp<br>
                    sha256：$file_hash<br>
                    上传时间：$time";
                    $username = 'admin';
                    $password = 'aa88012361';
                    $dbname = 'zcytxcbyz';
                    try{
                        $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
                        $stmt = $conn->prepare("INSERT INTO images(`name`,bindata,`time`,size,filetype,`hash`) 
                        VALUES (:name,:bindata,:time,:size,:filetype,:hash)");
                        $stmt->bindParam(':name', $filename);
                        $stmt->bindParam(':bindata', $file_data);
                        $stmt->bindParam(':time',  $time);
                        $stmt->bindParam(':size', $filesize);
                        $stmt->bindParam(':filetype', $filetype);
                        $stmt->bindParam(':hash', $file_hash);
                        $stmt->execute();
                        $conn = null;
                    }
                    catch(Exception $e){
                        echo $e->getMessage();
                    }
                }
            }
            else{
                echo '非法文件格式';
            }
        }
        else{
            echo '密码错误';
        }
    }
}
?>