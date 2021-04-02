<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1><?= ucfirst($page_label) ?> Review<small>Management</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?= ucfirst($page_label) ?> Review Management</li>
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
                                    <th>S.No.</th>
                                    <th>Review ID</th>
                                    <th>Review Title</th>
                                    <th>Rating</th>
                                    <th>Consumer Name</th>
                                    <?php 
                                    if ($page_label == 'merchant') 
                                        echo "<th>Merchant Name</th>";
                                    else
                                        echo "<th>Product Name</th>";
                                    ?>
                                    <th>Current status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            	if ($reviews) 
                            	{
                                    $count = 0;
                            		foreach ($reviews['result'] as $review_value) 
                            		{
                                        $review_id = $review_value['review_id'];

                                        if ($page_label == 'merchant') 
                                            $name = $review_value['shop_name'];
                                        else
                                            $name = $review_value['product_name'];
                                        
                                        if ($review_value['status']) 
                                        {
                                            $current_status = "<span class='label label-danger'>Not active</span>";
                                            $change_status = 0;
                                        }
                                        else
                                        {
                                            $current_status = "<span class='label label-success'>Active</span>";
                                            $change_status = 1;
                                        }

                                        echo "<tr>
                            					<td>".++$count."</td>
                                                <td>".$review_id."</td>
                                                <td><a href='".base_url("viewReview/$review_id/$page_label")."'>".$review_value['review_title']."</a></td>
                                                <td>".$review_value['rating']."</td>
                                                <td>".$review_value['consumer_name']."</td>
                                                <td>".$name."</td>
                                                <td>".$current_status."</td>
                                                <td>
                                                    <a href='".base_url("changeReviewStatus/$review_id/$change_status/$page_label")."' class='btn btn-warning'>change status</a>
                                                    <a href='".base_url("editReview/$review_id/$page_label")."' class='btn btn-primary'>Edit</a>
                                                    <a href='".base_url("deleteReview/$review_id/$page_label")."' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                                </td>
                            				</tr>";
                            		}
                            	}
                            	else
                            		echo "<tr><td colspan='8' align='center'>No Record found.</td></tr>";
                            	?>
                            </tbody>
                        </table>
                        <?= form_close(); ?>
                    </div><!-- /.box-body -->
                </div>
            </div><!-- /.box -->
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->
