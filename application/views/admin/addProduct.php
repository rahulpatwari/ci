<?php 
$product_id = isset($product_id) ? $product_id : false;
$product_name = isset($product_name) ? $product_name : '';
$amazon_prd_id = isset($amazon_prd_id) ? $amazon_prd_id : '';
$flipkart_prd_id = isset($flipkart_prd_id) ? $flipkart_prd_id : '';
$description = isset($description) ? $description : '';
$mrp_price = isset($mrp_price) ? $mrp_price : '';
$product_images_dir = isset($product_images_dir) ? $product_images_dir : '';
$images = isset($images) ? $images : '';
$category_name = isset($category_name) ? $category_name : '';
$brand_name = isset($brand_name) ? $brand_name : '';
$page_label = isset($page_label) ? $page_label : 'Add Product';
$prd_varients = isset($product_varients) ? $product_varients : false;
$cat_id = isset($category_id) ? $category_id : '';
$in_the_box = isset($in_the_box) ? $in_the_box : '';
$meta_keyword = isset($meta_keyword) ? $meta_keyword : '';
$meta_description = isset($meta_description) ? $meta_description : '';
$notes = isset($notes) ? $notes : '';

if (isset($page_label) && $page_label == "edit") 
	$page_title = 'Edit product';
else if (isset($page_label) && $page_label == "view") 
	$page_title = 'View product';
else if (isset($page_label) && $page_label == "duplicate") 
	$page_title = 'Create duplicate product';
else
{
	$page_label = "add";
	$page_title = 'Add product';
}
?>

<style type="text/css">
.vrnt_values{
	margin-bottom: 10px;
}
</style>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<?php if (isset($_GET['req_prd_id'])) { ?>
		<!-- bread crumb -->
	    <section class="content-header">
	        <h1>
	            Product
	            <small><?= $page_label ?></small>
	        </h1>
	        <ol class="breadcrumb">
	            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
	            <li><a href="<?= base_url('page/requestedProducts') ?>">Requested product Management</a></li>
	            <li class="active"><?= $page_title ?></li>
	        </ol>
	    </section>
	<?php } else { ?>
		<!-- bread crumb -->
	    <section class="content-header">
	        <h1>
	            Product
	            <small><?= $page_label ?></small>
	        </h1>
	        <ol class="breadcrumb">
	            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
	            <li><a href="<?= base_url('products') ?>">Product Management</a></li>
	            <li class="active"><?= $page_title ?></li>
	        </ol>
	    </section>
	<?php } ?>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <?php if (isset($_GET['req_prd_id']))
            	echo '<div class="col-md-7">';
            else
           		echo '<div class="col-md-8 col-md-offset-2">';
           	?>
					<!-- general form elements -->
					<div class="box box-primary">
					    <div class="box-header">
					        <!-- Attribute Modal -->
			                <div class="modal fade" id="attributeModal">
			                    <div class="modal-dialog">
			                        <!-- Modal content-->
			                        <div class="modal-content">
			                            <div class="modal-header">
			                                <button class="close" data-dismiss="modal">&times;</button>
			                                <h4 class="modal-title">Add varients</h4>
			                            </div>

			                            <div class="modal-body">
			                                <!-- select box for all attributes -->
			                                <?php
			                                echo form_open('addProductVarient').
			                                	 	"<input type='hidden' value='".$product_id."' name='prd_id'>
			                                		<input type='hidden' value='".$cat_id."' name='cat_id'>
			                                		<input type='hidden' value='".$page_label."' name='page_label'>
			                                    	<select class='form-control' id='att_id' name='att_id'>";

			                                    if (isset($attributes)) 
			                                    {
			                                        echo "<option value='0'>Select an attribute to make varients!!</option>";

			                                        foreach ($attributes as $att_value)
			                                            echo "<option value='".$att_value['att_id']."'>".$att_value['att_name']."</option>";
			                                    }
			                                    else
			                                        echo "<option value='0'>No attribute available!</option>";
			                                    
			                                    echo "</select>";

			                                    echo '<div class="form-group" id="input_field_div"></div>';
			                                ?>
			                            </div>
			                            <div class="modal-footer">
			                                <button type="button" class="btn btn-info" id="createVarientFieldBtn" disabled><i class="fa fa-plus"></i> Create verient field</button>
			                                <button class="btn btn-default" data-dismiss="modal">Close</button>
			                                <button type="submit" class="btn btn-primary" id="varientSubmitBtn" disabled>Submit</button>
			                            </div>
			                            <?= form_close() ?>			                            
			                        </div>
			                    </div>
			                </div>

