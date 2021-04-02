<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>
            Claimed Requests
            <small>Management</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Claimed Requests</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Claimed ID</th>
                                    <th>Merchant ID</th>
                                    <th>Shop Name</th>
                                    <th>Claimed Name</th>
                                    <th>Contact</th>
                                    <th>Email</th>
                                    <th>isApproved</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            	if ($claimedRequests) 
                            	{
                                    $count = 1;
                            		foreach ($claimedRequests as $claimedRequest)
                            		{
                                        $req_id = $claimedRequest['clmd_id'];

                                        if ($claimedRequest['is_clmd_approved'])
                                            $is_approved = "<span class='label label-success'>Approved</span>";
                                        else
                                            $is_approved = "<span class='label label-danger'>Not approved</span>";

                                        echo "<tr>
                                                <td>".$count++."</td>
                                                <td>".$req_id."</td>
                                                <td>".$claimedRequest['merchant_id']."</td>
                                                <td>".$claimedRequest['establishment_name']."</td>
                                                <td>".$claimedRequest['clmd_name']."</td>
                                                <td>".$claimedRequest['clmd_contact']."</td>
                                                <td>".$claimedRequest['clmd_email']."</td>
                                                <td>".$is_approved."</td>
                                                <td>
                                                    <a href='".base_url("viewRequest/$req_id")."' class='btn btn-primary'>View</a>
                                                    <a href='".base_url("deleteClaimedRequest/$req_id")."' class='btn btn-danger'>Delete</a>
                                                </td>
                                            </tr>";
                                    }
                            	}
                            	else
                            		echo "<tr><td colspan='7' align='center'>No Record found.</td></tr>";
                            	?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->
