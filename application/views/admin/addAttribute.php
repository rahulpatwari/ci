<?php 
$att_id = isset($data['att_id']) ? $data['att_id'] : '';
$att_name = isset($data['att_name']) ? $data['att_name'] : '';

if (isset($page_label) && $page_label == "edit") 
	$page_title = 'Edit attribute';
else
{
	$page_label = 'Add';
	$page_title = 'Add attribute';
}
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>
            Attribute
            <small><?= $page_label ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url('page/attributes') ?>">Attribute Management</a></li>
            <li class="active"><?= $page_title ?></li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-4 col-md-offset-4">
				<!-- general form elements -->
				<div class="box box-primary">
				    <!-- form start -->
				    <?= form_open('addAttribute'); ?>
				        <div class="box-body">
				            <div class="row form-group">
				            	<div class="col-sm-3">
				                	<label>Attribute*: </label>
				                </div>
				                <div class="col-sm-9">
					                <input type="hidden" name="att_id" value="<?= $att_id; ?>">
					                <input type="text" name="att_name" class="form-control" placeholder="Enter Attribute Name" value="<?= $att_name; ?>" required>
					            </div>
				            </div>
				        </div><!-- /.box-body -->

				        <div class="box-footer"  align="right">
				        	<a href='<?= base_url("page/attributes") ?>' class='btn btn-default'>Cancel</a>
				            <button type="submit" class="btn btn-primary">Submit</button>
				        </div>
				    <?= form_close(); ?>
				</div><!-- /.box -->
			</div>   <!-- /.row -->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->
