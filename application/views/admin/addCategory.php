<?php 
$required = "";
$star = "";

if (isset($page_label) && $page_label == "edit") 
	$page_title = 'Edit category';
else if (isset($page_label) && $page_label == "view") 
	$page_title = 'View category';
else
{
	$page_label = "add";
	$page_title = 'Add category';
	$required = "required";
	$star = "*";
}

$cat_id = isset($category['category_id']) ? $category['category_id'] : '';
$cat_name = isset($category['category_name']) ? $category['category_name'] : set_value('cat_name');
$parent_category_id = isset($category['parent_category_id']) ? $category['parent_category_id'] : '';
$meta_keyword = isset($category['meta_keyword']) ? $category['meta_keyword'] : '';
$meta_description = isset($category['meta_description']) ? $category['meta_description'] : '';
$create_date = isset($category['create_date']) ? convert_to_user_date($category['create_date']) : '';
$update_date = isset($category['update_date']) ? convert_to_user_date($category['update_date']) : '';

//categoty input type
$cat_name_data = array(
    'name' => 'cat_name',
    'class' => 'form-control',
    'placeholder' => 'Enter category name',
    'value' => $cat_name
);
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>Category<small><?= $page_label ?></small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url('category') ?>">Category Management</a></li>
            <li class="active"><?= $page_title ?></li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-7 col-md-offset-3">
				<!-- general form elements -->
				<div class="box box-primary">
				    <div class="box-header">
				        <?php if ($page_label == "view") { ?>
					        <div class="box-footer" align="right">
					            <a href='<?= base_url("category") ?>' class='btn btn-default'>Back</a>
					            <a href='<?= base_url("editCategory/$cat_id/edit") ?>' class='btn btn-primary'>Edit</a>
					            <a href='<?= base_url("deleteCategory/$cat_id") ?>' class='btn btn-danger'>Delete</a>
					        </div>
					    <?php } ?>
				    </div><!-- /.box-header -->

				    <!-- form start -->
				    <?php if ($page_label == "view") { ?>
				    	<div class="box-body">
				    		<div class="row form-group">
				    			<div class="col-sm-3">
				    				<label>Category:</label>	
				    			</div>
				    			<div class="col-sm-9">
				    				<?= $cat_name ?>
				    			</div>
				            </div>
				        
	    	 				<!-- select category -->
	                        <div class="row form-group">
	                        	<div class="col-sm-3">
	                            	<label>Parent Category:</label>
	                            </div>
	                            <div class="col-sm-9">
		                   		 	<?php
		                   		 	$par_cat_name = '-';
						    		if ($status) 
						    		{
						    			foreach ($categories as $cat_value) 
					    				{
					    					if ($cat_value['category_id'] == $parent_category_id) 
					    					{
					    						$par_cat_name = $cat_value['category_name'];
					    						break;
					    					}
					    				}
						    		}

						    		echo $par_cat_name;
						    		?>
						    	</div>
						    </div>

						    <div class="row form-group">
						    	<div class="col-sm-3">
	                            	<label>Category Images:</label>
	                            </div>
	                            <div class="col-sm-9">
		                    		<?php 
			                        if (!empty($images)) 
			                        {
			                        	foreach ($images as $img_value) 
			                        	{
			                        		$img_src = $category_images_dir.'/'.$img_value['atch_url'];
			                        		
			                        		echo '<div class="thumbnail" style="padding:10px;">
			                        				<figure>
														<img src="'.$img_src.'" class="img-rounded">
												    </figure>
												</div>';
			                        	}
			                        }
			                        else
			                        	echo "Not available";
			                        ?>
			                    </div>
	                        </div>
	                        
                        	<div class="row form-group">
						    	<div class="col-sm-3">
									<label>HTML File(s):</label>
								</div>
								<div class="col-sm-9">
									<span class="bigcheck">
										<?php
										for ( $i = 1, $j = 0; $i <= 5; $i++, $j++ )
			                        	{
			                        		$link = isset( $html_files['result'][$j]['html_file'] ) ? $html_files['result'][$j]['html_file'] : '';
											
											if ($link) 
												echo $this->config->item('site_url').HTML_FILES_PATH.$link."<br />";
			                        	}
	                                	?>	                                    
	                                </span>
								</div>
							</div>

							<div class="row form-group">
						    	<div class="col-sm-3">
									<label>Attributes:</label>
								</div>
								<div class="col-sm-9">
									<span class="bigcheck">
										<?php
										if ($attributes) 
			    						{
			    							$count = 1;
			    							$att_name = '';

			    							foreach ($attributes as $att_value)
			    							{
			    								$mp_id = isset($att_value['mp_id']) ? $att_value['mp_id'] : '';

			    								if ($mp_id != '') 
												{
													echo $att_name = $att_value['att_name'];

													if (sizeof($attributes)>$count)
														echo ", ";
												}												
												
												$count++;
			    							}
			    						}

			    						if (empty($att_name)) 
			    							echo "Not available";
	                                	?>	                                    
	                                </span>
								</div>
							</div>

							<div class="row form-group">
				    			<div class="col-sm-3">
				    				<label>Meta keywords:</label>	
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
						</div><!-- /.box-body -->	
				    <?php } else {
				    	echo form_open_multipart('addCategory'); 
				    ?>
				        	<div class="box-body">
					    		<div class="row form-group">
					    			<div class="col-sm-3">
					    				<label>Category Name*:</label>	
					    			</div>
					    			<div class="col-sm-5">
					    				<input type="hidden" name="cat_id" value="<?= $cat_id ?>">
					    				<?= form_input($cat_name_data) ?>
					    			</div>
					    			<div class="col-sm-4">
					    				<?= form_error('cat_name') ?>
					    			</div>
					            </div>
					        
		    	 				<!-- select category -->
		                        <div class="row form-group">
		                        	<div class="col-sm-3">
		                            	<label>Parent Category:</label>
		                            </div>
		                            <div class="col-sm-5">
			                   		 	<?php
							    		echo '<select class="form-control" name="parent_cat_id">';
							    		if ($status) 
							    		{
							    			echo "<option value='0'>Select an parent category!!</option>";

							    			foreach ($categories as $cat_value) 
							    			{
							    				$selected = $cat_value['category_id'] == $parent_category_id ? 'selected' : '';

							    				echo "<option value='".$cat_value['category_id']."' ".$selected.">".$cat_value['category_name']."</option>";
							    			}
							    		}
							    		else
							    			echo "<option value='0'>No parent category available!</option>";
							    		
							    		echo "</select>
							    			</div>";
							    		?>
							    	</div>
							   	</div>

						    	<div class="box-body table-responsive">
				                    <table id="example1" class="table table-bordered table-striped">
				                        <thead>
				                            <tr>
				                                <th colspan="4"><center>Category Images</center></th>
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
						                        		if (isset($images[$j]))
						                        		{
						                        			$img_src = $category_images_dir.'/'.$images[$j]['atch_url'];
							                        		
							                        		echo '<div class="thumbnail">
							                        				<figure>
																		<img src="'.$img_src.'">
																		<center>
																    		<figcaption><a href="'.base_url().'deleteAttactchment/'.$images[$j]['atch_url'].'/editCategory/'.$cat_id.'" class="btn btn-danger">DELETE</a></figcaption>
																    	</center>
																    </figure>
																</div>

																<input type="hidden" name="remove_img'.$i.'" value="'.$images[$j]['atch_url'].'" />';
							                        	}
							                        echo "</td>";
							                    } ?> 
				                        		<td>
				                        			<div class="file<?= $i ?>"></div>
				                        		</td>
				                        	</tr>
				                        <?php } ?>
				                        </tbody>
				                    </table>
				                </div>

							    <div class="box-body table-responsive">
				                    <table id="example1" class="table table-bordered table-striped">
				                        <thead>
				                        	<tr>
				                        		<th colspan="4">
				                        			<center>HTML FILE(S)</center>
				                        		</th>
				                        	</tr>
				                            <tr>
				                                <th></th>
				                                <th>Prefix path</th>
				                                <th>File path</th>
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
													$buttons = "<a href='".base_url("deleteLink/$link_id/$cat_id/CATEGORY")."' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
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
										<label>Attributes:</label>
									</div>
									<div class="col-sm-10">
										<span class="bigcheck">
											<?php
		                                	if ($attributes) 
				    						{
				    							foreach ($attributes as $att_value)
				    							{
				    								$mp_id = isset($att_value['mp_id']) ? $att_value['mp_id'] : '';

				    								$checked = ($mp_id != '') ? 'checked' : '';

				    								echo '<div class="col-sm-4"><label class="bigcheck">
													    	<input type="checkbox" class="bigcheck" name="selected_att_ids[]" value="'.$att_value['att_id'].'"'.$checked.' />&nbsp;&nbsp;&nbsp;
													    	<span class="bigcheck-target"></span>
													    	'.$att_value['att_name'].'
													  	</label></div>';
				    							}
				    						}
		                                	?>	                                    
		                                </span>
									</div>
								</div>

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

								<div class="box-footer" align="right">
						            <a href='<?= base_url("category") ?>' class='btn btn-default'>Cancel</a>
						            <button type="submit" class="btn btn-primary">Submit</button>
						        </div>
					        </div><!-- /.box-body -->
					    <?php 
					    	echo form_close(); 
					    }
					    ?>
				</div><!-- /.box -->
			</div>   <!-- /.row -->
		</section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php require_once('include/imageModel.php'); ?>

<style>
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
