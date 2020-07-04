<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
    try{
        session_start();
        $password=$_POST['password'];
        $captcha=$_POST['captcha'];
        if(strtolower($captcha)!=strtolower($_SESSION['authcode'])){   
            echo json_encode(array('status'=>'error','message'=>'验证码错误'));
        }
        else{
            $db_username = 'admin';
            $db_password = 'aa88012361';
            $dbname = 'zcytxcbyz';
            $conn = new PDO("mysql:host=localhost;dbname=$dbname", $db_username, $db_password);
            $stmt = $conn->prepare("SELECT `password` FROM passwords WHERE type='administrator'");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_COLUMN);
            $conn=null;
            if (password_verify($password, $results[0])) {
                $_SESSION['login']='true';
                echo json_encode(array('status'=>'success','message'=>'登录成功'));
            } else {
                echo json_encode(array('status'=>'error','message'=>'密码错误'));
            }
        }
    }
    catch(Exception $e){
        echo json_encode(array('status'=>'error','message'=>$e->getMessage()));
    }
}
?>