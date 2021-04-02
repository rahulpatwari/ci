<?php 
$merchant_id = isset($data['merchant_id']) ? $data['merchant_id'] : '';
$usr_id = isset($data['userId']) ? $data['userId'] : '';
$first_name = isset($data['first_name']) ? $data['first_name'] : '';
$middle_name = isset($data['middle_name']) ? $data['middle_name'] : '';
$last_name = isset($data['last_name']) ? $data['last_name'] : '';
$comp_name = isset($data['establishment_name']) ? $data['establishment_name'] : '';
$description = isset($data['description']) ? $data['description'] : '';
$cno = isset($data['contact']) ? $data['contact'] : '';
$business_days = isset($data['business_days']) ? $data['business_days'] : '';
$business_hours = isset($data['business_hours']) ? $data['business_hours'] : '';
$finance_available = (isset($data['finance_available']) && $data['finance_available']) ? 'Yes' : 'No';
$finance_terms = isset($data['finance_terms']) ? $data['finance_terms'] : '';
$home_delivery_available = (isset($data['home_delivery_available']) && $data['home_delivery_available']) ? 'Yes' : 'No';
$home_delivery_terms = isset($data['home_delivery_terms']) ? $data['home_delivery_terms'] : '';
$installation_available = (isset($data['installation_available']) && $data['installation_available']) ? 'Yes' : 'No';
$installation_terms = isset($data['installation_terms']) ? $data['installation_terms'] : '';
$replacement_available = (isset($data['replacement_available']) && $data['replacement_available']) ? 'Yes' : 'No';
$replacement_terms = isset($data['replacement_terms']) ? $data['replacement_terms'] : '';
$return_available = (isset($data['return_available']) && $data['return_available']) ? 'Yes' : 'No';
$return_policy = isset($data['return_policy']) ? $data['return_policy'] : '';
$last_name = isset($data['last_name']) ? $data['last_name'] : '';
$address_array = isset($data['address']) ? $data['address'] : array();
$seller_images_dir = isset($data['seller_images_dir']) ? $data['seller_images_dir'] : '';
$seller_images = isset($data['images']) ? $data['images'] : '';
$meta_keyword = isset($data['meta_keyword']) ? $data['meta_keyword'] : '';
$meta_description = isset($data['meta_description']) ? $data['meta_description'] : '';
$create_date = isset($data['create_date']) ? convert_to_user_date($data['create_date']) : '';
$update_date = isset($data['update_date']) ? convert_to_user_date($data['update_date']) : '';

//seller/merchant logo
if (isset($data['merchant_logo']))
    $merchant_logo = $data['merchant_logo'];
else
    $merchant_logo = $this->config->item('site_url').'assets/admin/img/avatar3.png';

if (isset($page_label) && $page_label == "edit") 
	$page_title = 'Edit seller';
else if (isset($page_label) && $page_label == "view") 
	$page_title = 'View seller';
else
{
	$page_label = "add";
	$page_title = 'Add seller';
}

