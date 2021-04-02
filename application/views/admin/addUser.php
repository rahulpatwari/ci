<?php 
//user data
$usr_id = isset($user['userId']) ? $user['userId'] : '';
$email = isset($user['email']) ? $user['email'] : '';
$fname = isset($user['first_name']) ? $user['first_name'] : '';
$mname = isset($user['middle_name']) ? $user['middle_name'] : '';
$lname = isset($user['last_name']) ? $user['last_name'] : '';
$roles = isset($user['roles']) ? $user['roles'] : false;
$create_date = isset($user['create_date']) ? convert_to_user_date($user['create_date']) : false;
$update_date = isset($user['update_date']) ? convert_to_user_date($user['update_date']) : false;
$adminChecked = "";
$buyerChecked = "";
$sellerChecked = "";
$testUserChecked = "";
$executiveUserChecked = "";

//user profile picture
if ( isset($user['profile_image']) )
    $profile_pic = $user['profile_image'];
else
    $profile_pic = $this->config->item('site_url').'assets/admin/img/avatar3.png';

//merchant data
$merchant_id = isset($merchant['merchant_id']) ? $merchant['merchant_id'] : '';
$comp_name = isset($merchant['establishment_name']) ? $merchant['establishment_name'] : '';
$cno = isset($merchant['contact']) ? $merchant['contact'] : '';
$business_days = isset($merchant['business_days']) ? $merchant['business_days'] : '';
$business_hours = isset($merchant['business_hours']) ? $merchant['business_hours'] : '';
$finance_available = (isset($merchant['finance_available']) && $merchant['finance_available']) ? 'Yes' : 'No';
$finance_terms = isset($merchant['finance_terms']) ? $merchant['finance_terms'] : '';
$home_delivery_available = (isset($merchant['home_delivery_available']) && $merchant['home_delivery_available']) ? 'Yes' : 'No';
$home_delivery_terms = isset($merchant['home_delivery_terms']) ? $merchant['home_delivery_terms'] : '';
$installation_available = (isset($merchant['installation_available']) && $merchant['installation_available']) ? 'Yes' : 'No';
$installation_terms = isset($merchant['installation_terms']) ? $merchant['installation_terms'] : '';
$replacement_available = (isset($merchant['replacement_available']) && $merchant['replacement_available']) ? 'Yes' : 'No';
$replacement_terms = isset($merchant['replacement_terms']) ? $merchant['replacement_terms'] : '';
$return_available = (isset($merchant['return_available']) && $merchant['return_available']) ? 'Yes' : 'No';
$return_policy = isset($merchant['return_policy']) ? $merchant['return_policy'] : '';
$last_name = isset($merchant['last_name']) ? $merchant['last_name'] : '';
$address_array = isset($merchant['address']) ? $merchant['address'] : array();
$seller_images_dir = isset($merchant['seller_images_dir']) ? $merchant['seller_images_dir'] : '';
$seller_images = isset($merchant['images']) ? $merchant['images'] : '';
$page_label = isset($merchant['page_label']) ? $merchant['page_label'] : 'Add Seller and company detail';

//seller/merchant logo
if ( isset($merchant['merchant_logo']) )
    $merchant_logo = $merchant['merchant_logo'];
else
    $merchant_logo = $this->config->item('site_url').'assets/admin/img/avatar3.png';

//get user roles
$showAddressManagementButton = false;
$count = 0;
$user_roles = '';
if ($roles) 
{
	foreach ($roles as $role) 
	{
		if ($role['type_name'] == "ADMIN")
			$adminChecked = 'checked="checked"';

		if ($role['type_name'] == "BUYER")
			$buyerChecked = 'checked="checked"';

		if ($role['type_name'] == "SELLER")
		{
			$sellerChecked = 'checked="checked"';
			$showAddressManagementButton = true;
		}

		if ($role['type_name'] == "TEST USER")
			$testUserChecked = 'checked="checked"';

		if ($role['type_name'] == "EXECUTIVE")
			$executiveUserChecked = 'checked="checked"';
	
		if ($count > 0 && sizeof($roles) > $count)
			$user_roles .= ',&nbsp;&nbsp;';

		$user_roles .= $role['type_name'];

		$count++;
	}
}
else
	$user_roles = "Not defined";

