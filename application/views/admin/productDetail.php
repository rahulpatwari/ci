<?php 
//product detail
$product_id = isset($product_id) ? $product_id : false;
$product_name = isset($product_name) ? $product_name : '';
$description = isset($description) ? $description : '';
$mrp_price = isset($mrp_price) ? $mrp_price : '';
$product_images_dir = isset($product_images_dir) ? $product_images_dir : '';
$images = isset($images) ? $images : '';
$category_name = isset($category_name) ? $category_name : '';
$brand_name = isset($brand_name) ? $brand_name : '';
$prd_varients = isset($product_varients) ? $product_varients : false;

//listing detail
$listing_id = isset($product_listing[0]['listing_id']) ? $product_listing[0]['listing_id'] : '';
$list_price = isset($product_listing[0]['list_price']) ? $product_listing[0]['list_price'] : '';
$sell_price = isset($product_listing[0]['sell_price']) ? $product_listing[0]['sell_price'] : '';

if ($listing_id) 
{
    $page_title = "Edit Listing";

    $finance_available = isset($product_listing[0]['finance_available']) ? $product_listing[0]['finance_available'] : '';
    $finance_terms = isset($product_listing[0]['finance_terms']) ? $product_listing[0]['finance_terms'] : '';
    $home_delivery_available = isset($product_listing[0]['home_delivery_available']) ? $product_listing[0]['home_delivery_available'] : '';
    $home_delivery_terms = isset($product_listing[0]['home_delivery_terms']) ? $product_listing[0]['home_delivery_terms'] : '';
    $installation_available = isset($product_listing[0]['installation_available']) ? $product_listing[0]['installation_available'] : '';
    $installation_terms = isset($product_listing[0]['installation_terms']) ? $product_listing[0]['installation_terms'] : '';
    $replacement_available = isset($product_listing[0]['replacement_available']) ? $product_listing[0]['replacement_available'] : '';
    $replacement_terms = isset($product_listing[0]['replacement_terms']) ? $product_listing[0]['replacement_terms'] : '';
    $return_available = isset($product_listing[0]['return_available']) ? $product_listing[0]['return_available'] : '';
    $return_policy = isset($product_listing[0]['return_policy']) ? $product_listing[0]['return_policy'] : '';
    $seller_offering = isset($product_listing[0]['seller_offering']) ? $product_listing[0]['seller_offering'] : '';
    $meta_keywords = isset($product_listing[0]['meta_keyword']) ? $product_listing[0]['meta_keyword'] : '';
    $meta_description = isset($product_listing[0]['meta_description']) ? $product_listing[0]['meta_description'] : '';
}
else
{
    $page_title = "Add Listing";

    $finance_available = isset($seller_default_values['finance_available']) ? $seller_default_values['finance_available'] : '';
    $finance_terms = isset($seller_default_values['finance_terms']) ? $seller_default_values['finance_terms'] : '';
    $home_delivery_available = isset($seller_default_values['home_delivery_available']) ? $seller_default_values['home_delivery_available'] : '';
    $home_delivery_terms = isset($seller_default_values['home_delivery_terms']) ? $seller_default_values['home_delivery_terms'] : '';
    $installation_available = isset($seller_default_values['installation_available']) ? $seller_default_values['installation_available'] : '';
    $installation_terms = isset($seller_default_values['installation_terms']) ? $seller_default_values['installation_terms'] : '';
    $replacement_available = isset($seller_default_values['replacement_available']) ? $seller_default_values['replacement_available'] : '';
    $replacement_terms = isset($seller_default_values['replacement_terms']) ? $seller_default_values['replacement_terms'] : '';
    $return_available = isset($seller_default_values['return_available']) ? $seller_default_values['return_available'] : '';
    $return_policy = isset($seller_default_values['return_policy']) ? $seller_default_values['return_policy'] : '';
    $seller_offering = isset($seller_default_values['seller_offering']) ? $seller_default_values['seller_offering'] : '';
    $meta_keywords = isset($seller_default_values['meta_keyword']) ? $seller_default_values['meta_keyword'] : '';
    $meta_description = isset($seller_default_values['meta_description']) ? $seller_default_values['meta_description'] : '';
}