<!---------------------########### START PRODUCT VIEW FORM ###################------------------>

					        <?php if ($page_label == "view") { ?>
						        <div class="box-footer" align="right">
						            <a href='<?= base_url("products") ?>' class='btn btn-default'>Back</a>
						            <a href='<?= base_url("editProduct/$product_id/edit") ?>' class='btn btn-primary'>Edit</a>
						            <a href='<?= base_url("deleteProduct/$product_id") ?>' class='btn btn-danger'>Delete</a>
						    	</div>

								<div class="box-body">
						    		<!-- select category -->
			                        <div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Category:</label>	
		                        		</div>
		                        		<div class="col-sm-9">
		                        			<?php
											if ($status) 
								    		{
								    			foreach ($categories as $cat_value) 
								    			{
								 					if ($cat_value['category_name'] == $category_name) 
								    				{
														echo $cat_value['category_name'];
														echo "<input type='hidden' value='".$cat_value['category_id']."' id='par_cat_id'>";
														break;
								    				}
								    			}
								    		}
								    		else
								    			echo "-";
								    		?>			
		                        		</div>
			                        </div>

									<!-- select brand -->
			                        <div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Brand:</label>	
		                        		</div>
		                        		<div class="col-sm-9">
		                        			<?php
								    		if ($status) 
								    		{
								    			foreach ($brands as $brands_value) 
								    			{
								    				if ($brands_value['name'] == $brand_name)
								    				{
								    					echo $brands_value['name'];
								    					break;
								    				}
								    			}
								    		}
								    		else
								    			echo "<option>-</option>";
								    		?>
		                        		</div>
		                        	</div>

							    	<input type="hidden" name="prd_id" value="<?= $product_id; ?>">

							    	<div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Product Name:</label>	
		                        		</div>
		                        		<div class="col-sm-9">
		                        			<?= $product_name ?>
		                        		</div>
		                        	</div>

		                        	<div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Amazon Product ID:</label>	
		                        		</div>
		                        		<div class="col-sm-9">
		                        			<?= $amazon_prd_id ?>
		                        		</div>
		                        	</div>

		                        	<div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Flipkart Product ID:</label>	
		                        		</div>
		                        		<div class="col-sm-9">
		                        			<?= $flipkart_prd_id ?>
		                        		</div>
		                        	</div>

			                        <div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Product Price*:</label>	
		                        		</div>
		                        		<div class="col-sm-9">
		                        			<?= $mrp_price ?>
		                        		</div>
		                        	</div>

		                        	<div class="row form-group" style="clear: both;">
		                        		<div class="col-sm-3">
		                        			<label>Product Description:</label>	
		                        		</div>
		                        		<div class="col-sm-9">
		                        			<?= $description ?>
		                        		</div>
		                        	</div>

		                        	<div class="row form-group" style="clear: both;">
		                        		<div class="col-sm-3">
		                        			<label>In The Box:</label>	
		                        		</div>
		                        		<div class="col-sm-9">
		                        			<?= $in_the_box ?>
		                        		</div>
		                        	</div>
									
									<div class="row form-group">
								    	<div class="col-sm-3">
											<label>Tags:</label>
										</div>
										<div class="col-sm-9">
											<span class="bigcheck">
												<?php
												$count = 0;	
			                                	if (count($tags)>0) 
					    						{
					    							function array_value_exist($product_tags, $value)
													{
														if (count($product_tags)>0) 
					    								{
														    foreach ($product_tags as $prd_tag_value) 
														    {
						    									if ( $prd_tag_value['tag_id'] == $value ) 
						    									{
						    										return "checked";
						    										break;
						    									}
						    								}
						    							}

					    								return "";
													}

													foreach ($tags as $tag_key => $tag_value)
					    							{
					    								$checked = array_value_exist($product_tags, $tag_value['tag_id']);

					    								if ($checked) 
					    								{
					    									echo $tag_value['tag_name'];

					    									if ( sizeof($tags)>$count )
																echo ", &nbsp;&nbsp;";

					    									$count++;
					    								}
					    							}
					    						}
					    						
					    						if ($count == 0)
					    							echo "Not available";
			                                	?>	                                    
			                                </span>
										</div>
									</div>

		                        	<div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Product Images:</label>	
		                        		</div>
		                        		<div class="col-sm-9">
		                        			<?php 
					                        if (!empty($images)) 
					                        {
					                        	foreach ($images as $img_value) 
					                        		echo '<div class="thumbnail">
					                        				<figure>
																<img src="'.$product_images_dir.'/'.$img_value['atch_url'].'" height="50">
														    </figure>
														</div>';
					                        }
					                        else
					                        	echo "Not available";
					                        ?>
		                        		</div>
		                        	</div>

		                        	<?php if ($page_label == "view" && $product_varients) { ?>
		                        		<div style="margin-bottom: 20px;">
			                        		<div class="box-body table-responsive">
							                    <table class="table table-bordered table-striped">
							                        <thead>
							                        	<tr>
							                        		<th colspan="3"><center>Product varients</center></th>
							                        	</tr>
							                        	<tr>
							                                <th>S.No.</th>
							                                <th>Varient name </th>
							                                <th>Varient value</th>
							                            </tr>
							                        </thead>
							                        <tbody>
							                        	<?php	
							                        	$i = 1;
						                        		foreach ($product_varients as $prd_vrnt_key => $prd_vrnt_values) 
						                        		{
						                        			echo "<tr>
						                        					<td>".$i++."</td>
						                        					<td>".$prd_vrnt_key."</td><td>";

						                        			foreach ($prd_vrnt_values as $vrnt_key => $vrnt_value) 
								                            {
								                            	if ($vrnt_key != 0)
								                            		echo ", ";

								                            	echo $vrnt_value['att_value'];
								                            }

							                                echo "</td></tr>";
						                                }
							                        	?>
							                        </tbody>
							                    </table>
							                </div><!-- /.box-body -->
							            </div>
		                			<?php } ?>

									<div class="form-group" id="att_fields" style="display: none;"></div>

									<div class="row form-group" style="clear: both;">
		                        		<div class="col-sm-3">
		                        			<label>Product key features:</label>	
		                        		</div>
		                        		<div class="col-sm-9">
		                        			<?php
			                                if ($key_features) 
			                                {
			                                	echo "<ul>";

			                                    foreach ($key_features['result'] as $feature_value) 
			                                    	echo "<li>".$feature_value['feature']."</li>";

			                                    echo "</ul>";
			                                }
			                                else
			                                    echo "Not available";
			                                ?>
		                        		</div>
		                        	</div>

		                        	<div class="row form-group" style="clear: both;">
		                        		<div class="col-sm-3">
		                        			<label>Product HTMLs:</label>	
		                        		</div>
		                        		<div class="col-sm-9">
		                        			<ul>
			                        			<?php
					                        	for ($i = 1, $j = 0; $i <= 5; $i++, $j++)
					                        	{
					                        		$link = isset( $html_files['result'][$j]['html_file'] ) ? $html_files['result'][$j]['html_file'] : '';

													if ( $link ) 
														echo "<li>".$this->config->item('site_url').HTML_FILES_PATH.$link."</li>";
													else
														echo "-";
					                        	}
					                        	?>
					                        </ul>
		                        		</div>
		                        	</div>

		                        	<div class="row form-group" style="clear: both;">
		                        		<div class="col-sm-3">
		                        			<label>Meta Keywords:</label>	
		                        		</div>
		                        		<div class="col-sm-9">
		                        			<?= $meta_keyword ?>
		                        		</div>
		                        	</div>

		                        	<div class="row form-group" style="clear: both;">
		                        		<div class="col-sm-3">
		                        			<label>Meta Description:</label>	
		                        		</div>
		                        		<div class="col-sm-9">
		                        			<?= $meta_description ?>
		                        		</div>
		                        	</div>

		                        	<div class="row form-group" style="clear: both;">
		                        		<div class="col-sm-3">
		                        			<label>Notes:</label>	
		                        		</div>
		                        		<div class="col-sm-9">
		                        			<?= $notes ?>
		                        		</div>
		                        	</div>

		                        	<div class="row form-group" style="clear: both;">
		                        		<div class="col-sm-3">
		                        			<label>Create Date:</label>	
		                        		</div>
		                        		<div class="col-sm-9">
		                        			<?= convert_to_user_date($create_date) ?>
		                        		</div>
		                        	</div>

		                        	<div class="row form-group" style="clear: both;">
		                        		<div class="col-sm-3">
		                        			<label>Update Date:</label>	
		                        		</div>
		                        		<div class="col-sm-9">
		                        			<?= convert_to_user_date($update_date) ?>
		                        		</div>
		                        	</div>
							    </div>

<!---------------------########### END PRODUCT VIEW FORM ###################-------------------->
<!----------------########### START PRODUCT ADD OR EDIT FORM ###################---------------->

					    <?php } else if ($page_label == "edit" || $page_label == "add") { ?>
					    	<!-- Key Feature Modal -->
	                        <div class="modal fade" id="keyFeatureModal">
	                            <div class="modal-dialog">
	                                <!-- Modal content-->
	                                <div class="modal-content">
	                                    <div class="modal-header">
	                                        <button class="close" data-dismiss="modal">&times;</button>
	                                        <h4 class="modal-title">Edit Feature</h4>
	                                    </div>

	                                    <?= form_open('addKeyFeature') ?>
	                                        <div class="modal-body">
	                                            <input type='hidden' name='feature_id' id='feature_id'>
	                                            <input type='hidden' name='product_id' id='product_id'>

	                                            <div class='row form-group'>
	                                                <div class='col-sm-3'>
	                                                    <label>Key Feature:</label>    
	                                                </div>
	                                                <div class='col-sm-9'>
	                                                    <input type='text' name='feature' id='feature' class='form-control' required>
	                                                </div>
	                                            </div>
	                                        </div>
	                                        <div class="modal-footer">
	                                            <button class="btn btn-default" data-dismiss="modal">Close</button>
	                                            <button type="submit" class="btn btn-primary">Submit</button>
	                                        </div>
	                                    <?= form_close() ?>                                     
	                                </div>
	                            </div>
	                        </div>

						    <!-- form start -->
						    <?php 
						    echo form_open_multipart('insertProduct'); 

						    if (isset($_GET['req_prd_id'])) 
						    {
						    	echo "<input type='hidden' value='".$_GET['req_prd_id']."' name='req_prd_id' />";
						    	echo "<input type='hidden' value='".$req_prds['merchant_id']."' name='merchant_id' />";
						    }
						    ?>

						    	<div class="box-body">
						    		<!-- select category -->
			                        <div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Category*:</label>	
		                        		</div>
		                        		<div class="col-sm-5">
		                        			<?php
		                        			if ($page_label == 'add') 
		                        			{
		                        				$product_id = 0;
		                        				$page_label = "'add'";
		                        			}
		                        			else
		                        				$page_label = "'edit'";

											echo '<select class="form-control" name="parent_cat_id" onchange="getCategoryAttribtes(this.value, '.$product_id.', '.$page_label.');" required>';

									    		if ($status) 
									    		{
									    			echo "<option value=''>Please select an category!!</option>";

									    			foreach ($categories as $cat_key => $cat_value) 
									    			{
									 					$selected = $cat_value['category_name'] == $category_name ? 'selected' : '';

									    				echo "<option value='".$cat_value['category_id']."' ".$selected.">".$cat_value['category_name']."</option>";
									    			}
									    		}
									    		else
									    			echo "<option>No parent category available!</option>";
								    		
								    		echo "</select>";
								    		?>			
		                        		</div>
			                        </div>

			                        <!-- select brand -->
			                        <div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Brand*:</label>	
		                        		</div>
		                        		<div class="col-sm-5">
		                        			<?php
								    		echo '<select class="form-control" name="brand_id" required>';
								    		if ($status) 
								    		{
								    			echo "<option value=''>Please select a brand!!</option>";

								    			foreach ($brands as $brand_key => $brands_value) 
								    			{
								    				$selected = $brands_value['name'] == $brand_name ? 'selected' : '';

								    				echo "<option value='".$brands_value['brand_id']."' ".$selected.">".$brands_value['name']."</option>";
								    			}
								    		}
								    		else
								    			echo "<option>No brand available!</option>";
								    		
								    		echo "</select>
								    			</div>";
								    		?>
		                        		</div>

							    	<input type="hidden" name="prd_id" value="<?= $product_id; ?>">

							    	<div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Product Name*:</label>	
		                        		</div>
		                        		<div class="col-sm-5">
		                        			<input type="text" class="form-control" placeholder="Enter product name..." name="prd_name" value="<?= $product_name ?>" required/>
		                        		</div>
		                        	</div>

		                        	<div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Amazon Product ID:</label>	
		                        		</div>
		                        		<div class="col-sm-5">
		                        			<input type="text" class="form-control" placeholder="Enter amazon product id..." name="amazon_prd_id" value="<?= $amazon_prd_id ?>" />
		                        		</div>
		                        	</div>

		                        	<div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Flipkart Product ID:</label>	
		                        		</div>
		                        		<div class="col-sm-5">
		                        			<input type="text" class="form-control" placeholder="Enter flipkart product id..." name="flipkart_prd_id" value="<?= $flipkart_prd_id ?>" />
		                        		</div>
		                        	</div>

			                        <div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Product Price*:</label>	
		                        		</div>
		                        		<div class="col-sm-5">
		                        			<input type="text" class="form-control" placeholder="Enter product price..." name="prd_price" value="<?= $mrp_price; ?>" required/>
		                        		</div>
		                        	</div>
								    
			                        <div class="row form-group" style="clear: both;">
		                        		<div class="col-sm-3">
		                        			<label>Product Description*:</label>	
		                        		</div>
		                        		<div class="col-sm-8">
		                        			<textarea class="form-control" rows="5" name="prd_desc" placeholder="Please enter product description..." required><?= $description ?></textarea>
		                        		</div>
		                        	</div>

		                        	<div class="row form-group" style="clear: both;">
		                        		<div class="col-sm-3">
		                        			<label>In The Box:</label>	
		                        		</div>
		                        		<div class="col-sm-8">
		                        			<textarea class="form-control" rows="5" name="in_the_box" placeholder="What you have provided in the product box..."><?= $in_the_box ?></textarea>
		                        		</div>
		                        	</div>
									
									<div class="row form-group">
								    	<div class="col-sm-3">
											<label>Tags:</label>
										</div>
										<div class="col-sm-8">
											<span class="bigcheck">
												<?php
			                                	if (count($tags)>0) 
					    						{
					    							function array_value_exist($product_tags, $value)
													{
														if (count($product_tags)>0) 
					    								{
														    foreach ($product_tags as $prd_tag_value) 
														    {
						    									if ( $prd_tag_value['tag_id'] == $value ) 
						    									{
						    										return "checked";
						    										break;
						    									}
						    								}
						    							}

					    								return "";
													}

					    							foreach ($tags as $tag_value)
					    							{
					    								$checked = array_value_exist($product_tags, $tag_value['tag_id']);

					    								echo '<div> <label class="bigcheck">
														    	<input type="checkbox" class="bigcheck" name="selected_tag_ids[]" value="'.$tag_value['tag_id'].'"'.$checked.' />
														    	<span class="bigcheck-target"></span>&nbsp;&nbsp;
														    	'.$tag_value['tag_name'].'
														  	</label></div>';
					    							}
					    						}
			                                	?>	                                    
			                                </span>
										</div>
									</div>

									<div class="box-body table-responsive">
					                    <table id="example1" class="table table-bordered table-striped">
					                        <thead>
					                            <tr>
					                                <th colspan="3"><center>Product Images</center></th>
					                            </tr>
					                        </thead>
					                        <tbody>
						                        <?php for ( $i = 1, $j = 0; $i < 7; $i++, $j++ ) { ?>
						                        	<tr>
						                        		<td>
						                        			<div class="btn btn-success btn-file">
							                                    <i class="fa fa-paperclip"></i> Image<?= $i ?>
							                                    <input type="file" name="file<?= $i ?>" id="file<?= $i ?>" />
							                                </div>
							                            </td>
						                        		<?php 
						                        		if ($page_label == "'edit'") 
						                        		{
							                        		echo "<td>";
							                        			if (isset($images[$j]))
								                        		{
								                        			$img_src = $product_images_dir.'/'.$images[$j]['atch_url'];
									                        		
									                        		echo '<div class="thumbnail">
									                        				<figure>
																				<img src="'.$img_src.'">
																				<center>
																		    		<figcaption><a href="'.base_url().'deleteAttactchment/'.$images[$j]['atch_url'].'/editProduct/'.$product_id.'" class="btn btn-danger">DELETE</a></figcaption>
																		    	</center>
																		    </figure>
																		</div>

																		<input type="hidden" name="remove_img'.$i.'" value="'.$images[$j]['atch_url'].'" />';
									                        	}
									                        echo "</td>";
								                        } ?>
						                        		<td><div class="file<?= $i ?>"></div></td>
						                        	</tr>
						                        <?php } ?>
					                    	</tbody>
					                    </table>
					                </div>
						            
						            <div class="box-body table-responsive" id="att_fields" style="display: none;"></div>

					            	<div style="margin-bottom: 20px;">
		                        		<div class="box-body table-responsive">
						                    <table class="table table-bordered table-striped">
						                        <thead>
						                        	<tr>
			                                            <th colspan="3">Product varients
			                                            <button class="btn btn-warning pull-right" data-toggle="modal" data-target="#attributeModal" id="addVarientBtn"><i class="fa fa-plus"></i> Add Varient</button></th>
			                                        </tr>
						                            <tr>
						                                <th>Varient name </th>
						                                <th>Varient value</th>
						                                <th>Delete</th>
						                            </tr>
						                        </thead>
						                        <tbody>
						                        	<?php	
						                        	if (isset($product_varients) && $product_varients) {
							                        	echo '<input type="hidden" value="'.$product_id.'" name="prd_id">';

							                        	$i = 1;
						                        		foreach ($product_varients as $prd_vrnt_key => $prd_vrnt_values) 
						                        		{
						                        			$rowspan = count($prd_vrnt_values)+1;
						                        			echo "<tr>
						                        					<td rowspan=".$rowspan.">".$prd_vrnt_key."</td></tr>";

						                        			foreach ($prd_vrnt_values as $vrnt_value) 
						                        			{
						                        				$vrnt_id = $vrnt_value['vrnt_id'];
								                            	$vrnt_del_link = base_url('deleteProductVarientValue/'.$vrnt_id.'/'.$product_id);

						                        				echo "<tr>
						                        						<td>".
								                            				"<input type='hidden' value='".$vrnt_id."' name='vrnt_ids[]'>
							                                            	<input type='text' class='vrnt_values' placeholder='Enter attibute value...' name='vrnt_values[]' value='".$vrnt_value['att_value']."' />"
									                            		."</td>
									                            		<td>
							                                                <a href='".$vrnt_del_link."' class='btn btn-danger'>Delete</a>
							                                            </td>
								                            		</tr>";
						                        			}
						                                }
						                            }
						                            else
						                            	echo "<tr><td colspan=3><center>Not available</center></td>";
						                        	?>
						                        </tbody>
						                    </table>
						                </div><!-- /.box-body -->
						            </div>
									
									<div class="box-body table-responsive">
		                                <table id="example1" class="table table-bordered table-striped">
		                                    <thead>
		                                        <tr>
		                                            <th colspan="2">
		                                                Product Key Features
		                                                <button type="button" class="btn btn-warning pull-right" id="createKeyFeatureFieldBtn"><i class="fa fa-plus"></i> Add product Key Feature</button>
		                                            </th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                    	<tr>
		                                    		<td>
		                                    			<div class="row form-group">
							                                <div class="col-sm-8" id="key_feature_input_field_div"></div>
							                            </div>
		                                    		</td>
		                                    	</tr>
		                                        <?php
		                                        if ($key_features) 
		                                        {
		                                            foreach ($key_features['result'] as $feature_value) 
		                                            {
		                                                $feature_id = $feature_value['feature_id'];
		                                                $feature = $feature_value['feature'];
		                                                $params = $feature_id.', "'.$feature.'", '.$product_id;

		                                                echo "<tr>
		                                                        <td>".$feature."</td>
		                                                        <td>
		                                                            <button type='button' class='btn btn-warning' onclick='open_key_feature_modal($params)'>Edit</button>
		                                                            <a href='".base_url()."deleteFeature/".$feature_id."/".$product_id."' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
		                                                        </td>
		                                                    </tr>";
		                                            }
		                                        }
		                                        else
		                                            echo "<tr><td colspan='3' align='center'>No Record found.</td></tr>";
		                                        ?>
		                                    </tbody>
		                                </table>
		                            </div><!-- /.box-body -->

		                            <div class="box-body table-responsive">
					                    <table id="example1" class="table table-bordered table-striped">
					                        <thead>
					                        	<tr>
					                        		<th colspan="4">
					                        			<center>HTML FILES FOR CATEGORY</center>
					                        		</th>
					                        	</tr>
					                            <tr>
					                                <th></th>
					                                <th>Prefix Path</th>
					                                <th>File Path</th>
					                                <th>Action</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php
					                        	for ( $i = 1, $j = 0; $i <= 5; $i++, $j++ )
					                        	{
					                        		$link_id = isset( $html_files['result'][$j]['html_file_id'] ) ? $html_files['result'][$j]['html_file_id'] : '';
													$link = isset( $html_files['result'][$j]['html_file'] ) ? $html_files['result'][$j]['html_file'] : '';

													if ($link) 
													{
														$buttons = "<a href='".base_url("deleteLink/$link_id/$product_id/PRODUCT")."' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
				                                                <a href='".$this->config->item('site_url').HTML_FILES_PATH.$link."' class='btn btn-success' target='_blank'>Preview</a>";
													}
													else
														$buttons = '';
													
					                                echo "<tr>
				                        					<td>HTML LINK".$i."</td>
				                        					<td><span class='label label-default'>".$this->config->item('site_url').HTML_FILES_PATH."/</span></td>
				                                            <td>
				                                            	<input type='hidden' name='html_id".$i."' value='".$link_id."' />
				                                            	<input type='text' name='html_link".$i."' value='".$link."' class='form-control' />
				                                            </td>
				                                            <td>".$buttons."</td>
				                        				</tr>";
					                        	}
					                        	?>
					                        </tbody>
					                    </table>
					                </div><!-- /.box-body -->

					                <div class="row form-group">
								    	<div class="col-sm-2">
											<label>Meta Keywords:</label>
										</div>
										<div class="col-sm-10">
											<textarea class="form-control" placeholder="please enter meta keyword(s)" name="meta_keyword"><?= $meta_keyword ?></textarea>
										</div>
									</div>

									<div class="row form-group">
								    	<div class="col-sm-2">
											<label>Meta Description:</label>
										</div>
										<div class="col-sm-10">
											<textarea class="form-control" placeholder="please enter meta description" name="meta_description"><?= $meta_description ?></textarea>
										</div>
									</div>

									<div class="row form-group">
								    	<div class="col-sm-2">
											<label>Notes:</label>
										</div>
										<div class="col-sm-10">
											<textarea class="form-control" placeholder="please enter notes" name="notes"><?= $notes ?></textarea>
										</div>
									</div>
									
									<div class="box-footer" align="right">
										<?php 
										if (isset($_GET['req_prd_id'])) 
											echo "<a href='".base_url("page/requestedProducts")."' class='btn btn-default'>Cancel</a>";
										else
											echo "<a href='".base_url("products")."' class='btn btn-default'>Cancel</a>";
										?>

							            <button type="submit" class="btn btn-primary" id="submit_btn">Submit</button>
							        </div>
							    </div>
						    <?= form_close() ?>
						
<!----------------########### END PRODUCT ADD OR EDIT FORM ###################---------------->
<!----------------########### START PRODUCT DUPLICATE FORM ###################---------------->

						<?php } elseif ($page_label == "duplicate") { ?>
							<!-- form start -->
						    <?= form_open_multipart('insertProduct') ?>
						    	<input type="hidden" name="old_prd_id" value="<?= $product_id ?>" />
						    	<div class="box-body">
						    		<!-- select category -->
			                        <div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Category*:</label>	
		                        		</div>
		                        		<div class="col-sm-5">
		                        			<?php
											echo '<select class="form-control" name="parent_cat_id" onchange="getCategoryAttribtes(this.value, '.$product_id.');" required>';

									    		if ($status) 
									    		{
									    			echo "<option value=''>Please select an category!!</option>";

									    			foreach ($categories as $cat_value) 
									    			{
									 					$selected = $cat_value['category_name'] == $category_name ? 'selected' : '';

									    				echo "<option value='".$cat_value['category_id']."' ".$selected.">".$cat_value['category_name']."</option>";
									    			}
									    		}
									    		else
									    			echo "<option>No parent category available!</option>";
								    		
								    		echo "</select>";
								    		?>			
		                        		</div>
			                        </div>

			                        <!-- select brand -->
			                        <div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Brand*:</label>	
		                        		</div>
		                        		<div class="col-sm-5">
		                        			<?php
								    		echo '<select class="form-control" name="brand_id" required>';
								    		if ($status) 
								    		{
								    			echo "<option value=''>Please select a brand!!</option>";

								    			foreach ($brands as $brands_value) 
								    			{
								    				$selected = $brands_value['name'] == $brand_name ? 'selected' : '';

								    				echo "<option value='".$brands_value['brand_id']."' ".$selected.">".$brands_value['name']."</option>";
								    			}
								    		}
								    		else
								    			echo "<option>No brand available!</option>";
								    		
								    		echo "</select>";
								    		?>
		                        		</div>
		                        	</div>
							    	<div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Product Name*:</label>	
		                        		</div>
		                        		<div class="col-sm-5">
		                        			<input type="text" class="form-control" placeholder="Enter product name..." name="prd_name" value="<?= $product_name ?>" required/>
		                        		</div>
		                        		<div class="col-sm-4">
		                        			(Same product name is not allowed)
		                        		</div>
		                        	</div>

		                        	<div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Amazon Product ID:</label>	
		                        		</div>
		                        		<div class="col-sm-5">
		                        			<input type="text" class="form-control" placeholder="Enter amazon product id..." name="amazon_prd_id" />
		                        		</div>
		                        	</div>

		                        	<div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Flipkart Product ID:</label>	
		                        		</div>
		                        		<div class="col-sm-5">
		                        			<input type="text" class="form-control" placeholder="Enter flipkart product id..." name="flipkart_prd_id" />
		                        		</div>
		                        	</div>

			                        <div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Product Price*:</label>	
		                        		</div>
		                        		<div class="col-sm-5">
		                        			<input type="text" class="form-control" placeholder="Enter product price..." name="prd_price" value="<?= $mrp_price ?>" required/>
		                        		</div>
		                        	</div>
								    
			                        <div class="row form-group" style="clear: both;">
		                        		<div class="col-sm-3">
		                        			<label>Product Description*:</label>	
		                        		</div>
		                        		<div class="col-sm-8">
		                        			<textarea class="form-control" rows="5" name="prd_desc" placeholder="Please enter product description..." required><?= $description ?></textarea>
		                        		</div>
		                        	</div>

		                        	<div class="row form-group" style="clear: both;">
		                        		<div class="col-sm-3">
		                        			<label>In The Box:</label>	
		                        		</div>
		                        		<div class="col-sm-8">
		                        			<textarea class="form-control" rows="5" name="in_the_box" placeholder="What you have provided in the product box..."><?= $in_the_box ?></textarea>
		                        		</div>
		                        	</div>
									
									<div class="row form-group">
								    	<div class="col-sm-3">
											<label>Tags:</label>
										</div>
										<div class="col-sm-8">
											<span class="bigcheck">
												<?php
			                                	if (count($tags)>0) 
					    						{
					    							function array_value_exist($product_tags, $value)
													{
														if (count($product_tags)>0) 
					    								{
														    foreach ($product_tags as $prd_tag_value) 
														    {
						    									if ( $prd_tag_value['tag_id'] == $value ) 
						    									{
						    										return "checked";
						    										break;
						    									}
						    								}
						    							}

					    								return "";
													}

					    							foreach ($tags as $tag_value)
					    							{
					    								$checked = array_value_exist($product_tags, $tag_value['tag_id']);

					    								echo '<div> <label class="bigcheck">
														    	<input type="checkbox" class="bigcheck" name="selected_tag_ids[]" value="'.$tag_value['tag_id'].'"'.$checked.' />
														    	<span class="bigcheck-target"></span>&nbsp;&nbsp;
														    	'.$tag_value['tag_name'].'
														  	</label></div>';
					    							}
					    						}
			                                	?>	                                    
			                                </span>
										</div>
									</div>

									<div class="row form-group">
		                        		<div class="col-sm-3">
		                        			<label>Product Images:</label>	
		                        		</div>
		                        		<div class="col-sm-9">
		                        			<?php 
		                        			if (!empty($images)) 
					                        {
					                        	foreach ($images as $img_value) 
					                        		echo '<div class="thumbnail">
					                        				<figure>
																<img src="'.$product_images_dir.'/'.$img_value['atch_url'].'" height="80">
														    </figure>
														</div>';
					                        }
					                        else
					                        	echo "Not available";
					                        ?>
		                        		</div>
		                        	</div>

									<?php if ($product_varients) { ?>
		                        		<div style="margin-bottom: 20px;">
			                        		<div class="box-body table-responsive">
							                    <table class="table table-bordered table-striped">
							                        <thead>
							                        	<tr>
				                                            <th colspan="3"><center>Product varients</center></th>
				                                        </tr>
							                            <tr>
							                                <th>Varient name </th>
							                                <th>Varient value</th>
							                            </tr>
							                        </thead>
							                        <tbody>
							                        	<?php	
							                        	$i = 1;
						                        		foreach ($product_varients as $prd_vrnt_key => $prd_vrnt_values) 
						                        		{
						                        			$rowspan = count($prd_vrnt_values)+1;
						                        			echo "<tr>
						                        					<td rowspan=".$rowspan.">".$prd_vrnt_key."</td></tr>";

						                        			foreach ($prd_vrnt_values as $vrnt_value) 
						                        				echo "<tr><td>".
							                            				"<input type='hidden' value='".$vrnt_value['vrnt_id']."' name='vrnt_ids[]'>
						                                            	<input type='text' class='vrnt_values' placeholder='Enter attibute value...' name='vrnt_values[]' value='".$vrnt_value['att_value']."' />"
								                            		."</td></tr>";
						                                }
							                        	?>
							                        </tbody>
							                    </table>
							                </div><!-- /.box-body -->
							            </div>
		                			<?php } ?>

									<div class="form-group" id="att_fields" style="display: none;"></div>
									
									<div class="box-body table-responsive">
		                                <table id="example1" class="table table-bordered table-striped">
		                                    <thead>
		                                        <tr>
		                                            <th colspan="2">
		                                                Product Key Features
		                                                <button type="button" class="btn btn-warning pull-right" id="createKeyFeatureFieldBtn"><i class="fa fa-plus"></i> Add product Key Feature</button>
		                                            </th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                    	<tr>
		                                    		<td>
		                                    			<div class="row form-group">
							                                <div class="col-sm-8" id="key_feature_input_field_div"></div>
							                            </div>
		                                    		</td>
		                                    	</tr>
		                                        <?php
		                                        if ($key_features) 
		                                        {
		                                            foreach ($key_features['result'] as $feature_value) 
		                                            	echo '<tr><td><input type="text" class="form-control" name="key_feature_values[]" value="'.$feature_value['feature'].'" /></td></tr>';
		                                        }
		                                        else
		                                            echo "<tr><td colspan='3' align='center'>No Record found.</td></tr>";
		                                        ?>
		                                    </tbody>
		                                </table>
		                            </div><!-- /.box-body -->

		                            <div class="box-body table-responsive">
					                    <table id="example1" class="table table-bordered table-striped">
					                        <thead>
					                        	<tr>
					                        		<th colspan="4">
					                        			<center>HTML FILES FOR CATEGORY</center>
					                        		</th>
					                        	</tr>
					                            <tr>
					                                <th></th>
					                                <th>Prefix Path</th>
					                                <th>File Path</th>
					                                <th>Action</th>
					                            </tr>
					                        </thead>
					                        <tbody>
					                        	<?php
					                        	for ( $i = 1, $j = 0; $i <= 5; $i++, $j++ )
					                        	{
					                        		$link_id = isset( $html_files['result'][$j]['html_file_id'] ) ? $html_files['result'][$j]['html_file_id'] : '';
													$link = isset( $html_files['result'][$j]['html_file'] ) ? $html_files['result'][$j]['html_file'] : '';

													if ($link) 
													{
														$buttons = "<a href='".base_url("deleteLink/$link_id/$product_id/PRODUCT")."' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
				                                                <a href='".$this->config->item('site_url').HTML_FILES_PATH.$link."' class='btn btn-success' target='_blank'>Preview</a>";
													}
													else
														$buttons = '';
													
					                                echo "<tr>
				                        					<td>HTML LINK".$i."</td>
				                        					<td><span class='label label-default'>".$this->config->item('site_url').HTML_FILES_PATH."/</span></td>
				                                            <td>
				                                            	<input type='hidden' name='html_id".$i."' value='".$link_id."' />
				                                            	<input type='text' name='html_link".$i."' value='".$link."' class='form-control' />
				                                            </td>
				                                            <td>".$buttons."</td>
				                        				</tr>";
					                        	}
					                        	?>
					                        </tbody>
					                    </table>
					                </div><!-- /.box-body -->

									<div class="box-footer" align="right">
										<a href='<?= base_url("products") ?>' class='btn btn-default'>Cancel</a>
										<button type="submit" class="btn btn-primary" id="submit_btn">Create Duplicate</button>
							        </div>
							    </div>
						    <?= form_close() ?>
						<?php } ?>

