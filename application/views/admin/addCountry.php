<?php 
$cnt_id = isset($country['country_id']) ? $country['country_id'] : '';
$cnt_name = isset($country['name']) ? $country['name'] : '';
$cnt_status = isset($country['status']) ? $country['status'] : 1;

if (isset($page_label) && $page_label == "edit") 
	$page_title = 'Edit country';
else
{
	$page_label = "add";
	$page_title = 'Add country';
}
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>
            Country
            <small><?= $page_label ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url('page/countryManagement') ?>">Country Management</a></li>
            <li class="active"><?= $page_title ?></li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6 col-md-offset-3">
				<!-- general form elements -->
				<div class="box box-primary">
				    <!-- form start -->
				    <?= form_open('addCountry'); ?>
				        <div class="box-body">
				            <div class="row form-group">
				            	<div class="col-sm-3">
				                	<label>Country*: </label>
				                </div>
				                <div class="col-sm-9">
					                <input type="hidden" name="cnt_id" value="<?= $cnt_id; ?>">
					                <input type="hidden" name="cnt_status" value="<?= $cnt_status; ?>">
					                <input type="text" name="cnt_name" class="form-control" placeholder="Enter Country Name" value="<?= $cnt_name; ?>" required>
					            </div>
				            </div>
				        </div><!-- /.box-body -->

				        <div class="box-footer"  align="right">
				        	<a href='<?= base_url("page/countryManagement");?>' class='btn btn-default'>Cancel</a>
				            <button type="submit" class="btn btn-primary">Submit</button>
				        </div>
				    <?= form_close(); ?><!-- form close -->
					
				</div><!-- /.box -->
			</div>   <!-- /.row -->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->
