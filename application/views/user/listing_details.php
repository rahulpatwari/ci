<?php 
$avg_rating = ($listing_detail['rating_info']['avg_rating']) ? $listing_detail['rating_info']['avg_rating'] : 0;
$rating_count = ($listing_detail['rating_info']['rating_count']) ? $listing_detail['rating_info']['rating_count'] : 0;
$one_star = $listing_detail['rating_info']['rating_count_1_star'];
$two_star = $listing_detail['rating_info']['rating_count_2_star'];
$three_star = $listing_detail['rating_info']['rating_count_3_star'];
$four_star = $listing_detail['rating_info']['rating_count_4_star'];
$five_star = $listing_detail['rating_info']['rating_count_5_star'];

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

$finance_available = ($listing_detail[0]['finance_available']) ? 'Yes' : 'No';
$home_delivery_available = ($listing_detail[0]['home_delivery_available']) ? 'Yes' : 'No';
$installation_available = ($listing_detail[0]['installation_available']) ? 'Yes' : 'No';
$finance_available = ($listing_detail[0]['finance_available']) ? 'Yes' : 'No';
$in_stock = ($listing_detail[0]['in_stock']) ? 'Yes' : 'No';
$replacement_available = ($listing_detail[0]['replacement_available']) ? 'Yes' : 'No';
$in_stock = ($listing_detail[0]['in_stock']) ? 'Yes' : 'No';
$url = isset($_GET['category']) ? '&category='.$_GET['category'] : '';
$product_name = $listing_detail[0]['product_name'];
?>

<div class="span9">
    <ul class="breadcrumb">
    	<li><a href="<?= base_url() ?>">Home</a> <span class="divider">/</span></li>
    	<?php if (isset($_GET['category'])) { ?>
	    	<li><a href="<?= base_url('product?category='.$_GET['category']) ?>">Products</a> <span class="divider">/</span></li>
	    <?php } ?>
	    <li><a href="<?= base_url('products/'.url_title($product_name, '-', true).'?prd_id='.$_GET['prd_id'].$url) ?>">product Details</a> <span class="divider">/</span></li>
	    <li class="active">Listing Information</li>
    </ul>	
    <div class="row">	  
		<div id="gallery" class="span3">
			<div style="margin: 40px;">
				<img src="<?= $listing_detail['images'][0] ?>" style="width:60%" title="<?= $product_name ?>" />
			</div>
            
            <div id="differentview" class="moreOptopm carousel slide">
                <div class="carousel-inner">
                	<div class="item active">
                		<?php
                		foreach ($listing_detail['images'] as $imgs) 
                			echo '<a href="'.$imgs.'"><img style="height:50px; margin:5px;" src="'.$imgs.'" /></a>';
                		?>
					</div>
                </div>
            </div>
		</div>

		<div class="span6">
			<h3><?= $product_name ?></h3>
			<h5>MRP: <strike><?= currency_format($listing_detail[0]['mrp_price']) ?></strike></h5>
			<hr />
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

			<a href="#" name="detail"></a>
			<hr class="soft"/>
		</div>
	
		<div class="span9" style="margin-top: 20px;">
            <div id="myTabContent" class="tab-content" style="overflow: hidden;">
            	<div class="tab-pane fade active in" id="home">
			  		<table class="table table-striped">
						<tbody>
							<tr>
								<td colspan="2">
									<i>Offered By</i>
									<a href="<?= base_url('merchants?merchant_id=').$listing_detail[0]['merchant_id'] ?>"><h4 style="color: #04c;"><?= $listing_detail[0]['establishment_name'] ?></h4></a>
								</td>
							</tr>
							<tr>
								<td>Sale Price</td>
								<td>&#x20b9; <?= $listing_detail[0]['list_price']." (".calculatePercentage($listing_detail[0]['mrp_price'], $listing_detail[0]['list_price'])."% Off)" ?></td>
							</tr>
							<tr>
								<td>Finance available </td>
								<td><?= $finance_available ?></td>
							</tr>
							<tr>
								<td>Finance terms</td>
								<td><?= $listing_detail[0]['finance_terms'] ?></td>
							</tr>
							<tr>
								<td>Home delievery available</td>
								<td><?= $home_delivery_available ?></td>
							</tr>
							<tr>
								<td>Home delivery terms</td>
								<td><?= $listing_detail[0]['home_delivery_terms'] ?></td>
							</tr>
							<tr>
								<td>Installation available</td>
								<td><?= $installation_available ?></td>
							</tr>
							<tr>
								<td>Installation terms</td>
								<td><?= $listing_detail[0]['installation_terms'] ?></td>
							</tr>
							<tr>
								<td>In stock</td>
								<td><?= $in_stock ?></td>
							</tr>
							<tr>
								<td>Replacement available</td>
								<td><?= $replacement_available ?></td>
							</tr>
							<tr>
								<td>Replacement terms</td>
								<td><?= $listing_detail[0]['replacement_terms'] ?></td>
							</tr>
							<tr>
								<td>Seller offerings</td>
								<td><?= $listing_detail[0]['seller_offering'] ?></td>
							</tr>
						</tbody>
					</table>

					<br /><h5>Offer(s) provided by merchant on product</h5>
					<table class="table">
						<tbody>
							<?php
							foreach ($listing_offers as $offer) 
							{
								echo '<tr>
										<td>'.$offer['description'].'</td>
									</tr>';
							}
							?>
						</tbody>
					</table>

					<br /><h5>Merhant address</h5>
					<table class="table">
						<tbody>
							<?php
							foreach ($merchant_addresses['result'] as $address) 
							{
								$lat = $addres['latitude'];
								$long = $addres['longitude'];
								$distance = distance($lat, $long);
								$contact = ($address['contact']) ? $address['contact'] : '';
								$address_line_1 = ($address['address_line_1']) ? $address['address_line_1'].', ' : '';
								$address_line_2 = ($address['address_line_2']) ? $address['address_line_2'].', ' : '';
								$landmark = ($address['landmark']) ? $address['landmark'].', ' : '';
								$city_name = ($address['city_name']) ? $address['city_name'].', ' : '';
								$state_name = ($address['state_name']) ? $address['state_name'].', ' : '';
								$country_name = ($address['country_name']) ? $address['country_name'] : '';
								$pin = ($address['pin']) ? ' - '.$address['pin'] : '';

								$merchant_address = $address_line_1.$address_line_2.$landmark.$city_name.$state_name.$country_name.$pin;

								echo '<tr>
										<td>'.$merchant_address."<br />Shop no: ".$contact.'</td>
										<td>';
											if ($distance) 
												echo '<a href="http://www.google.com/maps/place/'.$lat.','.$long.'" target="_blank"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSewwbzGWLC9Sr38nEmyRulDk1M2Dqq3zle8CInqmHb21WfCHsi" width="50px"></a>'.$distance;
									echo '</td>
									</tr>';
							}
							?>
							<tr>
								<td colspan=2>
									<h5>Business Days</h5>
									<?= $listing_detail[0]['business_days'] ?>
								</td>
							</tr>
							<tr>
								<td colspan=2>
									<h5>Business Hours</h5>
									<?= $listing_detail[0]['business_hours'] ?>
								</td>
							</tr>
						</tbody>
					</table>
              	</div>
			</div>
			<br class="clr">
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
</style>