if ($_COOKIE['site_code'] == 'admin') 
{
	$required = "";
	$star = "";
}
else
{
	$required = "required";
	$star = "*";
}
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>
            Seller
            <small><?= $page_label ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url('sellers/sellersTable') ?>">Seller Management</a></li>
            <li class="active"><?= $page_title ?></li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8 col-md-offset-2">
				<!-- general form elements -->
				<div class="box box-primary">
				    <div class="box-header">
				        <div class='box-footer' align='right'>
					        <?php if ($page_label == "view") {
					    	    echo "<a href='../../sellers/sellersTable' class='btn btn-default'>Back</a>
					            	<a href='../../seller/$merchant_id/edit' class='btn btn-primary'>Edit</a>";
						    } elseif ( $page_label == "edit" )
						    	echo "<a href='../../page/addressManagement?user_id=$usr_id&merchant_id=$merchant_id' class='btn btn-primary'>Manage Address</a>";
						    ?>
						</div>
				    </div><!-- /.box-header -->

				    <?php if ($page_label == "view") { ?>
			    		<div class="box-body">
			    			<div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Seller logo:</label>	
				            	</div>
				                <div class="col-sm-9">
				            		<?php 
						            if (isset($merchant_logo)) 
							            echo '<div class="row form-group">
									            	<div class="col-sm-3">
									      				<img src="'.$merchant_logo.'" width="80">
									            	</div>
									            </div>';
								    ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>First name:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $first_name ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Middle name:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $middle_name ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Last name:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $last_name ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Company name:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $comp_name ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Shop images:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?php 
			                        if (!empty($seller_images)) 
			                        {
			                        	foreach ($seller_images as $img_value) 
			                        		echo '<div class="thumbnail">
			                        				<figure>
														<img src="'.$seller_images_dir.'/'.$img_value['atch_url'].'" class="img-rounded" />
												    </figure>
												</div>';
			                        }
			                        ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Description:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $description ?>
				                </div>
				            </div>

	                        <div class="row form-group" style="clear: both;">
				            	<div class="col-sm-3">
				            		<label>Contact number:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $cno ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Business days:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $business_days ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Business hours:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $business_hours ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>finance available:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $finance_available ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>finance terms:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $finance_terms ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Home delivery available:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $home_delivery_available ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Home delivery terms:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $home_delivery_terms ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Installation available:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $installation_available ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Installation terms:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $installation_terms ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Replacement available:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $replacement_available ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Replacement terms:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $replacement_terms ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Return available:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $return_available ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Return policy:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $return_policy ?>
				                </div>
				            </div>

				            <?php if (count($data['address']) > 0) 
				            {
				            	$sno = 1;
				            	foreach ($data['address'] as $address_value) 
				            	{
				            		if ( $address_value['address_line_1'] )
				            			$line1 = $address_value['address_line_1'];
				            		else
				            			$line1 = '';

				            		if ( $address_value['address_line_2'] )
				            			$line2 = ', '.$address_value['address_line_2'];
				            		else
				            			$line2 = '';

				            		if ( $address_value['landmark'] )
				            			$landmark = ', '.$address_value['landmark'];
				            		else
				            			$landmark = '';

				            		if ( $address_value['city_name'] )
				            			$city_name = ', '.$address_value['city_name'];
				            		else
				            			$city_name = '';

				            		if ( $address_value['pin'] )
				            			$pin = ', '.$address_value['pin'];
				            		else
				            			$pin = '';

				            		if ($address_value['state_name'])
				            			$state_name = ', '.$address_value['state_name'];
				            		else
				            			$state_name = '';

				            		if ($address_value['country_name'])
				            			$country_name = ', '.$address_value['country_name'];
				            		else
				            			$country_name = '';

				            		echo '<div class="row form-group">
							            	<div class="col-sm-3">
							            		<label>Address '.$sno.':</label>	
							            	</div>
							                <div class="col-sm-9">'.
							                	$line1.$line2.$landmark.$city_name.$pin.$state_name.$country_name."<br />Shop no: ".$address_value['contact']
							                .'</div>
							            </div>';

				            		$sno++;
				            	}
				            } ?>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Meta Keyword:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $meta_keyword ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Meta Description:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $meta_description ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Create date:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $create_date ?>
				                </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				            		<label>Update date:</label>	
				            	</div>
				                <div class="col-sm-9">
				                	<?= $update_date ?>
				                </div>
				            </div>
				        </div>
				    <?php } else { ?>
				    	<!-- seller offering Modal -->
                        <div class="modal fade" id="sellerOfferingModal">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Edit Seller Offering</h4>
                                    </div>

                                    <?= form_open('addSellerOffering') ?>
                                        <div class="modal-body">
                                            <input type='hidden' name='offering_id' id='offering_id'>
                                            <input type='hidden' name='merchant_id' id='merchant_id'>

                                            <div class='row form-group'>
                                                <div class='col-sm-3'>
                                                    <label>Seller Offering:</label>    
                                                </div>
                                                <div class='col-sm-9'>
                                                    <input type='text' name='offering' id='offering' class='form-control' required>
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
					    <?= form_open_multipart('addSeller'); ?>
					    	<input type="hidden" name="merchant_id" value="<?= $merchant_id; ?>">
					        <input type="hidden" name="usr_id" value="<?= $usr_id; ?>">
					        <input type="hidden" name="is_default_address" value="1" />

				        	<div class="box-body">
				        		<div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Shop Logo:</label>
					            	</div>
					            	<div class="col-sm-9">
					            		<div class="col-sm-4">	
					            			<input type="file" name="file8" id="file8" />
					            		</div>
					            		<div class="col-sm-4">
						            		<?php if ($merchant_logo)
												echo '<img src="'.$merchant_logo.'" width="100px">';
											?>
						        		</div>		        			
						        		<div class="col-sm-4 file8"></div>
					            	</div>
					            </div>

				        		<div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Business proof:</label>
					            	</div>
					            	<div class="col-sm-9">
					            		<div class="col-sm-4">	
					            			<input type="file" name="file9" accept=".gif, .jpg, .png, .pdf, .jpeg, .pdf" />
					            		</div>
					            		<div class="col-sm-4">
					            			<?php
					            			if (isset($data['business_proof']))
    											echo '<a href="'.$data['business_proof'].'" class="btn btn-default" target="_blank">Preview</a>';
					            			?>
						        		</div>		        			
					            	</div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>First name<?= $star ?>:</label>	
					            	</div>
					                <div class="col-sm-5">
					                	<input type="text" name="fname" class="form-control" placeholder="Enter first Name" value="<?= $first_name ?>" <?= $required ?> />
					                </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Middle name:</label>	
					            	</div>
					                <div class="col-sm-5">
					                	<input type="text" name="mname" class="form-control" placeholder="Enter Middle Name" value="<?= $middle_name ?>" />
					                </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Last name<?= $star ?>:</label>	
					            	</div>
					                <div class="col-sm-5">
					                	<input type="text" name="lname" class="form-control" placeholder="Enter Last Name" value="<?= $last_name ?>" <?= $required ?> />
					                </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Company name*:</label>	
					            	</div>
					                <div class="col-sm-5">
					                	<input type="text" name="comp_name" class="form-control" placeholder="Enter Company Name" value="<?= $comp_name ?>" required />
					                </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Description:</label>	
					            	</div>
					                <div class="col-sm-5">
					                	<textarea name="description" class="form-control address" placeholder="Enter description"><?= $description ?></textarea>
					                </div>
					            </div>

					            <div class="row form-group" style="clear: both;">
					            	<div class="col-sm-2">
					            		<label>Contact number*:</label>	
					            	</div>
					                <div class="col-sm-5">
					                	<input type="text" name="contact_no" class="form-control" placeholder="Enter Company contact number" value="<?= $cno ?>" required />
					                </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Business days*:</label>	
					            	</div>
					                <div class="col-sm-5">
					                	<input type="text" name="business_days" class="form-control" placeholder="Enter Company Business Days" value="<?= $business_days ?>" required />
					                </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Business hours*:</label>	
					            	</div>
					                <div class="col-sm-5">
					                	<input type="text" name="business_hours" class="form-control" placeholder="Enter Company Business Hours" value="<?= $business_hours ?>" required />
					                </div>
					            </div>

					            <div class="row form-group">
	                        		<div class="col-sm-2">
	                        			<label>Finance Available:</label>	
	                        		</div>
	                        		<div class="col-sm-5">
	                        			<select class="form-control" name="finance_available">
	                        				<?php 
	                        				if ($finance_available == "No")
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
	                                <div class="col-sm-2">
	                                    <label>Finance Terms:</label>    
	                                </div>
	                                <div class="col-sm-8">
	                                    <textarea class="form-control" rows="5" name="finance_terms" placeholder="Please enter finance terms..."><?= $finance_terms ?></textarea>
	                                </div>
	                            </div>

		                        <div class="row form-group">
	                        		<div class="col-sm-2">
	                        			<label>Home Delievery:</label>	
	                        		</div>
	                        		<div class="col-sm-5">
	                        			<select class="form-control" name="home_delievery">
	                        				<?php 
	                        				if ($home_delivery_available == "No")
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
	                        		<div class="col-sm-2">
	                        			<label>Home Delievery Terms:</label>	
	                        		</div>
	                        		<div class="col-sm-8">
	                        			<textarea class="form-control" rows="5" name="delievery_terms" placeholder="Please enter delievery terms..."><?= $home_delivery_terms ?></textarea>
	                        		</div>
	                        	</div>

	                        	<div class="row form-group">
	                        		<div class="col-sm-2">
	                        			<label>Installation Available:</label>	
	                        		</div>
	                        		<div class="col-sm-5">
	                        			<select class="form-control" name="installation_available">
	                        				<?php 
	                        				if ($installation_available == "No")
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
	                        		<div class="col-sm-2">
	                        			<label>Installation Terms:</label>	
	                        		</div>
	                        		<div class="col-sm-8">
	                        			<textarea class="form-control" rows="5" name="installation_terms" placeholder="Please enter installation terms..."><?= $installation_terms ?></textarea>
	                        		</div>
	                        	</div>

	                        	<div class="row form-group">
	                        		<div class="col-sm-2">
	                        			<label>Replacement Available:</label>	
	                        		</div>
	                        		<div class="col-sm-5">
	                        			<select class="form-control" name="replacement_available">
	                        				<?php 
	                        				if ($replacement_available == "No")
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
	                        		<div class="col-sm-2">
	                        			<label>Replacement Terms:</label>	
	                        		</div>
	                        		<div class="col-sm-8">
	                        			<textarea class="form-control" rows="5" name="replacement_terms" placeholder="Please enter replacement terms..."><?= $replacement_terms ?></textarea>
	                        		</div>
	                        	</div>

	                        	<div class="row form-group">
	                        		<div class="col-sm-2">
	                        			<label>Return Available:</label>	
	                        		</div>
	                        		<div class="col-sm-5">
	                        			<select class="form-control" name="return_available">
	                        				<?php 
	                        				if ($return_available == "No")
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
	                        		<div class="col-sm-2">
	                        			<label>Return Terms:</label>	
	                        		</div>
	                        		<div class="col-sm-8">
	                        			<textarea class="form-control" rows="5" name="return_policy" placeholder="Please enter return terms..."><?= $return_policy ?></textarea>
	                        		</div>
	                        	</div>

					            <div class="box-body table-responsive">
				                    <table id="example1" class="table table-bordered table-striped">
				                        <thead>
				                            <tr>
				                                <th colspan="3"><center>Company Images</center></th>
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
					                        		if ($page_label == 'edit') 
					                        		{
						                        		echo "<td>";
							                        		if (isset($seller_images[$j]))
							                        		{
							                        			$img_src = $seller_images_dir.'/'.$seller_images[$j]['atch_url'];
								                        		
								                        		echo '<div class="thumbnail">
								                        				<figure>
																			<img src="'.$img_src.'">
																			<center>
																	    		<figcaption><a href="'.base_url().'deleteAttactchment/'.$seller_images[$j]['atch_url'].'/seller/'.$merchant_id.'" class="btn btn-danger">DELETE</a></figcaption>
																	    	</center>
																	    </figure>
																	</div>

																	<input type="hidden" name="remove_img'.$i.'" value="'.$seller_images[$j]['atch_url'].'" />';
								                        	}
								                        echo "</td>";
							                        } ?>
					                        		<td><div class="file<?= $i ?>"></div></td>
					                        	</tr>
					                        <?php } ?>
				                    	</tbody>
				                    </table>
				                </div>

				                <div class="box-body table-responsive">
	                                <table id="example1" class="table table-bordered table-striped">
	                                    <thead>
	                                        <tr>
	                                            <th colspan="2">
	                                                Seller offerings
	                                                <button type="button" class="btn btn-warning pull-right" id="createSellerOfferingBtn"><i class="fa fa-plus"></i> Add seller offering</button>
	                                            </th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                    	<tr>
	                                    		<td>
	                                    			<div class="row form-group">
						                                <div class="col-sm-8" id="seller_offering_input_field_div"></div>
						                            </div>
	                                    		</td>
	                                    	</tr>
	                                        <?php
	                                        if (isset($data['seller_offering']) && $data['seller_offering'])
	                                        {
	                                            foreach ($data['seller_offering']['result'] as $seller_offering_value) 
	                                            {
	                                                $offering_id = $seller_offering_value['offering_id'];
	                                                $offering = $seller_offering_value['offering'];
	                                                $params = $offering_id.', "'.$offering.'", '.$merchant_id;

	                                                echo "<tr>
	                                                        <td>".$offering."</td>
	                                                        <td>
	                                                            <button type='button' class='btn btn-warning' onclick='open_seller_offering_modal($params)'>Edit</button>
	                                                            <a href='".base_url()."deleteSellerOffering/".$offering_id."/".$merchant_id."' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
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

	                            <div class="row form-group">
	                        		<div class="col-sm-2">
	                        			<label>Meta Keyword:</label>	
	                        		</div>
	                        		<div class="col-sm-8">
	                        			<textarea class="form-control" rows="5" name="meta_keyword" placeholder="Please enter meta Keyword"><?= $meta_keyword ?></textarea>
	                        		</div>
	                        	</div>

	                        	<div class="row form-group">
	                        		<div class="col-sm-2">
	                        			<label>Meta Description:</label>	
	                        		</div>
	                        		<div class="col-sm-8">
	                        			<textarea class="form-control" rows="5" name="meta_description" placeholder="Please enter meta description"><?= $meta_description ?></textarea>
	                        		</div>
	                        	</div>

					            <?php if ($page_label != "edit") { ?>
					            	<div class="row form-group">
						            	<div class="col-sm-2">
						            		<label>Line1 address*:</label>	
						            	</div>
						                <div class="col-sm-8">
						                	<textarea name="line1" class="form-control address" placeholder="Enter Line1 Address" required></textarea>
						                </div>
						            </div>

						            <div class="row form-group">
						            	<div class="col-sm-2">
						            		<label>Line2 address:</label>	
						            	</div>
						                <div class="col-sm-8">
						                	<textarea name="line2" class="form-control address" placeholder="Enter Line2 Address"></textarea>
						                </div>
						            </div>

						            <div class="row form-group">
						            	<div class="col-sm-2">
						            		<label>Landmark:</label>	
						            	</div>
						                <div class="col-sm-8">
						                	<textarea name="landmark" class="form-control address" placeholder="Enter Landmark"></textarea>
						                </div>
						            </div>

						            <div class="row form-group">
						            	<div class="col-sm-2">
						            		<label>Country*:</label>	
						            	</div>
						                <div class="col-sm-5">
						                	<select class="form-control" name="country_id" id="cnt_id" onchange="getState(this.value);" required>
							                	<?php
									    		if ($countries) 
									    		{
									    			echo "<option value=''>Please select country!!</option>";

									    			foreach ($countries as $cnt_key => $cnt_value) 
									    				echo "<option value='".$cnt_value['country_id']."'>".$cnt_value['name']."</option>";
									    		}
									    		else
									    			echo "<option>country not available!</option>";
									    		?>
								    		</select>
						                </div>
						            </div>

						            <div class="row form-group">
						            	<div class="col-sm-2">
						            		<label>State*:</label>	
						            	</div>
						                <div class="col-sm-5">
						                	<select class="form-control" name="state_id" onchange="getCity(this.value);" id="states" required></select>
						                </div>
						                <div class="col-sm-2">
						                	<button type="button" onclick="getState();" class="btn btn-default">Refresh states</button>
						                </div>
						            </div>

						            <div class="row form-group">
						            	<div class="col-sm-2">
						            		<label>City*:</label>	
						            	</div>
						                <div class="col-sm-5">
						                	<select class="form-control" name="city_id" id="state_cities" required></select>
						                </div>
						                <div class="col-sm-2">
						                	<button type="button" onclick="getCity();" class="btn btn-default">Refresh cities</button>
						                </div>
						            </div>

						            <div class="row form-group">
						            	<div class="col-sm-2">
						            		<label>PIN:</label>	
						            	</div>
						                <div class="col-sm-5">
						                	<input type="text" name="pin" class="form-control" placeholder="PIN Code" />
						                </div>
						            </div>

						            <div class="row form-group">
						            	<div class="col-sm-2">
						            		<label>Shop no:</label>	
						            	</div>
						                <div class="col-sm-5">
						                	<input type="text" name="contact" class="form-control" placeholder="Shop contact number" />
						                </div>
						            </div>

					            	<div class="row form-group">
						            	<div class="col-sm-4">
						            		<input type="text" name="lat" class="form-control" placeholder="Enter Latitude" onkeyup="initialize();" id="lat" required />
						            	</div>
						                <div class="col-sm-4">
						                	<input type="text" name="long" id="long" class="form-control" placeholder="Enter Longitude" onkeyup="initialize();" required />
						                </div>
						                <div class="col-sm-4">
		                                    <button type="button" onclick="getLatLongFromAddress();" class="btn btn-info">Get lat-long from address</button>
		                                </div>
						            </div>

						            <!-- google map -->
									<center>
										<div id="googleMap" style="width:90%;height:400px; margin: 20px;"></div>
									</center>
						        <?php } ?>
					        </div>

					        <div class="box-footer"  align="right">
					        	<a href='<?= base_url("sellers/sellersTable") ?>' class='btn btn-default'>Cancel</a>
					            <button type="submit" class="btn btn-primary">Submit</button>
					        </div>
					    <?= form_close(); ?>
				    <?php } ?>
				</div><!-- /.box -->
			</div>   <!-- /.row -->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php require_once('include/imageModel.php'); ?>

<script>
$(document).ready(function() {
    cnt_id = $('#cnt_id').val();
	if (parseInt(cnt_id)) 
		getState(cnt_id);

	var count1 = 1;
    var count2 = 1;
    $('#createSellerOfferingBtn').click(function () {
        $('#seller_offering_input_field_div').append('<div class="row" style="margin-top:10px;" id="con1'+count1+'">'+
                                        '<div class="col-sm-9">'+
                                            '<input type="text" class="form-control" name="seller_offering_values[]" placeholder="Offering'+count1+'" required/>' + 
                                        '</div>'+
                                        '<div class="col-sm-3">'+
                                            '<button type="button" class="btn btn-danger" id="btnRemove1'+count1+'" onclick="removeBtn(1'+count1+')">Remove</button>'+
                                        '</div>'+
                                    '</div>'
                                    );
        
        count1++;
    });
});

function open_seller_offering_modal(offering_id, Offering, merchant_id) 
{
    $('#offering_id').val(offering_id);
    $('#offering').val(Offering);
    $('#merchant_id').val(merchant_id);
    $("#sellerOfferingModal").modal();
}

function removeBtn(id) 
{
	$('#con'+id).remove();
}

function getLatLongFromAddress() 
{
    geocoder = new google.maps.Geocoder();
    line1 = ($('[name="line1"]').val()) ? $('[name="line1"]').val()+', ' : '';
    line2 = ($('[name="line2"]').val()) ? $('[name="line2"]').val()+', ' : '';
    landmark = ($('[name="landmark"]').val()) ? $('[name="landmark"]').val()+', ' : '';
    country = ($("#cnt_id option:selected").html()) ? $("#cnt_id option:selected").html()+', ' : '';
    state = ($("#states option:selected").html()) ? $("#states option:selected").html()+', ' : '';
    city = ($("#state_cities option:selected").html()) ? $("#state_cities option:selected").html() : '';
    pin = ($('[name="pin"]').val()) ? '-'+$('[name="pin"]').val() : '';
    address = line1+line2+landmark+country+state+city+pin;
    
    //debugger;
    geocoder.geocode({'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            //get lat-long
            latitude = results[0].geometry.location.lat().toFixed(6);
            longitude = results[0].geometry.location.lng().toFixed(6);

            //set lat-long in text fields
            $('[name="lat"]').val(latitude);
            $('[name="long"]').val(longitude);

            //call map for map initialization
            initialize();
        } 
    }); 
}

