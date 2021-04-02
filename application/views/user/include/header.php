<?php 
$seller_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://").'seller.'.str_replace("seller.", "", $_SERVER['HTTP_HOST']); 
$seller_url = str_replace("www.", "", $seller_url); 
$site_url = str_replace("seller.", "", $seller_url);
$meta_title = isset($meta_data['title']) ? $meta_data['title'] : "";
$meta_description = isset($meta_data['description']) ? $meta_data['description'] : "";
$meta_keywords = isset($meta_data['keywords']) ? $meta_data['keywords'] : "";
?>
<!DOCTYPE html>
<html lang="en">
  	<head>
    	<meta charset="utf-8">
    	<title><?= $meta_title ?></title>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	    <meta name="description" content="<?= $meta_description ?>" />
		<meta name="keywords" content="<?= $meta_keywords ?>" />

		<!-- Bootstrap style --> 
    	<link id="callCss" rel="stylesheet" href="<?= $this->config->item('site_url').'assets/user/themes/bootshop/bootstrap.min.css' ?>" media="screen"/>
    	<link href="<?= $this->config->item('site_url').'assets/user/themes/css/base.css' ?>" rel="stylesheet" media="screen"/>
		
		<!-- Bootstrap style responsive -->	
		<link href="<?= $this->config->item('site_url').'assets/user/themes/css/bootstrap-responsive.min.css' ?>" rel="stylesheet"/>
		<link href="<?= $this->config->item('site_url').'assets/user/themes/css/font-awesome.css' ?>" rel="stylesheet" type="text/css">
		
		<!-- Google-code-prettify -->	
		<link href="<?= $this->config->item('site_url').'assets/user/themes/js/google-code-prettify/prettify.css' ?>" rel="stylesheet"/>

		<!-- fav and touch icons -->
		<link rel="shortcut icon" href="<?= $this->config->item('site_url').'assets/favicon.ico' ?>">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= $this->config->item('site_url').'assets/user/themes/images/ico/apple-touch-icon-144-precomposed.png' ?>" />
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= $this->config->item('site_url').'assets/user/themes/images/ico/apple-touch-icon-114-precomposed.png' ?>" />
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= $this->config->item('site_url').'assets/user/themes/images/ico/apple-touch-icon-72-precomposed.png' ?>" />
		<link rel="apple-touch-icon-precomposed" href="<?= $this->config->item('site_url').'assets/favicon.ico' ?>assets/user/themes/images/ico/apple-touch-icon-57-precomposed.png" />
		<style type="text/css" id="enject"></style>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		
		<style type="text/css">
		.site_logo{
			height: 47px;
		}
		</style>
  	</head>
	<body>
		<div id="header">
			<div class="container">
				<?php
				if (isset($_SESSION['user_detail'])) 
				{
					echo '<div id="welcomeLine" class="row">
							<div class="span12">
								<div class="pull-right">
									<div class="btn-group">
										<button class="btn">
											<img src="'.$_SESSION['user_detail']['profile_image'].'" width="15px" class="img-circle">

											Welcome!<strong> '.$_SESSION['user_detail']['first_name'].'</strong>
										</button>
										<button class="btn dropdown-toggle" data-toggle="dropdown">
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
											<li>
												<a>'.$_SESSION['user_detail']['email'].'</a>
												<hr style="border:3px solid #f1f1f1">
											</li>
											<li>
												<a href="'.$site_url.'/userProfile?profile=view'.'"><i class="icon-user"></i> View profile</a> 
											</li>
											<li>
												<a href="'.$site_url.'/userProfile?profile=edit'.'"><i class="icon-edit"></i> Edit profile</a> 
											</li>
											<li>
												<a href="'.$site_url.'/changePassword?edit_user_id='.$_SESSION['user_detail']['userId'].'"><i class="icon-key"></i> Change password</a> 
											</li>
											<li>
												<a href="'.$site_url.'/userLogout'.'"><i class="icon-unlock"></i> Logout</a> 
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>';
				}
				?>

				<!-- Navbar ================================================== -->
				<div id="logoArea" class="navbar">
					<a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
  					<div class="navbar-inner">
    					<a class="brand" href="<?= $site_url ?>"><img src="<?= $this->config->item('site_url').'assets/logo.png' ?>" alt="roposhop" class="site_logo" /></a>

						<form method="get" action="<?= $site_url.'/search' ?>" class="form-inline navbar-search">
	    					<input class="srchTxt" type="text" name="str" placeholder="Search: Product, Brand, Seller and More...." required />
							<button type="submit" id="submitButton" class="btn btn-primary">search</button>
	    				</form>

	    				<ul id="topMenu" class="nav pull-right">
	    					<li>
	 							<a href="<?= $seller_url.'/merchantLoginSignup' ?>" style="padding-right:0"><span class="btn btn-warning">Free Listing</span></a>
							</li>
							<li>
	 							<a href="<?= $site_url.'/app' ?>" style="padding-right:0"><span class="btn btn-primary">App</span></a>
							</li>
							<li>
	 							<a href="<?= $site_url.'/location_setting' ?>" style="padding-right:0"><span class="btn btn-danger">Location Setting</span></a>
							</li>
							<?php
							if (!isset($_SESSION['user_detail'])) 
								echo '<li>
			 							<a href="'.$site_url.'/userLogin'.'" style="padding-right:0"><span class="btn btn-success">Login</span></a>
									</li>';	
							?>
    					</ul>
  					</div>

  					<?php
  					if (SITE_ENVIRONMENT) 
  						echo '<div id="site_environment" align="center">
								<h4><b>ENVIRONMENT : '.SITE_ENVIRONMENT.'</b></h4>
							</div>';
  					?>
				</div>
			</div>
		</div>
		<!-- Header End====================================================================== -->
		
		<?php 
		if (isset($offers)) 
		{
			if ($offers) { ?>
				<div id="carouselBlk">
					<div id="myCarousel" class="carousel slide">
						<div class="carousel-inner">
							<?php
							$i = 0;
							foreach ($offers as $offer) 
							{
								if (isset($offer['offer_images'][0])) 
								{
									$offer_title = $offer['offer_title'];
									$class = ($i == 0) ? "active" : "";

									echo '<div class="item '.$class.'">
									  		<div class="container">
									  			<a href="'.base_url().'offer/'.$offer_title.'?offer_id='.$offer['offer_id'].'" style="text-decoration:none;">
										  			<div class="row" style="margin-left: 0px;">	
														<img style="height:300px; float:left;" src="'.$offer['offer_images'][0].'" />
														<h3>'.$offer_title.'</h3>
												  		<h4>'.$offer['description'].'</h4>
													</div>
												</a>
									  		</div>
									  	</div>';

									$i++;
								}
							}
							?>
						</div>
						<a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
						<a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
					</div> 
				</div>
		<?php } 
		} ?>

		<div id="mainBody">
			<div class="container">
				<div class="row">

<script type="text/javascript">
function register() 
{
	window.location.href = "<?= base_url('register') ?>";
}
</script>

<style type="text/css">
#site_environment{
	background-color: antiquewhite;
    padding: 2px;
    color: firebrick;
}
</style>
