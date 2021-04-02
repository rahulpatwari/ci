<div class="span9">
    <ul class="breadcrumb">
    	<li><a href="<?= base_url() ?>">Home</a> <span class="divider">/</span></li>
    	<?php 
    	if (isset($_GET['brand_id'])) 
    	{
	    	echo '<li><a href="'.base_url('brands').'">Brands</a> <span class="divider">/</span></li>
	    		<li class="active">Brand Detail</li>';
	    } 
	    else 
	    	echo '<li class="active">Brands</li>';
	    ?>
    </ul>	

	<div class="row">	  
		<?php if (isset($_GET['brand_id'])) { ?>
			<div id="gallery" class="span3">
				<div style="margin: 40px;">
					<img src="<?= base_url(BRAND_ATTATCHMENTS_PATH.$brand['brand_id'].'/'.$brand['brand_logo']) ?>" style="width:100%" title="<?= $brand['name'] ?>" />	
				</div>
	            
	            <div id="differentview" class="moreOptopm carousel slide">
	                <div class="carousel-inner">
	                	<div class="item active">
	                		<?php
	                		if ($brand_images) 
	                		{
	                			foreach ($brand_images as $imgs) 
	                				echo '<a href="'.$imgs.'"><img style="height:50px; margin:5px;" src="'.$imgs.'" /></a>';
	                		}
	                		?>
						</div>
	                </div>
	            </div>
			</div>

			<div class="span6">
				<h3><?= $brand['name'] ?></h3>
				<hr class="soft"/>
				
				<p><?= $brand['brand_desc'] ?></p>
				
				<a class="btn btn-small pull-right" href="#detail">More Details</a>
				<br class="clr"/>

				<a href="#" name="detail"></a>
				<hr class="soft"/>
			</div>
				
			<div class="span9">
	            <ul id="productDetail" class="nav nav-tabs">
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
			  					<?php if ($products) {
									foreach ($products['result'] as $product) { ?>
										<div class="row">	  
											<div class="span2">
												<img src="<?= $product['products_images'][0] ?>" />
											</div>
											<div class="span4">
												<h5><?= $product['product_name'] ?></h5>
												<p><?= $product['description'] ?></p>
											</div>
											<div class="span3 alignR">
												<form class="form-horizontal qtyFrm">
													<h3><?= currency_format($product['mrp_price']) ?></h3>
													<a class="btn btn-small pull-right" href="<?= base_url('products/'.url_title($product['product_name'], '-', true).'?prd_id='.$product['product_id'].'&category='.$selected_category_string) ?>">View Details</a>
													<br class="clr"/>
												</form>
											</div>
										</div>
										<hr class="soft"/>
									<?php } 
								} else
									echo "Not available"; ?>
			  				</div>
			  				<div class="tab-pane active" id="blockView">
			  					<ul class="thumbnails">
			  						<?php if ($products) {
										foreach ($products['result'] as $product) { ?>
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
														<h5 style="height: 40px;"><?= $product['product_name'] ?></h5>
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

			  			<?php if ($products) { ?>
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
				<br class="clr">
			</div>
		<?php } else { ?>
			<div class="span9">
		        <h4>Brands</h4>
		    	<table class="table">
					<tbody>
						<?php
						if (isset($result)) 
						{
							foreach ($result as $brand) 
							{
								echo '<tr class="brand" href="'.base_url('brands/'.$brand['name'].'?brand_id=').$brand['brand_id'].'">
										<td>
											<img src="'.$this->config->item('site_url').BRAND_ATTATCHMENTS_PATH.$brand['brand_id'].'/'.$brand['brand_logo'].'" width="100px">
										</td>
										<td>'.$brand['name'].'</td>
									</tr>';
							}
						}
						else
							"Not available";
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
    $('.brand').click(function(){
        window.location = $(this).attr('href');
        return false;
    });
});
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.brand:hover{
	background-color: #f7f7f7;
	cursor: pointer;
}

.thumbnail img{
	height: 150px;
}

.thumbnail{
	height: 230px;
}
</style>