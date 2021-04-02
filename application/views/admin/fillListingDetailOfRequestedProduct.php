<?php
$merchant_id = $_SESSION['merchant_id'];
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-9 col-md-offset-2">
			<!-- general form elements -->
			<div class="box box-primary">
			    	<div class="box-header">
                              <h3 class="box-title"><b>Seller Information</b></h3>
				</div><!-- /.box-header -->

				<!-- form start -->
				<?= form_open_multipart('insertListingInfo'); ?>
				   	<input type="hidden" name="req_prd_id" value="<?= $req_prd_id; ?>" />
                              <input type="hidden" name="merchant_id" value="<?= $merchant_id; ?>" />

				    	<div class="box-body">
				    		<div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Price*:</label>	
                        		</div>
                        		<div class="col-sm-9">
                        			<input type="text" class="form-control" placeholder="Enter price..." name="list_price" required/>
                        		</div>
                        	</div>

				    	<div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Finance Available*:</label>	
                        		</div>
                        		<div class="col-sm-9">
                        			<select class="form-control" name="finance_available" required>
                        				<option value="0">No</option>
                        				<option value="1">Yes</option>
                        			</select>		
                        		</div>
	                        </div>

                            <div class="row form-group">
                                <div class="col-sm-3">
                                    <label>Finance Terms:</label>    
                                </div>
                                <div class="col-sm-9">
                                    <textarea class="form-control" rows="5" name="finance_terms" placeholder="Please enter finance terms..."></textarea>
                                </div>
                            </div>

	                        <div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Home Delievery*:</label>	
                        		</div>
                        		<div class="col-sm-9">
                        			<select class="form-control" name="home_delievery" required>
                        				<option value="0">No</option>
                        				<option value="1">Yes</option>
                        			</select>		
                        		</div>
	                        </div>

	                        <div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Home Delievery Terms:</label>	
                        		</div>
                        		<div class="col-sm-9">
                        			<textarea class="form-control" rows="5" name="delievery_terms" placeholder="Please enter delievery terms..."></textarea>
                        		</div>
                        	</div>

                        	<div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Installation Available*:</label>	
                        		</div>
                        		<div class="col-sm-9">
                        			<select class="form-control" name="installation_available" required>
                        				<option value="0">No</option>
                        				<option value="1">Yes</option>
                        			</select>		
                        		</div>
	                        </div>

	                        <div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Installation Terms:</label>	
                        		</div>
                        		<div class="col-sm-9">
                        			<textarea class="form-control" rows="5" name="installation_terms" placeholder="Please enter installation terms..."></textarea>
                        		</div>
                        	</div>

                        	<div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>In Stock*:</label>	
                        		</div>
                        		<div class="col-sm-9">
                        			<select class="form-control" name="in_stock" required>
                        				<option value="0">No</option>
                        				<option value="1">Yes</option>
                        			</select>		
                        		</div>
	                        </div>

	                        <div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Available in stock on:</label>	
                        		</div>
                        		<div class="col-sm-9">
                        			<input type="date" class="form-control" name="back_in_stock">
                        		</div>
                        	</div>

                        	<div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Replacement Available*:</label>	
                        		</div>
                        		<div class="col-sm-9">
                        			<select class="form-control" name="replacement_available" required>
                        				<option value="0">No</option>
                        				<option value="1">Yes</option>
                        			</select>		
                        		</div>
	                        </div>

	                        <div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Replacement Terms:</label>	
                        		</div>
                        		<div class="col-sm-9">
                        			<textarea class="form-control" rows="5" name="replacement_terms" placeholder="Please enter replacement terms..."></textarea>
                        		</div>
                        	</div>

                        	<div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Return Available*:</label>	
                        		</div>
                        		<div class="col-sm-9">
                        			<select class="form-control" name="return_available" required>
                        				<option value="0">No</option>
                        				<option value="1">Yes</option>
                        			</select>		
                        		</div>
	                        </div>

	                        <div class="row form-group">
                        		<div class="col-sm-3">
                        			<label>Return Terms:</label>	
                        		</div>
                        		<div class="col-sm-9">
                        			<textarea class="form-control" rows="5" name="return_policy" placeholder="Please enter return terms..."></textarea>
                        		</div>
                        	</div>

							<div class="box-footer" align="right">
								<a href='<?= base_url("getAllProducts/$merchant_id") ?>' class='btn btn-default'>Cancel</a>
					            <button type="submit" class="btn btn-primary">Submit</button>
					        </div>
					    </div>
				    <?= form_close(); ?>
				    </div>
				</div><!-- /.box -->
			</div>   <!-- /.row -->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->
