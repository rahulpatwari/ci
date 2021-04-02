<?php 
$cities = isset($cities) ? $cities : '';
$city_id = isset($city['city_id']) ? $city['city_id'] : '';
$city_name = isset($city['name']) ? $city['name'] : '';
$lat = isset($city['latitude']) ? $city['latitude'] : '';
$long = isset($city['longitude']) ? $city['longitude'] : '';
$status = isset($city['status']) ? $city['status'] : 1;
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>
            City
            <small>Management</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">City Management</li>
        </ol>
    </section>

	<!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="box box-primary">
                            <div class="box-body">
                                <!-- select category -->
                                <div class="row form-group">
                                    <div class="col-sm-3 input-field">
                                        <label>Select country*:</label>    
                                    </div>
                                    <div class="col-sm-9 input-field">
                                        <select class="form-control" id="cnt_id">
                                            <option value="">Select country</option>
                                            <?php
                                            foreach ($countries as $cnt_value) 
                                            {
                                                $cntry_id = $cnt_value['country_id'];

                                                $selected = '';
                                                if (isset($selected_country_id) && $cntry_id == $selected_country_id) 
                                                    $selected = "selected";

                                                echo "<option value='".$cntry_id."' ".$selected.">".$cnt_value['name']."</option>";
                                            }
                                            ?>          
                                        </select>
                                    </div>
                                    
                                    <div class="col-sm-3 input-field">
                                        <label>Select state*:</label>    
                                    </div>
                                    <div class="col-sm-9 input-field">
                                        <select class="form-control" id="state_id">
                                            <?php 
                                            if ($states) 
                                            {
                                                foreach ($states as $state) 
                                                {
                                                    $state_id = $state['state_id'];
                                                    $selected = '';

                                                    if ($state_id == $selected_state_id)
                                                        $selected = "selected";

                                                    echo "<option value='".$state_id."' ".$selected.">".$state['name']."</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div> 

                                    <div class="col-sm-12" style="margin-top: 10px;" align="right">
                                        <a href="<?= base_url('page/cityManagement') ?>" class="btn btn-default">Remove Filter</a>
                                        <button class="btn btn-primary" onclick="cityManagement('getCityList');">Get city list</button>
                                        <button class="btn btn-warning" onclick="cityManagement('addNewCity');">Add new city</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!isset($_GET['addNewCity'])) { ?>
                    <div class="box">
                        <div class="box-header">
                            <h3>Cities <small>List</small></h3>
                        </div>
                        <div class="box-body table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S.NO.</th>
                                        <th>City ID</th>
                                        <th>City Name</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Current status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($cities) 
                                    {
                                        $count = 1;
                                        foreach ($cities as $city_value)
                                        {
                                            $city_id = $city_value['city_id'];
                                            $city_status = $city_value['status'];

                                            if ($city_status)
                                            {
                                                $status = "<span class='label label-success'>Active</span>";
                                                $newStatus = 0;
                                            }
                                            else
                                            {
                                                $status = "<span class='label label-warning'>Not active</span>";
                                                $newStatus = 1;
                                            }

                                            echo "<tr>
                                                    <td>".$count++."</td>
                                                    <td>".$city_id."</td>
                                                    <td>".$city_value['name']."</td>
                                                    <td>".$city_value['latitude']."</td>
                                                    <td>".$city_value['longitude']."</td>
                                                    <td>".$status."</td>
                                                    <td>
                                                        <a href='".base_url("page/cityManagement?addNewCity=$selected_country_id-$selected_state_id&city_id=$city_id")."' class='btn btn-primary'>Edit</a>
                                                        <a href='".base_url("changeCityStatus/$selected_country_id/$selected_state_id/$city_id/$newStatus")."' class='btn btn-warning'>Change status</a>
                                                    </td>
                                                </tr>";
                                        }
                                    }
                                    else
                                        echo "<tr><td colspan='6' align='center'>No Record found.</td></tr>";
                                    ?>
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div>
                <?php } else if (isset($_GET['addNewCity'])) 
                { 
                ?>
                    <div class="col-md-6 col-md-offset-3">
                        <div class="box box-primary">
                            <div class="box-header">
                                <?php
                                if (isset($_GET['city_id']))
                                    echo '<h3 class="box-title">Edit city</h3>';
                                else
                                    echo '<h3 class="box-title">Add city</h3>';    
                                ?>
                                
                            </div>
                            <!-- form start -->
                            <?= form_open_multipart('addCity'); ?>
                                <div class="box-body">
                                    <div class="row form-group">
                                        <input type="hidden" name="cnt_id" value="<?= $selected_country_id ?>" />
                                        <input type="hidden" name="state_id" value="<?= $selected_state_id ?>" />
                                        <input type="hidden" name="city_id" value="<?= $city_id ?>" />
                                        <input type="hidden" name="status" value="<?= $status ?>" />

                                        <div class="col-sm-3 input-field">
                                            <label>City Name*:</label> 
                                        </div>
                                        <div class="col-sm-9 input-field">
                                            <input type="text" name="city_name" class="form-control" placeholder="Enter City Name" value="<?= $city_name ?>" required>
                                        </div>    
                                        <div class="col-sm-3 input-field">
                                            <label>Latitude*:</label> 
                                        </div>
                                        <div class="col-sm-9 input-field">
                                            <input type="text" name="lat" class="form-control" placeholder="Enter Latitude Name" value="<?= $lat ?>" required />
                                        </div>
                                        <div class="col-sm-3 input-field">
                                            <label>Longitude*:</label> 
                                        </div>
                                        <div class="col-sm-9 input-field">
                                            <input type="text" name="long" class="form-control" placeholder="Enter Longitude Name" value="<?= $long ?>" required />
                                        </div>
                                        <div class="col-sm-12" align="right">
                                            <button type="button" class="btn btn-success" onclick="getLatLongFromCityName();">Get Lat-Long from city name</button>
                                            <a href='<?= base_url("page/cityManagement?getCityList=".$_GET['addNewCity']) ?>' class='btn btn-default'>Cancel</a>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            <?= form_close(); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->

<style type="text/css">
.input-field{
    margin-bottom: 10px;
}    
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
function getLatLongFromCityName() 
{
    city = ($('[name="city_name"]').val());
    state = ($("#state_id option:selected").html());
    country = ($("#cnt_id option:selected").html());
    geocoder = new google.maps.Geocoder();
    address = city+","+state+","+country;

    geocoder.geocode({'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            //get lat-long
            latitude = results[0].geometry.location.lat().toFixed(6);
            longitude = results[0].geometry.location.lng().toFixed(6);

            //set lat-long in text fields
            $('[name="lat"]').val(latitude);
            $('[name="long"]').val(longitude);
        } 
    }); 
}

function cityManagement(type) 
{
    cnt = document.getElementById('cnt_id');
    cnt_id = cnt.value;

    state = document.getElementById('state_id');
    state_id = state.value;

    if (cnt_id && state_id) 
    {
        url = "<?= base_url('page/cityManagement?'); ?>"+type+"="+cnt_id+"-"+state_id;
        location.href = url;
    }
    else
        alert('Error: please select country and state!!');
}

function getStates(cnt_id)
{
    if (cnt_id) 
    {
        $.ajax({
            type: "GET",
            url: '<?= base_url("states") ?>/'+cnt_id,
            success: function(state_data){
                if (state_data) 
                {
                    state_data = JSON.parse(state_data);
                    options = '<option value="">select state</option>';

                    for (var i = 0; i < state_data.length; i++) 
                        options += '<option value="'+state_data[i].state_id+'">'+state_data[i].name+'</option>';

                    $("#state_id").append(options);
                }
            },
        }); 
    }
    else
        alert("Error: state id not found!");
}

$(document).ready(function(){
    $("#cnt_id").change(function(){
        $("#state_id").empty();
        cnt_id = $("#cnt_id").val();

        if (cnt_id)
            getStates(cnt_id);
    });
});
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVz1q3IpVEItGM-WmXgBkNWEfMuofO3FI"></script>