//initialize google map
function initialize() 
{
    var lat = ($('[name="lat"]').val()) ? $('[name="lat"]').val() : 22.7196;
    var long = ($('[name="long"]').val()) ? $('[name="long"]').val() : 75.8577;

    //set location on google map using lat long
    var myLatlng = new google.maps.LatLng(lat, long);
    var mapOptions = {
                        zoom: 15,
                        center: myLatlng,
                        draggable: true
                    }
    var map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);
    setMarkerOnClickMap(myLatlng, map);

    google.maps.event.addListener(map, 'click', function (e) {
        lat1 = (e.latLng.lat()).toFixed(6);
        long1 = (e.latLng.lng()).toFixed(6);

        $('[name="lat"]').val(lat1);
        $('[name="long"]').val(long1);

        setMarkerOnClickMap(e.latLng, map);
    });
}

var gmarkers = [];

//set marker on click map
function setMarkerOnClickMap(latLng, map) 
{
    //remove old markers from map
    for(i=0; i<gmarkers.length; i++)
        gmarkers[i].setMap(null);

    //set marker on google map
    var marker = new google.maps.Marker({
                    position: latLng
                });

    // To add the marker to the map, call setMap();
    marker.setMap(map);

    //push old marker in array
    gmarkers.push(marker);

    //show info window for address
    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });

    //show address div on click marker
    showFormattedAddress((latLng.lat()), (latLng.lng()));
}

