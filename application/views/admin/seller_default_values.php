<?php 
//default values
$finance_available = isset($result[0]['finance_available']) ? $result[0]['finance_available'] : '';
$finance_terms = isset($result[0]['finance_terms']) ? $result[0]['finance_terms'] : '';
$home_delivery_available = isset($result[0]['home_delivery_available']) ? $result[0]['home_delivery_available'] : '';
$home_delivery_terms = isset($result[0]['home_delivery_terms']) ? $result[0]['home_delivery_terms'] : '';
$installation_available = isset($result[0]['installation_available']) ? $result[0]['installation_available'] : '';
$installation_terms = isset($result[0]['installation_terms']) ? $result[0]['installation_terms'] : '';
$replacement_available = isset($result[0]['replacement_available']) ? $result[0]['replacement_available'] : '';
$replacement_terms = isset($result[0]['replacement_terms']) ? $result[0]['replacement_terms'] : '';
$return_available = isset($result[0]['return_available']) ? $result[0]['return_available'] : '';
$return_policy = isset($result[0]['return_policy']) ? $result[0]['return_policy'] : '';
$seller_offering = isset($result[0]['seller_offering']) ? $result[0]['seller_offering'] : '';
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>
            Seller
            <small>Default values</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Default values</li>
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
				    <?= form_open('insertSellerDefaultValues') ?>
				    	<div class="box-body">
				    		<div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Finance Available:</label>	
                        		</div>
                        		<div class="col-sm-5">
                        			<select class="form-control" name="finance_available">
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
                        			<label>Home Delievery:</label>	
                        		</div>
                        		<div class="col-sm-5">
                        			<select class="form-control" name="home_delievery">
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
                        			<label>Installation Available:</label>	
                        		</div>
                        		<div class="col-sm-5">
                        			<select class="form-control" name="installation_available">
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
                        			<label>Replacement Available:</label>	
                        		</div>
                        		<div class="col-sm-5">
                        			<select class="form-control" name="replacement_available">
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
                        			<label>Return Available:</label>	
                        		</div>
                        		<div class="col-sm-5">
                        			<select class="form-control" name="return_available">
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

                            <div class="box-footer" align="right">
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