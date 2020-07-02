<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
        <label for="filename">文件名：</label>
        <input type="text" name="filename" id="filename"><br>
        <label for="sha256">sha256：</label>
        <input type="text" name="sha256" id="sha256"><br>
        <input type="submit" name="submit" value="提交">
    </form>
</body>
</html>
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['filename'])&&!empty($_POST['sha256'])){
        $username = 'admin';
        $password = 'aa88012361';
        $dbname = 'zcytxcbyz';
        $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
        $stmt = $conn->prepare("SELECT bindata,filetype FROM images 
        WHERE `name`=:filename AND `hash`=:hash");
        $stmt->bindParam(':filename', $_POST['filename']);
        $stmt->bindParam(':hash', $_POST['sha256']);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($result)>0){
            $data=$result[0]['bindata'];
            $type=$result[0]['filetype'];
            $myfile = fopen($_POST['filename'], "w");
            fwrite($myfile, $data);
            fclose($myfile);
        }
        $conn=null;
    }
}
?>