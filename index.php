<?php 
$title='主页';
$username = 'admin';
$password = 'aa88012361';
$dbname = 'zcytxcbyz';
try {
    $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT name FROM types WHERE enabled=1 ORDER BY Id"); 
    $stmt->execute();
    $types = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $class='dropdown-item';//若要激活加'active'
    $navDropdown=null;$navListGroup=null;
    for ($i=0; $i < count($types); $i++) { 
        $navDropdown.='<a class="'.$class.'" href="#'.$types[$i].'">'.$types[$i].'</a>';
    }
    $class='list-group-item list-group-item-action';
    for ($i=0; $i < count($types); $i++) { 
        $navListGroup.='<a href="#'.$types[$i].'" class="'.$class.'">'.$types[$i].'</a>';
    }
    $main=null;
    for ($i=0; $i < count($types); $i++) { 
        $stmt = $conn->prepare("SELECT title,`describe` FROM `index` WHERE type='$types[$i]' ORDER BY Id"); 
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $main.='<div class="type" id="'.$types[$i].'">';
        $main.='<h2>'.$types[$i].'</h2>';
        foreach($result as $item){
            $main.='<a class="category" href="#">';
            $main.='<h4>'.$item['title'].'</h4>';
            $main.='<p>'.$item['describe'].'</p>';
            $main.='</a>';
        }
        $main.='</div><br/>';
    }
}
catch(Exception $e)
{
    echo '<script>alert("'.$e->getMessage().'");</script>';
}
include('templates/Default.php');
?>