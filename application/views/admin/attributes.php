<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>
            Attribute
            <small>Management</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Attributes</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="col-sm-12" style="margin: 20px 0 20px 0;">
                        <a href="<?= base_url('page/addAttribute') ?>" class="btn btn-primary pull-right">
                            <i class="fa fa-plus"></i> Add New Attribute</a> 
                    </div>

                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <<th>Attribute ID</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            	if ($status) 
                            	{
                                    $count = 1;
                            		foreach ($attributes as $att_key => $att_value)
                            		{
                                        $att_id = $att_value['att_id'];

                                        echo "<tr>
                                                <td>".$count++."</td>
                                                <td>".$att_value['att_id']."</td>
                                                <td>".$att_value['att_name']."</td>
                                                <td>
                                                    <a href='".base_url("editAttribute/$att_id")."' class='btn btn-primary'>Edit</a>
                                                    <a href='".base_url("deleteAttribute/$att_id")."' class='btn btn-danger'>Delete</a>
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
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->