$in_stock = isset($product_listing[0]['in_stock']) ? $product_listing[0]['in_stock'] : '';
$will_back_in_stock_on = isset($product_listing[0]['will_back_in_stock_on']) ? $product_listing[0]['will_back_in_stock_on'] : '';
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>Seller<small>Product Listing</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <?php if ($_COOKIE['site_code'] == 'admin') {  ?>
                <li><a href="<?= base_url('sellers/sellersList') ?>">Sellers</a></li>
            <?php } ?>
            <li><a href="<?= base_url('getAllProducts/'.$seller_id) ?>">Linked/Requested Products</a></li>
            <li class="active"><?= $page_title ?></li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-9 col-md-offset-2">
				<!-- general form elements -->
				<div class="box box-primary">
				    <div class="box-header">
				        <h3 class="box-title"><b>Product Information</b></h3>
				    </div><!-- /.box-header -->
				    
			    	<div class="box-body">
			    		<!-- select category -->
                        <div class="row form-group">
                    		<div class="col-sm-2">
                    			<label>Category:</label>	
                    		</div>
                    		<div class="col-sm-10">
                    			<?= $category_name ?>			
                    		</div>
                        </div>

                        <div class="form-group" id="att_fields" style="display: none;">
                        	<div class="box-body table-responsive">
			                    <table class="table table-bordered table-striped">
			                    	<tbody id="att_data"></tbody>
			                    </table>
			                </div>
                        </div>
                    	
                        <!-- select brand -->
                        <div class="row form-group">
                    		<div class="col-sm-2">
                    			<label>Brand:</label>	
                    		</div>
                    		<div class="col-sm-10">
                    			<?= $brand_name ?>
                    		</div>
                    	</div>

				    	<input type="hidden" name="prd_id" value="<?= $product_id ?>">

				    	<div class="row form-group">
                    		<div class="col-sm-2">
                    			<label>Product Name:</label>	
                    		</div>
                    		<div class="col-sm-10">
                    			<?= $product_name ?>
                    		</div>
                    	</div>

                        <div class="row form-group">
                    		<div class="col-sm-2">
                    			<label>Product Price:</label>	
                    		</div>
                    		<div class="col-sm-10">
                    			<?= $mrp_price ?>
                    		</div>
                    	</div>
					    
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label>Product images:</label>   
                            </div>
                            <div class="col-sm-10">
                                <?php 
                                if (!empty($images)) 
                                {
                                    foreach ($images as $img_value) 
                                    {
                                        $img_src = $product_images_dir.'/'.$img_value['atch_url'];
                                        
                                        echo '<div class="thumbnail">
                                                <img src="'.$img_src.'" class="img-rounded" />
                                            </div>';
                                    }   
                                }
                                else
                                    echo "Not available";
                                ?>
                            </div>
                        </div>

						<div class="row form-group" style="clear: both;">
                    		<div class="col-sm-2">
                    			<label>Product Description:</label>	
                    		</div>
                    		<div class="col-sm-10">
                    			<?= $description ?>
                    		</div>
                    	</div>
						
                        <?php if ($prd_varients) { ?>
                            <div style="margin-bottom: 20px;">
                                <div class="box-body table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="3"><center>PRODUCT VARIENTS</center></th>
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

						<div class="row form-group">
					    	<div class="col-sm-2">
								<label>Tags:</label>
							</div>
							<div class="col-sm-10">
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

										foreach ($tags as $tag_value)
		    							{
		    								$checked = array_value_exist($product_tags, $tag_value['tag_id']);

		    								if ($checked)
		    								{
		    									if ($count != 0) 
		    										echo ",";

		    									echo ' <label>'.$tag_value['tag_name'].'</label>';

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

						<div class="box-header">
					        <h3 class="box-title"><b>Seller Information</b></h3>
					    </div><!-- /.box-header -->
                            
					    <!-- form start -->
				    <?= form_open_multipart('insertListingInfo') ?>
				    	<input type="hidden" name="prd_id" value="<?= $product_id; ?>" />
				    	<input type="hidden" name="merchant_id" value="<?= $seller_id; ?>" />
				    	<input type="hidden" name="listing_id" value="<?= $listing_id; ?>" />

				    	<div class="box-body">
				    		<div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Price*:</label>	
                        		</div>
                        		<div class="col-sm-5">
                        			<input type="text" class="form-control" placeholder="Enter price..." name="list_price" value="<?= $list_price ?>" required/>
                        		</div>
                        	</div>

				    		<div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Finance Available*:</label>	
                        		</div>
                        		<div class="col-sm-5">
                        			<select class="form-control" name="finance_available" required>
                        				<?php 
                        				if ($finance_available == 0)
                        				{
                        					$value0 = "selected";
                        					$value1 = '';
                        				}
                        				else
                        				{
                        					$value0 = '';
                        					$value1 = "selected";
                        				}
                        				?>
                        				<option value="0" <?= $value0 ?> >No</option>
                        				<option value="1" <?= $value1 ?> >Yes</option>
                        			</select>		
                        		</div>
	                        </div>

                            <div class="row form-group">
                                <div class="col-sm-3">
                                    <label>Finance Terms:</label>    
                                </div>
                                <div class="col-sm-8">
                                    <textarea class="form-control" rows="5" name="finance_terms" placeholder="Please enter finance terms..."><?= $finance_terms ?></textarea>
                                </div>
                            </div>

	                        <div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Home Delievery*:</label>	
                        		</div>
                        		<div class="col-sm-5">
                        			<select class="form-control" name="home_delievery" required>
                        				<?php 
                        				if ($home_delivery_available == 0)
                        				{
                        					$value0 = "selected";
                        					$value1 = '';
                        				}
                        				else
                        				{
                        					$value0 = '';
                        					$value1 = "selected";
                        				}
                        				?>
                        				<option value="0" <?= $value0 ?> >No</option>
                        				<option value="1" <?= $value1 ?> >Yes</option>
                        			</select>		
                        		</div>
	                        </div>

	                        <div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Home Delievery Terms:</label>	
                        		</div>
                        		<div class="col-sm-8">
                        			<textarea class="form-control" rows="5" name="delievery_terms" placeholder="Please enter delievery terms..."><?= $home_delivery_terms ?></textarea>
                        		</div>
                        	</div>

                        	<div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Installation Available*:</label>	
                        		</div>
                        		<div class="col-sm-5">
                        			<select class="form-control" name="installation_available" required>
                        				<?php 
                        				if ($installation_available == 0)
                        				{
                        					$value0 = "selected";
                        					$value1 = '';
                        				}
                        				else
                        				{
                        					$value0 = '';
                        					$value1 = "selected";
                        				}
                        				?>
                        				<option value="0" <?= $value0 ?> >No</option>
                        				<option value="1" <?= $value1 ?> >Yes</option>
                        			</select>		
                        		</div>
	                        </div>

	                        <div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Installation Terms:</label>	
                        		</div>
                        		<div class="col-sm-8">
                        			<textarea class="form-control" rows="5" name="installation_terms" placeholder="Please enter installation terms..."><?= $installation_terms ?></textarea>
                        		</div>
                        	</div>

                        	<div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>In Stock*:</label>	
                        		</div>
                        		<div class="col-sm-5">
                        			<select class="form-control" name="in_stock">
                        				<?php 
                                        if ($page_title == "Edit Listing") 
                                        {
                                            if ($in_stock == 0)
                                            {
                                                $value0 = 'selected="selected"';
                                                $value1 = '';
                                            }
                                            else
                                            {
                                                $value0 = '';
                                                $value1 = 'selected="selected"';
                                            }
                                        }
                                        else
                                        {
                                            $value0 = '';
                                            $value1 = 'selected="selected"';
                                        }
                        				?>
                        				<option value="1" <?= $value1 ?> >Yes</option>
                                        <option value="0" <?= $value0 ?> >No</option>
                        			</select>		
                        		</div>
	                        </div>

	                        <div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Available in stock on:</label>	
                        		</div>
                        		<div class="col-sm-8">
                        			<input type="date" class="form-control" name="back_in_stock" value="<?= $will_back_in_stock_on ?>" />
                        		</div>
                        	</div>

                        	<div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Replacement Available*:</label>	
                        		</div>
                        		<div class="col-sm-5">
                        			<select class="form-control" name="replacement_available" required>
                        				<?php 
                        				if ($replacement_available == 0)
                        				{
                        					$value0 = "selected";
                        					$value1 = '';
                        				}
                        				else
                        				{
                        					$value0 = '';
                        					$value1 = "selected";
                        				}
                        				?>
                        				<option value="0" <?= $value0 ?> >No</option>
                        				<option value="1" <?= $value1 ?> >Yes</option>
                        			</select>		
                        		</div>
	                        </div>

	                        <div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Replacement Terms:</label>	
                        		</div>
                        		<div class="col-sm-8">
                        			<textarea class="form-control" rows="5" name="replacement_terms" placeholder="Please enter replacement terms..."><?= $replacement_terms ?></textarea>
                        		</div>
                        	</div>

                        	<div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Return Available*:</label>	
                        		</div>
                        		<div class="col-sm-5">
                        			<select class="form-control" name="return_available" required>
                        				<?php 
                        				if ($return_available == 0)
                        				{
                        					$value0 = "selected";
                        					$value1 = '';
                        				}
                        				else
                        				{
                        					$value0 = '';
                        					$value1 = "selected";
                        				}
                        				?>
                        				<option value="0" <?= $value0 ?> >No</option>
                        				<option value="1" <?= $value1 ?> >Yes</option>
                        			</select>		
                        		</div>
	                        </div>

	                        <div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Return Terms:</label>	
                        		</div>
                        		<div class="col-sm-8">
                        			<textarea class="form-control" rows="5" name="return_policy" placeholder="Please enter return terms..."><?= $return_policy ?></textarea>
                        		</div>
                        	</div>

                            <div class="row form-group">
                                <div class="col-sm-3">
                                    <label>Seller Offerings:</label>    
                                </div>
                                <div class="col-sm-8">
                                    <textarea class="form-control" rows="5" name="seller_offering" placeholder="Please enter offering..."><?= $seller_offering ?></textarea>
                                </div>
                            </div>

                            <?php if ($_COOKIE['site_code'] == 'admin') { ?>
                                <div class="row form-group">
                                    <div class="col-sm-3">
                                        <label>Meta Keywords:</label>    
                                    </div>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" rows="5" name="meta_keyword" placeholder="Please enter offering..."><?= $meta_keywords ?></textarea>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-3">
                                        <label>Meta Description:</label>    
                                    </div>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" rows="5" name="meta_description" placeholder="Please enter offering..."><?= $meta_description ?></textarea>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="box-footer" align="right">
								<a href='<?= base_url("getAllProducts/$seller_id") ?>' class='btn btn-default'>Cancel</a>
					            <button type="submit" class="btn btn-primary">Submit</button>
					        </div>
					    </div>
				    <?= form_close() ?>
				    </div>
				</div><!-- /.box -->
			</div>   <!-- /.row -->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php require_once('include/imageModel.php'); ?>

<script>
function getCategoryAttribtes(cat_id, prd_id)
{
	$('#divLoading1').show();

	var prd_varients = <?= (!empty($prd_varients) ? json_encode($prd_varients) : '""'); ?>;
	prd_att_val_res = '';
	
	if (cat_id) 
	{
		if (prd_id) 
		{
			$.ajax({
		        type: "GET",
		        url: '<?= base_url("productAttributesValue");?>/'+prd_id,
		        success: function(att_data){
		            if (att_data) 
		            	prd_att_val_res = JSON.parse(att_data);
		        },
		    });	
		}

		$.ajax({
	        type: "GET",
	        url: '<?= base_url("categoryAttributes");?>/'+cat_id+'/'+0,
	        success: function(data){
	            if (data) 
	            {
	            	resp = JSON.parse(data);
	            	
	            	fields = '<tr><td colspan="2"><center><b>Product attributes</b></center></td></tr>';
	            	
	            	//remove attribute from the list where we have attibute as varient
	    			for (var k = 0; k < prd_varients.length; k++) 
	    			{
	    				for (var l = 0; l < resp.length; l++) 
	            		{
	            			if (prd_varients[k].att_id == resp[l].att_id)
	            				resp.splice(l, 1);
	            		}
	    			}
	    			
	    			if (resp.length > 0) 
	    			{
	    				for (var i = 0; i < resp.length; i++) 
		            	{
		            		var cat_att_mp_id = resp[i].mp_id;
		            		var att_val = '';

		            		if (cat_att_mp_id != null) 
		            		{
                                for (var j = 0; j < prd_att_val_res.length; j++) 
		            			{
		            				if (prd_att_val_res[j].cat_att_mp_id == cat_att_mp_id)
		            				{
		            					att_val = prd_att_val_res[j].att_value;
		            					prd_att_val_res.splice(j, 1);
		            					break;
		            				}
		            			}

                                //only show attribute if they have a value for there attribute
                                if (att_val) 
		            			   fields += '<tr>'+
    	                    					'<td>'+resp[i].att_name+'</td>'+
    		                    				'<td>'+att_val+'</td>'+
    	                					'</tr>';
							} 
		            	}

                        $('#att_data').append(fields);
                        
	            		if (fields != '')
	            			$('#att_fields').show();
	    			}
				}
	        },
	    });	
	}
	else
		alert('Could not found category id!');

	$('#divLoading1').hide();
}	

$( document ).ready(function() {
    $('#divLoading').show();
    setTimeout(function(){ 
        $('#divLoading').hide();
    }, 3000);

	prd_id = <?= (!empty($product_id) ? json_encode($product_id) : '""'); ?>;
	cat_id = <?= (!empty($category_id) ? json_encode($category_id) : '""'); ?>;

	getCategoryAttribtes(cat_id, prd_id);
});

function removeBtn( id ) 
{
    $('#con'+id).remove();
}
</script>

<style>
.thumbnail img {
    //width:115;
    height:80px;
    float: left;
    margin: 10px;
}

.thumbnail {
	border: none;
    float: left;
    padding: 20px;
}
</style>
