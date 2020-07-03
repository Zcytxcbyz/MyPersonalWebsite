<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $result=null;
    if(!empty($_POST['password'])&&!empty($_FILES['file'])){
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
                        echo json_encode(
                            array(
                                'status'=>'success',
                                'filename'=>$filename,
                                'filetype'=>$filetype,
                                'filesize'=>$filesize,
                                'tmp_name'=>$file_tmp,
                                'file_hash'=>$file_hash,
                                'time'=>$time
                            ));
                    }
                    catch(Exception $e){
                        echo json_encode(array('status'=>'error','info'=>$e->getMessage()));
                    }
                }
            }
            else{
                echo json_encode(array('status'=>'error','info'=>'Illegal file format.'));
            }
        }
        else{
            echo json_encode(array('status'=>'error','info'=>'Wrong password.'));
        }
    }
}
?>