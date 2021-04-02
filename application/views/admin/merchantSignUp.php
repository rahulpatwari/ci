<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>ROPO SHOP | Mechant signup</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="shortcut icon" href="<?= $this->config->item('site_url').'assets/4d_logo.ico' ?>">
        <!-- bootstrap 3.0.2 -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/bootstrap.min.css' ?>" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/font-awesome.min.css' ?>" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?= $this->config->item('site_url').'assets/admin/css/AdminLTE.css' ?>" rel="stylesheet" type="text/css" />

        <style type="text/css">
        .form-box{
            width: 800px;
        }
        </style>
    </head>
    <body class="bg-black">
        <div class="form-box" id="login-box">
            <div class="header">Merchant Signup Form</div>
            <?= form_open_multipart('addSeller') ?>
                <input type="hidden" name="is_default_address" value="1" />

                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="fname" class="form-control" placeholder="first name*" required />
                    </div>

                    <div class="form-group">
                        <input type="text" name="mname" class="form-control" placeholder="middle name" />
                    </div>

                    <div class="form-group">
                        <input type="text" name="lname" class="form-control" placeholder="last name*" required />
                    </div>

                    <?php if (isset($username) && isset($password)) {
                        echo '<input type="hidden" name="email" value="'.$username.'" required />
                            <input type="hidden" name="psw" value="'.$password.'" required />';
                    }  else { ?>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="email*" required />
                        </div>

                        <div class="form-group">
                            <input type="password" name="psw" class="form-control" placeholder="password*" required />
                        </div>

                        <div class="form-group">
                            <input type="password" name="cpsw" class="form-control" placeholder="confirm password*" required />
                        </div>
                    <?php } ?> 
                    <div class="row form-group">
                        <div class="col-sm-3">
                            Merchant Profile Picture:
                        </div>
                        <div class="col-sm-4">
                            <input type="file" name="file7" id="file7" />
                        </div>
                        <div class="col-sm-4 file7"></div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-3">
                            Shop Logo:
                        </div>
                        <div class="col-sm-4">
                            <input type="file" name="file8" id="file8" />
                        </div>
                        <div class="col-sm-4 file8"></div>
                    </div>

                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped" style="color: #433f3f;">
                            <thead>
                                <tr>
                                    <th colspan="3"><center>Shop images</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i=1; $i < 7; $i++) { ?>
                                    <tr>
                                        <td>Image<?= $i ?></td>
                                        <td><input type="file" name="file<?= $i ?>" id="file<?= $i ?>"></td>
                                        <td><div class="file<?= $i ?>"></div></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group">
                        <input type="text" name="comp_name" class="form-control" placeholder="company name*" required />
                    </div>

                    <div class="form-group">
                        <textarea name="description" class="form-control" placeholder="description"></textarea>
                    </div>

                    <div class="form-group">
                        <input type="text" name="contact_no" class="form-control" placeholder="contact number*" required />
                    </div>

                    <div class="form-group">
                        <input type="text" name="business_days" class="form-control" placeholder="business days*" required />
                    </div>

                    <div class="form-group">
                        <input type="text" name="business_hours" class="form-control" placeholder="business hours*" required />
                    </div>

                    <div class="form-group">
                        <textarea name="line1" class="form-control" placeholder="line1 address*" required></textarea>
                    </div>

                    <div class="form-group">
                        <textarea name="line2" class="form-control" placeholder="line2 address"></textarea>
                    </div>

                    <div class="form-group">
                        <textarea name="landmark" class="form-control" placeholder="landmark"></textarea>
                    </div>

                    <div class="form-group">
                        <select class="form-control" name="country_id" id="cnt_id" onchange="getState(this.value);" required>
                            <?php
                            if ($countries) 
                            {
                                echo "<option value=''>Please select country!!</option>";

                                foreach ($countries as $cnt_value) 
                                    echo "<option value='".$cnt_value['country_id']."'>".$cnt_value['name']."</option>";
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
                        <input type="text" name="pin" class="form-control" placeholder="pin code"/>
                    </div>

                    <div class="form-group">
                        <input type="text" name="contact" class="form-control" placeholder="Shop number"/>
                    </div>

                    <div class="form-group">
                        <input type="text" name="lat" class="form-control" placeholder="latitude" onkeyup="initialize();" id="lat" required />
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="long" id="long" class="form-control" placeholder="longitude" onkeyup="initialize();" required />
                    </div>

                    <div class="form-group">
                        <button type="button" onclick="getLatLongFromAddress();" class="btn btn-info">Get lat-long from address</button>
                    </div>
                    <!-- google map -->
                    <center>
                        <div id="googleMap" style="width:90%;height:400px; margin: 20px;"></div>
                    </center>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Sign up</button>  
                    <p><a href="<?= $this->config->item('site_url') ?>" class="btn bg-olive btn-block"><span class="glyphicon glyphicon-home"></span> Home page</a></p>
                </div>
            <?= form_close(); ?>
        </div>
    </body>
</html>

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
            url: '<?= base_url("seller/states") ?>/'+cnt_id,
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
            url: '<?= base_url("seller/cities") ?>/'+state_id,
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

$( document ).ready(function() {
    cnt_id = $('#cnt_id').val();
    if (parseInt(cnt_id)) 
        getState(cnt_id);
});
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVz1q3IpVEItGM-WmXgBkNWEfMuofO3FI&callback=initialize"></script>
