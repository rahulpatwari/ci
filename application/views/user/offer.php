<div class="span9">
    <ul class="breadcrumb">
    	<li><a href="<?= base_url() ?>">Home</a> <span class="divider">/</span></li>
    	<li><a href="<?= base_url() ?>">Offers</a> <span class="divider">/</span></li>
    	<?php if (isset($_GET['offer_id'])) { ?>
	    	<li><a class="active" href="<?= base_url() ?>">Offer</a></li>
	    <?php } ?>
    </ul>	
	<div class="row">	  
		<div id="gallery" class="span3">
			<div style="margin: 40px;">
				<img src="<?= $offers[0]['offer_images'][0] ?>" style="width:50%" title="<?= $offers[0]['offer_title'] ?>" />	
			</div>            
            <div id="differentview" class="moreOptopm carousel slide">
                <div class="carousel-inner">
                	<div class="item active">
                		<?php
                		foreach ($offers[0]['offer_images'] as $imgs) 
                			echo '<a href="'.$imgs.'"><img style="height:50px; margin:5px;" src="'.$imgs.'" /></a>';
                		?>
					</div>
                </div>
            </div>
		</div>

		<div class="span6">
			<h3><?= $offers[0]['offer_title'] ?></h3>
			<h5><?= $offers[0]['description'] ?></h5>
			<h5><?= "Valid from ".date('j M Y', strtotime($offers[0]['start_date']))." To ".date('j M Y', strtotime($offers[0]['end_date'])) ?></h5>
			<hr />

			<a href="#" name="detail"></a>
			<hr class="soft"/>
		</div>
			
		<div class="9">
			<div class="tab-pane fade active in" id="products">
	  			<div id="myTab" class="pull-right">
	  				<a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
	  				<a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
	  			</div>
	  			<br class="clr"/>
	  			<hr class="soft"/>
	  			<div class="tab-content">
	  				<div class="tab-pane" id="listView">
	  					<?php 
	  					if ($offer_listing_products) {
							foreach ($offer_listing_products as $prd) { ?>
								<div class="span2">
									<img src="<?= $prd['products_images'][0] ?>" />
								</div>
								<div class="span4">
									<h5><?= $prd['product_name'] ?></h5>
								</div>
								<hr class="soft"/>
							<?php } 
						} else
							echo "Similar Products Not available"; 
						?>
	  				</div>
	  				<div class="tab-pane active" id="blockView">
	  					<ul class="thumbnails">
	  						<?php 
	  						if ($offer_listing_products) {
							foreach ($offer_listing_products as $prd) { ?>
									<li class="span3">
										<div class="thumbnail">
											<?php $product_detail_url = base_url('product_detail?prd_id='.$prd['product_id']); ?>
											<a href="<?= $product_detail_url ?>">
												<img src="<?= $prd['products_images'][0] ?>" />
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

<style type="text/css">
.thumbnail img{
	height: 150px;
}
</style>