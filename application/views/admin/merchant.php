<div class="span9">
    <ul class="breadcrumb">
    	<li><a href="<?= base_url() ?>">Home</a> <span class="divider">/</span></li>
    	<?php
    	if (isset($_GET['merchant_id'])) 
    	{
    		echo '<li><a href="'.base_url('merchants').'">Merchants</a> <span class="divider">/</span></li>
    			<li class="active">Merchant detail</li>';
    	}
    	else
    		echo '<li class="active">Merchants</li>';
    	?>
    </ul>	
	<div class="row">	 
		<?php 
		if (isset($_GET['merchant_id'])) 
		{ 
			$avg_rating = ($rating_info['avg_rating']) ? $rating_info['avg_rating'] : 0;
			$rating_count = ($rating_info['rating_count']) ? $rating_info['rating_count'] : 0;
			$one_star = $rating_info['rating_count_1_star'];
			$two_star = $rating_info['rating_count_2_star'];
			$three_star = $rating_info['rating_count_3_star'];
			$four_star = $rating_info['rating_count_4_star'];
			$five_star = $rating_info['rating_count_5_star'];

			if ($rating_count) 
			{
				$five_star_width = ($five_star*100)/$rating_count.'%';
				$four_star_width = ($four_star*100)/$rating_count.'%';
				$three_star_width = ($three_star*100)/$rating_count.'%';
				$two_star_width = ($two_star*100)/$rating_count.'%';
				$one_star_width = ($one_star*100)/$rating_count.'%';
			}
			else
				$five_star_width = $four_star_width = $three_star_width = $two_star_width = $one_star_width = 0;

			echo '<div class="span9">
					<center><h4>
						<img src="'.base_url(SELLER_ATTATCHMENTS_PATH.$merchant_detail['merchant_id'].'/'.$merchant_detail['merchant_logo']).'" width="80px">&nbsp;&nbsp;&nbsp;'
						.ucfirst($merchant_detail['establishment_name']).
					'</h4></center>
			
					<table class="table">
						<tbody>
							<tr>
								<td>';
									foreach ($address['result'] as $addres) 
									{
										$lat = $addres['latitude'];
										$long = $addres['longitude'];
										$distance = distance($lat, $long);
										$contact = $addres['contact'];

										$merchant_address = $addres['address_line_1'].', '.$addres['address_line_2'].', '.$addres['landmark'].',<br />'.$addres['city_name'].', '.$addres['state_name'].', '.$addres['country_name'].' - '.$addres['pin'];

										echo $merchant_address;

										if ($contact) 
											echo "<br />Shop no: ".$contact;
										
										if ($distance) 
											echo '<br /><br /><a href="https://www.google.com/maps/place/'.$lat.','.$long.'" target="_blank"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSewwbzGWLC9Sr38nEmyRulDk1M2Dqq3zle8CInqmHb21WfCHsi" width="50px"></a>'.$distance.'<br /><br /><br />';
									}
								echo '</td>
							</tr>
							<tr>
								<td><h4>Contact</h4>'.$merchant_detail['contact'].'</td>
								<td></td>
							</tr>
						</tbody>
					</table>

					<table class="table">
						<tbody>
							<tr>
								<td>
									<h4>Business Days & Hours</h4>
									'.$merchant_detail['business_days'].'<br />'.$merchant_detail['business_hours'].'</td>
							</tr>
						</tbody>
					</table><hr />';

			for ($i = 1; $i <= 5; $i++) 
			{ 
				if ($i <= round($avg_rating))
					echo '<span class="fa fa-star checked"></span>';
				else
					echo '<span class="fa fa-star"></span>';
			}

			echo "<p>".$avg_rating.' average based on '.$rating_count.' reviews.'."</p>";
			?>
					
			<div class="side">
				<div>5 star</div>
			</div>
			<div class="middle">
				<div class="bar-container">
						<div class="bar-5"></div>
				</div>
			</div>
			<div class="side right">
				<div><?= $five_star ?></div>
			</div>
			<div class="side">
				<div>4 star</div>
			</div>
			<div class="middle">
				<div class="bar-container">
					<div class="bar-4"></div>
				</div>
			</div>
			<div class="side right">
				<div><?= $four_star ?></div>
			</div>
			<div class="side">
				<div>3 star</div>
			</div>
			<div class="middle">
				<div class="bar-container">
					<div class="bar-3"></div>
				</div>
			</div>
			<div class="side right">
				<div><?= $three_star ?></div>
			</div>
			<div class="side">
				<div>2 star</div>
			</div>
			<div class="middle">
				<div class="bar-container">
					<div class="bar-2"></div>
				</div>
			</div>
			<div class="side right">
				<div><?= $two_star ?></div>
			</div>
			<div class="side">
				<div>1 star</div>
			</div>
			<div class="middle">
				<div class="bar-container">
					<div class="bar-1"></div>
				</div>
			</div>
			<div class="side right">
				<div><?= $one_star ?></div>
			</div>

			  
	            <ul id="productDetail" class="nav nav-tabs">
					<li><a href="#merchant_review" data-toggle="tab">Reviews</a></li>
					<li class="active"><a href="#products" data-toggle="tab">Products</a></li>
	            </ul>

	            <div id="myTabContent" class="tab-content" style="overflow: hidden;">
	            	<div class="tab-pane fade active in" id="products">
			  			<div id="myTab" class="pull-right">
			  				<a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
			  				<a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
			  			</div>
			  			<br class="clr"/>
			  			<hr class="soft"/>
			  			<div class="tab-content">
			  				<div class="tab-pane" id="listView">
			  					<?php if ($listing_products) {
									foreach ($listing_products as $product) 
									{ 
										if (isset($selected_category_string)) 
											$product_detail_url = base_url('products/'.url_title($product['product_name'], '-', true).'?prd_id='.$product['product_id'].'&category='.$selected_category_string);
										else
											$product_detail_url = base_url('products/'.url_title($product['product_name'], '-', true).'?prd_id='.$product['product_id']);
									?>
										<a href="<?= $product_detail_url ?>">
											<div class="row">	  
												<div class="span2">
													<img src="<?= $product['products_images'][0] ?>" />
												</div>
												<div class="span4">
													<h5><?= $product['product_name'] ?></h5>
													<p><?= showLimitedCharacter($product['description']) ?></p>
												</div>
												<div class="span3 alignR">
													<h3><?= currency_format($product['mrp_price']) ?></h3>
													<br class="clr"/>
												</div>
											</div>
										</a>
										<hr class="soft"/>
									<?php } 
								} else
									echo "Not available"; ?>
			  				</div>
			  				<div class="tab-pane active" id="blockView">
			  					<ul class="thumbnails">
			  						<?php if ($listing_products) {
										foreach ($listing_products as $product) { ?>
											<li class="span3">
												<div class="thumbnail">
													<?php
													if (isset($selected_category_string)) 
														$product_detail_url = base_url('products/'.url_title($product['product_name'], '-', true).'?prd_id='.$product['product_id'].'&category='.$selected_category_string);
													else
														$product_detail_url = base_url('products/'.url_title($product['product_name'], '-', true).'?prd_id='.$product['product_id']);
													?>
													<a href="<?= $product_detail_url ?>">
														<img src="<?= $product['products_images'][0] ?>" />
													</a>
													<div class="caption" align="center">
														<h5 style="height: 40px;">
															<?php 
															echo $product['product_name'].
																"<br /><br /><strike>".
																currency_format($product['mrp_price']).
																"</strike>&nbsp;&nbsp;".
																currency_format($product['list_price']).
																"<br /> (".
																calculatePercentage($product['mrp_price'], $product['list_price']).
																"% Off)"; 
															?>
														</h5>
													</div>
											  	</div>
											</li>
										<?php } 
									} else
										echo "<li>Not available</li>"; ?>
			  					</ul>
			  					<hr class="soft"/>
			  				</div>
			  			</div>

			  			<?php if (isset($products)) { ?>
							<div class="pagination">
								<ul>
									<?php
									$total_pages = $paging['total_pages'];
									$current_page = $paging['page'];
									$prev_page = $current_page-1;
									$next_page = $current_page+1;

									if (isset($_GET['merchant_id'])) 
										$href = base_url('products?merchant_id='.$_GET['merchant_id'].'&limit=10&page=');
									else
										$href = base_url('products?category='.$selected_category_string.'&limit=10&page=');

									//set prev button
									if ($current_page <= 1)
										echo '<li><a>Prev</a></li>';
									else
										echo '<li><a href="'.$href.$prev_page.'">Prev</a></li>';

									//paging
									for ($i=1; $i <= $total_pages; $i++) 
									{
										if ($i == $current_page) 
											$selected_page = 'id="selected_page"';
										else
											$selected_page = 'href="'.$href.$i.'"';

										echo '<li><a '.$selected_page.'>'.$i.'</a></li>';
									}

									//set next button
									if ($current_page == $total_pages)
										echo '<li><a>Prev</a></li>';
									else
										echo '<li><a href="'.$href.$next_page.'">Next</a></li>';
									?>
								</ul>
							</div>
							<br class="clr"/>
						<?php } ?>
			  			<br class="clr">
	              	</div>

					<div class="tab-pane fade" id="merchant_review">
						<?php if ($reviews) {
					    	foreach ($reviews as $review) { ?>
						        <div style="margin-top: 10px;">
						            <div class="panel panel-white post panel-shadow">
						                <div class="post-heading">
						                    <div class="pull-left image">
						                        <?php 
						                    	$consumer_pic = ($review['picture']) ? base_url(PROFILE_PIC_PATH.$review['picture']) : "http://dummyimage.com/60x60/666/ffffff&text=No+Image";
												?>
						                        <img src="<?= $consumer_pic ?>" class="img-circle avatar" alt="user profile image">
						                    </div>
						                    <div class="meta">
						                    	<b><?= $review['consumer_name']."&nbsp;&nbsp;" ?></b>
						                        <div class="pull-right title h5">
						                            <?php
													for ($i = 1; $i <= 5; $i++) 
													{ 
														if ($i <= round($review['rating']))
															echo '<span class="fa fa-star checked"></span>';
														else
															echo '<span class="fa fa-star"></span>';
													}
													?>
						                        </div>
						                        <h6 class="text-muted time">
						                        	<?= time_elapsed_string($review['last_updated']) ?>
						                        </h6>
						                    </div>
						                </div> 
						                <div class="post-description"> 
						                    <p><?= $review['review'] ?></p>
						                </div>
						            </div>
						        </div>
						    <?php } 
						} elseif (isset($_SESSION['user_detail']['userId'])) 
							echo "Write first review";
						else
							echo "<a href='".base_url('login')."' class='btn btn-primary'>Write first review</a>";

						if (isset($_SESSION['user_detail']['userId'])) { ?>
							<form action="<?= base_url('addReview') ?>" method="post">
								<input type="hidden" name="review_for" value="merchant">
								<input type="hidden" name="merchant_id" value="<?= $_GET['merchant_id'] ?>">
								<textarea rows="8" style="width: 98%; margin-top: 80px;" placeholder="Write your review........" name="review" required></textarea>
								<div class="stars">
									<input class="star star-5" id="star-5" type="radio" name="star" value="5" />
									<label class="star star-5" for="star-5"></label>

									<input class="star star-4" id="star-4" type="radio" name="star" value="4" />
									<label class="star star-4" for="star-4"></label>

									<input class="star star-3" id="star-3" type="radio" name="star" value="3" />
									<label class="star star-3" for="star-3"></label>

									<input class="star star-2" id="star-2" type="radio" name="star" value="2" />
									<label class="star star-2" for="star-2"></label>

									<input class="star star-1" id="star-1" type="radio" name="star" value="1" />
									<label class="star star-1" for="star-1"></label>
								</div>
								<button type="submit" class="btn btn-primary pull-right">Submit</button>
							</form>
						<?php } ?>
					</div>
				</div>
				<br class="clr">
			</div>
		<?php } else { ?> 
			<div class="span9">
		        <h4>Merchants</h4>
		    	<table class="table">
					<tbody>
						<?php
						if (isset($result)) 
						{
							foreach ($result as $merchant) 
							{
								$establishment_name = $merchant['establishment_name']; 

								if ($merchant['merchant_logo']) 
									$seller_logo = '<img src="'.base_url(SELLER_ATTATCHMENTS_PATH.$merchant['merchant_id'].'/'.$merchant['merchant_logo']).'" width="100px" />';
								else
								{
									$shop_name_array = explode(" ",ucwords($establishment_name));
									$second_latter = isset($shop_name_array[1][0]) ? $shop_name_array[1][0] : "";
									$seller_logo = '<div id="shopNameImage">'.$shop_name_array[0][0].$second_latter.'</div>';
								}

								echo '<tr class="merchant_detail" href="'.base_url('merchants/'.url_title($establishment_name, '-', true).'?merchant_id=').$merchant['merchant_id'].'">
										<td>
											'.$seller_logo.'
										</td>
										<td>'.$establishment_name.'</td>
									</tr>';
							}
						}
						else
							echo "Not available";
						?>
					</tbody>
				</table>
			</div>
		<?php } ?>
	</div>