<!----------------########### END PRODUCT DUPLICATE FORM ###################---------------->
					</div><!-- /.box -->
				</div>   <!-- /.row -->
			</div>

<!----------------########### START REQUESTED PRODUCT FORM ###################---------------->

			<?php if (isset($_GET['req_prd_id'])) { ?>
	            <div class="col-md-5">
					<!-- general form elements -->
					<div class="box box-primary">
					    <div class="box-header">
					        <h3 class="box-title">Requested Product Detail</h3>
					    </div>

					    <div style="padding: 15px;">
						    <div class="row">
			            		<div class="col-sm-3">
			            			<label>Product Name:</label>	
			            		</div>
			            		<div class="col-sm-9">
			            			<?= $req_prds['product_name'] ?>
			            		</div>
			            	</div>

			            	<div class="row">
			            		<div class="col-sm-3">
			            			<label>Brand Name:</label>	
			            		</div>
			            		<div class="col-sm-9">
			            			<?= $req_prds['brand_name'] ?>
			            		</div>
			            	</div>

			            	<div class="row">
			            		<div class="col-sm-3">
			            			<label>Product Description:</label>	
			            		</div>
			            		<div class="col-sm-9">
			            			<?= $req_prds['description'] ?>
			            		</div>
			            	</div>

			            	<div class="row">
			            		<div class="col-sm-3">
			            			<label>Amazon Link:</label>	
			            		</div>
			            		<div class="col-sm-9">
			            			<a href="<?= $req_prds['amazon_link'] ?>" target="_blank"><?= $req_prds['amazon_link'] ?></a>
			            		</div>
			            	</div>

			            	<div class="row">
			            		<div class="col-sm-3">
			            			<label>Flipkart Link:</label>	
			            		</div>
			            		<div class="col-sm-9">
			            			<a href="<?= $req_prds['flipkart_link'] ?>" target="_blank"><?= $req_prds['flipkart_link'] ?></a>
			            		</div>
			            	</div>

			            	<div class="row">
			            		<div class="col-sm-3">
			            			<label>Paytm Link:</label>	
			            		</div>
			            		<div class="col-sm-9">
			            			<a href="<?= $req_prds['paytm_link'] ?>" target="_blank"><?= $req_prds['paytm_link'] ?></a>
			            		</div>
			            	</div>

			            	<div class="row">
			            		<div class="col-sm-3">
			            			<label>Other Link1:</label>	
			            		</div>
			            		<div class="col-sm-9">
			            			<a href="<?= $req_prds['other_link1'] ?>" target="_blank"><?= $req_prds['other_link1'] ?></a>
			            		</div>
			            	</div>

			            	<div class="row">
			            		<div class="col-sm-3">
			            			<label>Other Link2:</label>	
			            		</div>
			            		<div class="col-sm-9">
			            			<a href="<?= $req_prds['other_link2'] ?>" target="_blank"><?= $req_prds['other_link2'] ?></a>
			            		</div>
			            	</div>

			            	<div class="row">
			            		<div class="col-sm-3">
			            			<label>Request Date:</label>	
			            		</div>
			            		<div class="col-sm-9">
			            			<?= convert_to_user_date($req_prds['create_date']) ?>
			            		</div>
			            	</div>
			            </div>
					</div>
				</div>
			<?php } ?>

