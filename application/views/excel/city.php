<?php 
$cities = isset($cities) ? $cities : '';
$city_id = isset($city['city_id']) ? $city['city_id'] : '';
$city_name = isset($city['name']) ? $city['name'] : '';
$lat = isset($city['latitude']) ? $city['latitude'] : '';
$long = isset($city['longitude']) ? $city['longitude'] : '';
$status = isset($city['status']) ? $city['status'] : 1;
$query_string_cnt_id = "";
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
            <li class="active">City data import/export</li>
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
                                        <a href="<?= base_url('cityExcel') ?>" class="btn btn-default">Remove Filter</a>
                                        <button class="btn btn-primary" onclick="cityManagement('getCityList');">Get city list</button>

                                        <?= form_open_multipart('importCityXls') ?>
                                            <div class="file file_div btn btn-success">
                                                Import city
                                                <input type="file" name="result_file" class="input_type_file" required />
                                            </div>
                                            <button class="btn btn-primary" onclick="cityManagement('exportTemplateForCity');">Export Existing Data</button>
                                            <button class="btn btn-primary" onclick="cityManagement('exportEmptyTemplateForCity');">Export Empty Template</button>
                                        <?= form_close() ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                                    <th>State ID</th>
                                    <th>Current status</th>
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
                                                <td>".$city_value['state_id']."</td>
                                                <td>".$status."</td>
                                            </tr>";
                                    }
                                }
                                else
                                    echo "<tr><td colspan='7' align='center'>No Record found.</td></tr>";
                                ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div>
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
        if (type == 'exportEmptyTemplateForCity')
            url = "<?= base_url('exportTemplateForCity/0?getCityList='); ?>"+cnt_id+"-"+state_id;
        else if (type == 'exportTemplateForCity')
            url = "<?= base_url('exportTemplateForCity/1?getCityList='); ?>"+cnt_id+"-"+state_id;
        else if (type == 'getCityList')
            url = "<?= base_url('cityExcel?'); ?>"+type+"="+cnt_id+"-"+state_id;
    }
    else
        url = "<?= base_url('exportTemplateForCity/1'); ?>";

    location.href = url;
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
    $('input[type=file]').change(function() { 
        // select the form and submit
        $('form').submit(); 
    });

    $("#cnt_id").change(function(){
        $("#state_id").empty();
        cnt_id = $("#cnt_id").val();

        if (cnt_id)
            getStates(cnt_id);
    });
});
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVz1q3IpVEItGM-WmXgBkNWEfMuofO3FI"></script>

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