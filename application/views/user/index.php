<div class="span9">		
	<div class="well well-small">
		<h4>
			Latest Products 
			<small class="pull-right">
				<a class="btn btn-primary" href="<?= base_url('products') ?>">View all</a>
			</small>
		</h4>
		<div class="row-fluid">
			<div id="featured1" class="carousel slide">
				<div class="carousel-inner">
					<?php 
					if ($products) 
					{
						$i = 0;
						foreach ($products['result'] as $product) 
						{ 
							if ($i != 0 && $i%4 == 0)
								echo '</ul></div>';

							if ($i%4 == 0) 
							{
								$class = ($i == 0) ? "active" : "";

								echo '<div class="item '.$class.'">
					  					<ul class="thumbnails">';
							} 
						?>
							  				<li class="span3">
							  					<a href="<?= base_url('products/'.url_title($product['product_name'], '-', true).'?prd_id='.$product['product_id']) ?>">
								  					<div class="thumbnail">
									  					<img src="<?= $product['products_images'][0] ?>" />
														<div class="caption">
										  					<h5><?= $product['product_name'] ?></h5>
														</div>
									  				</div>
								  				</a>
											</li>
					  	<?php 
					  		$i++;

					  		if (count($products['result']) == $i) 
								echo '</ul></div>';
					  	}
					}
					else
						echo "Not available"; 
				  	?>
			  	</div>
				<a class="left carousel-control" href="#featured1" data-slide="prev">‹</a>
				<a class="right carousel-control" href="#featured1" data-slide="next">›</a>
			</div>
		</div>
	</div>	

	<div class="well well-small">
		<h4>
			Merchants 
			<small class="pull-right">
				<a class="btn btn-primary" href="<?= base_url('merchants') ?>">View all</a>
			</small>
		</h4>
		<div class="row-fluid">
			<div id="featured" class="carousel slide">
				<div class="carousel-inner">
					<?php 
					if ($merchants) 
					{
						$i = 0;
						foreach ($merchants['result'] as $merchant) 
						{ 
							$merchant_id = $merchant['merchant_id'];
							$establishment_name = $merchant['establishment_name'];
							$merchant_logo = ($merchant['merchant_logo']) ? $this->config->item('site_url').SELLER_ATTATCHMENTS_PATH.$merchant_id.'/'.$merchant['merchant_logo'] : '';

							if ($i != 0 && $i%5 == 0)
								echo '</ul></div>';

							if ($i%5 == 0) 
							{
								$class = ($i == 0) ? "active" : "";

								echo '<div class="item '.$class.'">
					  					<ul class="thumbnails">';
							} 
								if($merchant_logo)
								{
									echo '<li>
					  						<div class="brand_logo">';
								}
								else
								{
									echo '<li class="span3">
					  						<div class="thumbnail brand_logo">';
								}
				  						echo '<a href="merchants/'.url_title($establishment_name, '-', true).'?merchant_id='.$merchant_id.'">'; 
			  									if ($merchant_logo)
			  										echo '<img src="'.$merchant_logo.'" />';
			  									else
			  										echo $establishment_name;
			  							echo '</a> 
					  						</div>
										</li>';
					  		$i++;

					  		if (count($merchants['result']) == $i) 
								echo '</ul></div>';
					  	} 
					}
					else
						echo "Not available";
				  	?>
			  	</div>
				<a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
				<a class="right carousel-control" href="#featured" data-slide="next">›</a>
			</div>
		</div>
	</div>

	<div class="well well-small">
		<h4>
			Brands 
			<small class="pull-right">
				<a class="btn btn-primary" href="<?= base_url('brands') ?>">View all</a>
			</small>
		</h4>
		<div class="row-fluid">
			<div id="featured2" class="carousel slide">
				<div class="carousel-inner">
					<?php 
					if ($brands) 
					{
						$i = 0;
						foreach ($brands['result'] as $brand) 
						{ 
							$brand_id = $brand['brand_id'];


							if ($i != 0 && $i%7 == 0)
								echo '</ul></div>';

							if ($i%7 == 0) 
							{
								$class = ($i == 0) ? "active" : "";

								echo '<div class="item '.$class.'">
					  					<ul class="thumbnails">';
							} 
									echo '<li>
					  						<div class="brand_logo">
					  							<a href="brands/'.url_title($brand['name'], '-', true).'?brand_id='.$brand_id.'">
					  								<img src="'.base_url(BRAND_ATTATCHMENTS_PATH.$brand_id.'/'.$brand['brand_logo']).'" />
					  							</a> 
					  						</div>
										</li>';
					  		$i++;

					  		if (count($brands['result']) == $i) 
								echo '</ul></div>';
					  	} 
					}
					else
						echo "Not available";
				  	?>
			  	</div>
				<a class="left carousel-control" href="#featured2" data-slide="prev">‹</a>
				<a class="right carousel-control" href="#featured2" data-slide="next">›</a>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>

<style type="text/css">
.thumbnail img{
	height: 150px;
}

.brand_logo img{
	height: 50px;
}

.thumbnail h5{
	width: 170px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.carousel{
	margin-bottom: 0px;
}

.well h4{
	margin: 20px;
}
</style>