</div>
</div>
</div>
</div> 
</div>
</div>
<!-- MainBody End ============================= -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('.merchant_detail').click(function(){
        window.location = $(this).attr('href');
        return false;
    });
});
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
#shopNameImage {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: #512DA8;
  font-size: 20px;
  color: #fff;
  text-align: center;
  line-height: 55px;
}

div.stars {
  width: 270px;
  display: inline-block;
}

input.star { display: none; }

label.star {
  float: right;
  padding: 10px;
  font-size: 36px;
  color: #444;
  transition: all .2s;
}

input.star:checked ~ label.star:before {
  content: '\2605';
  color: orange;
  transition: all .25s;
}

input.star-5:checked ~ label.star:before {
  color: #FE7;
  text-shadow: 0 0 20px #952;
}

input.star-1:checked ~ label.star:before { color: #F62; }

label.star:hover { transform: rotate(-15deg) scale(1.3); }

label.star:before {
  content: '\2605';
}

.merchant_detail:hover{
	background-color: #f7f7f7;
	cursor: pointer;
}

.heading {
	font-size: 25px;
	margin-right: 25px;
}

.fa {
	font-size: 25px;
}

.checked {
	color: orange;
}

/* Three column layout */
.side {
	float: left;
	width: 15%;
	margin-top:10px;
}

.middle {
	margin-top:10px;
	float: left;
	width: 70%;
}

/* Place text to the right */
.right {
	text-align: right;
}

/* Clear floats after the columns */
.row:after {
	content: "";
	display: table;
	clear: both;
}

/* The bar container */
.bar-container {
	width: 100%;
	background-color: #f1f1f1;
	text-align: center;
	color: white;
}

/* Individual bars */
.bar-5 {
	width: <?= $five_star_width ?>; 
	height: 18px; 
	background-color: #4CAF50;
}
.bar-4 {
	width: <?= $four_star_width ?>;
	height: 18px; 
	background-color: #2196F3;
}
.bar-3 {
	width: <?= $three_star_width ?>;
	height: 18px; 
	background-color: #00bcd4;
}
.bar-2 {
	width: <?= $two_star_width ?>;
	height: 18px; 
	background-color: #ff9800;
}
.bar-1 {
	width: <?= $one_star_width ?>;
	height: 18px; 
	background-color: #f44336;
}

/* Responsive layout - make the columns stack on top of each other instead of next to each other */
@media (max-width: 400px) {
	.side, .middle {
		width: 100%;
	}
	.right {
		display: none;
	}
}

.panel-shadow {
    box-shadow: rgba(0, 0, 0, 0.3) 7px 7px 7px;
}
.panel-white {
  border: 1px solid #dddddd;
}
.panel-white  .panel-heading {
  color: #333;
  background-color: #fff;
  border-color: #ddd;
}
.panel-white  .panel-footer {
  background-color: #fff;
  border-color: #ddd;
}

.post .post-heading {
  height: 40px;
  padding: 20px 15px;
}
.post .post-heading .avatar {
  width: 60px;
  height: 60px;
  display: block;
  margin-right: 15px;
}
.post .post-heading .meta .title {
  margin-bottom: 0;
}
.post .post-heading .meta .title a {
  color: black;
}
.post .post-heading .meta .title a:hover {
  color: #aaaaaa;
}
.post .post-heading .meta .time {
  margin-top: 8px;
  color: #999;
}
.post .post-image .image {
  width: 100%;
  height: auto;
}
.post .post-description {
  padding: 15px;
}
.post .post-description p {
  font-size: 14px;
}
.post .post-description .stats {
  margin-top: 20px;
}
.post .post-description .stats .stat-item {
  display: inline-block;
  margin-right: 15px;
}
.post .post-description .stats .stat-item .icon {
  margin-right: 8px;
}
.post .post-footer {
  border-top: 1px solid #ddd;
  padding: 15px;
}
.post .post-footer .input-group-addon a {
  color: #454545;
}
.post .post-footer .comments-list {
  padding: 0;
  margin-top: 20px;
  list-style-type: none;
}
.post .post-footer .comments-list .comment {
  display: block;
  width: 100%;
  margin: 20px 0;
}
.post .post-footer .comments-list .comment .avatar {
  width: 35px;
  height: 35px;
}
.post .post-footer .comments-list .comment .comment-heading {
  display: block;
  width: 100%;
}
.post .post-footer .comments-list .comment .comment-heading .user {
  font-size: 14px;
  font-weight: bold;
  display: inline;
  margin-top: 0;
  margin-right: 10px;
}
.post .post-footer .comments-list .comment .comment-heading .time {
  font-size: 12px;
  color: #aaa;
  margin-top: 0;
  display: inline;
}
.post .post-footer .comments-list .comment .comment-body {
  margin-left: 50px;
}
.post .post-footer .comments-list .comment > .comments-list {
  margin-left: 50px;
}

.thumbnail img{
	height: 150px;
}

.thumbnail{
	height: 250px;
}
</style>