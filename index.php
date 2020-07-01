<?php 
$title='主页';
$username = 'admin';
$password = 'aa88012361';
$dbname = 'zcytxcbyz';
try {
    $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT name FROM types"); 
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $class='dropdown-item';
    $navDropdown='<a class="'.$class.' active" href="#">'.$rows[1].'</a>';
    for ($i=2; $i < count($rows); $i++) { 
        $navDropdown.='<a class="'.$class.'" href="#">'.$rows[$i].'</a>';
    }
    $class='list-group-item list-group-item-action';
    $navListGroup='<a href="#" class="'.$class.' active">'.$rows[1].'</a>';
    for ($i=2; $i < count($rows); $i++) { 
        $navListGroup.='<a href="#" class="'.$class.'">'.$rows[$i].'</a>';
    }
    $main='Loading...';
}
catch(Exception $e)
{
    echo '<script>alert("'.$e->getMessage().'");</script>';
}
include('model/Default.php');
?>