<!----------------########### END REQUESTED PRODUCT FORM ###################---------------->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
function getCategoryAttribtes(cat_id, prd_id=0, page_label)
{
	$('#open_att_modal').prop('disabled', true);
	$('#submit_btn').prop('disabled', false);
	$('#att_fields').empty();
	$('#divLoading').show();

	if (cat_id) 
	{
		$.ajax({
	        type: "GET",
	        url: '<?= base_url("categoryAttributes") ?>/'+cat_id+'/'+prd_id,
	        success: function(data){
	            if (data) 
	            {
	            	resp = JSON.parse(data);
	            	fields = '';
	            	
	            	if (resp.length > 0) 
	    			{
	    				fields += '<table class="table table-bordered table-striped dataTable"><tr><th colspan=2><center>Product attributes</center></th></tr>';

	    				for (var i = 0; i < resp.length; i++) 
		            	{
		            		if (resp[i].mp_id != null) 
		            		{
		            			$('#open_att_modal').prop('disabled', false);
	            			
		            			att_id = resp[i].att_id;
		            			att_name_label = resp[i].att_name;
		            			att_val = '';
		            			if (page_label != "add") 
		            			{
		            				att_val = resp[i].att_value;
		            				if (att_val == null)
		            					att_val = '';
		            			}

		            			fields += '<tr><td>'+att_name_label+'</td>';

		                		if (page_label == "view") 
		                			fields += '<td>'+att_val+'</td>';
		                		else
		                			fields += '<td>'+
			                    					'<input type="text" name="'+att_id+'" class="form-control att_values" placeholder="Enter '+att_name_label+'..." value="'+att_val+'" />'+
			                    				'</td><tr>';
		            		}
						}

						fields += '</table>'
	    			}

	            	$('#att_fields').append(fields);
	            	$('#att_fields').show();
	            }

	            $('#divLoading').hide();
	        },
	    });	
	}
	else
	{
		alert('Could not found category id!');
		$('#divLoading').hide();
	}
}	

