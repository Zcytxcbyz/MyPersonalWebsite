<?php 
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(!empty($_GET['id'])){
        $username = 'admin';
        $password = 'aa88012361';
        $dbname = 'zcytxcbyz';
        $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
        $stmt = $conn->prepare("SELECT bindata,filetype FROM images 
        WHERE `hash`=:hash");
        $stmt->bindParam(':hash', $_GET['id']);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($result)){
            $data=$result[0]['bindata'];
            $type=$result[0]['filetype'];
            header("Content-type:$type");
            echo $data;
        }
        $conn=null;
    }
}
?>