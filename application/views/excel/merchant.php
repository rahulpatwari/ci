<?php
$state_id = '';
$city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>Data import/export<small>Merchant</small></h1>
        
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Merchant data import/export</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
    	<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="row" style="margin: 10px 0 10px 0;">
						<?= form_open('merchantExcel', array('method' => 'get')) ?>
		                    <div class="col-sm-3">
		                        <select class="form-control" name="state_id" id="state_id" onchange="getCity(this.value);">
				                	<option value="">-- select state --</option>
				                    <?php
				                    foreach ($states as $state) 
				                    {
				                    	if (isset($_GET['state_id']) && $state['state_id'] == $_GET['state_id']) 
				                    	{
				                    		$selected = "selected='selected'";
				                    		$state_id = $state['state_id'];
				                    	}
				                    	else
				                    		$selected = '';

				                    	echo "<option value='".$state['state_id']."' ".$selected.">".$state['name']."</option>";
				                    }
				                    ?>
				                </select>
		                    </div>
		                    <div class="col-sm-3">
		                        <select class="form-control" name="city_id" id="state_cities"></select>
		                    </div>
		                    <div class="col-sm-3">
		                        <button type="submit" class="btn btn-info">Find merchant</button>
		                        <a href="<?= base_url('merchantExcel') ?>" class='btn btn-default'>Remove filter</a>
		                    </div>
		                <?= form_close() ?>
		                <div class="col-sm-3">
		                	<?= form_open('exportTemplateForMerchant', array('method' => 'get')) ?>
		                		<input type="hidden" name="state_id" value="<?= $state_id ?>" />
		                		<input type="hidden" name="city_id" value="<?= $city_id ?>" />
		                		<button type="submit" class="btn btn-primary pull-right">Export</button>
		                    <?= form_close() ?>
		                </div>
		            </div>

					<div class="box-body table-responsive" style="padding: 30px;">
		                <table id="example1" class="table table-bordered table-striped">
		                    <thead>
		                        <tr>
		                            <th>S.NO.</th>
		                            <th>Seller</th>
		                            <th>Seller ID</th>
		                            <th></th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                    	<?php
		                    	if (isset($merchants)) 
		                    	{
		                            $count = 1;
		                    		foreach ($merchants as $merchant) 
		                    		{	                                
		                                echo "<tr>
		                    					<td>".$count++."</td>
		                                        <td>".$merchant['establishment_name']."</td>
		                                        <td>".$merchant['merchant_id']."</td>
		                                        <td>
		                                        	<button type='button' class='btn btn-info' data-toggle='modal' data-target='#myModal".$count."'>Detail</button>
		                                        </td>
		                    				</tr>";

		                    			echo '<div class="modal fade" id="myModal'.$count.'" role="dialog">
												<div class="modal-dialog modal-xl">
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">#'.$merchant['merchant_id']." ".$merchant['establishment_name'].'</h4>
														</div>
														<div class="modal-body">
															<p><label>Finance Available : </label>&nbsp;'.$merchant['finance_available'].'</p>
															<p><label>Finance Terms : </label>&nbsp;<span class="more">'.$merchant['finance_terms'].'</span></p>
															<p><label>Home Delivery Available : </label>&nbsp;'.$merchant['home_delivery_available'].'</p>
															<p><label>Home Delivery Terms : </label>&nbsp;<span class="more">'.$merchant['home_delivery_terms'].'</span></p>
															<p><label>Installation Available : </label>&nbsp;'.$merchant['installation_available'].'</p>
															<p><label>Installation Terms : </label>&nbsp;<span class="more">'.$merchant['installation_terms'].'</span></p>
															<p><label>Replacement Available : </label>&nbsp;'.$merchant['replacement_available'].'</p>
															<p><label>Replacement Terms : </label>&nbsp;<span class="more">'.$merchant['replacement_terms'].'</span></p>
															<p><label>Return Available : </label>&nbsp;'.$merchant['return_available'].'</p>
															<p><label>Return Terms : </label>&nbsp;<span class="more">'.$merchant['return_policy'].'</span></p>
															<p><label>Seller Offering : </label>&nbsp;<span class="more">'.$merchant['seller_offering'].'</span></p>
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
		                    		echo "<tr><td colspan='14' align='center'>No Record found.</td></tr>";
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
    state_id = $('#state_id').val();
	if (parseInt(state_id)) 
		getCity(state_id);

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

//get city of state
function getCity(state_id)
{
	$('#state_cities').empty();

	if (state_id) 
	{
		$.ajax({
	        type: "GET",
	        url: '<?= base_url("cities") ?>/'+state_id,
	        success: function(data){
	            if (data) 
	            {
	            	city_data = JSON.parse(data);
	            	city_options = "<option value=''>Please select city!!</option>";
	            	usr_city_id = <?= (!empty($_GET['city_id']) ? json_encode($_GET['city_id']) : '""'); ?>

	            	for (var i = 0; i < city_data.length; i++) 
	            	{
	            		city_name = city_data[i].name;
	            		city_id = city_data[i].city_id;
	            		selected = "";

	            		if (usr_city_id == city_id)
	            			selected = "selected";

	            		city_options += "<option value='"+city_id+"' "+selected+">"+city_name+"</option>";
	            	}

	            	$('#state_cities').append(city_options);
	            }
	        },
	    });	
	}
	else
		$('#state_cities').append('<option value="">--City not available--</option>');
}
</script>
