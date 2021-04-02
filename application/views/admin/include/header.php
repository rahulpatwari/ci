<?php
if (isset($_COOKIE['image']))
    $usr_profile_pic = $_COOKIE['image'];
else
    $usr_profile_pic = $this->config->item('site_url').'assets/admin/img/avatar3.png';
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Roposhop | Dashboard</title>
        <link rel="shortcut icon" href="<?= $this->config->item('site_url').('assets/favicon.ico') ?>">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <!-- bootstrap 3.0.2 -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/bootstrap.min.css' ?>" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/font-awesome.min.css' ?>" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/ionicons.min.css' ?>" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/datatables/dataTables.bootstrap.css' ?>" rel="stylesheet" type="text/css" />

        <!-- Theme style -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/AdminLTE.css' ?>" rel="stylesheet" type="text/css" />
        
        <!-- Morris chart -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/morris/morris.css' ?>" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/jvectormap/jquery-jvectormap-1.2.2.css' ?>" rel="stylesheet" type="text/css" />
        <!-- fullCalendar -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/fullcalendar/fullcalendar.css' ?>" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/daterangepicker/daterangepicker-bs3.css' ?>" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css' ?>" rel="stylesheet" type="text/css" />
        
        <script type="text/javascript">
        function myFunction(){
            change_layout();
        }
        </script>

        <style type="text/css">
        .navbar-nav.navbar-center {
            position: absolute;
            left: 39%;
        }
        </style>
    </head>
    <body class="skin-black" onload="myFunction()">
        <div id="divLoading" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8; display: none;">
            <p style="position: absolute; top: 50%; left: 45%;">
                <img src="<?= $this->config->item('site_url').'assets/admin/img/ajax-loader.gif' ?>" />
            </p>
        </div>

        <div id="divLoading1" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8; display: none;">
            <p style="position: absolute; top: 50%; left: 45%;">
                <img src="<?= $this->config->item('site_url').'assets/admin/img/ajax-loader1.gif' ?>" />
            </p>
        </div>

        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?= base_url('dashboard') ?>" class="logo">ROPO SHOP</a>
            
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                
                <?php
                if (SITE_ENVIRONMENT) 
                    echo '<ul class="nav navbar-nav navbar-center">
                            <li><h3><b>ENVIRONMENT : '.SITE_ENVIRONMENT.'</b></h3></li>
                        </ul>';
                ?>

                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?= $_COOKIE['name'] ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?= $usr_profile_pic ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?= $_COOKIE['name'] ?>
                                        <br /><span><?= $_COOKIE['email'] ?></span>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?= base_url('editUser/'.$_COOKIE['user_id'].'?view') ?>" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?= base_url('signout');?>" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
