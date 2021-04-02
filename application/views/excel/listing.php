<?php
$merchant_id = isset($_GET['merchant_id']) ? $_GET['merchant_id'] : "";
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : "";
?>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>Data import/export<small>Listing</small></h1>
        
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Listing data import/export</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
    	<div class="row">
		    <div class="col-xs-12">
                <div class="box">
                    <div class="row" style="margin: 10px 0 10px 0;">
                        <div class="col-sm-6">
                            <?= form_open('listingExcel', array('method' => 'get')) ?>
                                <div class="col-sm-4">
                                    <select class="form-control" name="product_id">
                                        <option value="">-- select product --</option>
                                        <?php
                                        foreach ($products as $product) 
                                        {
                                            if (isset($_GET['product_id']) && $product['product_id'] == $_GET['product_id']) 
                                                $selected = "selected='selected'";
                                            else
                                                $selected = '';

                                            echo "<option value='".$product['product_id']."' ".$selected.">".$product['product_name']."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-sm-4">
                                    <select class="form-control" name="merchant_id">
                                        <option value="">-- select merchant --</option>
                                        <?php
                                        foreach ($sellers as $seller) 
                                        {
                                            if (isset($_GET['merchant_id']) && $seller['merchant_id'] == $_GET['merchant_id']) 
                                                $selected = "selected='selected'";
                                            else
                                                $selected = '';

                                            echo "<option value='".$seller['merchant_id']."' ".$selected.">".$seller['establishment_name']."</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-info">Find Listing</button>
                                    <a href="<?= base_url('listingExcel') ?>" class='btn btn-default'>Remove Filter</a>
                                </div>
                            <?= form_close() ?>
                        </div>
                        <div class="col-sm-6">
                            <div class="col-sm-10" align="right">
                                <?= form_open('exportTemplateForListing', array('method' => 'get')) ?>
                                    <input type="hidden" name="merchant_id" value="<?= $merchant_id ?>" />
                                    <input type="hidden" name="product_id" value="<?= $product_id ?>" />
                                    <button type="submit" class="btn btn-info">Export Existing Data</button>
                                    <a href="<?= base_url('exportTemplateForListing') ?>" class='btn btn-primary'>Export Empty Template</a>
                                <?= form_close() ?>
                            </div>
                            <div class="col-sm-2" align="left">
                                <?= form_open_multipart('importListingXls') ?>
                                    <div class="file file_div btn btn-success">
                                        Import address
                                        <input type="file" name="result_file" class="input_type_file" required />
                                    </div>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>

        		    <div class="box-body table-responsive" style="padding: 30px;">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.NO.</th>
                                    <th>Seller</th>
                                    <th>Seller ID</th>
                                    <th>Product Name</th>
                                    <th>Product ID</th>
                                    <th>Price</th>
                                    <th>Listing ID</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            	if (isset($listings)) 
                            	{
                                    $count = 1;
                            		foreach ($listings as $listing) 
                            		{	                                
                                        echo "<tr>
                            					<td>".$count++."</td>
                                                <td>".$listing['establishment_name']."</td>
                                                <td>".$listing['merchant_id']."</td>
                                                <td>".$listing['product_name']."</td>
                                                <td>".$listing['product_id']."</td>
                                                <td>".currency_format($listing['price'])."</td>
                                                <td>".$listing['listing_id']."</td>
                                                <td>
                                                    <button type='button' class='btn btn-info' data-toggle='modal' data-target='#myModal".$count."'>Detail</button>
                                                </td>
                            				</tr>";

                                        echo '<div class="modal fade" id="myModal'.$count.'" role="dialog">
                                                <div class="modal-dialog modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">#'.$listing['merchant_id']." ".$listing['establishment_name'].'</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><label>Product ID : </label>&nbsp;'.$listing['product_id'].'</p>
                                                            <p><label>Product Name : </label>&nbsp;'.$listing['product_name'].'</p>
                                                            <p><label>Brand Name : </label>&nbsp;'.$listing['brand_name'].'</p>
                                                            <p><label>Category Name : </label>&nbsp;'.$listing['category_name'].'</p>
                                                            <p><label>Price : </label>&nbsp;'.currency_format($listing['price']).'</p>
                                                            <p><label>In Stock : </label>&nbsp;'.$listing['in_stock'].'</p>
                                                            <p><label>Will Back In Stock On : </label>&nbsp;'.convert_to_user_date($listing['will_back_in_stock_on']).'</p>
                                                            <p><label>Seller Offering : </label>&nbsp;<span class="more">'.$listing['seller_offering'].'</span></p>
                                                            <p><label>Finance Available : </label>&nbsp;'.$listing['finance_available'].'</p>
                                                            <p><label>Finance Terms : </label>&nbsp;<span class="more">'.$listing['finance_terms'].'</span></p>
                                                            <p><label>Home Delivery Available : </label>&nbsp;'.$listing['home_delivery_available'].'</p>
                                                            <p><label>Home Delivery Terms : </label>&nbsp;<span class="more">'.$listing['home_delivery_terms'].'</span></p>
                                                            <p><label>Installation Available : </label>&nbsp;'.$listing['installation_available'].'</p>
                                                            <p><label>Installation Terms : </label>&nbsp;<span class="more">'.$listing['installation_terms'].'</span></p>
                                                            <p><label>Replacement Available : </label>&nbsp;'.$listing['replacement_available'].'</p>
                                                            <p><label>Replacement Terms : </label>&nbsp;<span class="more">'.$listing['replacement_terms'].'</span></p>
                                                            <p><label>Return Available : </label>&nbsp;'.$listing['return_available'].'</p>
                                                            <p><label>Return Policy : </label>&nbsp;<span class="more">'.$listing['return_policy'].'</span></p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                            		}
                            	}
                            	else
                            		echo "<tr><td colspan='22' align='center'>No Record found.</td></tr>";
                            	?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side --></div><!-- ./wrapper -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<style type="text/css">
.file_div {
    position: relative;
    overflow: hidden;
}
.input_type_file {
    position: absolute;
    font-size: 50px;
    opacity: 0;
    right: 0;
    top: 0;
}

@media (min-width: 768px) {
    .modal-xl {
        width: 90%;
        max-width:1200px;
    }
}

.morecontent span {
    display: none;
}
.morelink {
    display: block;
}
</style>

<script type="text/javascript">
$(document).ready(function(){
    $('input[type=file]').change(function() { 
        // select the form and submit
        $('form').submit(); 
    });

    var showChar = 250;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more";
    var lesstext = "Show less";
    
    $('.more').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
 
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});
</script>
