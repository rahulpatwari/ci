<?php 
$merchant_id = isset($merchant_id) ? $userId : $_GET['merchant_id'];
$user_id = isset($userId) ? $userId : $_GET['user_id'];
$address_id = isset($address_id) ? $address_id : '';
$lat = isset($latitude) ? $latitude : '';
$long = isset($longitude) ? $longitude : '';
$pin = isset($pin) ? $pin : '';
$line1 = isset($address_line_1) ? $address_line_1 : '';
$line2 = isset($address_line_2) ? $address_line_2 : '';
$landmark = isset($landmark) ? $landmark : '';
$cnt_id = isset($country_id) ? $country_id : '';
$state_id = isset($state_id) ? $state_id : '';
$city_id = isset($city_id) ? $city_id : '';
$is_default_address = isset($is_default_address) ? $is_default_address : 0;
$contact = isset($contact) ? $contact : '';
$business_days = isset($business_days) ? $business_days : '';
$business_hours = isset($business_hours) ? $business_hours : '';
$merchant_id = isset($_GET['merchant_id']) ? $_GET['merchant_id'] : $_SESSION['merchant_id'];

if (isset($page_label) && $page_label == "edit") 
    $page_title = 'Edit address';
else if (isset($page_label) && $page_label == "view") 
    $page_title = 'View address';
else
{
    $page_label = "add";
    $page_title = 'Add address';
}
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
                <li><a href="<?= base_url('sellers/sellersTable') ?>">Edit Seller</a></li>
            <?php } ?>
            <li><a href="<?= base_url('page/addressManagement?user_id='.$user_id.'&merchant_id='.$merchant_id) ?>">View address</a></li>
            <li class="active"><?= $page_title ?></li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6 col-md-offset-3">
				<!-- general form elements -->
				<div class="box box-primary">
				    <!-- form start -->
				    <?= form_open('addAddress') ?>
				    	<div class="box-body">
					    	<input type="hidden" name="address_id" value="<?= $address_id ?>" />
					    	<input type="hidden" name="user_id" value="<?= $user_id ?>" />
					    	<input type="hidden" name="is_default_address" value="<?= $is_default_address ?>" />
                            <input type="hidden" name="merchant_id" value="<?= $merchant_id ?>" />

                            <div class="form-group">
                                <textarea name="line1" class="form-control" placeholder="line1 address*" required><?= $line1 ?></textarea>
                            </div>

					    	<div class="form-group">
		                        <textarea name="line2" class="form-control" placeholder="line2 address"><?= $line2 ?></textarea>
		                    </div>

		                    <div class="form-group">
		                        <textarea name="landmark" class="form-control" placeholder="landmark"><?= $landmark ?></textarea>
		                    </div>

		                    <div class="form-group">
		                    	<select class="form-control" name="country_id" id="cnt_id" onchange="getState(this.value);" required>
		                            <?php
		                            if ($countries) 
		                            {
		                                echo "<option value=''>Please select country!!</option>";

		                                foreach ($countries['result'] as $cnt_value) 
		                                {
		                                	if ($cnt_value['country_id'] == $cnt_id) 
		                                		$selected = "selected";
		                                	else
		                                		$selected = "";

		                                	echo "<option value='".$cnt_value['country_id']."' ".$selected.">".$cnt_value['name']."</option>";
		                                }
		                            }
		                            else
		                                echo "<option>country not available!</option>";
		                            ?>
		                        </select>
		                    </div>

		                    <div class="form-group">
		                        <select class="form-control" name="state_id" onchange="getCity(this.value);" id="states" required></select>
		                    </div>

		                    <div class="form-group">
		                        <select class="form-control" name="city_id" id="state_cities" required></select>
		                    </div>

		                    <div class="form-group">
		                        <input type="text" name="pin" value="<?= $pin ?>" class="form-control" placeholder="pin code"/>
		                    </div>

                            <div class="form-group">
                                <input type="text" name="contact" class="form-control" placeholder="contact number" value="<?= $contact ?>" />
                            </div>

                            <div class="form-group">
                                <input type="text" name="business_days" class="form-control" placeholder="business days" value="<?= $business_days ?>" />
                            </div>

                            <div class="form-group">
                                <input type="text" name="business_hours" class="form-control" placeholder="business hours" value="<?= $business_hours ?>" />
                            </div>

                            <div class="row form-group">
                                <div class="col-sm-4">
                                    <input type="text" name="lat" class="form-control" placeholder="latitude" onkeyup="initialize();" id="lat" value="<?= $lat ?>" required />
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" name="long" id="long" class="form-control" placeholder="longitude" onkeyup="initialize();" value="<?= $long ?>" required />
                                </div>
                                <div class="col-sm-4">
                                    <button type="button" onclick="getLatLongFromAddress();" class="btn btn-info">Get lat-long from address</button>
                                </div>
                            </div>

                            <!-- google map -->
                            <center>
                                <div id="googleMap" style="width:90%;height:400px; margin: 20px;"></div>
                            </center>

                            <div class="box-footer" align="right">
                                <?php 
                                if ($_COOKIE['site_code'] == 'seller') 
                                    echo "<a href='".base_url().'page/addressManagement?user_id='.$_SESSION['usr_detail']['userId'].'&merchant_id='.$_SESSION['merchant_id']."' class='btn btn-default'>Cancel</a>";
                                else
                                    echo "<a href='../page/addressManagement?user_id=$user_id&merchant_id=$merchant_id' class='btn btn-default'>Cancel</a>";
                                ?>
					        	
					            <button type="submit" class="btn btn-primary">Submit</button>
					        </div>
					    </div>
				    <?= form_close() ?>
				</div><!-- /.box -->
			</div>   <!-- /.row -->
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php require_once('include/imageModel.php'); ?>

