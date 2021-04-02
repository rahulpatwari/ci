<?php 
if (isset($_GET['merchant_id'])) 
	$selected_category_name = 'Seller products';
else if (isset($_GET['brand_id'])) 
	$selected_category_name = 'Brand products';
else if (isset($_GET['category'])) 
	$selected_category_name = ucfirst($this->uri->segment(2));
else
	$selected_category_name = 'All products';
?>

<div class="span9">
    <ul class="breadcrumb">
		<li><a href="<?= base_url() ?>">Home</a> <span class="divider">/</span></li>
		<li class="active"><?= $selected_category_name ?></li>
    </ul>
	<h3> <?= $selected_category_name ?> <small class="pull-right"> <?= $products['count'] ?> product(s) available </small></h3>
	<hr class="soft"/>

	<div id="myTab" class="pull-right" style="margin-bottom: 10px;">
 		<a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
 		<a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
	</div>
	<br class="clr"/>
	
	<div class="tab-content">
		<div class="tab-pane active" id="blockView">
			<ul class="thumbnails box">
				<?php if ($products) {
					foreach ($products['result'] as $product) { ?>
						<li class="span3">
							<div class="thumbnail">
								<?php
								$product_detail_url = base_url('products/'.url_title($product['product_name'], '-', true).'?prd_id='.$product['product_id']);
								?>
								<a href="<?= $product_detail_url ?>">
									<img src="<?= $product['products_images'][0] ?>" />
								</a>
								<div class="caption" align="center">
									<h5 style="height: 40px;"><?= $product['product_name'] ?></h5>
									<h4 style="text-align:center">
										<a class="btn btn-primary"><?= currency_format($product['mrp_price']) ?></a>
									</h4>
								</div>
						  	</div>
						</li>
					<?php } 
				} else
					echo "<li>Not available</li>"; ?>
			</ul>
			<hr class="soft"/>
		</div>

		<div class="tab-pane" id="listView">
			<?php if ($products) {
				foreach ($products['result'] as $product) { 
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
								<form class="form-horizontal qtyFrm">
									<h3><?= currency_format($product['mrp_price']) ?></h3>
									<br class="clr"/>
								</form>
							</div>
						</div>
					</a>
					<hr class="soft"/>
				<?php } 
			} else
				echo "Not available"; ?>
		</div>
	</div>

	<?php if ($products && $products['paging']['total_pages'] > 1) { ?>
		<div class="pagination">
			<ul>
				<?php
				$total_pages = $products['paging']['total_pages'];
				$current_page = $products['paging']['page'];
				$prev_page = $current_page-1;
				$next_page = $current_page+1;
				$query_strings = array();

				if ($_SERVER['QUERY_STRING']) 
				{
					$query_strings = $_GET;
			        unset($query_strings['limit']);
			        unset($query_strings['page']);	
				}

				$query_strings['limit'] = 9;

				$href = base_url($_SERVER['REDIRECT_URL'].'?'.http_build_query($query_strings).'&page=');

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
					echo '<li><a>Next</a></li>';
				else
					echo '<li><a href="'.$href.$next_page.'">Next</a></li>';
				?>
			</ul>
		</div>
		<br class="clr"/>
	<?php } ?>
</div>
</div>
</div>
</div>
<!-- MainBody End ============================= -->

<style>
#blockView img, #listView img{
	height: 150px;
}

#selected_page{
	background-color: #006dcc;
	color: white;
}

.box:hover{
	-moz-box-shadow: 0 0 10px #ccc;
	-webkit-box-shadow: 0 0 10px #ccc;
	box-shadow: 0 0 10px #ccc;
}	
</style>
