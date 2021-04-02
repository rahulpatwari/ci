<?php 
$areas = isset($areas) ? $areas : '';
$area_id = isset($area['area_id']) ? $area['area_id'] : '';
$area_name = isset($area['area_name']) ? $area['area_name'] : '';
$lat = isset($area['latitude']) ? $area['latitude'] : '';
$long = isset($area['longitude']) ? $area['longitude'] : '';
$status = isset($area['status']) ? $area['status'] : 1;
?>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- bread crumb -->
    <section class="content-header">
        <h1>
            Area
            <small>Management</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Area data import/export</li>
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
                                                if ($cntry_id == $selected_country_id)
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

                                    <div class="col-sm-3 input-field">
                                        <label>Select city*:</label>    
                                    </div>
                                    <div class="col-sm-9 input-field">
                                        <select class="form-control" id="city_id">
                                            <?php 
                                            if ($cities) 
                                            {
                                                foreach ($cities as $city) 
                                                {
                                                    $city_id = $city['city_id'];
                                                    $selected = '';

                                                    if ($city_id == $selected_city_id)
                                                        $selected = "selected";

                                                    echo "<option value='".$city_id."' ".$selected.">".$city['name']."</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div> 

                                    <div class="col-sm-12" style="margin-top: 10px;" align="right">
                                        <a href="<?= base_url('areaExcel') ?>" class="btn btn-default">Remove Filter</a>
                                        <button class="btn btn-primary" onclick="areaManagement('getAreaList');">Get area list</button>

                                        <?= form_open_multipart('importCountryXls') ?>
                                            <div class="file file_div btn btn-success">
                                                Import state
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
                        <h3>Area <small>List</small></h3>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Area ID</th>
                                    <th>Name</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Current status</th>
                                    <th>City ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($areas) 
                                {
                                    $count = 1;
                                    foreach ($areas as $area_value)
                                    {
                                        $area_id = $area_value['area_id'];
                                        $area_status = $area_value['status'];

                                        if ($area_status)
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
                                                <td>".$area_id."</td>
                                                <td>".$area_value['area_name']."</td>
                                                <td>".$area_value['latitude']."</td>
                                                <td>".$area_value['longitude']."</td>
                                                <td>".$status."</td>
                                                <td>".$area_value['city_id']."</td>
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
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- ./wrapper -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
function areaManagement(type) 
{
    cnt = document.getElementById('cnt_id');
    cnt_id = cnt.value;

    state = document.getElementById('state_id');
    state_id = state.value;

    city = document.getElementById('city_id');
    city_id = city.value;

    if (cnt_id && state_id && city_id) 
    {
        url = "<?= base_url('areaExcel?'); ?>"+type+"="+cnt_id+"-"+state_id+"-"+city_id;
        location.href = url;
    }
    else
        alert('Error: please select country, state and city!!');
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

function getCities(state_id)
{
    if (state_id) 
    {
        $.ajax({
            type: "GET",
            url: '<?= base_url("cities") ?>/'+state_id,
            success: function(city_data){
                if (city_data) 
                {
                    city_data = JSON.parse(city_data);
                    options = '<option value="">select city</option>';

                    for (var i = 0; i < city_data.length; i++) 
                        options += '<option value="'+city_data[i].state_id+'">'+city_data[i].name+'</option>';

                    $("#city_id").append(options);
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
        $("#city_id").empty();
        cnt_id = $("#cnt_id").val();

        if (cnt_id)
            getStates(cnt_id);
    });

    $("#state_id").change(function(){
        $("#city_id").empty();
        state_id = $("#state_id").val();

        if (state_id)
            getCities(state_id);
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

.input-field{
    margin-bottom: 10px;
}  
</style>