<?php 
$WebsiteName='Zcytxcbyz';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/Default.css">
    <link rel="stylesheet" href="https://cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/Default.js"></script>
    <title><?php echo $title?></title>
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark TopNavbar">
        <a class="navbar-brand" href="index.php"><?php echo $WebsiteName?></a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item<?php if($title=='主页') echo ' active'?>">
                    <a class="nav-link" href="index.php">主页</a>
                </li>
                <li class="nav-item<?php if($title=='教程') echo ' active'?>">
                    <a class="nav-link" href="#">教程</a>
                </li>
                <li class="nav-item<?php if($title=='工具') echo ' active'?>">
                    <a class="nav-link" href="tools.php">工具</a>
                </li>
                <li class="nav-item dropdown nav-dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">导航</a>
                    <div class="dropdown-menu dropdown-list" aria-labelledby="dropdownId">
                    <?php if(isset($navDropdown)) echo $navDropdown;?>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="搜索">
                <button class="btn btn-success my-2 my-sm-0" type="submit">搜索</button>
            </form>
        </div>
    </nav>
    <div class="container-fluid  middle-content">
        <div class="leftNav">
            <div class="card">
                <div class="card-header navHeader">导&nbsp;航</div>
            </div>
            <div class="list-group navListGroup">
                <?php if(isset($navListGroup)) echo $navListGroup;?>
            </div>
        </div>
        <div class="rightContent">
            <?php if(isset($toolbar)) echo $toolbar?>
            <div class="main">
                <?php if(isset($main)) echo $main?>
            </div>
            <?php if(isset($toolbar)) echo $toolbar?>
        </div>
    </div>
    <div class="bottom"> 
        <?php 
        $year=date("Y");
        if ($year==2020) echo "Copyright &copy; $year $WebsiteName";
        else echo "Copyright &copy; 2020-$year $WebsiteName";    
        ?>
    </div>
</body>
</html>