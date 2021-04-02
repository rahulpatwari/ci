<?php 
$seller_url = (isset($_SERVER['HTTPS']) ? "https://" : "http://").'seller.'.str_replace("seller.", "", $_SERVER['HTTP_HOST']); 
$seller_url = str_replace("www.", "", $seller_url); 
$site_url = str_replace("seller.", "", $seller_url);
?>

<!-- contact form in modal ================================================================== -->
<div id="login" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3>Help & Support</h3>
	</div>
	<div class="modal-body">
		<form action="<?= base_url('sendMail') ?>" method="post">
			<input type="hidden" name="mail_code" value="<?= MAIL_CODE_HELP_AND_SUPPORT ?>" />
			
			<div class="form-group">								
				<input type="text" placeholder="Full name" name="name" required />
			</div>
			<div class="form-group">								
				<input type="email" placeholder="Email" name="email" required />
			</div>
			<div class="form-group">
				<input type="text" placeholder="Contact" name="contact" required />
			</div>
			<div class="form-group">
				<textarea name="message" placeholder="Message" name="message"></textarea>
			</div>

			<button type="submit" class="btn btn-success">Send</button>
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		</form>		
	</div>
</div>

<!-- Footer ================================================================== -->
<?php 
$CI =& get_instance();
if (!$CI->uri->segment(1)) { ?>
<div id="footer">
	<div class="container">
		<div class="row" id="footer-content">
			<div class="span12">
			<h4>ROPO Shop: Research Online Purchase Offline</h4>
			<p>Online shopping is emerging very fast in recent years. Now a day the internet holds the attention of retail market. Millions and millions of people shop online. On the other hand the purchasing of product from traditional market is continuing since years. Many customers go for purchasing offline so as to examine the product and hold the possession of the product just after the payment for the product. In this contemporary world customer’s loyalty depends upon the consistent ability to deliver quality, value and satisfaction. Some go for offline shopping, some for online and many go for both kind of shopping.</p>

			<h4>Differentiation from Online shopping Portals</h4>
			<h4> Risk:</h4>
			<p>​ When customer buy products from online shopping they do not touch or feel the product in a physical sense .Hence we understand that lot of risk is involve while buying an online product whether it will reach us on proper time or not is also a concern and a lso there may arise a risk of product size and colour as it may differ in real view or sense. Sometimes the product ordered is kind of damaged. With ROPOShop a user buy product from shop after physical checks so this risk is not there.</p>

			<h4>Convenience :</h4>
			<p>​ Online shopping is much more convenient than offline shopping. Instead of taking out your vehicle and visit shop to shop you can just sit at your home and do the shopping. It is convenient to sit at one place and shop the product of our choice without moving from place to place. Online shopping makes things more convenient. We can have a lot of choice over there in any kind of material we want to deal with that too without any fear of dealing with any dealer or distributers. Online s hopping is convenient in its real sense as it do not carry any dealing with issues of asking for wanted items or issues of asking for desired kind of items which helps in avoiding the part of waiting, asking, questioning about the product.<br />​ ROPOShop offers a user same convenience of shopping at home, once user have decided on what he/she want to buy and from which seller then only he/she need to visit the shop and make purchase.</p>

			<h4>Tangibility of the product:</h4>
			<p>​ At the store the customer gets to touch and feel the product they purchase before buying which help the customer to take the decision to buy the product or not whether the product will suit the customer need or not. Whether, we can and see feel a product is also a reason which determines whether a person’s wants to go for shopping or not. Tangibility of any product also determines the online shopping.Without touching the preferred or desired substance nobody can get its security about the worthiness or quality or sense of any preferred product.<br />With ROPOShop customer get a chance to touch and feel the product before making final purchase.</p>

			<h4>Delivery time:</h4>
			<p>​ The product ordered by the customer in online shopping takes a minimum of six to seven days to deliver the product to the customer. But in offline shopping the possession of the goods is immediately transferred to the buyer. So this is a major factor which affects the online shopping. People want a good delivery time; they prefer to get a product in a desired time or in short time of duration. Duration is the second major factor affecting the demand of product.<br />With ROPOShop customer also get the possession of product immediately.</p>

			<h4>Variety:</h4>
			<p>The kind of variety that a customer gets online is hard to match any product purchased offline. The online retailer’s stock products from the entire major brand and a customer can find any product in their listing no matter how hard to find it is in the offline store.<br />ROPOShop also offer same kind of Variety of prodcts to the customers.</p>

			<h4>Instant gratification:</h4>
			<p>Customer buying offline gets their products as soon as they pay for it but in online shopping customer have to wait for their product to get their product. Under normal circumstances waiting a day or two does not matter much but when a customer want to get the product instantly than offline shopping become necessary.<br />ROPOShop alows user to get their products as soon as they purchase it.</p></div>
		</div>
	</div></div>
<?php } ?>

