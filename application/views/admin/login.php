<?php
str_replace("admin.", "", $_SERVER['HTTP_HOST']);
if(strpos($_SERVER['HTTP_HOST'], 'admin') !== false)
    $url = str_replace("admin.", "", $_SERVER['HTTP_HOST']);
else if(strpos($_SERVER['HTTP_HOST'], 'seller') !== false)
    $url = str_replace("seller.", "", $_SERVER['HTTP_HOST']);

$home_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://").$url;
?>

<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>ROPO SHOP | Log in</title>
        <link rel="shortcut icon" href="<?= $this->config->item('site_url').'assets/4d_logo.ico' ?>">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        
        <!-- bootstrap 3.0.2 -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/bootstrap.min.css' ?>" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/font-awesome.min.css' ?>" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/AdminLTE.css' ?>" rel="stylesheet" type="text/css" />
    </head>
    <body class="bg-black">
        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
            <?= form_open('doLogin') ?>
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="username"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Sign me in</button>  
                    
                    <p><a href="<?= $home_url ?>"><span class="glyphicon glyphicon-home"></span> Home page</a></p>
                    <p><a href="#"><span class="glyphicon glyphicon-lock"></span> I forgot my password</a></p>
                    
                    <?php if ($_COOKIE['site_code'] == 'seller') {  ?>
                        <a href="<?= base_url('signup') ?>"><span class="glyphicon glyphicon-user"></span> Register a new merchant</a>
                    <?php } ?>
                </div>
            <?= form_close() ?>
        </div>
    </body>
</html>
