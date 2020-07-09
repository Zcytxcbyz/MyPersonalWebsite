<?php
if($_SERVER["REQUEST_METHOD"] == "GET"){
    try{
        if(!isset($_GET['id'])) throw new Exception("Invalid address.", E_ERROR);
        $hash=$_GET['id'];
        $title='教程';
        $username = 'admin';
        $password = 'aa88012361';
        $dbname = 'zcytxcbyz';
        $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT title,content,category FROM courses WHERE `hash`=:hash");
        $stmt->bindParam(':hash',$hash);
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        if($result==false) throw new Exception("Invalid address.", E_ERROR);
        $title=$result['title'];
        $category=$result['category'];
        $main=$result['content'];
        $stmt = $conn->prepare("SELECT title,`hash` FROM courses WHERE category=:category");
        $stmt->bindParam(':category',$category);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $navListGroup=null;
        $class='list-group-item list-group-item-action';
        $class_active=$class.' active';
        foreach ($result as $key => $item) {
            if($item['hash']==$hash)
            {
                $navListGroup.='<a href="course.php?id='.$item['hash'].'" class="'.$class_active.'">'.$item['title'].'</a>';
                $index = $key;
            }
            else
            {
                $navListGroup.='<a href="course.php?id='.$item['hash'].'" class="'.$class.'">'.$item['title'].'</a>';
            }
        }
        $toolbar='<div class="toolbar">';
        if($index>0&&isset($result[$index-1])){
            $toolbar.='<a class="prev" href="course.php?id='.$result[$index-1]['hash'].'">';
            $toolbar.='<i class="fa fa-arrow-left" aria-hidden="true"></i>';
            $toolbar.='<span>'.$result[$index-1]['title'].'</span>';
            $toolbar.='</a>';
        }
        if(isset($result[$index+1])){
            $toolbar.='<a class="next" href="course.php?id='.$result[$index+1]['hash'].'">';
            $toolbar.='<span>'.$result[$index+1]['title'].'</span>';
            $toolbar.='<i class="fa fa-arrow-right" aria-hidden="true"></i>';
            $toolbar.='</a>';
        }
        $toolbar.='</div>';    
        include('templates/Default.php');
    }
    catch(PDOException $e){
        customError();
    }
    catch(Exception $e){
        customError();
    }
}

function customError()
{
    header("Status: 404 Not Found");
    exit();
}

?>