<div id="footerSection">
	<div class="container">
		<div class="row">
			<div class="span3">
				<h5>ACCOUNT</h5>
				<?php
				if (isset($_SESSION['user_detail']['userId'])) 
					echo '<a href="'.$site_url.'/userProfile?profile=view">YOUR ACCOUNT</a>';
				else
					echo '<a href="'.$site_url.'/login">LOGIN</a>';
				?>
				<a href="<?= $seller_url.'/merchantLoginSignup' ?>">BECOME A SELLER</a> 
			 </div>
			<div class="span3">
				<h5>INFORMATION</h5>
				<a href="#login" data-toggle="modal">CONTACT US</a>
				<a href="#login" data-toggle="modal">HELP AND SUPPORT</a>  
				<a href="#">TERMS AND CONDITIONS</a> 
				<a href="#">FAQ</a>
				<a href="<?= $site_url ?>/privacypolicy">Privacy policy</a>
			 </div>
			<div class="span3">
				<h5>SECTIONS</h5>
				<a href="<?= $site_url ?>/products">PRODUCTS</a> 
				<a href="#">TOP SELLERS</a>  
				<a href="<?= $site_url ?>/brands">BRANDS</a>  
				<a href="#">CATEGORIES</a> 
			 </div>
			<div id="socialMedia" class="span3 pull-right">
				<h5>SOCIAL MEDIA </h5>
				<a href="https://www.facebook.com/roposhop"><img width="60" height="60" src="<?= $this->config->item('site_url').'assets/user/themes/images/facebook.png' ?>" title="facebook" alt="facebook"/></a>
				<a href="#"><img width="60" height="60" src="<?= $this->config->item('site_url').'assets/user/themes/images/twitter.png' ?>" title="twitter" alt="twitter"/></a>
				<a href="#"><img width="60" height="60" src="<?= $this->config->item('site_url').'assets/user/themes/images/youtube.png' ?>" title="youtube" alt="youtube"/></a>
			 </div> 
		 </div>
		<p class="pull-right">&copy; 2018 Ropo shop</p>
	</div><!-- Container End -->
</div>
<!-- Placed at the end of the document so the pages load faster ============================================= -->
<script src="<?= $this->config->item('site_url').'assets/user/themes/js/jquery.js' ?>" type="text/javascript"></script>
<script src="<?= $this->config->item('site_url').'assets/user/themes/js/bootstrap.min.js' ?>" type="text/javascript"></script>
<script src="<?= $this->config->item('site_url').'assets/user/themes/js/google-code-prettify/prettify.js' ?>"></script>

<script src="<?= $this->config->item('site_url').'assets/user/themes/js/bootshop.js' ?>"></script>
<script src="<?= $this->config->item('site_url').'assets/user/themes/js/jquery.lightbox-0.5.js' ?>"></script>

<style type="text/css">
#footer{
	border-top: 5px solid gainsboro;
}

#footer-content{
	padding: 40px;
}
</style>
</body>
</html>