$(document).ready(function() {
	prd_id = <?= (!empty($product_id) ? json_encode($product_id) : '""'); ?>;
	page_label = <?= (!empty($page_label) ? json_encode($page_label) : '""'); ?>;
	
	if (prd_id) 
	{
		if (page_label == "view") 
			cat_id = parseInt($("#par_cat_id").val());
		else
			cat_id = $("[name='parent_cat_id'] option:selected").val();

		if (cat_id && cat_id != 0) 
		{
			setTimeout(function(){ 
				getCategoryAttribtes(cat_id, prd_id, page_label);
			}, 2000);
		}
	}
});
</script>

<style type="text/css">
label{
	float: left;
	margin-right: 20px;
}

span.bigcheck-target {
	font-family: FontAwesome;
	color: #D35400;
}

input[type='checkbox'].bigcheck {
  position: relative;
  left: -999em;
}

input[type='checkbox'].bigcheck + span.bigcheck-target:after {
  content: "\f096";
}

input[type='checkbox'].bigcheck:checked + span.bigcheck-target:after {
  content: "\f046";
}

.thumbnail img {
    height:50px;
    float: left;
}

.thumbnail {
	border: none;
    float: left;
    margin-bottom: 0px;
}
</style>

<?php require_once('include/imageModel.php'); ?>

