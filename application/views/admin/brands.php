<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>
            Brand
            <small>Management</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Brands</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="col-sm-12" style="margin: 20px 0 20px 0;">
                        <a href="<?= base_url('page/addBrand');?>" class="btn btn-primary pull-right">
                            <i class="fa fa-plus"></i> Add New Brand</a> 
                    </div>

                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Brand ID</th>
                                    <th>Brand</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            	if ($success) 
                            	{
                                    $count = 1;
                            		foreach ($data as $brand_key => $brand_value)
                            		{
                                        $brand_id = $brand_value['brand_id'];

                                        echo "<tr>
                                                <td>".$count++."</td>
                                                <td>".$brand_id."</td>
                                                <td>
                                                    <a href='".base_url("editBrand/$brand_id/view")."'>".$brand_value['name']."</a>
                                                </td>
                                                <td>
                                                    <a href='".base_url("editBrand/$brand_id/edit")."' class='btn btn-primary'>Edit</a>
                                                    <a href='".base_url("deleteBrand/$brand_id")."' class='btn btn-danger'>Delete</a>
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
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->
