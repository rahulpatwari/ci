<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>Offer<small>Management</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Offers Management</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="col-sm-12" style="margin: 20px 0 20px 0;">
                        <a href="<?= base_url('page/addOffer') ?>" class="btn btn-primary pull-right">
                            <i class="fa fa-plus"></i> Add New Offer</a> 
                    </div>

                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Offer Title</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            	if ($merchant_offers) 
                            	{
                                    $count = 1;
                            		foreach ($merchant_offers as $offer_value)
                            		{
                                        $offer_id = $offer_value['offer_id'];

                                        echo "<tr>
                                                <td>".$count++."</td>
                                                <td><a href='".base_url("editOffer/$offer_id/view")."'>".$offer_value['offer_title']."</a></td>
                                                <td>".$offer_value['start_date']."</td>
                                                <td>".$offer_value['end_date']."</td>
                                                <td>
                                                    <a href='".base_url("editOffer/$offer_id/edit")."' class='btn btn-primary'>Edit</a>
                                                    <a href='".base_url("deleteOffer/$offer_id")."' class='btn btn-danger'>Delete</a>
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