//show address div on click marker
function showFormattedAddress(lat, long) 
{
    infowindow = new google.maps.InfoWindow();
    latlng = new google.maps.LatLng(lat, long);
    geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'latLng': latlng }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) 
            infowindow.setContent(results[0].formatted_address);
    });
}

//get state of country
function getState(selected_cnt_id='')
{
	cnt_id = (selected_cnt_id) ? selected_cnt_id : ($("#cnt_id").val());

	if (cnt_id) 
	{
		$('#states').empty();
		$('#state_cities').empty();
		
		$.ajax({
	        type: "GET",
	        url: '<?= base_url("states") ?>/'+cnt_id,
	        success: function(data){
	            if ( data ) 
	            {
	            	state_data = JSON.parse(data);
	            	state_options = "<option value=''>Please select state!!</option>";
	            	usr_state_id = <?= (!empty($state_id) ? json_encode($state_id) : '""'); ?>

	            	for (var i = 0; i < state_data.length; i++) 
	            	{
	            		state_name = state_data[i].name;
	            		state_id = state_data[i].state_id;
	            		selected = "";

	            		if (state_id == usr_state_id)
	            			selected = "selected";

	            		state_options += "<option value='"+state_id+"' "+selected+">"+state_name+"</option>";
	            	}

	            	$('#states').append(state_options);

					state_id = $('#states').val();
					if (parseInt(state_id)) 
						getCity(state_id);
	            }
	        },
	    });	
	}
	else
		alert('Error: Unable to get country id!');
}

//get city of state
function getCity(selected_state_id)
{
	state_id = (selected_state_id) ? selected_state_id : ($("#states").val());

	if (state_id) 
	{
		$('#state_cities').empty();

		$.ajax({
	        type: "GET",
	        url: '<?= base_url("cities") ?>/'+state_id,
	        success: function(data){
	            if (data != "null") 
	            {
	            	city_data = JSON.parse(data);
	            	city_options = "<option value=''>Please select city!!</option>";
	            	usr_city_id = <?= (!empty($city_id) ? json_encode($city_id) : '""'); ?>

	            	for (var i = 0; i < city_data.length; i++) 
	            	{
	            		city_name = city_data[i].name;
	            		city_id = city_data[i].city_id;
	            		selected = "";

	            		if (usr_city_id == city_id)
	            			selected = "selected";

	            		city_options += "<option value='"+city_id+"' "+selected+">"+city_name+"</option>";
	            	}

	            	$('#state_cities').append(city_options);
	            }
	            else
	            	alert("Error: City not found for this state!");
	        },
	    });	
	}
	else
		alert("Error: Unable to get state id!");
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVz1q3IpVEItGM-WmXgBkNWEfMuofO3FI&callback=initialize"></script>

<style type="text/css">
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
