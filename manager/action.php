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
    if($_POST['type']=='loadtypes'){
        $course=$_POST['course'];
        $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT Id,title,`describe` FROM `index` WHERE type=:course ORDER BY Id");
        $stmt->bindValue(':course',$course);
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        $html='<table><tr><th id="id">ID</th><th id="title">标题</th><th id="describe">描述</th></tr>';
        $id=0;
        $_SESSION['data']=array();
        foreach ($result as $item) {
            $html.='<tr id="'.++$id.'" onclick="row_click('.$id.')"><td name="id">'.$id.'</td>';
            $html.='<td><input type="text" name="title" value="'.$item['title'].'"></td>';
            $html.='<td><input type="text" name="describe"  value="'.$item['describe'].'"></td></tr>';
            $_SESSION['data'][$id-1]=array("id"=>$id,"title"=>$item['title'],"describe"=>$item['describe'],"SQLId"=>$item['Id']);
        }
        $html.="</table>";
        echo $html;
    }
    if($_POST['type']=='type_save'){
        $data=find_diff($_POST['data'],$_SESSION['data']);
        $course=$_POST['course'];
        try{
            $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->beginTransaction();
            foreach ($data['insert'] as $value) {
                $stmt = $conn->prepare("INSERT INTO `index`(title,`describe`,`type`) 
                VALUES(:title,:describe,:type)");
                $stmt->bindValue(':title',$value['title']);
                $stmt->bindValue(':describe',$value['describe']);
                $stmt->bindValue(':type',$course);
                $stmt->execute();
            }
            foreach ($data['update'] as $value) {
                $stmt = $conn->prepare("UPDATE `index` 
                SET title=:title,`describe`=:describe
                WHERE Id=:id");
                $stmt->bindValue(':title',$value['title']);
                $stmt->bindValue(':describe',$value['describe']);
                $stmt->bindValue(':id',$value['id']);
                $stmt->execute();
            }
            foreach ($data['delete'] as $value) {
                $stmt = $conn->prepare("DELETE FROM `index` 
                WHERE Id=:id");
                $stmt->bindValue(':id',$value['id']);
                $stmt->execute();
            }
            $result=$conn->commit();
            if($result) echo '保存成功';
            else echo '保存失败';
        }
        catch(Exception $e){
            $conn->rollBack();
            echo $e->getMessage();
        }
    }
}
catch(Exception $e){
    echo $e->getMessage();
}
}

function find_diff($a,$b)
{
    $insert=array();$delete=array();$update=array();
    for($i=0;$i<count($a);$i++){
        for($j=0;$j<count($b);$j++)
            if($a[$i]['id']==$b[$j]['id']) break;
        if($j<count($b)){
            if($a[$i]['title']!=$b[$j]['title']
            ||$a[$i]['describe']!=$b[$j]['describe']){
                array_push($update,
                array('title'=>$a[$i]['title'],'describe'=>$a[$i]['describe'],'id'=>$b[$j]['SQLId']));
            }
        }
        else{
            array_push($insert,
            array('title'=>$a[$i]['title'],'describe'=>$a[$i]['describe']));
        }
    }
    for($i=0;$i<count($b);$i++){
        for($j=0;$j<count($a);$j++)
            if($a[$j]['id']==$b[$i]['id']) break;
        if($j>=count($a)){
            array_push($delete,
            array('title'=>$b[$i]['title'],'describe'=>$b[$i]['describe'],'id'=>$b[$i]['SQLId']));
        }
    }
    return array("insert"=>$insert,"update"=>$update,"delete"=>$delete);
}

?>