<script>
function getLatLongFromAddress() 
{
    geocoder = new google.maps.Geocoder();
    line1 = ($('[name="line1"]').val()) ? $('[name="line1"]').val()+', ' : '';
    line2 = ($('[name="line2"]').val()) ? $('[name="line2"]').val()+', ' : '';
    landmark = ($('[name="landmark"]').val()) ? $('[name="landmark"]').val()+', ' : '';
    country = ($("#cnt_id option:selected").html()) ? $("#cnt_id option:selected").html()+', ' : '';
    state = ($("#states option:selected").html()) ? $("#states option:selected").html()+', ' : '';
    city = ($("#state_cities option:selected").html()) ? $("#state_cities option:selected").html() : '';
    pin = ($('[name="pin"]').val()) ? '-'+$('[name="pin"]').val() : '';
    address = line1+line2+landmark+country+state+city+pin;
    
    //debugger;
    geocoder.geocode({'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            //get lat-long
            latitude = results[0].geometry.location.lat().toFixed(6);
            longitude = results[0].geometry.location.lng().toFixed(6);

            //set lat-long in text fields
            $('[name="lat"]').val(latitude);
            $('[name="long"]').val(longitude);

            //call map for map initialization
            initialize();
        } 
    }); 
}

//initialize google map
function initialize() 
{
    var lat = ($('[name="lat"]').val()) ? $('[name="lat"]').val() : 22.7196;
    var long = ($('[name="long"]').val()) ? $('[name="long"]').val() : 75.8577;

    //set location on google map using lat long
    var myLatlng = new google.maps.LatLng(lat, long);
    var mapOptions = {
                        zoom: 15,
                        center: myLatlng,
                        draggable: true
                    }
    var map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);
    setMarkerOnClickMap(myLatlng, map);

    google.maps.event.addListener(map, 'click', function (e) {
        lat1 = (e.latLng.lat()).toFixed(6);
        long1 = (e.latLng.lng()).toFixed(6);

        $('[name="lat"]').val(lat1);
        $('[name="long"]').val(long1);

        setMarkerOnClickMap(e.latLng, map);
    });
}

var gmarkers = [];

//set marker on click map
function setMarkerOnClickMap(latLng, map) 
{
    //remove old markers from map
    for(i=0; i<gmarkers.length; i++)
        gmarkers[i].setMap(null);

    //set marker on google map
    var marker = new google.maps.Marker({
                    position: latLng
                });

    // To add the marker to the map, call setMap();
    marker.setMap(map);

    //push old marker in array
    gmarkers.push(marker);

    //show info window for address
    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });

    //show address div on click marker
    showFormattedAddress((latLng.lat()), (latLng.lng()));
}

//show address div on click marker
function showFormattedAddress(lat, long) 
{
    infowindow = new google.maps.InfoWindow();
    latlng = new google.maps.LatLng(lat, long);
    geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'latLng': latlng }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) 
            infowindow.setContent(results[0].formatted_address);
    });
}

//get state of country
function getState(cnt_id)
{
    $('#states').empty();

    if (cnt_id) 
    {
        $.ajax({
            type: "GET",
            url: '<?= base_url("states") ?>/'+cnt_id,
            success: function(data){
                if ( data ) 
                {
                    $('#states').empty();
                    state_data = JSON.parse(data);
                    state_options = "<option value=''>Please select state!!</option>";
                    usr_state_id = <?= (!empty($state_id) ? json_encode($state_id) : '""'); ?>

                    for (var i = 0; i < state_data.length; i++) 
                    {
                        state_name = state_data[i].name;
                        state_id = state_data[i].state_id;
                        selected = "";

                        if (state_id == usr_state_id)
                            selected = "selected";

                        state_options += "<option value='"+state_id+"' "+selected+">"+state_name+"</option>";
                    }

                    $('#states').append(state_options);

                    state_id = $('#states').val();
                    if (parseInt(state_id)) 
                        getCity(state_id);
                }
            },
        }); 
    }
}

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
                if ( data ) 
                {
                    $('#state_cities').empty();
                    city_data = JSON.parse(data);
                    city_options = "<option value=''>Please select city!!</option>";
                    usr_city_id = <?= (!empty($city_id) ? json_encode($city_id) : '""'); ?>

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
}

$(document).ready(function() {
    cnt_id = $('#cnt_id').val();
    if (parseInt(cnt_id)) 
        getState(cnt_id);
});
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVz1q3IpVEItGM-WmXgBkNWEfMuofO3FI&callback=initialize"></script>
