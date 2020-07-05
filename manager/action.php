<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$username = 'admin';
$password = 'aa88012361';
$dbname = 'zcytxcbyz';
try{
    if($_POST['type']=='loadpages'){
        $category=$_POST['category'];
        $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT id,title FROM courses 
        WHERE category=:category ORDER BY Id"); 
        $stmt->bindValue(':category',$category);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $html='<ul>';
        foreach ($result as $item) {
            $html.='<li><a href="#" onclick="pages_click(page'.$item['id'].')" id="page'.$item['id'].'">'.$item['title'].'</a></li>';
        }
        $html.'</ul>';
        $conn=null;
        echo $html;
    }
    if($_POST['type']=='pagecontent'){
        $title=$_POST['page'];
        $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT content FROM courses 
        WHERE title=:title ORDER BY Id");
        $stmt->bindValue(':title',$title);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_COLUMN);
        $conn=null;
        if(count($result)>0) echo $result[0];
    }
    if($_POST['type']=='savepage'){
        $title0=$_POST['title0'];
        $title1=$_POST['title1'];
        $content=$_POST['content'];
        $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("UPDATE courses 
        SET title=:title1, content=:content 
        WHERE title=:title0");
        $stmt->bindValue(':title0',$title0);
        $stmt->bindValue(':title1',$title1);
        $stmt->bindValue(':content',$content);
        $result=$stmt->execute();
        $conn=null;
        if($result) echo true;
        else echo false;
    }
    if($_POST['type']=='addpage'){
        $title=$_POST['title'];
        $content=$_POST['content'];
        $category=$_POST['category'];
        $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $createtime=date('Y-m-d H:i:s');
        $hash=hash('sha256',"title:$title,createtime:$createtime");
        $stmt = $conn->prepare("INSERT INTO 
        courses(title,content,category,createtime,`hash`)
        values(:title,:content,:category,:createtime,:hash)");
        $stmt->bindValue(':title',$title);
        $stmt->bindValue(':content',$content);
        $stmt->bindValue(':category',$category);
        $stmt->bindValue(':createtime',$createtime);
        $stmt->bindValue(':hash',$hash);
        $result=$stmt->execute();
        $conn=null;
        if($result) echo true;
        else echo false;
    }
    if($_POST['type']=='delpage'){
        $title=$_POST['title'];
        $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("DELETE FROM courses WHERE title=:title");
        $stmt->bindValue(':title',$title);
        $result=$stmt->execute();
        $conn=null;
        if($result) echo true;
        else echo false;
    }
    if($_POST['type']=='leftNavClick'){
        try{
            $navItem = $_POST['navItem'];
            $_SESSION['navItem'] = $navItem;
            echo true;
        }
        catch(Exception $e)
        {
            echo false;
        }
    }
}
catch(Exception $e){
    echo $e->getMessage();
}
}
?>