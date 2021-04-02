<?php 
$review_id = isset($review_data['review_id']) ? $review_data['review_id'] : '';
$review_title = isset($review_data['review_title']) ? $review_data['review_title'] : '';
$rating = isset($review_data['rating']) ? $review_data['rating'] : '';
$review = isset($review_data['review']) ? $review_data['review'] : '';
$create_date = isset($review_data['review_date']) ? convert_to_user_date($review_data['review_date']) : '';
$update_date = isset($review_data['last_updated']) ? convert_to_user_date($review_data['last_updated']) : '';
$consumer_name = isset($review_data['consumer_name']) ? $review_data['consumer_name'] : '';
$shop_name = isset($review_data['shop_name']) ? $review_data['shop_name'] : $review_data['product_name'];
$merchant_or_product_label = ($page_label == 'merchant') ? 'Shop name' : 'Product name';
$page_title = ($page_type == 'view') ? $page_label.' review' : 'Edit '.$page_label.' review';
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1><?= ucfirst($page_label) ?> Review<small><?= $page_type ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url('review/'.$page_label) ?>"><?= ucfirst($page_label) ?> Review Management</a></li>
            <li class="active"><?= ucwords($page_type.' '.$page_label) ?> Review</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6 col-md-offset-3">
				<!-- general form elements -->
				<div class="box box-primary">
				    <div class="box-header">
				    	<?php if ($page_type == "view") { ?>
					        <div class="box-footer" align="right">
					            <a href='<?= base_url("review/$page_label") ?>' class='btn btn-default'>Back</a>
					            <a href='<?= base_url("editReview/$review_id/$page_label") ?>' class='btn btn-primary'>Edit</a>
					            <a href='<?= base_url("deleteReview/$review_id/$page_label") ?>' class='btn btn-danger'>Delete</a>
					        </div>
					    <?php } ?>
					</div><!-- /.box-header -->

					<?php if ($page_type == 'view') { ?>
						<div class="box-body">
							<div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Consumer name:</label>	
				            	</div>
				            	<div class="col-sm-9">
				            		<?= $consumer_name ?>
				            	</div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label><?= $merchant_or_product_label ?>:</label>	
				            	</div>
				            	<div class="col-sm-9">
				            		<?= $shop_name ?>
				            	</div>
				            </div>

							<div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Title:</label>	
				            	</div>
				            	<div class="col-sm-9">
				            		<?= $review_title ?>
				            	</div>
				            </div>

				            <div class="row form-group">
	                    		<div class="col-sm-3">
	                    			<label>Review:</label>	
	                    		</div>
	                    		<div class="col-sm-9">
	                    			<?= $review ?>
	                    		</div>
	                    	</div>

	                    	<div class="row form-group">
	                    		<div class="col-sm-3">
	                    			<label>Rating:</label>	
	                    		</div>
	                    		<div class="col-sm-9">
	                    			<?= $rating ?>
	                    		</div>
	                    	</div>

	                    	<div class="row form-group">
	                    		<div class="col-sm-3">
	                    			<label>Create Date:</label>	
	                    		</div>
	                    		<div class="col-sm-9">
	                    			<?= $create_date ?>
	                    		</div>
	                    	</div>

	                    	<div class="row form-group">
	                    		<div class="col-sm-3">
	                    			<label>Update Date:</label>	
	                    		</div>
	                    		<div class="col-sm-9">
	                    			<?= $update_date ?>
	                    		</div>
	                    	</div>
	                    </div>
					<?php } else { ?>
						<!-- form start -->
					    <?= form_open('addReview'); ?>
					        <div class="box-body">
					            <div class="row form-group">
					            	<div class="col-sm-3">
					                	<label>Title: </label>
					                </div>
					                <div class="col-sm-9">
						                <input type="hidden" name="review_for" value="<?= $page_label ?>" />
						                <input type="hidden" name="review_id" value="<?= $review_id ?>" />

						                <input type="text" name="review_title" class="form-control" placeholder="Enter Review Title" value="<?= $review_title ?>" />
						            </div>
								</div>

								<div class="row form-group">
					            	<div class="col-sm-3">
					                	<label>Review*: </label>
					                </div>
					                <div class="col-sm-9">
						                <textarea name="review" class="form-control address" placeholder="Enter Review" required><?= $review ?></textarea>
						            </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-3">
					                	<label>Rating*: </label>
					                </div>
					                <div class="col-sm-9">
					                	<select class="form-control" name="rating">
						                	<?php 
						                	for ( $i=1; $i <= 5; $i++ ) 
						                	{ 
						                		if ( $i == $rating ) 
						                			$selected = "selected='selected'";
						                		else
						                			$selected = '';

						                		echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';	
						                	}
						                	?>
				                        </select>
						            </div>
					            </div>
					        </div><!-- /.box-body -->

					        <div class="box-footer"  align="right">
					        	<?php echo "<a href='../../review/$page_label' class='btn btn-default'>Cancel</a>"; ?>
					            <button type="submit" class="btn btn-primary">Submit</button>
					        </div>
					    <?php echo form_close(); 
					} ?>
				</div><!-- /.box -->
			</div>   <!-- /.row -->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->