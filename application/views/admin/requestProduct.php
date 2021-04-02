<?php 
$products = isset($products) ? json_encode($products) : false; 
$request_id = isset($request_id) ? $request_id : ''; 
$product_name = isset($product_name) ? $product_name : ''; 
$brand_name = isset($brand_name) ? $brand_name : ''; 
$description = isset($description) ? $description : ''; 
$amazon_link = isset($amazon_link) ? $amazon_link : ''; 
$paytm_link = isset($paytm_link) ? $paytm_link : ''; 
$flipkart_link = isset($flipkart_link) ? $flipkart_link : ''; 
$other_link1 = isset($other_link1) ? $other_link1 : ''; 
$other_link2 = isset($other_link2) ? $other_link2 : ''; 

if ($request_id) 
      $page_label = 'Edit';
else
      $page_label = 'Add';
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
      <!-- bread crumb -->
      <section class="content-header">
            <h1>Requested Product<small><?= $page_label ?></small></h1>
            <ol class="breadcrumb">
                  <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li><a href="<?= base_url('page/merchantRequestedProducts') ?>">Requested products</a></li>
                  <li class="active"><?= $page_label ?></li>
            </ol>
      </section>

	<!-- Main content -->
      <section class="content">
            <div class="row">
                  <!-- left column -->
                  <div class="col-md-6 col-md-offset-3">
				<!-- general form elements -->
				<div class="box box-primary">
                              <div class="box-header">
                                    <h3 class="box-title">Request for new product</h3>
                              </div><!-- /.box-header -->
                              <?= form_open('addRequestedProduct'); ?>
                                    <input type="hidden" name="request_id" value="<?= $request_id ?>" />

                                    <div class="box-body">
                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Product Name*:</label>	
                                                </div>
                                                <div class="col-sm-9">
                                                      <input class="form-control" name="prd_name" id="query" placeholder="Enter product name..." type="text" value="<?= $product_name ?>" required />
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Brand Name*:</label>	
                                                </div>
                                                <div class="col-sm-9">
                                                      <input type="text" name="brand_name" class="form-control" placeholder="Please enter brand name..." value="<?= $brand_name ?>" required />
                                                </div>
                        	            </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Description:</label>	
                                                </div>
                                                <div class="col-sm-9">
                                                      <textarea class="form-control" rows="5" name="prd_desc" placeholder="Please enter product description ..."><?= $description ?></textarea>
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-12">
                                                      <center><label>Please fill atleast one referance link</label></center>   
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Amazon Link:</label>	
                                                </div>
                                                <div class="col-sm-9">
                                                      <input type="text" name="amazon_link" class="form-control" placeholder="Please enter amazon link..."  value="<?= $amazon_link ?>" />
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Flipkart Link:</label>	
                                                </div>
                                                <div class="col-sm-9">
                                                      <input type="text" name="flipkart_link" class="form-control" placeholder="Please enter flipkart link..." value="<?= $flipkart_link ?>" />
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Paytm Link:</label>	
                                                </div>
                                                <div class="col-sm-9">
                                                      <input type="text" name="paytm_link" class="form-control" placeholder="Please enter paytm link..." value="<?= $paytm_link ?>" />
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Other Link1:</label>	
                                                </div>
                                                <div class="col-sm-9">
                                                      <input type="text" name="other_link1" class="form-control" placeholder="Please enter other link..." value="<?= $other_link1 ?>" />
                                                </div>
                                          </div>

                                          <div class="row form-group">
                                                <div class="col-sm-3">
                                                      <label>Other Link2:</label>	
                                                </div>
                                                <div class="col-sm-9">
                                                      <input type="text" name="other_link2" class="form-control" placeholder="Please enter other link..." value="<?= $other_link2 ?>" />
                                                </div>
                                          </div>

                                          <div class="box-footer" align="right" style="clear: both;">
                                                <a href="<?= base_url('page/merchantRequestedProducts') ?>" class="btn btn-default">Cancel</a>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                          </div>
                                    </div>
                              <?= form_close(); ?>
			      </div><!-- /.box -->
		      </div>   <!-- /.row -->
            </section><!-- /.content -->
      </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
	$('#query').each(function(i, el) {
	    var that = $(el);
	    products = JSON.parse('<?= $products ?>');
	    that.autocomplete({
	    	source: products,
	    	display: function( event , ui ) {
	            return ui.label
	        }, 
	        select: function( event , ui ) {
	            if (ui.item.id) 
                  {
                        alert('This product is already available, please enter new product name!')
                        setTimeout(function(){ 
                              $('#query').val('');
                        }, 500);
                  }
	        }
	    });
	});   
});                     
</script>