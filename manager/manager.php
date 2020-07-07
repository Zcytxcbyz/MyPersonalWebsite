<?php 
session_start();
$_SESSION['login']='true';
if(!isset($_SESSION['navItem'])){
    $_SESSION['navItem']='pages';
}
if(isset($_SESSION['login'])&&$_SESSION['login']=='true'){
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/manager.js"></script>
    <link rel="stylesheet" href="../css/manager.css">
    <title>网站后台管理系统</title>
</head>
<body>
    <div class="leftNav">
        <ul>
            <li><a href="#" id="pages" class="<?php if($_SESSION['navItem']=='pages')echo 'active';?>">页面</a></li>
            <li><a href="#" id="courses" class="<?php if($_SESSION['navItem']=='courses')echo 'active';?>">教程</a></li>
            <li><a href="#" id="sections" class="<?php if($_SESSION['navItem']=='sections')echo 'active';?>">版块</a></li>
            <li><a href="#" id="tools" class="<?php if($_SESSION['navItem']=='tools')echo 'active';?>">工具</a></li>
            <li><a href="#" id="gallery" class="<?php if($_SESSION['navItem']=='gallery')echo 'active';?>">图库</a></li>
            <li><a href="#" id="password" class="<?php if($_SESSION['navItem']=='password')echo 'active';?>">密码</a></li>
            <li><a href="#" id="query" class="<?php if($_SESSION['navItem']=='query')echo 'active';?>">查询</a></li>
        </ul>
    </div>
    <div class="mainContent">
        <?php
        if($_SESSION['navItem']=='pages'){
        $username = 'admin';
        $password = 'aa88012361';
        $dbname = 'zcytxcbyz';
        try {
            $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT name FROM types WHERE enabled=1 ORDER BY Id"); 
            $stmt->execute();
            $types = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo  '<div class="categories" id="categories"><ul>';
            for ($i=0; $i < count($types); $i++) { 
                $stmt = $conn->prepare("SELECT title FROM `index` WHERE type='$types[$i]' ORDER BY Id"); 
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
                echo '<li><a href="#">'.$types[$i].'</a><ul class="drop-list">';
                foreach($result as $item){
                    echo '<li><a href="#">'.$item.'</a></li>';
                }
                echo '</ul></li>';
            }
            echo '<ul/></div>';
            $conn=null;
        }
        catch(Exception $e)
        {
            echo '<script>alert("'.$e->getMessage().'");</script>';
        }
        ?>
        <div class="categories pages" id="pages">
            <ul>
                <li><a href="#">请先选择左侧</a></li>
            </ul>
        </div>
        <div class="pagecontent">
            <div class="toolbar">
                <label for="title">标题</label>
                <input type="text" id="title">
                <button onclick="del()">删除</button>
                <button onclick="save()">保存</button>
                <button onclick="add()">添加</button>
            </div>
            <textarea class="contenteditor"></textarea>
        </div>
        <?php 
        }
        else if($_SESSION['navItem']=='courses'){
        $username = 'admin';
        $password = 'aa88012361';
        $dbname = 'zcytxcbyz';
        try {
            $conn = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT name FROM types WHERE enabled=1 ORDER BY Id"); 
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo  '<div class="categories" id="types"><ul>';
            foreach ($results as $item) {
                echo '<li><a href="#">'.$item.'</a></li>';
            }
            echo '<ul/></div>';
            $conn=null;
        }
        catch(Exception $e)
        {
            echo '<script>alert("'.$e->getMessage().'");</script>';
        }
        ?>
        <div class="typecontent">
            <div class="toolbar">
                <button onclick="type_add()">添加</button>
                <button onclick="reload()">刷新</button>
                <button onclick="type_del()">删除</button>
                <button onclick="type_save()">保存</button>
            </div>
            <div class="typeeditor">
                <table>
                    <tr>
                        <th id="id">ID</th>
                        <th id="title">标题</th>
                        <th id="describe">描述</th>
                    </tr>
                    <tr id="1" onclick="row_click(1)">
                        <td name="id">1</td>
                        <td><input type="text" name="title"></td>
                        <td><input type="text" name="describe"></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</body>
</html>
<?php 
}
else{
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/login.js"></script>
    <title>登录</title>
</head>
<body>
    <form method="post" class="login">
        <h1>登&nbsp;录</h1>
        <div class="password">
            <label for="password" id="label-password">管理员密码：</label>
            <input type="password" name="password" id="password">
        </div>
        <div class="captcha">
            <label for="password" id="label-captcha">验证码：</label>
            <input type="text" name="captcha" id="captcha">
        </div>
        <div class="captcha_img">   
            <img id="captcha_img" src="./captcha.php?r=<?php echo rand(); ?>" alt="" width="100" height="30"><br>		
            <a href="javascript:void(0)" id="captcha_change">换一个?</a>
        </div>
        <div id="info"></div>
        <div class="submit">
            <input type="button" value="确&nbsp;认" id="submit">
        </div>    
    </form>
</body>
</html>
<?php 
}
?>
