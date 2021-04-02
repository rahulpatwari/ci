<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>
            Country
            <small>Management</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Countries</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="col-sm-12" style="margin: 10px 0 20px 0;">
                        <a href="<?= base_url('page/addCountry') ?>" class="btn btn-primary pull-right">
                            <i class="fa fa-plus"></i> Add New Country
                        </a> 
                    </div>

                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Country ID</th>
                                    <th>Country</th>
                                    <th>Current status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            	if ($country) 
                            	{
                                    $count = 1;
                                    foreach ($country['result'] as $value)
                            		{
                                        $cnt_id = $value['country_id'];
                                        $status = $value['status'];
                                        if ($status)
                                        {
                                            $status = "<span class='label label-success'>Active</span>";
                                            $new_status = 0;
                                        }
                                        else
                                        {
                                            $status = "<span class='label label-warning'>Not active</span>";
                                            $new_status = 1;
                                        }

                                        echo "<tr>
                                                <td>".$count++."</td>
                                                <td>".$cnt_id."</td>
                                                <td>".$value['name']."</td>
                                                <td>".$status."</td>
                                                <td>
                                                    <a href='".base_url("editCountry/$cnt_id")."' class='btn btn-primary'>Edit</a>
                                                    <a href='".base_url("changeCountryStatus/$cnt_id/$new_status")."' class='btn btn-warning'>Change status</a>
                                                </td>
                                            </tr>";
                                    }
                            	}
                            	else
                            		echo "<tr><td colspan='5' align='center'>No Record found.</td></tr>";
                            	?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->
