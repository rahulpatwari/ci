<?php 
$clmd_id = isset($data['clmd_id']) ? $data['clmd_id'] : '';
$merchant_id = isset($data['merchant_id']) ? $data['merchant_id'] : '';
$clmd_email = isset($data['clmd_email']) ? $data['clmd_email'].rand() : '';
$clmd_name = isset($data['clmd_name']) ? $data['clmd_name'] : '';
$clmd_contact = isset($data['clmd_contact']) ? $data['clmd_contact'] : '';
$clmd_message = isset($data['clmd_message']) ? $data['clmd_message'] : '';
$clmd_business_proof = isset($data['clmd_business_proof']) ? $data['clmd_business_proof'] : '';
$establishment_name = isset($data['establishment_name']) ? $data['establishment_name'] : '';
$create_date = isset($data['create_date']) ? $data['create_date'] : '';
$update_date = isset($data['update_date']) ? $data['update_date'] : '';
$is_clmd_approved = isset($data['is_clmd_approved']) ? $data['is_clmd_approved'] : '';
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>
            Claimed Requests
            <small>View Requests</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url('page/claimedRequest') ?>"><i class="fa fa-dashboard"></i> Claimed Requests</a></li>
            <li class="active">View Request</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8 col-md-offset-2">
				<!-- general form elements -->
				<div class="box box-primary">
				    <div class="box-body">

			        	<div class="row form-group">
                    		<div class="col-sm-2">
                    			<label>Name:</label>	
                    		</div>
                    		<div class="col-sm-10">
                    			<?= $clmd_name ?>
                    		</div>
                    	</div>

			            <div class="row form-group">
			            	<div class="col-sm-2">
			            		<label>Email:</label>	
			            	</div>
			            	<div class="col-sm-10">
			            		<?= $clmd_email ?>
			            	</div>
			            </div>

			            <div class="row form-group">
			            	<div class="col-sm-2">
			            		<label>Contact:</label>	
			            	</div>
			            	<div class="col-sm-10">
			            		<?= $clmd_contact ?>
			            	</div>
			            </div>

			            <div class="row form-group">
			            	<div class="col-sm-2">
			            		<label>Message:</label>	
			            	</div>
			            	<div class="col-sm-10">
			            		<?= $clmd_message ?>
			            	</div>
			            </div>

			            <div class="row form-group">
			            	<div class="col-sm-2">
			            		<label>Business Proof:</label>	
			            	</div>
			            	<div class="col-sm-10">
			        			<?php if ($clmd_business_proof) { ?>
			        				<img src="<?= base_url(TEMP_FOLDER_PATH).$clmd_business_proof ?>" width="100px">
			        			<?php } else 
			        				echo "Not available!";
			        			?>
			            	</div>
			            </div>

			            <div class="row form-group">
			            	<div class="col-sm-2">
			            		<label>Shop Name:</label>	
			            	</div>
			            	<div class="col-sm-10">
			            		<?= $establishment_name ?>
			            	</div>
			            </div>

						<div class="row form-group">
			    			<div class="col-sm-2">
			    				<label>Create date:</label>	
			    			</div>
			    			<div class="col-sm-10">
			    				<?= $create_date ?>
			    			</div>
			            </div>

			            <div class="row form-group">
			    			<div class="col-sm-2">
			    				<label>Update date:</label>	
			    			</div>
			    			<div class="col-sm-10">
			    				<?= $update_date ?>
			    			</div>
			            </div>

			            <?php
			            if (!$is_clmd_approved) 
			            {
				            echo form_open('acceptRequest'); 
				            ?>
				            	<input type="hidden" name="claimed_id" value="<?= $clmd_id ?>" />
				            	<input type="hidden" name="merchant_id" value="<?= $merchant_id ?>" />
				            	<input type="hidden" name="fname" value="<?= $clmd_name ?>" />
				            	<input type="hidden" name="email" value="<?= $clmd_email ?>" />
				            	<input type="hidden" name="establishment_name" value="<?= $establishment_name ?>" />
				            	<input type="hidden" name="clmd_business_proof" value="<?= $clmd_business_proof ?>" />
				            	<input type="hidden" name="user_type[]" value="SELLER" />
				            	<button type="submit" class="btn btn-success">Approve</button>
			            <?php echo form_close();
			        	}
			            ?>
			        </div><!-- /.box-body -->
				</div><!-- /.box -->
			</div>   <!-- /.row -->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php require_once('include/imageModel.php'); ?>

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

input[type="file"] {
  display: block;
}
</style>
