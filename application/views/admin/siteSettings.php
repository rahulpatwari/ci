<?php
$home_page_title = isset($site_settings['home_page_title']) ? $site_settings['home_page_title'] : '';
$home_page_meta_description = isset($site_settings['home_page_meta_description']) ? $site_settings['home_page_meta_description'] : '';
$home_page_key_words = isset($site_settings['home_page_key_words']) ? $site_settings['home_page_key_words'] : '';
$product_title_suffix = isset($site_settings['product_title_suffix']) ? $site_settings['product_title_suffix'] : '';
$merchant_title_suffix = isset($site_settings['merchant_title_suffix']) ? $site_settings['merchant_title_suffix'] : '';
$category_title_suffix = isset($site_settings['category_title_suffix']) ? $site_settings['category_title_suffix'] : '';
$brand_title_suffix = isset($site_settings['brand_title_suffix']) ? $site_settings['brand_title_suffix'] : '';
$listing_title_suffix = isset($site_settings['listing_title_suffix']) ? $site_settings['listing_title_suffix'] : '';
$merchants_meta_title = isset($site_settings['merchants_meta_title']) ? $site_settings['merchants_meta_title'] : '';
$merchants_meta_description = isset($site_settings['merchants_meta_description']) ? $site_settings['merchants_meta_description'] : '';
$merchants_meta_keywords = isset($site_settings['merchants_meta_keywords']) ? $site_settings['merchants_meta_keywords'] : '';
$products_meta_title = isset($site_settings['products_meta_title']) ? $site_settings['products_meta_title'] : '';
$products_meta_description = isset($site_settings['products_meta_description']) ? $site_settings['products_meta_description'] : '';
$products_meta_keywords = isset($site_settings['products_meta_keywords']) ? $site_settings['products_meta_keywords'] : '';
$brands_meta_title = isset($site_settings['brands_meta_title']) ? $site_settings['brands_meta_title'] : '';
$brands_meta_description = isset($site_settings['brands_meta_description']) ? $site_settings['brands_meta_description'] : '';
$brands_meta_keywords = isset($site_settings['brands_meta_keywords']) ? $site_settings['brands_meta_keywords'] : '';
$categories_meta_title = isset($site_settings['categories_meta_title']) ? $site_settings['categories_meta_title'] : '';
$categories_meta_description = isset($site_settings['categories_meta_description']) ? $site_settings['categories_meta_description'] : '';
$categories_meta_keywords = isset($site_settings['categories_meta_keywords']) ? $site_settings['categories_meta_keywords'] : '';
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>Site setting</h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Site setting</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8 col-md-offset-2">
				<!-- general form elements -->
				<div class="box box-primary">
				    <!-- form start -->
				    <?= form_open_multipart('updateSiteSetting') ?>
				    	<div class="box-body">
				    		<div class="box-body">
				    			<h3>Home Page:</h3>
					    		<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Title:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter home page title" name="home_page_title" required><?= $home_page_title ?></textarea>
									</div>
								</div>

						        <div class="row form-group">
							    	<div class="col-sm-2">
										<label>Meta Description:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter home page meta description" name="home_page_meta_description" required><?= $home_page_meta_description ?></textarea>
									</div>
								</div>

								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Key Words:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter home page key words" name="home_page_key_words" required><?= $home_page_key_words ?></textarea>
									</div>
								</div>
							</div>

							<div class="box-body">
				    			<h3>Title Suffix:</h3>
								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Product:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter product title suffix" name="product_title_suffix"><?= $product_title_suffix ?></textarea>
									</div>
								</div>

								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Merchant:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter merchant title suffix" name="merchant_title_suffix"><?= $merchant_title_suffix ?></textarea>
									</div>
								</div>

								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Category:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter category title suffix" name="category_title_suffix"><?= $category_title_suffix ?></textarea>
									</div>
								</div>

								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Brand:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter brand title suffix" name="brand_title_suffix"><?= $brand_title_suffix ?></textarea>
									</div>
								</div>

								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Listing:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter listing title suffix" name="listing_title_suffix"><?= $listing_title_suffix ?></textarea>
									</div>
								</div>
							</div>

							<div class="box-body">
				    			<h3>Meta Data For All Brands:</h3>
								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Title:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter brands title" name="brands_meta_title"><?= $brands_meta_title ?></textarea>
									</div>
								</div>

								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Description:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter brands description" name="brands_meta_description"><?= $brands_meta_description ?></textarea>
									</div>
								</div>

								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Key Words:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter brands meta keywords" name="brands_meta_keywords"><?= $brands_meta_keywords ?></textarea>
									</div>
								</div>
							</div>

							<div class="box-body">
				    			<h3>Meta Data For All Products:</h3>
								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Title:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter products title" name="products_meta_title"><?= $products_meta_title ?></textarea>
									</div>
								</div>

								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Description:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter products description" name="products_meta_description"><?= $products_meta_description ?></textarea>
									</div>
								</div>

								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Key Words:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter products meta keywords" name="products_meta_keywords"><?= $products_meta_keywords ?></textarea>
									</div>
								</div>
							</div>

							<div class="box-body">
				    			<h3>Meta Data For All Categories:</h3>
								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Title:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter categories title" name="categories_meta_title"><?= $categories_meta_title ?></textarea>
									</div>
								</div>

								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Description:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter categories description" name="categories_meta_description"><?= $categories_meta_description ?></textarea>
									</div>
								</div>

								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Key Words:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter categories meta keywords" name="categories_meta_keywords"><?= $categories_meta_keywords ?></textarea>
									</div>
								</div>
							</div>

							<div class="box-body">
				    			<h3>Meta Data For All Merchants:</h3>
								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Title:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter merchants title" name="merchants_meta_title"><?= $merchants_meta_title ?></textarea>
									</div>
								</div>

								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Description:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter merchants description" name="merchants_meta_description"><?= $merchants_meta_description ?></textarea>
									</div>
								</div>

								<div class="row form-group">
							    	<div class="col-sm-2">
										<label>Key Words:</label>
									</div>
									<div class="col-sm-10">
										<textarea class="form-control" placeholder="please enter merchants meta keywords" name="merchants_meta_keywords"><?= $merchants_meta_keywords ?></textarea>
									</div>
								</div>
							</div>
					        <div class="box-footer" align="right" style="clear: both;">
					        	<a href='<?= base_url("dashboard") ?>' class='btn btn-default'>Cancel</a>
					            <button type="submit" class="btn btn-primary">Submit</button>
					        </div>
					    </div>
				    <?= form_close() ?>
				</div><!-- /.box -->
			</div>   <!-- /.row -->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->
