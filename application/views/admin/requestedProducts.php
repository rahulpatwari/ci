<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>Requested product<small>Management</small></h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Requested product Management</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="box">
                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Requested ID</th>
                                <th>Product Name</th>
                                <th>Brand</th>
                                <th>Seller Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($req_prds) 
                            {
                                $count = 1;
                                foreach ($req_prds as $req_prd) 
                                {
                                    $req_prd_id = $req_prd['request_id'];
                                    $list_id = '';

                                    if ($req_prd['isLinked'] == 1)
                                        $isLinked = "LINKED";
                                    else 
                                        $isLinked = "NOT LINKED";

                                    echo "<tr>
                                            <td>".$count++."</td>
                                            <td>".$req_prd_id."</td>
                                            <td>".$req_prd['product_name']."</td>
                                            <td>".$req_prd['brand_name']."</td>
                                            <td></td>
                                            <td>
                                                <a href='".base_url()."addProduct?req_prd_id=".$req_prd_id."' class='btn btn-success'>ADD</a>
                                            </td>
                                        </tr>";
                                }
                            }

                            if ( !$req_prds )
                                echo "<tr><td colspan='7' align='center'>No Record found.</td></tr>";
                            ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->
