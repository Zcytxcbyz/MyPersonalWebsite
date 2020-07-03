<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/login.js"></script>
    <title>Document</title>
</head>
<body>
    <form action="" method="post" class="login">
        <h1>登录</h1>
        <div class="password">
            <label for="password" id="label-password">管理员密码：</label>
            <input type="text" name="password" id="password">
        </div>
        <div class="captcha">
            <label for="password" id="label-captcha">验证码：</label>
            <input type="text" name="captcha" id="captcha">
        </div>
        <div class="captcha_img">
            <img id="captcha_img" border="1" src="./captcha.php?r=<?php echo rand(); ?>" alt="" width="100" height="30"><br>		
            <a href="javascript:void(0)" id="captcha_change">换一个?</a>
        </div>
        <div class="submit">
            <input type="submit" value="确认">
        </div>
    </form>
</body>
</html>