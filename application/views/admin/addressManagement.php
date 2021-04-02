<?php 
if (isset($page_label) && $page_label == "edit") 
	$page_title = 'Edit address';
else if (isset($page_label) && $page_label == "view") 
	$page_title = 'View address';
else
{
	$page_label = "add";
	$page_title = 'Add address';
}

$merchant_logo = isset($merchant['result'][0]['merchant_logo']) ? $merchant['result'][0]['merchant_logo'] : '';
$shop_name = isset($merchant['result'][0]['establishment_name']) ? $merchant['result'][0]['establishment_name'] : '';
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
$merchant_id = isset($_GET['merchant_id']) ? $_GET['merchant_id'] : '';
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>
            Seller address
            <small><?= $page_label ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <?php if ($_COOKIE['site_code'] == 'admin') { ?>
	            <li><a href="<?= base_url('sellers/sellersTable') ?>">Seller Management</a></li>
	            <li><a href="<?= base_url('seller/'.$_GET['merchant_id'].'/edit') ?>">Edit Seller</a></li>
	        <?php } ?>
            <li class="active"><?= $page_title ?></li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
        	<div class="col-sm-12" style="margin: 20px;">
        		<center>
        			<img src="<?= $merchant_logo ?>" height="80px" />
        			<h2><?= $shop_name ?></h2>
        		</center>
        	</div>
        	<div class="col-sm-9">
        		<?= form_open('page/addressManagement', array('method'=>'get')) ?>
        			<input type="hidden" name="user_id" value="<?= $_GET['user_id'] ?>" />
        			<input type="hidden" name="merchant_id" value="<?= $_GET['merchant_id'] ?>" />

	                <div class="row">
	                    <div class="col-sm-4">
	                        <select class="form-control" name="state_id" id="state_id" onchange="getCity(this.value);" required>
	                        	<option value="">--Please select state--</option>
	                            <?php
	                            foreach ($states as $state) 
	                            {
	                            	if (isset($_GET['state_id']) && $state['state_id'] == $_GET['state_id']) 
	                            		$selected = "selected='selected'";
	                            	else
	                            		$selected = '';

	                            	echo "<option value='".$state['state_id']."' ".$selected.">".$state['name']."</option>";
	                            }
	                            ?>
	                        </select>
	                    </div>
	                    <div class="col-sm-4">
	                        <select class="form-control" name="city_id" id="state_cities"></select>
	                    </div>
	                    <div class="col-sm-4">
	                        <button type="submit" class="btn btn-info">Find address</button>
	                        <a href="<?= base_url('page/addressManagement?user_id='.$_GET["user_id"].'&merchant_id=').$_GET["merchant_id"] ?>" class='btn btn-default'>Remove filter</a>
	                    </div>
	                </div>
	            <?= form_close() ?>
            </div>
        	<div class="col-sm-3" style="margin-bottom: 20px;">
        		<a href="<?= base_url('page/addAddress?user_id='.$_GET['user_id'].'&merchant_id='.$_GET['merchant_id']) ?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Add New Address</a> 
        	</div>
        	<?php
            //address data
			if (count($address)>0) 
			{
				foreach ($address as $add_value) 
				{
					$isPrimary = "";
					if ( $add_value['is_default_address'] == 1 ) 
						$isPrimary = '<h3 class="box-title"><b>Primary Address</b></h3>';

					$address_id = $add_value['address_id'];
					$lat = $add_value['latitude'];
					$long = $add_value['longitude'];
					$pin = $add_value['pin'];
					$contact = $add_value['contact'];
					$business_days = $add_value['business_days'];
					$business_hours = $add_value['business_hours'];
					$line1 = $add_value['address_line_1'];
					$line2 = $add_value['address_line_2'];
					$landmark = $add_value['landmark'];
					$cnt_id = $add_value['country_id'];
					$state_id = $add_value['state_id'];
					$city_id = $add_value['city_id'];
					$country_name = $add_value['country_name'];
					$state_name = $add_value['state_name'];
					$city_name = $add_value['city_name']; 
					?>

        			<div class="col-sm-3">
						<div class="box box-primary1">
							<div class="box-body">
								<div class="row form-group">
					            	<div class="col-sm-12 address">
					            		<?= $line1.'<br />'.$line2.'<br />'.$landmark.'<br />'.$city_name." - ".$pin.'<br />'.$state_name.", ".$country_name."<br /><br />" ?>
					            		<label>Lat-Long :</label> <?= $lat.", ".$long ?><br />
					            		<label>Phone no :</label> <?= $contact ?><br />
					            		<label>Business days :</label> <?= $business_days ?><br />
					            		<label>Business hours :</label> <?= $business_hours ?>
									</div>
					                <div class="col-sm-12">
					                	<?php 
										if (!$isPrimary)
											echo "<a href='".base_url("deleteAddress/$address_id").'/'.$_GET['user_id']."/".$merchant_id."' class='btn btn-danger'>Delete</a>";
										?>

										<a href='<?= base_url("page/addAddress?address_id=$address_id&merchant_id=".$_GET['merchant_id']) ?>' class='btn btn-primary'>Edit</a>
					                </div>
					            </div>
				        	</div>
			        	</div>
			        </div>
				<?php }
			} 
			else
				echo "No shop found!";
			?>
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php require_once('include/imageModel.php'); ?>

<style type="text/css">
.box-primary1{
	border: 2px solid #ccc;
	box-shadow: 15px 10px 18px #ccc;
	height: 350px;
}

.box .box-header a{
	color: #fff;
	margin: 10px;
}

.address{
	margin: 5px;
}
</style>

<script type="text/javascript">
$(document).ready(function() {
    state_id = $('#state_id').val();
	if (parseInt(state_id)) 
		getCity(state_id);
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
