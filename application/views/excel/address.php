<?php
$merchant_id = isset($_GET['merchant_id']) ? $_GET['merchant_id'] : "";
$state_id = isset($_GET['state_id']) ? $_GET['state_id'] : "";
$city_id = isset($_GET['city_id']) ? $_GET['city_id'] : "";
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
	<!-- bread crumb -->
    <section class="content-header">
        <h1>Data import/export<small>Address</small></h1>
        
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Address data import/export</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
    	<div class="row">
    		<div class="col-xs-12">
                <div class="box">
                	<div class="row" style="margin: 10px 0 10px 0;">
                        <div class="col-sm-8">
                            <?= form_open('addressExcel', array('method' => 'get')) ?>
                                <div class="col-sm-3">
                                    <select class="form-control" name="merchant_id">
					                	<option value="">-- select merchant --</option>
					                    <?php
					                    foreach ($sallers as $saller) 
					                    {
					                    	if (isset($_GET['merchant_id']) && $saller['merchant_id'] == $_GET['merchant_id']) 
					                    		$selected = "selected='selected'";
					                    	else
					                    		$selected = '';

					                    	echo "<option value='".$saller['merchant_id']."' ".$selected.">".$saller['establishment_name']."</option>";
					                    }
					                    ?>
					                </select>
                                </div>

                                <div class="col-sm-3">
                                    <select class="form-control" name="state_id" id="state_id" onchange="getCity(this.value);">
					                	<option value="">-- select state --</option>
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

                                <div class="col-sm-3">
                                	<select class="form-control" name="city_id" id="state_cities"></select>
                                </div>

                                <div class="col-sm-3">
                                    <button type="submit" class="btn btn-info">Apply Filter</button>
                                    <a href="<?= base_url('addressExcel') ?>" class='btn btn-default'>Remove Filter</a>
                                </div>
                            <?= form_close() ?>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-9" align="right">
                                <?= form_open('exportTemplateForAddress', array('method' => 'get')) ?>
                                    <input type="hidden" name="merchant_id" value="<?= $merchant_id ?>" />
                                    <input type="hidden" name="state_id" value="<?= $state_id ?>" />
                                    <input type="hidden" name="city_id" value="<?= $city_id ?>" />
                                    <button type="submit" class="btn btn-info">Export Existing Data</button>
                                    <a href="<?= base_url('exportTemplateForAddress') ?>" class='btn btn-primary'>Export Empty Template</a>
                                <?= form_close() ?>
                            </div>
                            <div class="col-sm-3" align="left">
                                <?= form_open_multipart('importAddressXls') ?>
                                    <div class="file file_div btn btn-success">
                                        Import address
	                    				<input type="file" name="result_file" class="input_type_file" required />
                                    </div>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                    
                    <?php
                    //Error or success message div
                    if (count($error)>0) 
                    {
                        echo '<div class="alert alert-warning" role="alert">';
                            echo "<b>Error: Unable to get Latitude-Longitude for below addresses :</b> <ul>";
                            foreach ($error as $value) 
                                echo "<li>".$value."</li>";
                        echo "</ul></div>";
                    }
                    else if ($message) 
                        echo '<div class="alert alert-success" role="alert">'.$message.'</div>';
                    ?>

                	<div class="box-body table-responsive" style="padding: 30px;">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Seller</th>
                                    <th>Seller ID</th>
                                    <th>Address</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Address ID</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            	if (isset($address)) 
                            	{
                                    $count = 1;
                            		foreach ($address as $addres) 
                            		{	  
                            			$shop_address = $addres['address_line_1'].', '.$addres['address_line_2'].', '.$addres['landmark'].' - '.$addres['pin'];

                                        echo "<tr>
                            					<td>".$count++."</td>
                                                <td>".$addres['establishment_name']."</td>
                                                <td>".$addres['merchant_id']."</td>
                                                <td>".$shop_address."</td>
                                                <td>".$addres['city_name']."</td>
                                                <td>".$addres['state_name']."</td>
                                                <td>".$addres['address_id']."</td>
                                                <td>
                                                    <button type='button' class='btn btn-info' data-toggle='modal' data-target='#myModal".$count."'>Detail</button>
                                                </td>
                            				</tr>";

                                        echo '<div class="modal fade" id="myModal'.$count.'" role="dialog">
                                                    <div class="modal-dialog modal-xl">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">#'.$addres['merchant_id']." ".$addres['establishment_name'].'</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><label>Contact : </label>&nbsp;'.$addres['contact'].'</p>
                                                                <p><label>Business Days : </label>&nbsp;'.$addres['business_days'].'</p>
                                                                <p><label>Business Hours : </label>&nbsp;'.$addres['business_hours'].'</p>
                                                                <p><label>Address : </label>&nbsp;'.$shop_address.'</p>
                                                                <p><label>Country Name : </label>&nbsp;'.$addres['country_name'].'</p>
                                                                <p><label>Country ID : </label>&nbsp;'.$addres['country_id'].'</p>
                                                                <p><label>State Name : </label>&nbsp;'.$addres['state_name'].'</p>
                                                                <p><label>State ID : </label>&nbsp;'.$addres['state_id'].'</p>
                                                                <p><label>City Name : </label>&nbsp;'.$addres['city_name'].'</p>
                                                                <p><label>City ID : </label>&nbsp;'.$addres['city_id'].'</p>
                                                                <p><label>Latitude : </label>&nbsp;'.$addres['latitude'].'</p>
                                                                <p><label>Longitude : </label>&nbsp;'.$addres['longitude'].'</p>
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
</style>

<script type="text/javascript">
$(document).ready(function(){
    $('input[type=file]').change(function() { 
        // select the form and submit
        $('form').submit(); 
    });

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
