<?php 
$avg_rating = ($product['rating_info']['avg_rating']) ? $product['rating_info']['avg_rating'] : 0;
$rating_count = ($product['rating_info']['rating_count']) ? $product['rating_info']['rating_count'] : 0;
$one_star = $product['rating_info']['rating_count_1_star'];
$two_star = $product['rating_info']['rating_count_2_star'];
$three_star = $product['rating_info']['rating_count_3_star'];
$four_star = $product['rating_info']['rating_count_4_star'];
$five_star = $product['rating_info']['rating_count_5_star'];

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
?>

<div class="span9">
    <ul class="breadcrumb">
    	<li><a href="<?= base_url() ?>">Home</a> <span class="divider">/</span></li>
    	<?php if (isset($_GET['category'])) { ?>
	    	<li><a href="<?= base_url('products?category='.$_GET['category']) ?>">Products</a> <span class="divider">/</span></li>
	    <?php } 
	    elseif (isset($_GET['prd_id'])) { ?>
	    	<li><a href="<?= base_url('products') ?>">Products</a> <span class="divider">/</span></li>
	    <?php } ?>
	    <li class="active">product Details</li>
    </ul>	
	<div class="row">	  
		<div id="gallery" class="span3">
			<div style="margin: 40px;">
				<img src="<?= $product['images'][0] ?>" style="width:30%" title="<?= $product['product_name'] ?>" />	
			</div>
            
            <div id="differentview" class="moreOptopm carousel slide">
                <div class="carousel-inner">
                	<div class="item active">
                		<?php
                		foreach ($product['images'] as $imgs) 
                			echo '<a href="'.$imgs.'"><img style="height:30px; width:30px; margin:5px;" src="'.$imgs.'" /></a>';
                		?>
					</div>
                </div>
            </div>
		</div>

		<div class="span6">
			<h3><?= $product['product_name'] ?></h3><hr />
			
			<table class="table table-bordered">
				<tbody>
					<tr><th colspan="2">Product Details</th></tr>
					<?php
					if ($product['brand_name']) 
					{
						echo '<tr>
								<td>Brand</td>
								<td>'.$product['brand_name'].'</td>
							</tr>';
					}

					if ($product['in_the_box']) 
					{
						echo '<tr>
								<td>In the box</td>
								<td>'.$product['in_the_box'].'</td>
							</tr>';
					}

					if ($product['mrp_price']) 
					{
						echo '<tr>
								<td>MRP</td>
								<td>'.currency_format($product['mrp_price']).'</td>
							</tr>';
					}
					?>
				</tbody>
			</table>
		</div>
			
		<div class="span9">
            <ul id="productDetail" class="nav nav-tabs">
				<li><a href="#specification" data-toggle="tab">Specifications</a></li>
				<li><a href="#description" data-toggle="tab">Description</a></li>
				<li class="active"><a href="#key_features" data-toggle="tab">Key Features</a></li>
            </ul>

            <div id="myTabContent" class="tab-content" style="overflow: hidden;">
            	<div class="tab-pane fade active in" id="key_features">
            		<?php if ($product['key_features']) { ?>
						<ul>
							<?php
							foreach ($product['key_features'] as $feature) 
								echo "<li>".$feature."</li>";
							?>
						</ul>
					<?php } else
								echo "Not available"; ?>
            	</div>

            	<div class="tab-pane fade" id="description"><?= $product['description'] ?></div>

            	<div class="tab-pane fade" id="specification">
            		<?php if ($product['specifications']) { ?>
						<table class="table table-bordered">
							<tbody>
								<?php
								foreach ($product['specifications'] as $spec_value) 
								{
									if ($spec_value['value']) 
									{
										echo '<tr><td>'.$spec_value['spec'].'</td><td>'.$spec_value['value'].'</td></tr>';
									}
								}

								if ($product['varients']) 
								{
									foreach ($product['varients'] as $vrnt_key_name => $vrnt_values) 
									{
										echo '<tr><td>'.$vrnt_key_name.'</td><td>';

										$i = 0;
										foreach ($vrnt_values as $vrnt_value) 
										{
											if ($i > 0) 
												echo ", ";

											echo $vrnt_value;

											$i++;
										}

										echo '</td></tr>';
									}
								}
								?>
							</tbody>
						</table>
					<?php } ?>
            	</div>
			</div>
			<br class="clr">
		</div>

		<?php if ($product['sold_by_merchants']) { ?>
			<div class="span9" style="margin-bottom: 20px;">
				<h3>Offered by</h3>
				<?php 
				$url = isset($_GET['category']) ? '&category='.$_GET['category'] : '';

		    	foreach ($product['sold_by_merchants'] as $merchant) 
		    	{
		    		$listing_url = base_url('listings').'/'.url_title($merchant['establishment_name'].'-'.$product['product_name'], '-', true).'?list_id='.$merchant['listing_id'].'&prd_id='.$_GET['prd_id'].$url;
		    	?>
			        <div class="span3" style="margin-left: 5px;">
			            <div class="panel panel-white post panel-shadow">
			                <div class="post-heading" style="height: auto;">
			                	<a href="<?= $listing_url ?>">
				                	<div class="row">
				                		<div style="padding: 0px 0px 10px 40px;">
					                		<div class="pull-left meta">
						                        <div class="title h5">
						                            <?php 
						                            echo "<h4><b>".$merchant['establishment_name']."</b></h4>";
						                        	$lat = $merchant['nearest_address']['latitude'];
						                    		$long = $merchant['nearest_address']['longitude'];
						                        	$distance = distance($lat, $long);
						                        	if ($distance) 
						                        	{
						                        		echo "<div class='distance'>
						                        				<img src='https://cdn0.iconfinder.com/data/icons/logistics-delivery-set-2-1/512/7-512.png' width='20px' />
						                        				".$distance."
						                        			</div>";	
						                        	} 
						                        	echo currency_format($merchant['list_price']);
					                            	echo "&nbsp;&nbsp;<b>(".calculatePercentage($product['mrp_price'], $merchant['list_price'])."% Off)</b>";
						                        	?>
						                        </div>
						                    </div>
						                </div>
					                </div>
				                </a>
			                </div> 
			            </div>
			        </div>
			    <?php } ?>	
			</div>

		<?php } if ($product['reviews']) { ?>
		<div class="span9" style="margin-bottom: 20px;">
            <ul id="productDetail" class="nav nav-tabs">
				<li><a href="#review" data-toggle="tab">Reviews</a></li>
				<li class="active"><a href="#product_rating" data-toggle="tab">Rating</a></li>
            </ul>

            <div id="myTabContent" class="tab-content" style="overflow: hidden;">
	            <div class="tab-pane fade active in" id="product_rating">
	            	<?php
					for ($i = 1; $i <= 5; $i++) 
					{ 
						if ($i <= round($avg_rating))
							echo '<span class="fa fa-star checked"></span>';
						else
							echo '<span class="fa fa-star"></span>';
					}
					?>

	        		<p><?= $avg_rating.' average based on '.$rating_count.' reviews.' ?></p>
				
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
	        	</div>
	        	
	        	<div class="tab-pane fade" id="review">
					<?php foreach ($product['reviews'] as $review) {  ?>
					        <div class="panel panel-white post panel-shadow" style="margin-bottom: 13px;">
				                <div class="post-heading">
				                    <div class="pull-left image">
				                        <?php 
				                    	$consumer_pic = ($review['picture']) ? $this->config->item('site_url').PROFILE_PIC_PATH.$review['picture'] : "http://dummyimage.com/60x60/666/ffffff&text=No+Image";
										?>
				                        <img src="<?= $consumer_pic ?>" class="img-circle avatar" alt="user profile image">
				                    </div>
				                    <div class="pull-left meta">
				                        <div class="title h5">
				                            <b><?= $review['consumer_name']."&nbsp;&nbsp;" ?></b>
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
				                        <h6 class="text-muted time"><?= time_elapsed_string($review['last_updated']) ?></h6>
				                    </div>
				                </div> 
				                <div class="post-description"> 
				                    <p><?= $review['review'] ?></p>
				                </div>
				            </div>
					    <?php } 

					if (isset($_SESSION['user_detail']['userId'])) { ?>
						<form action="<?= base_url('addReview') ?>" method="post">
							<input type="hidden" name="review_for" value="product">
							<input type="hidden" name="product_id" value="<?= $_GET['prd_id'] ?>">
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
        </div>
        <?php } else if (!isset($_SESSION['user_detail']['userId']))
        			echo "<div class='span9'><a href='".base_url('login')."' class='btn btn-primary btn-block'>Become First to Review this Product</a></div>";
        else { ?>
        	<form action="<?= base_url('addReview') ?>" method="post">
				<input type="hidden" name="review_for" value="product">
				<input type="hidden" name="product_id" value="<?= $_GET['prd_id'] ?>">
				<textarea rows="8" style="width: 98%; margin-top: 80px;" placeholder="Become First to Review this Product........" name="review" required></textarea>
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

		<div class="span9" style="margin-top: 10px;">
			<div class="tab-pane fade active in" id="products">
	  			<div class="pull-left">
	  				<h4>Similar Products</h4>
	  			</div>	
	  			<div id="myTab" class="pull-right">
	  				<a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
	  				<a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
	  			</div>
	  			<br class="clr"/>
	  			<hr class="soft"/>
	  			<div class="tab-content">
	  				<div class="tab-pane" id="listView">
	  					<?php 
	  					if ($product['similar_products']) {
							foreach ($product['similar_products'] as $prd) { ?>
								<div class="span9" style="margin: 20px;">
									<div class="span2">
										<img src="<?= $prd['images'][0] ?>" />
									</div>
									<h5><?= $prd['product_name'] ?></h5>
								</div>
								<hr class="soft"/>
							<?php } 
						} else
							echo "Similar Products Not available"; ?>
	  				</div>
	  				<div class="tab-pane active" id="blockView">
	  					<ul class="thumbnails">
	  						<?php 
	  						if ($product['similar_products']) {
								foreach ($product['similar_products'] as $prd) { ?>
									<li class="span3">
										<div class="thumbnail">
											<?php $product_detail_url = base_url('products/'.url_title($prd['product_name'], '-', true).'?prd_id='.$prd['product_id']); ?>
											<a href="<?= $product_detail_url ?>">
												<img src="<?= $prd['images'][0] ?>" />
											</a>
											<div class="caption" align="center">
												<h5 style="height: 40px;">
													<?= $prd['product_name'] ?>
												</h5>
											</div>
									  	</div>
									</li>
								<?php } 
							} else
								echo "<li>Similar Products Not available</li>"; ?>
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
		</div>
	</div>
</div>
</div>
</div>
</div> 
</div>
</div>
<!-- MainBody End ============================= -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
#blockView img, #listView img{
	height: 150px;
}

.distance{
    background-color: orange;
    padding: 10px;
    color: white;
    font-weight: 900;
    font-size: 25px;
    margin: 10px;

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
</style>