<script>
function open_key_feature_modal(feature_id, feature, product_id) 
{
    $('#feature_id').val(feature_id);
    $('#feature').val(feature);
    $('#product_id').val(product_id);
    $("#keyFeatureModal").modal();
}

$(document).ready(function() {
    $('.prd_ids').on('change', function(){
        $('#addVarientBtn').prop('disabled', true);

        $.each($(".prd_ids"), function(){            
            if (this.checked)
                $('#addVarientBtn').prop('disabled', false);
        });  
    })

    var count = 1;
    $('#createVarientFieldBtn').click(function () {
        $('#input_field_div').append('<div class="row" style="margin-top:10px;" id="con'+count+'">'+
                                        '<div class="col-sm-9">'+
                                            '<input type="text" class="form-control" name="vrnt_vals[]" placeholder="Varient value" required/>' + 
                                        '</div>'+
                                        '<div class="col-sm-3">'+
                                            '<button type="button" class="btn btn-danger" id="btnRemove'+count+'" onclick="removeBtn('+count+')">Remove</button>'+
                                        '</div>'+
                                    '</div>'
                                    );
        
        count++;
    });

    $("select#att_id").change(function(){
        var att_id = $("#att_id option:selected").val();
        
        if ( att_id > 0 )
        {
            $('#createVarientFieldBtn').prop('disabled', false);
            $('#varientSubmitBtn').prop('disabled', false);
        }
        else
        {
            $('#createVarientFieldBtn').prop('disabled', true);
            $('#varientSubmitBtn').prop('disabled', true); 
			$('#input_field_div').remove();
        }
    });

    var count1 = 1;
    var count2 = 1;
    $('#createKeyFeatureFieldBtn').click(function () {
        $('#key_feature_input_field_div').append('<div class="row" style="margin-top:10px;" id="con1'+count1+'">'+
                                        '<div class="col-sm-9">'+
                                            '<input type="text" class="form-control" name="key_feature_values[]" placeholder="Feature'+count1+'" required/>' + 
                                        '</div>'+
                                        '<div class="col-sm-3">'+
                                            '<button type="button" class="btn btn-danger" id="btnRemove1'+count1+'" onclick="removeBtn(1'+count1+')">Remove</button>'+
                                        '</div>'+
                                    '</div>'
                                    );
        
        count1++;
    });
});

function removeBtn(id) 
{
	$('#con'+id).remove();
}
</script>
