<?php 
if ($category) 
{
    $category_options = '<option value="">-- select category --</option>';
    
    foreach ($category['result'] as $cat_value) 
    {
        $selected = '';
        
        if (isset($_GET['category_id']) && ($_GET['category_id'] == $cat_value['category_id'])) 
            $selected = 'selected';

        $category_options .= "<option value='".$cat_value['category_id']."' ".$selected.">".$cat_value['category_name']."</option>";
    }
}
else
    $category_options = '<option value="">Category not available</option>';

if ($brands) 
{
    $brand_options = '<option value="">-- select brand --</option>';
    foreach ($brands['result'] as $brand_value) 
    {
        $selected = '';

        if( isset($_GET['brand_id']) && ($_GET['brand_id'] == $brand_value['brand_id']) )
            $selected = 'selected';

        $brand_options .= "<option value='".$brand_value['brand_id']."' ".$selected.">".$brand_value['name']."</option>";
    }
}
else
    $brand_options = '<option value="">Brand not available</option>';   
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>
            Product
            <small>Management</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Products</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="row" style="margin: 10px 0 10px 0;">
                        <?= form_open('products', array('method' => 'get')) ?>
                            <div class="col-sm-3">
                                <select class="form-control" name="category_id">
                                    <?= $category_options ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control" name="brand_id">
                                    <?= $brand_options ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-info">Find product</button>
                                <a href="<?= base_url('products') ?>" class='btn btn-default'>Remove filter</a>
                            </div>
                        <?= form_close() ?>
                        <div class="col-sm-3">
                            <a href="<?= base_url('addProduct') ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Product</a>
                        </div>
                    </div>

                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Product ID</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            	if ($data) 
                            	{
                                    $count = 1;
                            		foreach ($data as $prd_value) 
                            		{
                                        $prd_id = $prd_value['product_id'];
                                        $cat_id = $prd_value['category_id'];
                                        
                                        echo "<tr>
                            					<td>".$count++."</td>
                                                <td>".$prd_id."</td>
                                                <td><a href='".base_url("editProduct/$prd_id/view")."'>".$prd_value['product_name']."</a></td>
                                                <td>".$prd_value['category_name']."</td>
                                                <td>".$prd_value['brand_name']."</td>
                                                <td>".$prd_value['mrp_price']."</td>
                                                <td>
                                                    <a href='".base_url("editProduct/$prd_id/edit")."' class='btn btn-primary'>Edit</a>
                                                    <a href='".base_url("editProduct/$prd_id/duplicate")."' class='btn btn-warning'>Duplcate</a>
                                                    <a href='".base_url("deleteProduct/$prd_id")."' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                                </td>
                            				</tr>";
                            		}
                            	}
                            	else
                            		echo "<tr><td colspan='7' align='center'>No Record found.</td></tr>";
                            	?>
                            </tbody>
                        </table>
                        <?= form_close(); ?>
                    </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    <!-- </div> -->
    </section><!-- /.content -->
</div><!-- ./wrapper -->
