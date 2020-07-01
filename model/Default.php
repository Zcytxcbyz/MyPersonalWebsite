<?php 
session_start();
$title=$_SESSION['title'];
$WebsiteName=$_SESSION['WebsiteName'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/Default.css">
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
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
                    <a class="nav-link" href="course.php">教程</a>
                </li>
                <li class="nav-item<?php if($title=='工具') echo ' active'?>">
                    <a class="nav-link" href="tools.php">工具</a>
                </li>
                <li class="nav-item dropdown nav-dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">导航</a>
                    <div class="dropdown-menu dropdown-list" aria-labelledby="dropdownId">
                        <!-- php example
                        $class='dropdown-item';
                        echo '<a class="'.$class.' active" href="#">Item</a>';
                        for ($i=0; $i < 9; $i++) { 
                            echo '<a class="'.$class.'" href="#">Item</a>';
                        }
                    -->
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
        <div class="row" style="height: 400px;">
            <div class="leftNav">
                <div class="card">
                    <div class="card-header navHeader">导&nbsp;航</div>
                </div>
                <div class="list-group navListGroup">
                    <!-- php example
                    $class='list-group-item list-group-item-action';
                    echo '<a href="#" class="'.$class.' active">Item</a>';
                    for ($i=0; $i < 9; $i++) { 
                        echo '<a href="#" class="'.$class.'">Item</a>';
                    }
                -->
                </div>
            </div>
            <div class="flex-grow-1" style="padding: 0 0 0 0;">
                <div class="main">  
                </div>
            </div>
            <div class="bottom"> 
            <?php 
            $year=date("Y");
            if ($year==2020) echo "Copyright &copy; {$year} {$WebsiteName}";
            else echo "Copyright &copy; 2020-{$year} {$WebsiteName}";    
            ?>
            </div>
        </div>
    </div>
</body>
</html>