<?php 
$category_id = '';
$brand_id = '';

if ($categories) 
{
    $category_options = '<option value="">-- select category --</option>';
    
    foreach ($categories as $cat_value) 
    {
        $selected = '';
        
        if (isset($_GET['category_id']) && ($_GET['category_id'] == $cat_value['category_id'])) 
        {
        	$selected = 'selected';
        	$category_id = $_GET['category_id'];
        }

        $category_options .= "<option value='".$cat_value['category_id']."' ".$selected.">".$cat_value['category_name']."</option>";
    }
}
else
    $category_options = '<option value="">Category not available</option>';

if ($brands) 
{
    $brand_options = '<option value="">-- select brand --</option>';
    foreach ($brands as $brand_value) 
    {
        $selected = '';

        if(isset($_GET['brand_id']) && ($_GET['brand_id'] == $brand_value['brand_id']))
        {
        	$selected = 'selected';
        	$brand_id = $_GET['brand_id'];
        }

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
        <h1>Data import/export<small>Product</small></h1>
        
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Product data import/export</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="row" style="margin: 10px 0 10px 0;">
                        <?= form_open('productExcel', array('method' => 'get')) ?>
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
                                <a href="<?= base_url('productExcel') ?>" class='btn btn-default'>Remove filter</a>
                            </div>
                        <?= form_close() ?>
                        <div class="col-sm-3">
                        	<?= form_open('exportTemplateForProduct', array('method' => 'get')) ?>
                        		<input type="hidden" name="category_id" value="<?= $category_id ?>" />
                        		<input type="hidden" name="brand_id" value="<?= $brand_id ?>" />
                        		<button type="submit" class="btn btn-primary pull-right">Export</button>
                            <?= form_close() ?>
                        </div>
                    </div>

					<div class="box-body table-responsive" style="padding: 30px;">
		                <table id="example1" class="table table-bordered table-striped">
		                    <thead>
		                        <tr>
		                            <th>S.NO.</th>
		                            <th>Product Name</th>
		                            <th>Product ID</th>
		                            <th>Category Name</th>
		                            <th>Category ID</th>
		                            <th>Brand Name</th>
		                            <th>Brand ID</th>
		                            <th>Price</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                    	<?php
		                    	if (isset($products)) 
		                    	{
		                            $count = 1;
		                    		foreach ($products as $prd_value) 
		                    		{	                                
		                                echo "<tr>
		                    					<td>".$count++."</td>
		                                        <td>".$prd_value['product_name']."</td>
		                                        <td>".$prd_value['product_id']."</td>
		                                        <td>".$prd_value['category_name']."</td>
		                                        <td>".$prd_value['category_id']."</td>
		                                        <td>".$prd_value['brand_name']."</td>
		                                        <td>".$prd_value['brand_id']."</td>
		                                        <td>".$prd_value['mrp_price']."</td>
		                    				</tr>";
		                    		}
		                    	}
		                    	else
		                    		echo "<tr><td colspan='8' align='center'>No Record found.</td></tr>";
		                    	?>
		                    </tbody>
		                </table>
		            </div><!-- /.box-body -->
		        </div>
        	</div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side --></div><!-- ./wrapper -->