if (isset($_GET['edit'])) 
{
	$page_label = 'edit';
	$page_title = 'Edit user';
}
else if (isset($_GET['view'])) 
{
	$page_label = 'view';
	$page_title = 'View user';
}
else
{
	$page_label = "add";
	$page_title = 'Add user';
}
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>
            User
            <small><?= $page_label ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url('page/userManagement') ?>">User Management</a></li>
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
					<?php if (isset($_GET['view'])) { ?>
						<div class="box-header">
					        <h3 class="box-title">User Detail</h3>
					        <div class="box-footer" align="right">
					        	<?php if ($_COOKIE['site_code'] == 'admin')
					            	echo "<a href='".base_url("page/userManagement")."' class='btn btn-default'>Back</a>";
					            
					            echo "<a href='".base_url("editUser/$usr_id?edit")."' class='btn btn-primary' style='margin-left:5px;'>Edit</a>";

			            		if ($usr_id != $_COOKIE['user_id'])
					            	echo "<a href='".base_url("deleteUser/$usr_id")."' class='btn btn-danger' style='margin-left:5px;'>Delete</a>";
					            ?>
					        </div>
						</div>

						<div class="box-body">
							<?php if ($profile_pic)
								echo '<img src="'.$profile_pic.'" width="100px" />';
							?>

				        	<div class="row form-group">
				            	<div class="col-sm-3">
				                	<label>First name: </label>
				                </div>
				                <div class="col-sm-9">
					                <?= $fname ?>
					            </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				                	<label>Middle name: </label>
				                </div>
				                <div class="col-sm-9">
					                <?= $mname ?>
					            </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				                	<label>Last name: </label>
				                </div>
				                <div class="col-sm-9">
					                <?= $lname ?>
					            </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				                	<label>Email: </label>
				                </div>
				                <div class="col-sm-9">
					        		<?= $email ?>
					            </div>
				            </div>

				            <?php if ($_COOKIE['site_code'] == "admin") { ?>
					            <div class="row form-group">
					            	<div class="col-sm-3">
					            		<label>Role:</label>
					            	</div>
					            	<div class="col-sm-9">
					            		<?= $user_roles ?>
					            	</div>
					            </div>
					        <?php } ?>

					        <div class="row form-group">
				            	<div class="col-sm-3">
				                	<label>Create Date: </label>
				                </div>
				                <div class="col-sm-9">
					        		<?= $create_date ?>
					            </div>
				            </div>

				            <div class="row form-group">
				            	<div class="col-sm-3">
				                	<label>Update Date: </label>
				                </div>
				                <div class="col-sm-9">
					        		<?= $update_date ?>
					            </div>
				            </div>
				        </div><!-- /.box-body -->

				        <?php if ($_COOKIE['site_code'] == 'seller') { ?>
					        <div class="box-header">
						        <h3 class="box-title">Seller Detail</h3>
							</div>

							<div class="box-body">
					            <div class="row form-group">
					            	<div class="col-sm-3">
					            		<label>Company name:</label>	
					            	</div>
					                <div class="col-sm-9">
					                	<?= $comp_name ?>
					                </div>
					            </div>

						        <?php 
		                        if (!empty($seller_images)) 
		                        {
		                        	foreach ($seller_images as $img_key => $img_value) 
		                        		echo '<div class="thumbnail">
		                        				<figure>
													<img src="'.$seller_images_dir.'/'.$img_value['atch_url'].'" class="img-rounded" width="150" height="100">
											    </figure>
											</div>';
		                        }
		                        ?>

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
					            		<label>Finance available:</label>	
					            	</div>
					                <div class="col-sm-9">
					                	<?= $finance_available ?>
					                </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-3">
					            		<label>Finance terms:</label>	
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

					            <div class="row form-group">
					            	<div class="col-sm-3">
					            		<label>Seller offerings:</label>	
					            	</div>
					                <div class="col-sm-9">
					                	<?php
					                	if ($merchant['seller_offering']) 
					                	{
					                		echo "<ul>";
					                			foreach ($merchant['seller_offering'] as $offering) 
					                				echo "<li>".$offering['offering']."</li>";
					                		echo "</ul>";
					                	}
					                	?>
					                </div>
					            </div>

					            <?php 
					            if (count($address_array) > 0 && $showAddressManagementButton) 
					            {
					            	$sno = 1;
					            	foreach ($address_array as $address_value) 
					            	{
					            		if ($address_value['address_line_1'])
					            			$line1 = $address_value['address_line_1'];
					            		else
					            			$line1 = '';

					            		if ($address_value['address_line_2'])
					            			$line2 = ', '.$address_value['address_line_2'];
					            		else
					            			$line2 = '';

					            		if ($address_value['landmark'])
					            			$landmark = ', '.$address_value['landmark'];
					            		else
					            			$landmark = '';

					            		if ($address_value['city_name'])
					            			$city_name = ', '.$address_value['city_name'];
					            		else
					            			$city_name = '';

					            		if ($address_value['pin'])
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
								                	$line1.$line2.$landmark.$city_name.$pin.$state_name.$country_name."<br />Contact no: ".$address_value['contact']
								                .'</div>
								            </div>';

					            		$sno++;
					            	}
					            } ?>
					        </div>
					<?php } 
					} else { ?>
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
					    <?= form_open_multipart('addUser'); ?>
					    	<input type="hidden" name="usr_id" value="<?= $usr_id; ?>">
					        <div class="box-body">
					        	<div class="row form-group">
					            	<div class="col-sm-2">
					                	<label>First name*: </label>
					                </div>
					                <div class="col-sm-7">
						                <input type="text" name="fname" class="form-control" placeholder="Enter First Name" value="<?= $fname ?>" required>
						            </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					                	<label>Middle name: </label>
					                </div>
					                <div class="col-sm-7">
						                <input type="text" name="mname" class="form-control" placeholder="Enter Middle Name" value="<?= $mname ?>">
						            </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					                	<label>Last name*: </label>
					                </div>
					                <div class="col-sm-7">
						                <input type="text" name="lname" class="form-control" placeholder="Enter Last Name" value="<?= $lname ?>" required>
						            </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					                	<label>Email*: </label>
					                </div>
					                <div class="col-sm-7">
						        		<?php if ($usr_id) { ?>
						                	<input type="text" class="form-control" value="<?= $email ?>" disabled>
						                <?php } else { ?>
						                	<input type="email" name="email" class="form-control" placeholder="Enter email address" required>
						                <?php } ?>
						            </div>
					            </div>

					            <div class="row form-group">
					            	<div class="col-sm-2">
					            		<label>Profile picture:</label>
					            	</div>
					            	<div class="col-sm-7">
					            		<div class="col-sm-4">	
					            			<input type="file" name="file7" id="file7" />
					            		</div>
					            		<div class="col-sm-4 file7"></div>
					            		<div class="col-sm-4">
						            		<?php if ($profile_pic)
												echo '<img src="'.$profile_pic.'" width="100px">';
											?>
						        		</div>		        			
					            	</div>
					            </div>

					            <?php if ($_COOKIE['site_code'] == 'seller') {  ?>
						            <div class="row form-group">
						            	<div class="col-sm-2">
						            		<?php
						            		if ($merchant_id) 
						            			echo "<label>Change Shop Logo:</label>";
						            		else
						            			echo "<label>Shop Logo:</label>";
						            		?>	
						            	</div>
						            	<div class="col-sm-9">
						            		<div class="col-sm-4">	
						            			<input type="file" name="file8" id="file8" />
						            		</div>
						            		<div class="col-sm-4 file8"></div>
						            		<div class="col-sm-4">
							            		<?php if ($merchant_logo)
													echo '<img src="'.$merchant_logo.'" width="100px">';
												?>
							        		</div>		        			
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
					            			if (isset($merchant['business_proof']))
    											echo '<a href="'.$merchant['business_proof'].'" class="btn btn-default" target="_blank">Preview</a>';
					            			?>
						        		</div>		        			
					            	</div>
					            </div>
						        <?php } ?>

					            <?php if ($_COOKIE['site_code'] == "admin") { ?>
						            <div class="row form-group">
						            	<div class="col-sm-2">
						            		<label>User role:</label>
						            	</div>
						            	<div class="col-sm-7">
						            		<p><input type="checkbox" name="user_type[]" value="ADMIN" <?= $adminChecked ?> >&nbsp;&nbsp;&nbsp;Admin</p>
						            		<p><input type="checkbox" name="user_type[]" value="SELLER" <?= $sellerChecked ?> >&nbsp;&nbsp;&nbsp;Seller</p>
						            		<p><input type="checkbox" name="user_type[]" value="BUYER" <?= $buyerChecked ?> >&nbsp;&nbsp;&nbsp;Buyer</p>
						            		<p><input type="checkbox" name="user_type[]" value="TEST USER" <?= $testUserChecked ?> >&nbsp;&nbsp;&nbsp;Test user</p>
						            		<p><input type="checkbox" name="user_type[]" value="EXECUTIVE" <?= $executiveUserChecked ?> >&nbsp;&nbsp;&nbsp;Executive</p>
						            	</div>
						            </div>
						        <?php } ?>
					        </div><!-- /.box-body -->
					        
					        <?php if ( $_COOKIE['site_code'] == 'seller' ) { ?>
					        	<input type="hidden" name="merchant_id" value="<?= $merchant_id; ?>">
						        <input type="hidden" name="usr_id" value="<?= $usr_id ?>">

					        	<div class="box-body">
						            <div class="row form-group">
						            	<div class="col-sm-2">
						            		<label>Company name*:</label>	
						            	</div>
						                <div class="col-sm-7">
						                	<input type="text" name="comp_name" class="form-control" placeholder="Enter Company Name" value="<?= $comp_name ?>" required />
						                </div>
						            </div>

						            <div class="box-body table-responsive">
					                    <table id="example1" class="table table-bordered table-striped">
					                        <thead>
					                            <tr>
					                                <th colspan="3"><center>Company images</center></th>
					                            </tr>
					                        </thead>
					                        <tbody>
						                        <?php for ($i=1; $i < 7; $i++) { ?>
						                        	<tr>
						                        		<td>Image<?= $i ?></td>
						                        		<td><input type="file" name="file<?= $i ?>" id="file<?= $i ?>"></td>
						                        		<td><div class="file<?= $i ?>"></div></td>
						                        	</tr>
						                        <?php } ?>
					                    	</tbody>
					                    </table>
					                </div>

							        <?php 
			                        if (!empty($seller_images)) 
			                        {
			                        	foreach ($seller_images as $img_key => $img_value) 
			                        	{
			                        		$img_src = $seller_images_dir.'/'.$img_value['atch_url'];
			                        		$img_id = $img_value['atch_id'];

			                        		echo '<div class="thumbnail">
			                        				<figure>
														<img src="'.$img_src.'" class="img-rounded" width="150" height="100">
												    	<center>
												    		<figcaption><a href="'.base_url().'deleteAttactchment/'.$img_value['atch_url'].'-'.$_SESSION['merchant_id'].'/editUser/'.$usr_id.'" class="btn btn-danger">DELETE</a></figcaption>
												    	</center>
												    </figure>
												</div>';
			                        	}	
			                        }
			                        ?>

			                        <div class="row form-group" style="clear: both;">
						            	<div class="col-sm-2">
						            		<label>Contact number*:</label>	
						            	</div>
						                <div class="col-sm-7">
						                	<input type="text" name="contact_no" class="form-control" placeholder="Enter Company contact number" value="<?= $cno ?>" required />
						                </div>
						            </div>

						            <div class="row form-group">
						            	<div class="col-sm-2">
						            		<label>Business days*:</label>	
						            	</div>
						                <div class="col-sm-7">
						                	<input type="text" name="business_days" class="form-control" placeholder="Enter Company Business Days" value="<?= $business_days ?>" required />
						                </div>
						            </div>

						            <div class="row form-group">
						            	<div class="col-sm-2">
						            		<label>Business hours*:</label>	
						            	</div>
						                <div class="col-sm-7">
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
		                                        if ($merchant['seller_offering']) 
		                                        {
		                                            foreach ($merchant['seller_offering'] as $seller_offering_value) 
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
						        </div>
					        <?php } ?>

					        <div class="box-footer"  align="right">
					        	<?php if ($_COOKIE['site_code'] == "admin") { ?>
					        		<a href='<?= base_url("page/userManagement") ?>' class='btn btn-default'>Cancel</a>
					        	<?php } else { ?>
					        		<a href='<?= base_url("editUser/$usr_id?view") ?>' class='btn btn-default'>Cancel</a>
					        	<?php } ?>
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
</script>

<style type="text/css">
.thumbnail img {
    width:115;
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
